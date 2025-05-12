<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Dokter\DashboardController as DokterDashboardController;
use App\Http\Controllers\Dokter\MedicalRecordController;
use App\Http\Controllers\Pasien\DashboardController as PasienDashboardController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Dokter\AppointmentController as DokterAppointmentController;

Route::auth();
// Route halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Route autentikasi
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route admin
Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\CheckRole::class . ':admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Routes manajemen user
    Route::resource('users', UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);

    // Routes manajemen dokter
    Route::resource('doctors', DoctorController::class)->names([
        'index' => 'admin.doctors.index',
        'create' => 'admin.doctors.create',
        'store' => 'admin.doctors.store',
        'show' => 'admin.doctors.show',
        'edit' => 'admin.doctors.edit',
        'update' => 'admin.doctors.update',
        'destroy' => 'admin.doctors.destroy',
    ]);

    // Routes manajemen pasien
    Route::resource('patients', PatientController::class)->names([
        'index' => 'admin.patients.index',
        'create' => 'admin.patients.create',
        'store' => 'admin.patients.store',
        'show' => 'admin.patients.show',
        'edit' => 'admin.patients.edit',
        'update' => 'admin.patients.update',
        'destroy' => 'admin.patients.destroy',
    ]);

    // Routes manajemen appointment
    Route::resource('appointments', AppointmentController::class)->names([
        'index' => 'admin.appointments.index',
        'create' => 'admin.appointments.create',
        'store' => 'admin.appointments.store',
        'show' => 'admin.appointments.show',
        'edit' => 'admin.appointments.edit',
        'update' => 'admin.appointments.update',
        'destroy' => 'admin.appointments.destroy',
    ]);
});

// Route dokter
Route::prefix('dokter')->middleware(['auth', \App\Http\Middleware\CheckRole::class . ':dokter'])->group(function () {
    Route::get('/dashboard', [DokterDashboardController::class, 'index'])->name('dokter.dashboard');

    // Routes manajemen rekam medis
    Route::resource('medical-records', MedicalRecordController::class)->names([
        'index' => 'dokter.medical-records.index',
        'create' => 'dokter.medical-records.create',
        'store' => 'dokter.medical-records.store',
        'show' => 'dokter.medical-records.show',
        'edit' => 'dokter.medical-records.edit',
        'update' => 'dokter.medical-records.update',
        'destroy' => 'dokter.medical-records.destroy',
    ]);

    // Routes manajemen kunjungan untuk dokter
    Route::resource('appointments', DokterAppointmentController::class)->only([
        'index',
        'show',
        'update'
    ])->names([
        'index' => 'dokter.appointments.index',
        'show' => 'dokter.appointments.show',
        'update' => 'dokter.appointments.update',
    ]);
});

// Route pasien
Route::prefix('pasien')->middleware(['auth', \App\Http\Middleware\CheckRole::class . ':pasien'])->group(function () {
    Route::get('/dashboard', [PasienDashboardController::class, 'index'])->name('pasien.dashboard');
});


use Illuminate\Support\Facades\Artisan;

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize');
    return "Cache, Config, View, Route, Optimize Cleared";
});
