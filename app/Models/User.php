<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\Access\Authorizable;
use App\Models\Profile;
use App\Models\Mentorship;
use App\Models\Event;
use App\Models\JobApplication;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\ForumPost;

/**
 * @method bool hasRole(string|array $roles)
 * @method bool hasAnyRole(array|string $roles)
 * @method bool can(string $ability, array $arguments = [])
 * @property Profile|null $profile
 * @property \Illuminate\Database\Eloquent\Collection|Mentorship[] $mentorships
 * @property \Illuminate\Database\Eloquent\Collection|Mentorship[] $mentorshipRequests
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, Authorizable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'student_id',
        'graduation_year',
        'program',
        'is_approved',
        'approved_by',
        'approved_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function forumThreads()
    {
        return $this->hasMany(ForumThread::class, 'user_id');
    }

    public function forumPosts()
    {
        return $this->hasMany(ForumPost::class, 'user_id');
    }

    public function mentorships()
    {
        return $this->hasMany(Mentorship::class, 'mentor_id');
    }

    public function mentorshipRequests()
    {
        return $this->hasMany(Mentorship::class, 'mentee_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class)
            ->withPivot('last_read_at')
            ->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function scopeRole($query, $role)
    {
        return $query->whereHas('roles', function ($q) use ($role) {
            $q->where('name', $role);
        });
    }

    public function scopePendingApproval($query)
    {
        return $query->where('is_approved', false);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function unreadNotificationsCount(): int
    {
        return $this->unreadNotifications()->count();
    }

    public function isApproved(): bool
    {
        return $this->is_approved;
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_rsvps')
                    ->withPivot('status', 'guests', 'notes')
                    ->withTimestamps();
    }


    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

}
