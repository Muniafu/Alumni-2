<?php

namespace App\Policies;

use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPostingPolicy
{
    use HandlesAuthorization;

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
        return $user->hasRole(['admin', 'alumni']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, JobPosting $jobPosting)
    {
        // Allow the poster of the job posting or an admin to update it
        return $user->hasRole('admin') || $jobPosting->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, JobPosting $jobPosting)
    {
        return $user->hasRole('admin') || $jobPosting->user_id === $user->id;
    }

    /**
     * Determine whether the user can viewApplications the model.
     */
    public function viewApplications(User $user, JobPosting $jobPosting)
    {
        // Allow the poster of the job posting or an admin to view applications
        return $user->hasRole('admin') || $jobPosting->user_id === $user->id;
    }

    /**
     * Determine whether the user can update applications to the job posting.
     */
    public function updateApplications(User $user, JobApplication $application)
    {
        // Allow the poster of the job posting or an admin to update applications
        return $user->hasRole('admin') || $application->job_posting->user_id === $user->id;
    }
}
