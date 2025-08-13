<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;

class JobManagementController extends Controller
{
    public function index()
    {
        $jobs = JobPosting::latest()->paginate(15);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function destroy(JobPosting $job)
    {
        $job->delete();
        return back()->with('success', 'Job deleted successfully');
    }
}
