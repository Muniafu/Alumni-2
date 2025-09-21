<?php

namespace App\Policies;

use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Allow admins to bypass all checks.
     */
    public function before(User $user, $ability)
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the user can view a specific application.
     */
    public function view(User $user, JobApplication $application)
    {
        return $user->hasRole('admin') ||
               $application->jobPosting->user_id === $user->id ||
               $application->user_id === $user->id;
    }

    /**
     * Determine whether the user can update the application status.
     */
    public function update(User $user, JobApplication $application)
    {
        return $application->jobPosting->user_id === $user->id;
    }

    /**
     * Determine whether the user can download the resume.
     */
    public function downloadResume(User $user, JobApplication $application)
    {
        return $user->hasRole('admin') ||
               $application->jobPosting->user_id === $user->id ||
               $application->user_id === $user->id;
    }
}
