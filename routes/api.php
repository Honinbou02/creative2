<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\Generator\GeneratorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix("envato")->name("envato.")->group(function (){
   Route::get("products", [AdminController::class,"envatoProducts"])->name("products") ;
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

# Admin Users
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::post('add-admin', [AdminController::class, 'store'])->name('admin.store'); //->middleware('demo');
});


Route::prefix("generator")->name("generator.")->group(function(){
    Route::post("new-topics", [GeneratorController::class,"generateTopics"])->name("generateTopics");
    Route::post("new-keywords", [GeneratorController::class,"generateKeywords"])->name("generateKeywords");
    Route::post("new-titles", [GeneratorController::class,"generateTitles"])->name("generateTitles");
    Route::post("new-outlines", [GeneratorController::class,"generateOutlines"])->name("generateOutlines");
});
