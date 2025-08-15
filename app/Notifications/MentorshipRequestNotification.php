<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Models\MentorshipRequest;

class MentorshipRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $mentorshipRequest;

    public function __construct(MentorshipRequest $mentorshipRequest)
    {
        $this->mentorshipRequest = $mentorshipRequest;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'request_id' => $this->mentorshipRequest->id,
            'mentee_name' => $this->mentorshipRequest->mentee->name,
            'message' => "{$this->mentorshipRequest->mentee->name} has requested mentorship",
            'url' => route('mentorship.requests'),
            'type' => 'mentorship_request'
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
