<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;


// Splash Screen
Route::get('/', function () {
    return view('splash');
})->name('splash');

// Guest Routes (Authentication)
// Route::middleware('guest')->group(function () {

Route::get('/jwu', function () {
    return view('admin.login');
})->name('jwu');

    Route::get('/', [AuthController::class, 'splash'])->name('splash');
    
    
    Route::get('/test', function () {
    return auth()->check() ? 'LOGGED IN' : 'NOT LOGGED IN';
});

    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
// });




// Protected Routes (Require Authentication)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/rank', [DashboardController::class, 'rank'])->name('rank');
    
    // Quiz Routes
    Route::prefix('quiz')->name('quiz.')->group(function () {
        Route::get('/{quizId}/instructions', [QuizController::class, 'instructions'])->name('instructions');
        Route::get('/{quizId}/prayer', [QuizController::class, 'prayer'])->name('prayer');
        
        
        Route::post('/{quizId}/start', [QuizController::class, 'start'])->name('start');
        Route::get('/attempt/{attemptId}/question/{questionNumber}', [QuizController::class, 'question'])->name('question');
        Route::post('/attempt/{attemptId}/save-answer', [QuizController::class, 'saveAnswer'])->name('saveAnswer');
        Route::post('/attempt/{attemptId}/submit', [QuizController::class, 'submit'])->name('submit');
        Route::get('/attempt/{attemptId}/result', [QuizController::class, 'result'])->name('result');
        Route::get('/attempt/{attemptId}/review', [QuizController::class, 'review'])->name('review');
    });
    
    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::put('/change-password', [ProfileController::class, 'changePassword'])->name('changePassword');
    });
    
    // History Routes
    Route::prefix('history')->name('history.')->group(function () {
        Route::get('/', [HistoryController::class, 'index'])->name('index');
        Route::get('/{attemptId}', [HistoryController::class, 'show'])->name('show');
    });
    
    
     Route::prefix('prayer')->name('prayer.')->group(function () {
        Route::get('/', [DashboardController::class, 'prayer_page'])->name('index');
        Route::get('{id}', [DashboardController::class, 'prayer_points'])->name('show');
    });

      Route::prefix('verse')->name('verse.')->group(function () {
        Route::get('/', [DashboardController::class, 'memoryverse_page'])->name('index');
        Route::get('{id}', [DashboardController::class, 'verse'])->name('show');
    });
    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
         Route::get('users/{user}/history', [\App\Http\Controllers\Admin\UserController::class, 'history'])->name('users.history');
        Route::resource('quizzes', \App\Http\Controllers\Admin\QuizController::class);
        Route::resource('prayer', \App\Http\Controllers\Admin\PrayerController::class);
        Route::resource('verse', \App\Http\Controllers\Admin\VerseController::class);
        Route::resource('quizzes.questions', \App\Http\Controllers\Admin\QuestionController::class)->except(['index', 'show']);
        Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/{quiz}', [\App\Http\Controllers\Admin\ReportController::class, 'show'])->name('reports.show');
    });
});
