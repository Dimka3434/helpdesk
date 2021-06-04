<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\Auth\ProblemController as AccountProblemController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::apiResource('users', UserController::class);

    Route::put('problems/{id}/performer', [ProblemController::class, 'assignPerformer'])->name('problems.assign_performer');
    Route::apiResource('problems', ProblemController::class);

    Route::apiResource('categories/{id}/subcategories', SubcategoryController::class);
    Route::apiResource('categories', CategoryController::class);

    Route::prefix('/account')->namespace('Auth')->name('account.')->group(function () {
        Route::prefix('/problems')->name('problems.')->group(function () {
            Route::get('/create', [AccountProblemController::class, 'create'])->name('create');
            Route::get('', [AccountProblemController::class, 'index'])->name('index');
            Route::post('', [AccountProblemController::class, 'store'])->name('store');
        });
    });
});

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
