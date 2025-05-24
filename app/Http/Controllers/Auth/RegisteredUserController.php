<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use App\Models\ActivityLog;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', [
            'graduationYears' => range(date('Y') - 10, date('Y') + 5),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'student_id' => ['required', 'string', 'max:50', 'unique:users'],
            'graduation_year' => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . (date('Y') + 5)],
            'program' => ['required', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'student_id' => $request->student_id,
            'graduation_year' => $request->graduation_year,
            'program' => $request->program,
            'is_approved' => false,
        ]);

        // Determine role based on graduation year
        $currentYear = date('Y');
        $role = ($request->graduation_year <= $currentYear) ? 'alumni' : 'student';
        
        $user->assignRole($role);

        try {
            // Create empty profile
            $user->profile()->create([]);
        } catch (\Exception $e) {
            Log::error('Failed to create profile for user: ' . $user->id, [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        // Log the registration
        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'register',
            'description' => 'User registered with ' . $role . ' role',
            'model_type' => User::class,
            'model_id' => $user->id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registration successful! Your account is pending approval.');
    }
}