<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumThread extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'forum_category_id',
        'user_id',
        'title',
        'slug',
        'content',
        'is_pinned',
        'is_locked'
    ];

    public function category()
    {
        return $this->belongsTo(ForumCategory::class, 'forum_category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function posts()
    {
        return $this->hasMany(ForumPost::class)->latest();
    }

    public function latestPost()
    {
        return $this->hasOne(ForumPost::class)->latestOfMany();
    }

    public function getPostCountAttribute()
    {
        return $this->posts()->count();
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeNotPinned($query)
    {
        return $query->where('is_pinned', false);
    }
    
}
