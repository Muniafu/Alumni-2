<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Models\EventRsvp;

class RsvpStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $rsvp;
    public $oldStatus;
    public $newStatus;

    public function __construct(EventRsvp $rsvp, $oldStatus, $newStatus)
    {
        $this->rsvp = $rsvp;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('RSVP Status Changed for ' . $this->rsvp->event->title)
            ->line('Your RSVP status for "' . $this->rsvp->event->title . '" has changed.')
            ->line('Old Status: ' . $this->oldStatus)
            ->line('New Status: ' . $this->newStatus)
            ->action('View Event', route('events.show', $this->rsvp->event->id));
    }

    public function toArray($notifiable)
    {
        return [
            'event_id' => $this->rsvp->event->id,
            'user_id' => $this->rsvp->user->id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => "RSVP status changed from {$this->oldStatus} to {$this->newStatus}",
            'url' => route('events.show', $this->rsvp->event->id),
            'type' => 'rsvp_status_changed'
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
