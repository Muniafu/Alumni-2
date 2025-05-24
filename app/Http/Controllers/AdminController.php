<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

    public function dashboard()
    {
        Gate::authorize('access-admin-dashboard');

        $totalUsers = User::count();
        $pendingApprovals = User::pendingApproval()->count();
        $recentActivities = ActivityLog::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'pendingApprovals', 'recentActivities'));
    }

    public function pendingApprovals()
    {
        Gate::authorize('view-pending-approvals');

        $users = User::pendingApproval()->with('roles')->get();

        return view('admin.pending-approvals', compact('users'));
    }

    public function approveUser(Request $request, User $user)
    {
        Gate::authorize('approve-users');

        $user->update([
            'is_approved' => true,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'approve',
            'description' => 'Approved user: ' . $user->name,
            'model_type' => User::class,
            'model_id' => $user->id,
        ]);

        return redirect()->route('admin.pending-approvals')
            ->with('success', 'User approved successfully');
    }

    public function rejectUser(Request $request, User $user)
    {
        Gate::authorize('approve-users');

        $user->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'reject',
            'description' => 'Rejected user: ' . $user->name,
            'model_type' => User::class,
            'model_id' => $user->id,
        ]);

        return redirect()->route('admin.pending-approvals')
            ->with('success', 'User rejected successfully');
    }

    public function userManagement()
    {
        Gate::authorize('manage-users');

        $users = User::with('roles')->approved()->get();

        return view('admin.user-management', compact('users'));
    }
}
