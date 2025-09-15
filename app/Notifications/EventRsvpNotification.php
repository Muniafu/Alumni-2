<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Models\EventRsvp;

class EventRsvpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $rsvp;

    /**
     * Create a new notification instance.
     */
    public function __construct(EventRsvp $rsvp)
    {
        $this->rsvp = $rsvp;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New RSVP for Event: ' . $this->rsvp->event->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line("{$this->rsvp->user->name} has RSVP’d for your event: **{$this->rsvp->event->title}**")
            ->line("📅 Date: " . $this->rsvp->event->start->format('d M, Y'))
            ->line("📍 Location: " . $this->rsvp->event->location)
            ->action('View Event', route('events.show', $this->rsvp->event->id))
            ->line('Keep track of attendees in your dashboard.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'event_id' => $this->rsvp->event->id,
            'user_id' => $this->rsvp->user->id,
            'user_name' => $this->rsvp->user->name,
            'message' => "{$this->rsvp->user->name} RSVP’d for {$this->rsvp->event->title}",
            'url' => route('events.show', $this->rsvp->event->id),
            'type' => 'event_rsvp'
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
