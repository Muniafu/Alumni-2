<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\MentorshipStatusChangedNotification;
use Illuminate\Support\Facades\Notification;

class Mentorship extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_id',
        'mentee_id',
        'status',
        'notes',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function mentee()
    {
        return $this->belongsTo(User::class, 'mentee_id');
    }

    protected static function booted()
    {
        static::updated(function ($mentorship) {
            if ($mentorship->isDirty('status')) {
                $oldStatus = $mentorship->getOriginal('status');
                $newStatus = $mentorship->status;
                if ($oldStatus !== $newStatus) {
                    $mentor = $mentorship->mentor;
                    $mentee = $mentorship->mentee;
                    $admins = User::role('admin')->get();
                    Notification::send($mentor, new MentorshipStatusChangedNotification($mentorship, $newStatus));
                    Notification::send($mentee, new MentorshipStatusChangedNotification($mentorship, $newStatus));
                    Notification::send($admins, new MentorshipStatusChangedNotification($mentorship, $newStatus));
                }
            }
        });
    }

}
