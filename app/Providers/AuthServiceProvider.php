<?php

namespace App\Providers;

use App\Models\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\UserPolicy;
use App\Policies\EventPolicy;
use App\Models\User;

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
        Gate::define('access-student-dashboard', [UserPolicy::class, 'viewStudentDashboard']);
        Gate::define('manage-users', [UserPolicy::class, 'manageUsers']);
        Gate::define('approve-users', [UserPolicy::class, 'approveUsers']);
        Gate::define('edit-profile', [UserPolicy::class, 'editProfile']);
        Gate::define('view-pending-approvals', [UserPolicy::class, 'viewPendingApprovals']);
    }
}
