<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_approved' => $request->is_approved ?? false,
        ]);

        $user->assignRole($request->role);
        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function approve(User $user)
    {
        $user->update(['is_approved' => true]);
        return back()->with('success', 'User approved successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted successfully');
    }
}
