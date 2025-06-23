<?php

use Illuminate\Support\Facades\Route;
use Modules\LogManager\App\Http\Controllers\LogManagerController;
use Modules\LogManager\App\Http\Controllers\LogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin/logs', 'as' => 'admin.logs.', 'middleware' => ['auth', 'verified', 'permission']], function () {
        // List all log folders and root log files
        Route::get('/', [LogController::class, 'index'])->name('index');

        Route::get('/dashboard', [LogController::class, 'dashboard'])->name('dashboard');

        // Show files in a specific log folder
        Route::get('/{folderName}', [LogController::class, 'showFolder'])->name('folder');

        // Show contents of a specific log file
        Route::get('/{folderName}/{fileName}', [LogController::class, 'showFile'])->name('file');
});

Route::group([], function () {
    Route::resource('logmanager', LogManagerController::class)->names('logmanager');
});
