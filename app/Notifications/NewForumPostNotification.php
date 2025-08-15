<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Models\ForumPost;

class NewForumPostNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $post;

    public function __construct(ForumPost $post)
    {
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'post_id' => $this->post->id,
            'thread_id' => $this->post->thread_id,
            'author_name' => $this->post->author->name,
            'message' => "New reply in thread: {$this->post->thread->title}",
            'url' => route('forum.threads.show', [
                'thread' => $this->post->thread,
                'page' => $this->post->thread->posts()->paginate(15)->lastPage()
            ]) . '#post-' . $this->post->id,
            'type' => 'new_forum_post'
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
