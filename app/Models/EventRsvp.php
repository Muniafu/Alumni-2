<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\RsvpStatusChangedNotification;
use Illuminate\Support\Facades\Notification;

class EventRsvp extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'status',
        'guests',
        'notes',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::updated(function ($rsvp) {
            if ($rsvp->isDirty('status')) {
                $oldStatus = $rsvp->getOriginal('status');
                $newStatus = $rsvp->status;
                if ($oldStatus !== $newStatus) {
                    $user = $rsvp->user;
                    $organizer = $rsvp->event->organizer;
                    $admins = User::role('admin')->get();
                    $user->notify(new RsvpStatusChangedNotification($rsvp, $oldStatus, $newStatus));
                    Notification::send($organizer, new RsvpStatusChangedNotification($rsvp, $oldStatus, $newStatus));
                    Notification::send($admins, new RsvpStatusChangedNotification($rsvp, $oldStatus, $newStatus));
                }
            }
        });
    }

}
