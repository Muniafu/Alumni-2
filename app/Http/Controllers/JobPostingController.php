<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Notifications\NewJobPostedNotification;
use App\Notifications\JobApplicationNotification;
use App\Notifications\ApplicationStatusChangedNotification;
use Illuminate\Support\Facades\Notification;

use function PHPSTORM_META\type;

class JobPostingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type =$request->query('type');
        $query = JobPosting::active()->with('poster')->latest();

        if ($type && in_array($type, ['job', 'internship', 'mentorship'])) {

            $query->where('type', $type);
            $title = ucfirst($type) . ' Opportunities';
        } else {
            $title = 'Job Board';
        }

        $jobs = $query->paginate(10);

        return view('jobs.index', compact('jobs', 'title'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', JobPosting::class);

        return view('jobs.create');

    }

    public function show(JobPosting $job)
    {
        $userApplication = auth()->check()
            ? $job->applications()->where('user_id', auth()->id())->first()
            : null;

        return view('jobs.show', [
            'job' => $job,
            'userApplication' => $userApplication
        ]);
    }

    public function myPostings()
    {
        $jobs = JobPosting::where('user_id', auth()->id())
            ->withCount('applications')
            ->latest()
            ->paginate(10);

        return view('jobs.my-postings', [
            'jobs' => $jobs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', JobPosting::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:job,internship,mentorship',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'is_remote' => 'boolean',
            'salary_range' => 'nullable|string|max:100',
            'employment_type' => 'nullable|string|max:100',
            'application_deadline' => 'nullable|date',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
            'website' => 'nullable|url',
            'skills_required' => 'nullable|string',
            'skills_preferred' => 'nullable|string',
        ]);

        // Process skills
        $validated['skills_required'] = $request->skills_required
            ? array_map('trim', explode(',', $request->skills_required))
            : null;

        $validated['skills_preferred'] = $request->skills_preferred
            ? array_map('trim', explode(',', $request->skills_preferred))
            : null;

        $validated['user_id'] = auth()->id();
        $validated['is_active'] = true;

        try {
            $job = JobPosting::create($validated);

            if (!$job->exists) {
                throw new \Exception('Failed to save job posting');
            }

            // 🔔 Notify only approved students + admins
            $students = User::query()
                ->where('is_approved', true)
                ->whereHas('roles', fn($q) => $q->where('name', 'student'))
                ->get();

            $admins = User::role('admin')->get();

            Notification::send($students, new NewJobPostedNotification($job));
            Notification::send($admins, new NewJobPostedNotification($job));

            return redirect()->route('jobs.show', $job)
                ->with('success', 'Job posting created successfully');

        } catch (\Exception $e) {
            Log::error('Job posting creation failed: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Failed to create job posting. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPosting $job)
    {
        Gate::authorize('update', $job);

        return view('jobs.edit', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobPosting $job)
    {

        Gate::authorize('update', $job);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:job,internship,mentorship',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'is_remote' => 'boolean',
            'salary_range' => 'nullable|string|max:100',
            'employment_type' => 'nullable|string|max:100',
            'application_deadline' => 'nullable|date',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
            'website' => 'nullable|url',
            'skills_required' => 'nullable|string',
            'skills_preferred' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['skills_required'] = $request->skills_required
            ? array_map('trim', explode(',', $request->skills_required))
            : null;

        $validated['skills_preferred'] = $request->skills_preferred
            ? array_map('trim', explode(',', $request->skills_preferred))
            : null;

        $job->update($validated);

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Job posting updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPosting $job)
    {

        Gate::authorize('delete', $job);
        $job->delete();

        return redirect()->route('jobs.index')
            ->with('success', 'Job posting deleted successfully');

    }

    /**
     * Apply the specified resource.
     */
    public function apply(Request $request, JobPosting $job)
    {

        if (!$job->canApply()) {
            return back()->with('error', 'You cannot apply to this job posting.');
        }

        $validated = $request->validate([
            'cover_letter' => 'required|string|min:100|max:2000',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $resumePath = $request->file('resume')->store('resumes', 'private');

        $application = JobApplication::create([
            'job_posting_id' => $job->id,
            'user_id' => auth()->id(),
            'cover_letter' => $validated['cover_letter'],
            'resume_path' => $resumePath,
        ]);

        // Notify job poster (alumni) and admins about new application
        $job->poster->notify(new JobApplicationNotification($application));
        $admins = User::role('admin')->get();
        Notification::send($admins, new JobApplicationNotification($application));

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Application submitted successfully');

    }

    /**
     * Applications the specified resource.
     */
    public function applications(JobPosting $job)
    {

        Gate::authorize('viewApplications', $job);

        $applications = $job->applications()->with(['applicant' => function($query) {
            $query->with('profile');
        }])->latest()->get();

        return view('jobs.applications', compact('job', 'applications'));

    }

    /**
     * Show a single application.
     */
    public function showApplication(JobPosting $job, JobApplication $application)
    {
        Gate::authorize('viewApplication', [$job, $application]);

        $application->load('applicant.profile');

        return view('jobs.application-show', compact('job', 'application'));
    }

    /**
     * UpdateApplications the specified resource in storage.
     */
    public function updateApplicationStatus(Request $request, JobApplication $application)
    {

        Gate::authorize('updateApplication', $application);

        $validated = $request->validate([
            'status' => 'required|in:submitted,reviewed,interviewed,rejected,hired',
            'notes' => 'nullable|string|max:500',
        ]);

        $oldStatus = $application->status;
        $application->update($validated);

        // Notify student if status changed significantly
        if ($oldStatus !== $application->status && in_array($application->status, ['interviewed', 'hired', 'rejected'])) {
            $application->applicant->notify(new ApplicationStatusChangedNotification($application, $oldStatus));
        }

        return back()->with('success', 'Application status updated');

    }
}
