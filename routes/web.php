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
use App\Http\Controllers\MentorshipController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


// Public directory & events (limited info)
Route::get('/public/directory', [UserSearchController::class, 'publicIndex'])->name('public.directory');
Route::get('/public/events', [EventController::class, 'publicIndex'])->name('public.events');

/*
|--------------------------------------------------------------------------
| Guest Routes (Auth)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::get('/pending-approval', [ApprovalController::class, 'pending'])->name('pending-approval');

/*
|--------------------------------------------------------------------------
| Authenticated & Approved Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'approved'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |-----------------------------
    | Profile Management (All Roles)
    |-----------------------------
    */
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/details', [ProfileController::class, 'updateDetails'])->name('profile.details.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |-----------------------------
    | Events
    |-----------------------------
    */
    Route::resource('events', EventController::class)->except(['show']);
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show'); // Public view for registered users
    Route::get('/events/calendar', [EventController::class, 'calendar'])->name('events.calendar');
    Route::get('/events/calendar/data', [EventController::class, 'getCalendarEvents'])->name('events.calendar.data');
    Route::post('/events/{event}/rsvp', [EventController::class, 'rsvp'])->name('events.rsvp');
    Route::delete('/events/{event}/rsvp', [EventController::class, 'cancelRsvp'])->name('events.rsvp.cancel');

    /*
    |-----------------------------
    | Jobs
    |-----------------------------
    */
    Route::middleware(['can:create jobs'])->group(function () {
        Route::resource('jobs', JobPostingController::class)->except(['index', 'show']);
    });
    Route::get('/jobs/create', [JobPostingController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobPostingController::class, 'store'])->name('jobs.store');
    Route::get('jobs', [JobPostingController::class, 'index'])->name('jobs.index');Route::get('/jobs/my-postings', [JobPostingController::class, 'myPostings'])
            ->name('jobs.my-posting')
            ->middleware('role:alumni');
    Route::get('jobs/{job}', [JobPostingController::class, 'show'])->name('jobs.show');
    Route::post('/jobs/{job}/apply', [JobPostingController::class, 'apply'])->name('jobs.apply');
    Route::get('/jobs/{job}/applications', [JobPostingController::class, 'applications'])->middleware('role:admin|alumni')->name('jobs.applications');
    Route::put('/applications/{application}', [JobPostingController::class, 'updateApplicationStatus'])->middleware('role:admin|alumni')->name('applications.update');
    Route::get('/{application}', [JobPostingController::class, 'showApplication'])->name('jobs.applications.show');
    Route::put('/{application}', [JobPostingController::class, 'updateApplicationStatus'])->name('jobs.applications.update');
    Route::get('/', [JobPostingController::class, 'applications'])->name('jobs.applications');

    /*
    |-----------------------------
    | Messaging
    |-----------------------------
    */
    Route::resource('conversations', ConversationController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    Route::resource('conversations.messages', MessageController::class)->only(['store', 'destroy']);
    Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::get('/conversations/create', [ConversationController::class, 'create'])->name('conversations.create');
    Route::post('/conversations', [ConversationController::class, 'store'])->name('conversations.store');
    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');
    Route::delete('/conversations/{conversation}', [ConversationController::class, 'destroy'])->name('conversations.destroy');

    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    /*
    |-----------------------------
    | Forum
    |-----------------------------
    */
    Route::prefix('forum')->name('forum.')->group(function () {
        Route::get('/', [ForumCategoryController::class, 'index'])->name('index');
        Route::get('/categories/{category}', [ForumCategoryController::class, 'show'])->name('categories.show');
        Route::resource('threads', ForumThreadController::class)->except(['index']);
        Route::post('/threads/{thread}/posts', [ForumPostController::class, 'store'])->name('posts.store');
        Route::resource('posts', ForumPostController::class)->only(['edit', 'update', 'destroy']);
        Route::post('/forum/threads/{thread}/subscribe', [ForumThreadController::class, 'subscribe'])
        ->name('forum.threads.subscribe')
        ->middleware('auth');
        Route::post('/forum/threads/{thread}/unsubscribe', [ForumThreadController::class, 'unsubscribe'])
        ->name('forum.threads.unsubscribe')
        ->middleware('auth');
        });

    /*
    |-----------------------------
    | Notification routes
    |-----------------------------
    */
    Route::post('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])
        ->name('notifications.markAsRead')
        ->middleware('auth');

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.all')
        ->middleware('auth');

    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.markAllAsRead')
        ->middleware('auth');

    /*
    |-----------------------------
    | Mentorship
    |-----------------------------
    */
    Route::prefix('mentorship')->name('mentorship.')->group(function () {
        Route::get('/', [MentorshipController::class, 'index'])->name('mentorship.index');
        Route::get('/find', [MentorshipController::class, 'findMentors'])->name('mentorship.find');
        Route::get('/mentor/{mentor}', [MentorshipController::class, 'showMentor'])->name('mentorship.show-mentor');
        Route::get('/{mentorship}', [MentorshipController::class, 'show'])->name('mentorship.show');
        Route::post('/request/{mentor}', [MentorshipController::class, 'sendRequest'])->name('mentorship.send-request');
        Route::get('/requests', [MentorshipController::class, 'myRequests'])->name('mentorship.requests');
        Route::post('/requests/{mentorshipRequest}/respond', [MentorshipController::class, 'respondToRequest'])->name('mentorship.respond-to-request');
        Route::put('/{mentorship}', [MentorshipController::class, 'update'])->name('mentorship.update');
    });

    /*
    |-----------------------------
    | Directory
    |-----------------------------
    */
    Route::get('/directory', [UserSearchController::class, 'index'])->name('directory.index');
    Route::get('/directory/{user}', [UserSearchController::class, 'show'])->name('directory.show');

    /*
    |-----------------------------
    | Engagement (Leaderboards, Badges)
    |-----------------------------

    Route::get('/leaderboard', [EngagementController::class, 'leaderboard'])->name('leaderboard');
    */

    /*
    |-----------------------------
    | Admin Routes
    |-----------------------------
    */
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/pending-approvals', [AdminController::class, 'pendingApprovals'])->name('pending-approvals');
        Route::post('/approve-user/{user}', [AdminController::class, 'approveUser'])->name('approve-user');
        Route::delete('/reject-user/{user}', [AdminController::class, 'rejectUser'])->name('reject-user');

        // Permissions Manangement
        Route::get('/permissions', [AdminController::class, 'permissions'])->name('permissions');
        Route::get('/permissions/{role}', [AdminController::class, 'getRolePermissions'])->name('permissions.get');
        Route::post('/permissions/update', [AdminController::class, 'updatePermissions'])->name('permissions.update');

        // User Management
        Route::get('/user-management', [AdminController::class, 'userManagement'])->name('user-management');
        Route::get('/user/create', [AdminController::class, 'createUser'])->name('user.create');
        Route::post('/user/store', [AdminController::class, 'storeUser'])->name('user.store');
        Route::get('/user/{user}/edit', [AdminController::class, 'editUser'])->name('user.edit');
        Route::put('/user/{user}/update', [AdminController::class, 'updateUser'])->name('user.update');
        Route::delete('/user/{user}/delete', [AdminController::class, 'deleteUser'])->name('user.delete');

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('index');
            Route::post('/generate', [ReportController::class, 'generate'])->name('generate');
        });

        // Announcements & Newsletter
        /*
        Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
        Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
        Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
        */
    });

    /*
    |-----------------------------
    | Moderator Routes
    |-----------------------------

    Route::middleware(['role:moderator'])->prefix('moderator')->name('moderator.')->group(function () {
        Route::get('/dashboard', [ModeratorController::class, 'dashboard'])->name('dashboard');
        Route::get('/reports', [ModeratorController::class, 'viewReports'])->name('reports');
        Route::post('/reports/{report}/resolve', [ModeratorController::class, 'resolveReport'])->name('reports.resolve');
    });

    */

    /*
    |-----------------------------
    | Alumni Routes
    |-----------------------------
    */
    Route::middleware(['role:alumni'])->prefix('alumni')->name('alumni.')->group(function () {
        Route::get('/dashboard', [AlumniController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [AlumniController::class, 'editProfile'])->name('profile');
        Route::post('/profile/update', [AlumniController::class, 'updateProfile'])->name('profile.update');
    });

    /*
    |-----------------------------
    | Student Routes
    |-----------------------------
    */
    Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [StudentController::class, 'editProfile'])->name('profile');
        Route::post('/profile/update', [StudentController::class, 'updateProfile'])->name('profile.update');
    });
});

// Breeze auth routes
require __DIR__.'/auth.php';
