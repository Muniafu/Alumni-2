<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Models\Mentorship;

class MentorshipAcceptedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $mentorship;

    public function __construct(Mentorship $mentorship)
    {
        $this->mentorship = $mentorship;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'mentorship_id' => $this->mentorship->id,
            'mentor_name' => $this->mentorship->mentor->name,
            'message' => "{$this->mentorship->mentor->name} has accepted your mentorship request",
            'url' => route('mentorship.show', $this->mentorship),
            'type' => 'mentorship_accepted'
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
