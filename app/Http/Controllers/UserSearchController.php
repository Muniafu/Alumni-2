<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserSearchController extends Controller
{

    public function index(Request $request)
    {
        $query = User::with('profile')
            ->approved()
            ->whereHas('roles', function($q) {
                $q->whereIn('name', ['alumni', 'student']);
            });

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('student_id', 'like', "%$search%")
                    ->orWhere('program', 'like', "%$search%")
                    ->orWhere('skills', 'like', "%$search%")
                    ->orWhereHas('profile', function($q) use ($search) {
                        $q->where('current_job', 'like', "%$search%")
                            ->orWhere('company', 'like', "%$search%")
                            ->orWhereJsonContains('skills', $search);
                    });
            });
        }

        if ($request->has('graduation_year')) {
            $query->where('graduation_year', $request->graduation_year);
        }

        if ($request->has('program')) {
            $query->where('program', 'like', "%{$request->program}%");
        }

        if ($request->has('role')) {
            $query->role($request->role);
        }

        $users = $query->paginate(15)->appends($request->all());

        $graduationYears = User::approved()
            ->select('graduation_year')
            ->distinct()
            ->orderBy('graduation_year', 'desc')
            ->pluck('graduation_year');

        $programs = User::approved()
            ->select('program')
            ->distinct()
            ->whereNotNull('program')
            ->orderBy('program')
            ->pluck('program');

        return view('directory.index', compact('users', 'graduationYears', 'programs'));
    }

    public function show(User $user)
    {
        $user->load('profile');
        return view('directory.show', compact('user'));
    }

}
