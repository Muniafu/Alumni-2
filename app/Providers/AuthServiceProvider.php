<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\JobPosting;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\ForumThread;
use App\Models\ForumPost;
use App\Policies\ForumThreadPolicy;
use App\Policies\ForumPostPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\UserPolicy;
use App\Policies\EventPolicy;
use App\Models\User;
use App\Policies\JobPostingPolicy;
use App\Policies\ReportPolicy;
use App\Policies\ConversationPolicy;
use App\Policies\MessagePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Event::class => EventPolicy::class,
        JobPosting::class => JobPostingPolicy::class,
        User::class => ReportPolicy::class,
        Conversation::class => ConversationPolicy::class,
        Message::class => MessagePolicy::class,
        ForumThread::class => ForumThreadPolicy::class,
        ForumPost::class   => ForumPostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        // Define gates for role-based access

        Gate::define('access-admin-dashboard', [UserPolicy::class, 'viewAdminDashboard']);
        Gate::define('access-alumni-dashboard', [UserPolicy::class, 'viewAlumniDashboard']);
        Gate::define('access-alumni-dashboard', function ($user) {
            return $user->hasRole('alumni');
            });
        Gate::define('access-student-dashboard', [UserPolicy::class, 'viewStudentDashboard']);
        Gate::define('manage-users', [UserPolicy::class, 'manageUsers']);
        Gate::define('approve-users', [UserPolicy::class, 'approveUsers']);
        Gate::define('edit-profile', [UserPolicy::class, 'editProfile']);
        Gate::define('view-pending-approvals', [UserPolicy::class, 'viewPendingApprovals']);

        Gate::define('create-jobs', [JobPostingPolicy::class, 'create']);
        Gate::define('edit-jobs', [JobPostingPolicy::class, 'update']);
        Gate::define('delete-jobs', [JobPostingPolicy::class, 'delete']);
        Gate::define('view-job-applications', [JobPostingPolicy::class, 'viewApplications']);
        Gate::define('manage-job-applications', [JobPostingPolicy::class, 'updateApplications']);

        Gate::define('generate-reports', [ReportPolicy::class, 'generateReports']);

        Gate::define('view-events', [EventPolicy::class, 'viewAny']);
        Gate::define('create-events', [EventPolicy::class, 'create']);
        Gate::define('edit-events', [EventPolicy::class, 'update']);
        Gate::define('delete-events', [EventPolicy::class, 'delete']);
        Gate::define('rsvp-events', [EventPolicy::class, 'rsvp']);
    }
}
