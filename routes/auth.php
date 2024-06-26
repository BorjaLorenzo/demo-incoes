<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Workers;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::get('personal', [Workers::class, 'mainView'])
        ->name('personal');

    Route::get('dashboard', [Workers::class, 'dashboard'])
        ->name('dashboard');

    Route::post('/datosTrabajador', [Workers::class, 'getWorker'])
        ->name('getworker');

    Route::post('/desactivar/Trabajador', [Workers::class, 'deleteWorker'])
        ->name('deleteWorker');

    Route::post('/resfrescar/tabla/trabajadores', [Workers::class, 'RefrescarDatatableWorkers'])
        ->name('refreshTableWorkers');

    Route::post('/editar/formulario/trabajadores', [Workers::class, 'editarTrabajador'])
        ->name('editarTrabajador');

    Route::post('/editar/calendario/vacaciones', [Workers::class, 'getVacaciones'])
        ->name('getVacaciones');

    Route::post('/añadir/calendario/vacaciones', [Workers::class, 'setVacaciones'])
        ->name('setVacaciones');

    Route::post('/delete/calendario/vacaciones', [Workers::class, 'removeVacaciones'])
        ->name('removeVacaciones');

    Route::post('/add/trabajador', [Workers::class, 'addTrabajador'])
        ->name('addTrabajador');

    Route::post('/check/dni', [Workers::class, 'checkDNI'])
        ->name('checkDNI');

    Route::get('/get/excel/trabajadores', [Workers::class, 'getExcelTrabajadores'])
        ->name('getExcelTrabajadores');

    Route::get('/send/pdf/trabajadores', [Workers::class, 'generarPDFListaPersonal'])
        ->name('generarPDFListaPersonal');
});
