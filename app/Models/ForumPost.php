<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['forum_thread_id', 'user_id', 'content'];

    public function create(User $user): bool
    {
        return $user->is_approved;
    }

    public function view(User $user, ForumPost $post): bool
    {
        return true; // anyone can view
    }

    public function thread()
    {
        return $this->belongsTo(ForumThread::class, 'forum_thread_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
