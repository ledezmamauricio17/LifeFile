<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\DepartmentController;
use Illuminate\Support\Facades\Artisan;

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
require __DIR__.'/auth.php';



Route::get('/index', [HomeController::class, 'index'])->middleware('auth')->name('home.index');

//User
Route::get('/loadUsers', [UserController::class, 'index'])->middleware('auth')->name('users.index');
Route::get('/changeStatus', [UserController::class, 'change'])->middleware('auth')->name('users.change');
Route::get('/issetDocument', [UserController::class, 'isset'])->name('users.isset');
Route::post('/create', [UserController::class, 'store'])->middleware('auth')->name('users.store');
Route::post('/createCSV', [UserController::class, 'uploadUsers'])->middleware('auth')->name('users.uploadUsers');
Route::post('/update', [UserController::class, 'update'])->middleware('auth')->name('users.update');
Route::get('/delete', [UserController::class, 'destroy'])->middleware('auth')->name('users.destroy');
Route::get('/loadEditUser', [UserController::class, 'show'])->middleware('auth')->name('users.show');

//Department
Route::get('/loadDepartments', [DepartmentController::class, 'index'])->middleware('auth')->name('department.index');

//History
Route::get('/loadHistory', [RecordController::class, 'index'])->middleware('auth')->name('record.index');
Route::get('/loadHistoryByDates', [RecordController::class, 'filter'])->middleware('auth')->name('record.filter');

//Record
Route::get('/createRecord', [RecordController::class, 'store'])->middleware('guest')->name('record.store');


