<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'order'];

    public function threads()
    {
        return $this->hasMany(ForumThread::class)->latest();
    }

    public function getThreadCountAttribute()
    {
        return $this->threads()->count();
    }

    public function getPostCountAttribute()
    {
        return ForumPost::whereIn('forum_thread_id', $this->threads()->pluck('id'))->count();
    }

    public function getLatestThreadAttribute()
    {
        return $this->threads()->latest()->first();
    }

}
