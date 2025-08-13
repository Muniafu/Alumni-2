<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    public function apply(JobPosting $job)
    {
        Auth::user()->jobApplications()->attach($job->id);
        return back()->with('success', 'Applied for job successfully');
    }
}
