<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewDashboard(User $user)
    {
        return $user->hasAllPermissionsTo('view dashboard')
            ? Response::allow()
            : Response::deny('You do not have permission to view the dashboard.');
    }
    /**
     * Determine whether the user can view the admin dashboard.
     */
    public function viewAdminDashboard(User $user)
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('You do not have permission to view the admin dashboard.');
    }

    /**
     * Determine whether the user can view the alumni dashboard.
     */
    public function viewAlumniDashboard(User $user)
    {
        return $user->hasRole('alumni') && $user->is_approved
            ? Response::allow()
            : Response::deny('You do not have permission to view the alumni dashboard or you are not approved.');
    }

    /**
     * Determine whether the user can view the student dashboard.
     */
    public function viewStudentDashboard(User $user)
    {
        return $user->hasRole('student') && $user->is_approved
            ? Response::allow()
            : Response::deny('You do not have permission to view the student dashboard or you are not approved.');
    }

    public function manageUsers(User $user)
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('You do not have permission to manage users.');
    }

    public function approveUsers(User $user)
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('You do not have permission to approve users.');
    }

    public function editProfile(User $user, User $model)
    {
        // Allow users to edit their own profile
        return $user->id === $model->id && $user->is_approved
            ? Response::allow()
            : Response::deny('You do not have permission to edit this profile or you are not approved.');
    }

    public function viewPendingApprovals(User $user)
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('You do not have permission to view pending approvals.');
    }

    public function generateReports(User $user)
    {
        // Only allow admin users to generate reports
        return $user->hasRole('admin');
    }

}
