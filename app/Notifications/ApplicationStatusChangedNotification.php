<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\JobApplication;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ApplicationStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $application;
    public $oldStatus;

    public function __construct(JobApplication $application, $oldStatus)
    {
        $this->application = $application;
        $this->oldStatus = $oldStatus;
    }

    public function via($notifiable)
    {
        return ['database', 'mail', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Your Application Status Has Changed')
                    ->line('The status of your application for ' . $this->application->job->title . ' has changed.')
                    ->line('Old Status: ' . ucfirst($this->oldStatus))
                    ->line('New Status: ' . ucfirst($this->application->status))
                    ->action('View Application', route('jobs.show', $this->application->job))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'application_id' => $this->application->id,
            'job_id' => $this->application->job_posting_id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->application->status,
            'message' => "Your application status changed from {$this->oldStatus} to {$this->application->status}",
            'url' => route('jobs.show', $this->application->job_posting_id),
            'type' => 'application_status_changed'
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

}
