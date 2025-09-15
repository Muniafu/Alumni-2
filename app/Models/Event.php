<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\EventCreatedNotification;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'start',
        'end',
        'location',
        'image',
        'capacity',
        'is_online',
        'meeting_url',
        'user_id',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'is_online' => 'boolean',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rsvps()
    {
        return $this->hasMany(EventRsvp::class);
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_rsvps')
            ->withPivot('status', 'guests', 'notes')
            ->withTimestamps();
    }

    public function getAttendeesGoingAttribute()
    {
        return $this->attendees()->wherePivot('status', 'going')->count();
    }

    public function getAttendeesInterestedAttribute()
    {
        return $this->attendees()->wherePivot('status', 'interested')->count();
    }

    public function getAvailableSpotsAttribute()
    {
        return $this->capacity ? max(0, $this->capacity - $this->attendees_going) : null;

    }

    public function isFull()
    {
        return $this->capacity && ($this->attendees_going >= $this->capacity);
    }

    public function hasUserRsvped(User $user)
    {
        return $this->rsvps()->where('user_id', $user->id)->exists();
    }

    public function getUserRsvpStatus(User $user)
    {
        $rsvp = $this->rsvps()->where('user_id', $user->id)->first();
        return $rsvp ? $rsvp->status : null;
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start', '>', now());
    }

    public function scopePast($query)
    {
        return $query->where('end', '<', now());
    }

    public function scopeCurrent($query)
    {
        return $query->where('start', '<=', now())
            ->where('end', '>=', now());
    }

    protected static function booted()
    {
       //
    }

}
