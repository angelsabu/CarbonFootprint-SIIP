<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FootprintController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard',
        [FootprintController::class, 'index'])
        ->name('dashboard');

    Route::get('/add',
        [FootprintController::class, 'create'])
        ->name('add.footprint');

    Route::post('/store',
        [FootprintController::class, 'store'])
        ->name('store.footprint');

    Route::get('/export',
        [FootprintController::class, 'exportCsv'])
        ->name('export.footprint');

    Route::get('/edit/{id}',
        [FootprintController::class, 'edit'])
        ->name('edit.footprint');

    Route::post('/update/{id}',
        [FootprintController::class, 'update'])
        ->name('update.footprint');

    Route::get('/delete/{id}',
        [FootprintController::class, 'destroy'])
        ->name('delete.footprint');

});

/*
|--------------------------------------------------------------------------
| PROFILE ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile',
        [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile',
        [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile',
        [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/admin/dashboard',
        [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::get('/admin/delete-user/{id}',
        [AdminController::class, 'deleteUser'])
        ->name('admin.delete.user');

    Route::get('/admin/delete-footprint/{id}',
        [AdminController::class, 'deleteFootprint'])
        ->name('admin.delete.footprint');

});

require __DIR__.'/auth.php';
