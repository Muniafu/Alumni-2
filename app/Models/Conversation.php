<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['subject'];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('last_read_at')
            ->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->latest();
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function markAsReadForUser($userId)
    {
        $this->users()->updateExistingPivot($userId, [
            'last_read_at' => now()
        ]);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('users', function($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    public function getOtherUsersAttribute()
    {
        return $this->users->where('id', '!=', auth()->id());
    }

    public function getIsUnreadAttribute()
    {
        $lastRead = $this->users->find(auth()->id())->pivot->last_read_at;
        return $lastRead
            ? $this->latestMessage && $this->latestMessage->created_at > $lastRead
            : (bool) $this->latestMessage;
    }

}
