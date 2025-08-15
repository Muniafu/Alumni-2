<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Models\Mentorship;

class MentorshipStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $mentorship;
    public $status;

    public function __construct(Mentorship $mentorship, $status)
    {
        $this->mentorship = $mentorship;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        $message = $this->status === 'completed'
            ? "Your mentorship with {$this->mentorship->mentor->name} has been completed"
            : "Your mentorship with {$this->mentorship->mentor->name} has been cancelled";

        if ($notifiable->id === $this->mentorship->mentor_id) {
            $message = $this->status === 'completed'
                ? "Your mentorship with {$this->mentorship->mentee->name} has been completed"
                : "Your mentorship with {$this->mentorship->mentee->name} has been cancelled";
        }

        return [
            'mentorship_id' => $this->mentorship->id,
            'status' => $this->status,
            'message' => $message,
            'url' => route('mentorship.show', $this->mentorship),
            'type' => 'mentorship_status_changed'
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
