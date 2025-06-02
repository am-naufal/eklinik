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
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Dokter\AppointmentController as DokterAppointmentController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Pemilik\DashboardController as PemilikDashboardController;
use App\Http\Controllers\Pemilik\ReportController;
use App\Http\Controllers\Resepsionis\DashboardController as ResepsionisDashboardController;
use App\Http\Controllers\Resepsionis\PatientController as ResepsionisPatientController;
use App\Http\Controllers\Resepsionis\AppointmentController as ResepsionisAppointmentController;
use App\Http\Controllers\Resepsionis\InvoiceController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\InpatientController;
use App\Http\Controllers\Resepsionis\InpatientController as ResepsionisInpatientController;

// Route halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Route autentikasi
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Tambah route register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

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

    // Routes manajemen obat
    Route::resource('medicines', MedicineController::class)->names([
        'index' => 'admin.medicines.index',
        'create' => 'admin.medicines.create',
        'store' => 'admin.medicines.store',
        'show' => 'admin.medicines.show',
        'edit' => 'admin.medicines.edit',
        'update' => 'admin.medicines.update',
        'destroy' => 'admin.medicines.destroy',
    ]);
    Route::post('/medicines/{medicine}/update-stock', [MedicineController::class, 'updateStock'])->name('admin.medicines.update-stock');

    // Room Management Routes
    Route::resource('rooms', RoomController::class)->names([
        'index' => 'admin.rooms.index',
        'create' => 'admin.rooms.create',
        'store' => 'admin.rooms.store',
        'show' => 'admin.rooms.show',
        'edit' => 'admin.rooms.edit',
        'update' => 'admin.rooms.update',
        'destroy' => 'admin.rooms.destroy',
    ]);
    Route::resource('inpatients', InpatientController::class)->names([
        'index' => 'admin.inpatients.index',
        'create' => 'admin.inpatients.create',
        'store' => 'admin.inpatients.store',
        'show' => 'admin.inpatients.show',
        'edit' => 'admin.inpatients.edit',
        'update' => 'admin.inpatients.update',
        'destroy' => 'admin.inpatients.destroy',
    ]);
});

// Route pemilik klinik
Route::prefix('pemilik')->middleware(['auth', \App\Http\Middleware\CheckRole::class . ':pemilik_klinik'])->group(function () {
    Route::get('/dashboard', [PemilikDashboardController::class, 'index'])->name('pemilik.dashboard');

    // Routes manajemen laporan
    Route::resource('reports', ReportController::class)->names([
        'index' => 'pemilik.reports.index',
        'create' => 'pemilik.reports.create',
        'store' => 'pemilik.reports.store',
        'show' => 'pemilik.reports.show',
        'edit' => 'pemilik.reports.edit',
        'update' => 'pemilik.reports.update',
        'destroy' => 'pemilik.reports.destroy',
    ]);
});

// Route resepsionis
Route::prefix('resepsionis')->middleware(['auth', \App\Http\Middleware\CheckRole::class . ':resepsionis'])->group(function () {
    Route::get('/dashboard', [ResepsionisDashboardController::class, 'index'])->name('resepsionis.dashboard');

    // Routes manajemen pasien
    Route::resource('patients', ResepsionisPatientController::class)->names([
        'index' => 'resepsionis.patients.index',
        'create' => 'resepsionis.patients.create',
        'store' => 'resepsionis.patients.store',
        'show' => 'resepsionis.patients.show',
        'edit' => 'resepsionis.patients.edit',
        'update' => 'resepsionis.patients.update',
        'destroy' => 'resepsionis.patients.destroy',
    ]);
    Route::get('/patients/search', [ResepsionisPatientController::class, 'search'])->name('resepsionis.patients.search');

    // Routes manajemen kunjungan
    Route::resource('appointments', ResepsionisAppointmentController::class)->names([
        'index' => 'resepsionis.appointments.index',
        'create' => 'resepsionis.appointments.create',
        'store' => 'resepsionis.appointments.store',
        'show' => 'resepsionis.appointments.show',
        'edit' => 'resepsionis.appointments.edit',
        'update' => 'resepsionis.appointments.update',
        'destroy' => 'resepsionis.appointments.destroy',
    ]);
    Route::get('/check-availability', [ResepsionisAppointmentController::class, 'checkAvailability'])->name('resepsionis.appointments.check-availability');

    // Routes manajemen nota penanganan
    Route::resource('invoices', InvoiceController::class)->names([
        'index' => 'resepsionis.invoices.index',
        'create' => 'resepsionis.invoices.create',
        'store' => 'resepsionis.invoices.store',
        'show' => 'resepsionis.invoices.show',
        'edit' => 'resepsionis.invoices.edit',
        'update' => 'resepsionis.invoices.update',
        'destroy' => 'resepsionis.invoices.destroy',
    ]);
    Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('resepsionis.invoices.print');
    Route::put('/invoices/{invoice}/mark-as-paid', [InvoiceController::class, 'markAsPaid'])->name('resepsionis.invoices.mark-as-paid');

    // Routes manajemen ruang rawat inap
    Route::resource('inpatients', ResepsionisInpatientController::class)->names([
        'index' => 'resepsionis.inpatients.index',
        'create' => 'resepsionis.inpatients.create',
        'store' => 'resepsionis.inpatients.store',
        'show' => 'resepsionis.inpatients.show',
        'edit' => 'resepsionis.inpatients.edit',
        'update' => 'resepsionis.inpatients.update',
        'destroy' => 'resepsionis.inpatients.destroy',
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
    // Tambahkan rute khusus untuk pemeriksaan pasien
    Route::get('/appointments/{appointment}/examine', [DokterAppointmentController::class, 'examine'])->name('dokter.appointments.examine');

    // Routes manajemen obat
    Route::resource('medicines', \App\Http\Controllers\Dokter\MedicineController::class)->names([
        'index' => 'dokter.medicines.index',
        'create' => 'dokter.medicines.create',
        'store' => 'dokter.medicines.store',
        'show' => 'dokter.medicines.show',
        'edit' => 'dokter.medicines.edit',
        'update' => 'dokter.medicines.update',
        'destroy' => 'dokter.medicines.destroy',
    ]);

    Route::get('/medical-records-all/', [MedicalRecordController::class, 'showAllMedicalRecords'])->name('dokter.medical-records.semua');

    // Routes manajemen pasien rawat inap
    Route::resource('inpatients', \App\Http\Controllers\Dokter\InpatientController::class)->only([
        'index',
        'show',
        'update'
    ])->names([
        'index' => 'dokter.inpatients.index',
        'show' => 'dokter.inpatients.show',
        'update' => 'dokter.inpatients.update',
    ]);
});

// Route pasien
Route::prefix('pasien')->middleware(['auth', \App\Http\Middleware\CheckRole::class . ':pasien'])->group(function () {
    Route::get('/dashboard', [PasienDashboardController::class, 'index'])->name('pasien.dashboard');

    // Routes jadwal kunjungan untuk pasien
    Route::get('/jadwal', [App\Http\Controllers\Pasien\AppointmentController::class, 'index'])->name('pasien.appointments.index');
    Route::get('/jadwal/tambah', [App\Http\Controllers\Pasien\AppointmentController::class, 'create'])->name('pasien.appointments.create');
    Route::post('/jadwal', [App\Http\Controllers\Pasien\AppointmentController::class, 'store'])->name('pasien.appointments.store');
    Route::get('/jadwal/{appointment}', [App\Http\Controllers\Pasien\AppointmentController::class, 'show'])->name('pasien.appointments.show');
    Route::put('/jadwal/{appointment}/cancel', [App\Http\Controllers\Pasien\AppointmentController::class, 'cancel'])->name('pasien.appointments.cancel');

    // Routes rekam medis untuk pasien
    Route::get('/rekam-medis', [App\Http\Controllers\Pasien\MedicalRecordController::class, 'index'])->name('pasien.medicalrecords.index');
    Route::get('/rekam-medis/{medicalRecord}', [App\Http\Controllers\Pasien\MedicalRecordController::class, 'show'])->name('pasien.medicalrecords.show');
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
