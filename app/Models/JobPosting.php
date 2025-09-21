<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\JobApplication;
use App\Notifications\JobStatusChangedNotification;
use Illuminate\Support\Facades\Notification;

class JobPosting extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'title',
        'description',
        'type',
        'company',
        'location',
        'is_remote',
        'salary_range',
        'employment_type',
        'application_deadline',
        'contact_email',
        'contact_phone',
        'website',
        'skills_required',
        'skills_preferred',
        'user_id',
        'is_active'
    ];

    protected $casts = [
        'is_remote' => 'boolean',
        'is_active' => 'boolean',
        'skills_required' => 'array',
        'skills_preferred' => 'array',
        'application_deadline' => 'datetime',
    ];

    public function poster()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function scopeActive($query)
    {
        return $query->where(function($q) {
            $q->where('application_deadline', '>=', now())
            ->orWhereNull('application_deadline');
        })
        ->where('is_active', true);
    }

    public function scopeJobs($query)
    {
        return $query->where('type', 'job');
    }

    public function scopeInternships($query)
    {
        return $query->where('type', 'internship');
    }

    public function scopeMentorships($query)
    {
        return $query->where('type', 'mentorship');
    }

    public function getIsExpiredAttribute()
    {
        return $this->application_deadline
            ? now()->gt($this->application_deadline)
            : false;
    }

    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'inactive';
        }

        if ($this->is_expired) {
            return 'expired';
        }

        return 'active';
    }

    public function canApply(User $user = null)
    {
        $user = $user ?? auth()->user();

        if (!$user) {
            return false;
        }

        if ($this->is_expired || !$this->is_active) {
            return false;
        }

        return !$this->applications()->where('user_id', $user->id)->exists();
    }

    protected static function booted()
    {
        static::created(function ($job) {
            $students = User::where('is_approved', true)->whereHas('roles', fn($q) => $q->where('name', 'student'))->get();
            $admins = User::role('admin')->get();
            Notification::send($students->merge($admins), new \App\Notifications\NewJobPostedNotification($job));
        });

        static::deleted(function ($job) {
            $allUsers = User::where('is_approved', true)->whereHas('roles', fn($q) => $q->whereIn('name', ['alumni', 'student', 'admin']))->get();
            $applicants = $job->applications()->with('applicant')->get()->pluck('applicant');
            $deletedBy = auth()->check() ? auth()->user()->name : 'System';
            Notification::send($allUsers->merge($applicants)->unique('id'), new \App\Notifications\JobDeletedNotification($job->title, $deletedBy));
        });

        static::updated(function ($job) {
            if ($job->isDirty('is_active')) {
                $oldStatus = $job->getOriginal('is_active') ? 'active' : 'inactive';
                $newStatus = $job->is_active ? 'active' : 'inactive';
                if ($oldStatus !== $newStatus) {
                    $poster = $job->poster;
                    $admins = User::role('admin')->get();
                    $applicants = $job->applications()->with('applicant')->get()->pluck('applicant');
                    Notification::send($poster, new JobStatusChangedNotification($job, $oldStatus, $newStatus));
                    Notification::send($admins, new JobStatusChangedNotification($job, $oldStatus, $newStatus));
                    Notification::send($applicants, new JobStatusChangedNotification($job, $oldStatus, $newStatus));
                }
            }
        });
    }
}
