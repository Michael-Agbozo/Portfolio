<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\TwoFactorChallengeController;
use App\Http\Controllers\Dashboard\TwoFactorController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\CvController;
use App\Http\Controllers\Dashboard\DesignController;
use App\Http\Controllers\Dashboard\LogController;
use App\Http\Controllers\Dashboard\MessageController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\ProjectController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

// Public portfolio
Route::get('/', [PortfolioController::class, 'home']);
Route::post('/contact', [PortfolioController::class, 'sendContact'])->middleware('throttle:5,1')->name('contact.send');

// Public project detail
Route::get('/projects/{project}', [PortfolioController::class, 'project'])->name('project.show');

// Auth
Route::get('/login', [LoginController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware(['guest', 'throttle:5,1']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('guest')->group(function () {
    Route::get('/two-factor-challenge', [TwoFactorChallengeController::class, 'show'])->name('two-factor.challenge');
    Route::post('/two-factor-challenge', [TwoFactorChallengeController::class, 'verify'])->middleware('throttle:5,1')->name('two-factor.verify');
});

// Dashboard (auth required)
Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::resource('projects', ProjectController::class)->except(['show']);
    Route::patch('projects/{project}/toggle-active', [ProjectController::class, 'toggleActive'])->name('projects.toggle-active');

    Route::get('designs', [DesignController::class, 'index'])->name('designs.index');
    Route::get('designs/create', [DesignController::class, 'create'])->name('designs.create');
    Route::post('designs', [DesignController::class, 'store'])->name('designs.store');
    Route::get('designs/{design}', [DesignController::class, 'show'])->name('designs.show');
    Route::get('designs/{design}/edit', [DesignController::class, 'edit'])->name('designs.edit');
    Route::post('designs/{design}', [DesignController::class, 'update'])->name('designs.update');
    Route::delete('designs/{design}', [DesignController::class, 'destroy'])->name('designs.destroy');

    Route::get('media', [\App\Http\Controllers\Dashboard\MediaController::class, 'index'])->name('media.index');
    Route::post('media', [\App\Http\Controllers\Dashboard\MediaController::class, 'store'])->name('media.store');
    Route::patch('media/{filename}', [\App\Http\Controllers\Dashboard\MediaController::class, 'update'])->name('media.update')->where('filename', '.*');
    Route::delete('media/{filename}', [\App\Http\Controllers\Dashboard\MediaController::class, 'destroy'])->name('media.destroy')->where('filename', '.*');

    Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::patch('messages/{message}/mark-unread', [MessageController::class, 'markUnread'])->name('messages.mark-unread');
    Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::delete('profile/photo', [ProfileController::class, 'destroyPhoto'])->name('profile.photo.destroy');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::get('cv', [CvController::class, 'show'])->name('cv.show');
    Route::post('cv', [CvController::class, 'update'])->name('cv.update');

    Route::get('logs', [LogController::class, 'index'])->name('logs.index');
    Route::delete('logs', [LogController::class, 'clear'])->name('logs.clear');

    Route::get('security', [TwoFactorController::class, 'show'])->name('security.index');
    Route::post('security/enable', [TwoFactorController::class, 'enable'])->name('security.enable');
    Route::post('security/confirm', [TwoFactorController::class, 'confirm'])->name('security.confirm');
    Route::delete('security', [TwoFactorController::class, 'disable'])->name('security.disable');
    Route::post('security/recovery-codes', [TwoFactorController::class, 'regenerateRecoveryCodes'])->name('security.recovery-codes');
});
