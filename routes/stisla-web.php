<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\YoutubeController;
use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Route;

# DASHBOARD
// Route::get('/', [DashboardController::class, 'home'])->name('home');
Route::get('/', function() {
    return view('frontend.portal');
})->name('portal');

# AUTH
Route::get('auth/login', [AuthController::class, 'loginForm'])->name('login');
Route::get('auth/login2', [AuthController::class, 'loginForm'])->name('login2');
Route::post('auth/login', [AuthController::class, 'login'])->name('login-post');
Route::get('auth/send-email-verification', [AuthController::class, 'verificationForm'])->name('send-email-verification');
Route::post('auth/verification', [AuthController::class, 'sendEmailVerification']);
Route::get('auth/verify/{token}', [AuthController::class, 'verify'])->name('verify');
Route::get('auth/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('auth/register', [AuthController::class, 'register']);
Route::get('auth/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('auth/forgot-password', [AuthController::class, 'forgotPasswordForm'])->name('forgot-password');
Route::post('auth/forgot-password', [AuthController::class, 'forgotPassword']);
Route::get('auth/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('reset-password');
Route::post('auth/reset-password/{token}', [AuthController::class, 'resetPassword']);

// Rute untuk portal
Route::get('auth/login-portal', [AuthController::class, 'loginPortal'])->name('login-portal');
Route::post('auth/login-portal', [AuthController::class, 'loginPortalPost'])->name('login-portal-post');
Route::post('auth/logout-portal', [AuthController::class, 'logoutPortal'])->name('logout-portal');

# SOCIAL LOGIN AND REGISTER
Route::get('auth/social-login/{provider}', [AuthController::class, 'socialLogin'])->name('social-login');
Route::get('auth/social-register/{provider}', [AuthController::class, 'socialRegister'])->name('social-register');
Route::get('auth/social/{provider}/callback', [AuthController::class, 'socialCallback'])->name('social-callback');

# CRUD GENERATOR
Route::get('crud-generator', [CrudController::class, 'index'])->middleware('auth');
Route::post('crud-generator', [CrudController::class, 'generateJson'])->middleware('auth');

# YOUTUBE
Route::get('youtube/view-sync', [YoutubeController::class, 'viewSync'])->name('youtube.view-sync')->middleware('auth');

# TEST
Route::get('test', [TestingController::class, 'test'])->name('test');

# FRONTEND ROUTES
Route::get('/sidarling', [FrontendController::class, 'sidarling'])->name('sidarling');
Route::get('/info-sidarling/jadwal', [FrontendController::class, 'allJadwalSidarling'])->name('all-jadwal-sidarling');
Route::get('/info-sidarling/jadwal/{id}', [FrontendController::class, 'detailJadwalSidarling'])->name('jadwal-sidarling.detail');
Route::get('/permohonan-masyarakat', [FrontendController::class, 'permohonanMasyarakat'])->name('permohonan-masyarakat');
Route::get('/peraturan', [FrontendController::class, 'peraturan'])->name('peraturan');
Route::get('/biaya', [FrontendController::class, 'biaya'])->name('biaya');
Route::middleware(['auth'])->group(function () {
    Route::get('/upload-penetapan', [FrontendController::class, 'uploadPenetapan'])->name('upload-penetapan');
    Route::post('/upload-penetapan', [FrontendController::class, 'storePenetapan'])->name('upload-penetapan.store');
});