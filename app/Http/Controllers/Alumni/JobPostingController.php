<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alumni\StoreJobPostingRequest;
use App\Models\JobPosting;
use Illuminate\Support\Facades\Auth;

class JobPostingController extends Controller
{
    public function index()
    {
        $jobs = JobPosting::where('posted_by', Auth::id())->paginate(10);
        return view('alumni.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('alumni.jobs.create');
    }

    public function store(StoreJobPostingRequest $request)
    {
        JobPosting::create([
            'title' => $request->title,
            'company' => $request->company,
            'location' => $request->location,
            'description' => $request->description,
            'posted_by' => Auth::id(),
        ]);

        return redirect()->route('alumni.jobs.index')->with('success', 'Job posted successfully');
    }

    public function destroy(JobPosting $job)
    {
        $this->authorize('delete', $job);
        $job->delete();
        return back()->with('success', 'Job deleted successfully');
    }
}
