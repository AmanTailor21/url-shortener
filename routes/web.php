<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;
Route::get('/', fn () => auth()->check() ? redirect()->route('dashboard') : redirect()->route('login'));
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});
Route::get('/invite/{token}', [InvitationController::class, 'acceptForm'])->name('invitations.accept.form');
Route::post('/invite/{token}', [InvitationController::class, 'accept'])->name('invitations.accept');
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::middleware('role:SuperAdmin')->group(function () {
        Route::get('/clients', [CompanyController::class, 'index'])->name('clients.index');
        Route::get('/clients/create', [CompanyController::class, 'create'])->name('clients.create');
        Route::post('/clients', [CompanyController::class, 'store'])->name('clients.store');
        Route::get('/clients/{company}', [CompanyController::class, 'show'])->name('clients.show');
    });
    Route::middleware('role:SuperAdmin,Admin')->group(function () {
        Route::get('/invite-user', [InvitationController::class, 'create'])->name('users.invite');
        Route::post('/invite-user', [InvitationController::class, 'store'])->name('users.invite.store');
    });
    Route::get('/short-urls', [ShortUrlController::class, 'index'])->name('short-urls.index');
    Route::get('/short-urls/download', [ShortUrlController::class, 'download'])->name('short-urls.download');
    Route::middleware('role:Sales,Manager')->group(function () {
        Route::get('/short-urls/create', [ShortUrlController::class, 'create'])->name('short-urls.create');
        Route::post('/short-urls', [ShortUrlController::class, 'store'])->name('short-urls.store');
    });
    Route::get('/s/{code}', [ShortUrlController::class, 'redirect'])->name('short-urls.redirect');
});
