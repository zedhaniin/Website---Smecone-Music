<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/about', [LandingController::class, 'about'])->name('about');
Route::get('/gallery', [LandingController::class, 'gallery'])->name('gallery');
Route::get('/gallery/{gallery:slug}', [LandingController::class, 'galleryDetail'])->name('gallery.detail');
Route::get('/showcase', [LandingController::class, 'showcase'])->name('showcase');
Route::get('/struktur', [LandingController::class, 'struktur'])->name('struktur');
Route::get('/struktur/{slug}', [LandingController::class, 'strukturDetail'])->name('struktur.detail');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('otp.verify');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.submit');
    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('otp.resend');

    // Forgot Password & Gmail Reset Routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| User Routes (Authenticated + Approved)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'approved'])->prefix('dashboard')->group(function (): void {
    Route::get('/', [UserDashboardController::class, 'index'])->name('user.dashboard');
    
    // Inven Barang: Katalog & Tracking
    Route::get('/instruments', [UserDashboardController::class, 'instruments'])->name('user.instruments.index');
    Route::get('/borrowings', [UserDashboardController::class, 'borrowings'])->name('user.borrowings.index');
    Route::get('/borrowing/create', [UserDashboardController::class, 'createBorrowing'])->name('user.borrowing.create');
    Route::post('/borrowing', [UserDashboardController::class, 'storeBorrowing'])->name('user.borrowing.store');
    
    // Ruangan & Studio: Liat Info & Tracking Booking
    Route::get('/bookings', [UserDashboardController::class, 'bookings'])->name('user.bookings.index');
    Route::get('/booking/create', [UserDashboardController::class, 'createBooking'])->name('user.booking.create');
    Route::post('/booking', [UserDashboardController::class, 'storeBooking'])->name('user.booking.store');
    
    Route::get('/calendar', [UserDashboardController::class, 'bookingCalendar'])->name('user.calendar');
    
    // Account Profile & Password Settings (Accessible to all authenticated members & admins)
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'approved', 'role:admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/approve', [Admin\UserController::class, 'approve'])->name('users.approve');
    Route::patch('/users/{user}/reject', [Admin\UserController::class, 'reject'])->name('users.reject');
    Route::patch('/users/{user}/role', [Admin\UserController::class, 'updateRole'])->name('users.updateRole');
    Route::delete('/users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');

    // Role & Permissions Management (Super Admin / Ketua & Wakil)
    Route::get('/roles', [Admin\RolePermissionController::class, 'index'])->name('roles.index');
    Route::put('/roles/{role}', [Admin\RolePermissionController::class, 'update'])->name('roles.update');
    Route::post('/roles/{role}/add', [Admin\RolePermissionController::class, 'addPermission'])->name('roles.addPermission');
    Route::post('/roles/{role}/remove', [Admin\RolePermissionController::class, 'removePermission'])->name('roles.removePermission');
    Route::post('/roles/{role}/reset', [Admin\RolePermissionController::class, 'resetDefault'])->name('roles.resetDefault');

    // Instruments
    Route::get('/instruments', [Admin\InstrumentController::class, 'index'])->name('instruments.index');
    Route::get('/instruments/create', [Admin\InstrumentController::class, 'create'])->name('instruments.create');
    Route::post('/instruments', [Admin\InstrumentController::class, 'store'])->name('instruments.store');
    Route::get('/instruments/{instrument}/edit', [Admin\InstrumentController::class, 'edit'])->name('instruments.edit');
    Route::put('/instruments/{instrument}', [Admin\InstrumentController::class, 'update'])->name('instruments.update');
    Route::delete('/instruments/{instrument}', [Admin\InstrumentController::class, 'destroy'])->name('instruments.destroy');

    // Borrowing Approvals
    Route::get('/borrowings', [Admin\BorrowingController::class, 'index'])->name('borrowings.index');
    Route::patch('/borrowings/{borrowing}/approve', [Admin\BorrowingController::class, 'approve'])->name('borrowings.approve');
    Route::patch('/borrowings/{borrowing}/reject', [Admin\BorrowingController::class, 'reject'])->name('borrowings.reject');
    Route::patch('/borrowings/{borrowing}/returned', [Admin\BorrowingController::class, 'returned'])->name('borrowings.returned');

    // Booking Approvals
    Route::get('/bookings', [Admin\StudioBookingController::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{booking}/approve', [Admin\StudioBookingController::class, 'approve'])->name('bookings.approve');
    Route::patch('/bookings/{booking}/reject', [Admin\StudioBookingController::class, 'reject'])->name('bookings.reject');

    // CMS: Gallery, Showcase, Members
    Route::get('/galleries', [Admin\GalleryController::class, 'index'])->name('galleries.index');
    Route::post('/galleries', [Admin\GalleryController::class, 'store'])->name('galleries.store');
    Route::get('/galleries/{gallery}/edit', [Admin\GalleryController::class, 'edit'])->name('galleries.edit');
    Route::put('/galleries/{gallery}', [Admin\GalleryController::class, 'update'])->name('galleries.update');
    Route::delete('/galleries/{gallery}', [Admin\GalleryController::class, 'destroy'])->name('galleries.destroy');
    Route::delete('/galleries/photos/{photo}', [Admin\GalleryController::class, 'destroyPhoto'])->name('galleries.photos.destroy');

    Route::get('/showcases', [Admin\ShowcaseController::class, 'index'])->name('showcases.index');
    Route::post('/showcases', [Admin\ShowcaseController::class, 'store'])->name('showcases.store');
    Route::delete('/showcases/{showcase}', [Admin\ShowcaseController::class, 'destroy'])->name('showcases.destroy');

    Route::get('/members', [Admin\MemberStructureController::class, 'index'])->name('members.index');
    Route::post('/members', [Admin\MemberStructureController::class, 'store'])->name('members.store');
    Route::put('/members/{member}', [Admin\MemberStructureController::class, 'update'])->name('members.update');
    Route::delete('/members/{member}', [Admin\MemberStructureController::class, 'destroy'])->name('members.destroy');

    // Division Management
    Route::get('/divisions/{division:slug}/edit', [Admin\MemberStructureController::class, 'editDivision'])->name('divisions.edit');
    Route::put('/divisions/{division}', [Admin\MemberStructureController::class, 'updateDivision'])->name('divisions.update');
    Route::post('/divisions/{division}/members', [Admin\MemberStructureController::class, 'storeDivisionMember'])->name('divisions.members.store');
});
