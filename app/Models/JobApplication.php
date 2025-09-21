<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\ApplicationStatusChangedNotification;
use Illuminate\Support\Facades\Notification;

class JobApplication extends Model
{
    use HasFactory;


    protected $fillable = [
        'job_posting_id',
        'user_id',
        'cover_letter',
        'resume_path',
        'status',
        'notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function job()
    {
        return $this->belongsTo(JobPosting::class, 'job_posting_id');
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'submitted' => 'Submitted',
            'reviewed' => 'Under Review',
            'interviewed' => 'Interviewing',
            'rejected' => 'Not Selected',
            'hired' => 'Hired',
            'revoked' => 'Revoked',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }

    protected static function booted()
    {
        static::updated(function ($application) {
            if ($application->isDirty('status')) {
                $oldStatus = $application->getOriginal('status');
                $newStatus = $application->status;
                if ($oldStatus !== $newStatus) {
                    $applicant = $application->applicant;
                    $jobPoster = $application->job->poster;
                    $admins = User::role('admin')->get();
                    $applicant->notify(new ApplicationStatusChangedNotification($application, $oldStatus));
                    Notification::send($jobPoster, new ApplicationStatusChangedNotification($application, $oldStatus));
                    Notification::send($admins, new ApplicationStatusChangedNotification($application, $oldStatus));
                }
            }
        });
    }

}
