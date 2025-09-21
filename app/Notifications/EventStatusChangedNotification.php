<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Models\Event;

class EventStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $event;
    public $oldStatus;
    public $newStatus;

    public function __construct(Event $event, $oldStatus, $newStatus)
    {
        $this->event = $event;
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
            ->subject('Event Status Changed: ' . $this->event->title)
            ->line('The status of the event "' . $this->event->title . '" has changed.')
            ->line('Old Status: ' . $this->oldStatus)
            ->line('New Status: ' . $this->newStatus)
            ->action('View Event', route('events.show', $this->event->id));
    }

    public function toArray($notifiable)
    {
        return [
            'event_id' => $this->event->id,
            'title' => $this->event->title,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => "Event status changed from {$this->oldStatus} to {$this->newStatus}",
            'url' => route('events.show', $this->event->id),
            'type' => 'event_status_changed'
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
