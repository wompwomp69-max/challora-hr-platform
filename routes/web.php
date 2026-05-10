<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\User\SavedJobController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ApplicationController as UserApplicationController;
use App\Http\Controllers\Hr\JobController as HrJobController;
use App\Http\Controllers\Hr\ApplicationController as HrApplicationController;
use App\Http\Controllers\Hr\IntelligenceController as HrIntelligenceController;
use Illuminate\Support\Facades\Route;

Route::get('/up', function () {
    return response('OK', 200);
});

Route::get('/debug-file/{appId}', function ($appId) {
    $app = \App\Models\Application::with('user')->find($appId);
    if (!$app) return response()->json(['error' => "Application $appId not found"]);

    $disk = \Illuminate\Support\Facades\Storage::disk('public');
    $fields = ['cv_path', 'diploma_path', 'photo_path'];
    $result = [
        'application_id'      => $appId,
        'storage_path_app'    => storage_path('app/public'),
        'base_path'           => base_path(),
        'public_path_storage' => public_path('storage'),
        'symlink_target'      => is_link(public_path('storage')) ? readlink(public_path('storage')) : 'not a symlink',
        'disk_root'           => $disk->path(''),
        'files' => [],
    ];

    foreach ($fields as $field) {
        $appPath  = $app->$field;
        $userPath = $app->user->$field ?? null;
        $result['files'][$field] = [
            'on_application'      => $appPath,
            'on_user'             => $userPath,
            'app_exists_in_disk'  => $appPath  ? $disk->exists($appPath)  : false,
            'user_exists_in_disk' => $userPath ? $disk->exists($userPath) : false,
            'app_real_path'       => $appPath  ? $disk->path($appPath)    : null,
            'user_real_path'      => $userPath ? $disk->path($userPath)   : null,
            'app_file_exists'     => $appPath  ? file_exists($disk->path($appPath))  : false,
            'user_file_exists'    => $userPath ? file_exists($disk->path($userPath)) : false,
        ];
    }

    return response()->json($result, 200, [], JSON_PRETTY_PRINT);
});

Route::get('/dbcheck', function () {
    return response()->json([
        'host' => env('DB_HOST'),
        'port' => env('DB_PORT'),
        'database' => env('DB_DATABASE'),
        'username' => env('DB_USERNAME'),
        'connection' => env('DB_CONNECTION'),
        'db' => function_exists('DB') ? 'loaded' : 'missing',
        'ping' => (function() {
            try {
                \DB::connection()->getPdo();
                return 'connected';
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        })(),
    ]);
});

Route::get('/', function () {
    $latestJobs = \App\Models\JobPosting::with('creator')->latest()->take(3)->get();
    return view('landing', [
        'pageTitle' => 'Rekrutmen Cerdas (Powered by Chally)',
        'latestJobs' => $latestJobs
    ]);
})->name('landing');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

// Public / Guest accessible Job Listing and Detail
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Download / Preview File
    Route::get('/download/{type}/{id}', [DownloadController::class, 'download'])->name('download.file');
    Route::get('/preview/{type}', [DownloadController::class, 'previewUserFile'])->name('preview.user_file');
    Route::get('/view-document/{type}/{id?}', [DownloadController::class, 'viewDocument'])->name('view.document');
    Route::get('/avatar', [DownloadController::class, 'avatar'])->name('avatar');

    // User / Candidate Routes
    Route::middleware('role:user,hr')->prefix('user')->name('user.')->group(function () {
        Route::get('/settings', [ProfileController::class, 'index'])->name('settings.index');
        Route::get('/settings/edit', [ProfileController::class, 'edit'])->name('settings.edit');
        Route::post('/settings', [ProfileController::class, 'update'])->name('settings.update');
        Route::post('/settings/avatar', [ProfileController::class, 'uploadAvatar'])->name('settings.avatar');
        Route::post('/settings/upload/{field}', [ProfileController::class, 'uploadDocument'])->name('settings.upload');
        Route::post('/settings/ai-suggestion', [ProfileController::class, 'requestAiSuggestion'])->name('settings.ai_suggestion');
        
        Route::get('/applications', [UserApplicationController::class, 'index'])->name('applications.index');
        Route::post('/jobs/{job}/apply', [UserApplicationController::class, 'apply'])->name('jobs.apply');
        
        Route::get('/jobs/saved', [SavedJobController::class, 'index'])->name('jobs.saved');
        Route::post('/jobs/{job}/save', [SavedJobController::class, 'save'])->name('jobs.save');
        Route::post('/jobs/{job}/unsave', [SavedJobController::class, 'unsave'])->name('jobs.unsave');
    });

    // HR Routes
    Route::middleware('role:hr')->prefix('hr')->name('hr.')->group(function () {
        Route::get('/dashboard', \App\Http\Controllers\Hr\DashboardController::class)->name('dashboard');
        Route::get('/intelligence', [HrIntelligenceController::class, 'index'])->name('intelligence');
        Route::get('/intelligence/candidates/{application}', [HrIntelligenceController::class, 'showCandidate'])
            ->name('intelligence.candidates.show');
        
        Route::resource('jobs', HrJobController::class);
        
        Route::get('/applications', [HrApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}/berkas', [HrApplicationController::class, 'berkas'])->name('applications.berkas');
        Route::get('/applications/{application}/file', [HrApplicationController::class, 'berkas'])->name('applications.file');
        Route::post('/applications/{application}/status', [HrApplicationController::class, 'updateStatus'])->name('applications.status');
        Route::post('/applications/{application}/ai-refresh', [HrApplicationController::class, 'refreshAi'])->name('applications.ai_refresh');
    });
});
