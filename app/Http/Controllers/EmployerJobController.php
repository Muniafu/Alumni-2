<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosting;
use App\Http\Requests\JobPosting\StoreJobPostingRequest;

class EmployerJobController extends Controller
{
    public function store(StoreJobPostingRequest $request){
        $job = JobPosting::create(array_merge($request->validated(), [
        'created_by' => auth()->id()
        ]));

        return redirect()->route('employer.jobs.index')->with('success','Job created.');
    }

    public function applicants(JobPosting $job){
        $this->authorize('viewApplications', $job);
        $applications = $job->applications()->with('user')->latest()->paginate(15);

        return view('employer.jobs.applicants', compact('job','applications'));
    }

    public function updateApplicationStatus(Request $request, JobPosting $job){
        $this->authorize('manageApplications', $job);
        $request->validate(['status'=> 'required|in:submitted,reviewed,shortlisted,rejected,hired']);

        return back()->with('success','Application updated.');
    }

}
