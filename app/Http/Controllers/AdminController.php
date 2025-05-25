<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules;

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


    public function createUser()
    {
        Gate::authorize('manage-users');

        $roles = Role::all();
        $currentYear = date('Y');
        $graduationYears = range($currentYear - 10, $currentYear + 5);

        return view('admin.user-create', compact('roles', 'graduationYears'));
    }

    public function storeUser(Request $request)
    {
        Gate::authorize('manage-users');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,name'],
            'student_id' => ['required_if:role,student,alumni', 'string', 'max:50', 'unique:users'],
            'graduation_year' => ['required_if:role,student,alumni', 'digits:4', 'integer', 'min:1900', 'max:' . (date('Y') + 5)],
            'program' => ['required_if:role,student,alumni', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'student_id' => $request->student_id,
            'graduation_year' => $request->graduation_year,
            'program' => $request->program,
            'is_approved' => true,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        $user->assignRole($request->role);

        // Create empty profile
        $user->profile()->create([]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'description' => 'Created new user: ' . $user->name . ' with role ' . $request->role,
            'model_type' => User::class,
            'model_id' => $user->id,
        ]);

        return redirect()->route('admin.user-management')
            ->with('success', 'User created successfully');
    }

    public function editUser(User $user)
    {
        Gate::authorize('manage-users');

        $roles = Role::all();
        $currentYear = date('Y');
        $graduationYears = range($currentYear - 10, $currentYear + 5);

        return view('admin.user-edit', compact('user', 'roles', 'graduationYears'));
    }

    public function updateUser(Request $request, User $user)
    {
        Gate::authorize('manage-users');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'exists:roles,name'],
            'student_id' => ['required_if:role,student,alumni', 'string', 'max:50', 'unique:users,student_id,'.$user->id],
            'graduation_year' => ['required_if:role,student,alumni', 'digits:4', 'integer', 'min:1900', 'max:' . (date('Y') + 5)],
            'program' => ['required_if:role,student,alumni', 'string', 'max:255'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'student_id' => $request->student_id,
            'graduation_year' => $request->graduation_year,
            'program' => $request->program,
        ]);

        // Sync roles (remove all and add the new one)
        $user->syncRoles([$request->role]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'description' => 'Updated user: ' . $user->name,
            'model_type' => User::class,
            'model_id' => $user->id,
        ]);

        return redirect()->route('admin.user-management')
            ->with('success', 'User updated successfully');
    }

    public function deleteUser(User $user)
    {
        Gate::authorize('manage-users');

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.user-management')
                ->with('error', 'You cannot delete your own account');
        }

        $user->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'description' => 'Deleted user: ' . $user->name,
            'model_type' => User::class,
            'model_id' => $user->id,
        ]);

        return redirect()->route('admin.user-management')
            ->with('success', 'User deleted successfully');
    }

}
