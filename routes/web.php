<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuotaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TimeFrameController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Middleware\CheckTimeFrame;
use App\Http\Controllers\ChooseSupervisorController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;





Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/password/forgot', [AuthController::class, 'showForgotPasswordForm'])->name('password.forgot');
Route::post('/password/email', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

// Routes for changing passwords
Route::get('/password/change', [PasswordChangeController::class, 'edit'])->name('password.change');
Route::post('/password/change', [PasswordChangeController::class, 'update'])->name('password.change.update');

// Group routes with `auth` and `CheckPasswordChanged` middleware
Route::middleware(['auth', \App\Http\Middleware\CheckPasswordChanged::class])->group(function () {
    // Dashboard Routes
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/supervisor/dashboard', [DashboardController::class, 'supervisorDashboard'])->name('supervisor.dashboard');
    Route::get('/students/dashboard', [DashboardController::class, 'studentDashboard'])->name('student.dashboard');


    // Quota Routes
    Route::get('/Quota', [QuotaController::class, 'index'])->name('quota.index');
    Route::get('/quota/create', [QuotaController::class, 'create'])->name('quota.create');
    Route::post('/quota', [QuotaController::class, 'store'])->name('quota.store');
    Route::get('/quota/{id}/edit', [QuotaController::class, 'edit'])->name('quota.edit');
    Route::put('/quota/{id}', [QuotaController::class, 'update'])->name('quota.update');
    Route::delete('/quota/{id}', [QuotaController::class, 'destroy'])->name('quota.destroy');

    // Timeframe Routes
    Route::get('/timeframes', [TimeFrameController::class, 'index'])->name('timeframes.index');
    Route::get('/timeframes/create', [TimeFrameController::class, 'create'])->name('timeframes.create');
    Route::post('/timeframes', [TimeFrameController::class, 'store'])->name('timeframes.store');
    Route::get('/timeframes/{id}/edit', [TimeFrameController::class, 'edit'])->name('timeframes.edit');
    Route::put('/timeframes/{id}', [TimeFrameController::class, 'update'])->name('timeframes.update');
    Route::delete('/timeframes/{id}', [TimeFrameController::class, 'destroy'])->name('timeframes.destroy');

    // User Routes
    Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/admin/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/admin/users/{id}/update', [UserController::class, 'update'])->name(name: 'users.update');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Report Routes
    Route::get('/admin/reports/users', [ReportController::class, 'userReport'])->name('reports.users');
    Route::get('/admin/reports/users/export', [ReportController::class, 'exportUserReport'])->name('reports.users.export');
    Route::get('/admin/reports/users/export/pdf', [ReportController::class, 'exportUserReportPDF'])->name('reports.users.export.pdf');

    Route::get('/admin/topics', [AdminController::class, 'viewAllTopics'])->name('admin.topics');

    // Supervisor Post Topics
    Route::middleware(['auth', CheckTimeFrame::class . ':Supervisor Post Topics'])->group(function () {

        Route::get('/topics/create', [TopicController::class, 'create'])->name('topics.create');
        Route::post('/topics', [TopicController::class, 'store'])->name('topics.store');
    });
    Route::get('/topics', [TopicController::class, 'index'])->name('topics.index');

    // Student Routes
    Route::middleware(['auth', CheckTimeFrame::class . ':Student Apply for Topics'])->group(function () {
        Route::get('/students/view-topics', [TopicController::class, 'viewTopics'])->name('students.view-topics');
        Route::get('/students/view-status', [TopicController::class, 'viewTopicStatus'])->name('students.view-status');
        Route::post('/students/apply-topic/{id}', [TopicController::class, 'applyTopic'])->name('students.apply-topic');
        Route::post('/students/search-topics', [TopicController::class, 'searchTopics'])->name('students.search-topics');
    });

    Route::get('/supervisor/dashboard', [SupervisorController::class, 'dashboard'])->name('supervisor.dashboard');
    Route::post('/supervisor/approve-application/{id}', [SupervisorController::class, 'approveApplication'])->name('supervisor.approve-application');
    Route::post('/supervisor/reject-application/{id}', [SupervisorController::class, 'rejectApplication'])->name('supervisor.reject-application');

    // Supervisor Accept Applications
    Route::middleware(['auth', CheckTimeFrame::class . ':Supervisor Accept Applications'])->group(function () {
        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::post('/applications/{id}/review', [ApplicationController::class, 'review'])->name('applications.review');
    });

    Route::post('/topics/{id}/apply', [TopicController::class, 'apply'])->name('students.apply-topic');

    Route::get('/notifications', function () {
        $notifications = DB::table('notifications')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifications.index', compact('notifications'));
    })->name('notifications.index');

    Route::get('/notifications/mark-as-read/{id}', function ($id) {
        DB::table('notifications')->where('id', $id)->update(['is_read' => true]);
        return redirect()->back();
    })->name('notifications.markAsRead');

    Route::middleware(['auth'])->group(function () {
        Route::get('/student/timeframes', [App\Http\Controllers\TimeFrameController::class, 'viewStudentTimeframes'])->name('student.timeframes');
        Route::get('/supervisor/timeframes', [App\Http\Controllers\TimeFrameController::class, 'viewSupervisorTimeframes'])->name('supervisor.timeframes');
    });
});

//Appointment
Route::middleware(['auth'])->group(function () {
    // Supervisor can manage their own appointments and slots
    Route::get('/appointments/manage', [AppointmentController::class, 'manageAppointments'])->name('appointments.manage');

    // Supervisor can add new slots
    Route::post('/appointments/add-slot', [AppointmentController::class, 'addSlot'])->name('appointments.addSlot');

    // Supervisor can toggle availability of slots (mark them available or unavailable)
    Route::patch('/appointments/slots/{slotId}/toggle', [AppointmentController::class, 'toggleSlotAvailability'])->name('appointments.toggleAvailability');

    // Supervisor can approve/reject an appointment request
    Route::patch('/appointments/{appointment}/manage', [AppointmentController::class, 'manageAppointmentStatus'])->name('appointments.manageStatus');
});

//Student Appointment
Route::middleware(['auth'])->group(function () {
    // Student can request an appointment for an available slot
    Route::post('/appointments/request', [AppointmentController::class, 'requestAppointment'])->name('appointments.request');

    // Student can view their own appointments (pending, approved, rejected)
});


Route::get('/send-test-email', function () {
    Mail::raw('This is a test email.', function ($message) {
        $message->to('mus.razor@gmail.com')
            ->subject('Test Email');
    });
    return 'Email sent successfully!';
});
