<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

// Pending approval route
Route::get('/pending-approval', [ApprovalController::class, 'pending'])
    ->name('pending-approval');

// Authenticated routes
Route::middleware(['auth', 'approved'])->group(function () {
    // Dashboard redirect
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes (common for all roles)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/pending-approvals', [AdminController::class, 'pendingApprovals'])->name('pending-approvals');
        Route::post('/approve-user/{user}', [AdminController::class, 'approveUser'])->name('approve-user');
        Route::delete('/reject-user/{user}', [AdminController::class, 'rejectUser'])->name('reject-user');

        // User management routes
        Route::get('/user-management', [AdminController::class, 'userManagement'])->name('user-management');
        Route::get('/user/create', [AdminController::class, 'createUser'])->name('user.create');
        Route::post('/user/store', [AdminController::class, 'storeUser'])->name('user.store');
        Route::get('/user/{user}/edit', [AdminController::class, 'editUser'])->name('user.edit');
        Route::put('/user/{user}/update', [AdminController::class, 'updateUser'])->name('user.update');
        Route::delete('/user/{user}/delete', [AdminController::class, 'deleteUser'])->name('user.delete');
    });

    // Alumni routes
    Route::middleware(['role:alumni'])->prefix('alumni')->name('alumni.')->group(function () {
        Route::get('/dashboard', [AlumniController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [AlumniController::class, 'editProfile'])->name('profile');
        Route::post('/profile/update', [AlumniController::class, 'updateProfile'])->name('profile.update');
    });

    // Student routes
    Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [StudentController::class, 'editProfile'])->name('profile');
        Route::post('/profile/update', [StudentController::class, 'updateProfile'])->name('profile.update');
    });
});

// Breeze auth routes
require __DIR__.'/auth.php';
