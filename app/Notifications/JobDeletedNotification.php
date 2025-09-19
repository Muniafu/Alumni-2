<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Models\JobPosting;

class JobDeletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $jobTitle;
    public $deletedBy;

    /**
     * Create a new notification instance.
     */
    public function __construct($jobTitle, $deletedBy)
    {
        $this->jobTitle = $jobTitle;
        $this->deletedBy = $deletedBy;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Job Posting Deleted: {$this->jobTitle}")
            ->line("A job posting has been deleted by {$this->deletedBy}.")
            ->line("Job Title: {$this->jobTitle}")
            ->line('If you had applied to this job, please note that it is no longer available.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'job_title' => $this->jobTitle,
            'deleted_by' => $this->deletedBy,
            'message' => "Job posting '{$this->jobTitle}' was deleted by {$this->deletedBy}",
            'url' => route('jobs.index'),
            'type' => 'job_deleted'
        ];
    }

    /**
     * Get the broadcast representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
