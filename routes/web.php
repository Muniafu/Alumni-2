<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ForumCategoryController;
use App\Http\Controllers\ForumThreadController;
use App\Http\Controllers\ForumPostController;
use App\Http\Controllers\UserSearchController;

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

    // Event routes
    Route::resource('events', EventController::class)->only([
        'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
    ]);
    Route::get('/events/calendar', [EventController::class, 'calendar'])->name('events.calendar');
    Route::get('/events/calendar/data', [EventController::class, 'getCalendarEvents'])->name('events.calendar.data');
    Route::post('/events/{event}/rsvp', [EventController::class, 'rsvp'])->name('events.rsvp');
    Route::delete('/events/{event}/rsvp', [EventController::class, 'cancelRsvp'])->name('events.rsvp.cancel');

    // Job Postings
    Route::resource('jobs', JobPostingController::class)->only([
        'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
    ]);
    Route::post('/jobs/{job}/apply', [JobPostingController::class, 'apply'])->name('jobs.apply');
    Route::get('/jobs/{job}/applications', [JobPostingController::class, 'applications'])->name('jobs.applications');
    Route::put('/applications/{application}', [JobPostingController::class, 'updateApplicationStatus'])->name('applications.update');

    // Messaging
    Route::resource('conversations', ConversationController::class)->only([
        'index', 'create', 'store', 'show', 'destroy'
    ]);
    Route::resource('conversations.messages', MessageController::class)->only([
        'store', 'destroy'
    ]);

    // Forum
    Route::prefix('forum')->name('forum.')->group(function () {
        Route::get('/', [ForumCategoryController::class, 'index'])->name('index');
        Route::get('/categories/{category}', [ForumCategoryController::class, 'show'])->name('categories.show');

        Route::resource('threads', ForumThreadController::class)->except(['index']);
        Route::post('/threads/{thread}/posts', [ForumPostController::class, 'store'])->name('posts.store');
        Route::resource('posts', ForumPostController::class)->only(['edit', 'update', 'destroy']);
    });

    // User Directory - Added here
    Route::get('/directory', [UserSearchController::class, 'index'])->name('directory.index');
    Route::get('/directory/{user}', [UserSearchController::class, 'show'])->name('directory.show');

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
