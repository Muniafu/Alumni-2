<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Models\JobPosting;

class JobStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $job;
    public $oldStatus;
    public $newStatus;

    public function __construct(JobPosting $job, $oldStatus, $newStatus)
    {
        $this->job = $job;
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
            ->subject('Job Status Changed: ' . $this->job->title)
            ->line('The status of the job "' . $this->job->title . '" has changed.')
            ->line('Old Status: ' . $this->oldStatus)
            ->line('New Status: ' . $this->newStatus)
            ->action('View Job', route('jobs.show', $this->job->id));
    }

    public function toArray($notifiable)
    {
        return [
            'job_id' => $this->job->id,
            'title' => $this->job->title,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => "Job status changed from {$this->oldStatus} to {$this->newStatus}",
            'url' => route('jobs.show', $this->job->id),
            'type' => 'job_status_changed'
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
