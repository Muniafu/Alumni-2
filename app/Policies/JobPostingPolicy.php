<?php

namespace App\Policies;

use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPostingPolicy
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

        // Return null to continue with other policies
        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        // Allow all authenticated users to view job postings
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, JobPosting $jobPosting)
    {
        // Allow all authenticated users to view job postings
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasRole('alumni');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, JobPosting $jobPosting)
    {
        return $jobPosting->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, JobPosting $jobPosting)
    {
        return $jobPosting->user_id === $user->id;
    }

    /**
     * Determine whether the user can view applications for the model.
     */
    public function viewApplications(User $user, JobPosting $jobPosting)
    {
        // Allow the poster of the job posting or an admin to view applications
        return $jobPosting->user_id === $user->id;
    }
}
