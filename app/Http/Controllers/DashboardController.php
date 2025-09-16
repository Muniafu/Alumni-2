<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Event;
use App\Models\JobPosting;
use App\Models\ForumThread;
use App\Models\Activity; // if you create a dedicated activity log model

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('alumni')) {
            return redirect()->route('alumni.dashboard');
        } elseif ($user->hasRole('student')) {
            return redirect()->route('student.dashboard');
        }

        return redirect()->route('login');
    }

    /**
     * Admin Dashboard
     */
    public function adminDashboard()
    {
        // Example stats
        $userCounts = [
            'total' => User::count(),
            'admins' => User::role('admin')->count(),
            'alumni' => User::role('alumni')->count(),
            'students' => User::role('student')->count(),
            'pending_approvals' => User::where('status', 'pending')->count(),
            'new_last_week' => User::where('created_at', '>=', now()->subWeek())->count(),
        ];

        $eventStats = [
            'total' => Event::count(),
            'upcoming' => Event::where('date', '>=', now())->count(),
            'past' => Event::where('date', '<', now())->count(),
            'rsvps' => DB::table('event_user')->count(), // ✅ FIXED
            'avg_attendance' => DB::table('event_user')
                ->selectRaw('COUNT(user_id)/COUNT(DISTINCT event_id) as avg')
                ->value('avg') ?? 0,
        ];

        $jobStats = [
            'total' => JobPosting::count(),
            'active' => JobPosting::where('deadline', '>=', now())->count(),
            'applications' => DB::table('job_applications')->count(), // ✅ FIXED
            'avg_applications' => DB::table('job_applications')
                ->selectRaw('COUNT(id)/COUNT(DISTINCT job_posting_id) as avg')
                ->value('avg') ?? 0,
        ];

        $forumStats = [
            'threads' => ForumThread::count(),
            'posts' => DB::table('forum_posts')->count(), // ✅ FIXED
            'recent_posts' => DB::table('forum_posts')
                ->where('created_at', '>=', now()->subWeek())
                ->count(),
        ];

        // Recent Activity (combine multiple models)
        $recentEvents = Event::latest()->take(5)->get();
        $recentJobs = JobPosting::latest()->take(5)->get();
        $recentThreads = ForumThread::latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        // If you track approvals/profile updates in an Activity model
        $recentApprovals = DB::table('user_approvals')->latest()->take(5)->get(); // ✅ FIXED
        $recentProfiles = DB::table('profile_updates')->latest()->take(5)->get(); // ✅ FIXED

        // Merge all into one collection and sort by created_at
        $recentActivities = collect()
            ->merge($recentEvents)
            ->merge($recentJobs)
            ->merge($recentThreads)
            ->merge($recentUsers)
            ->merge($recentApprovals)
            ->merge($recentProfiles)
            ->sortByDesc('created_at')
            ->take(10);

        return view('admin.dashboard', compact(
            'userCounts',
            'eventStats',
            'jobStats',
            'forumStats',
            'recentActivities'
        ));
    }
}
