<?php

use Illuminate\Support\Facades\Route;
use Modules\Dormitory\Http\Controllers\DormitoryController;
use Modules\Dormitory\Http\Controllers\RoomController;
use Modules\Dormitory\Http\Controllers\RoomTypeController;
use Modules\Dormitory\Http\Controllers\StudentDormitoryController;

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


Route::prefix('admin/room_types')->as('admin.room_types.')->middleware(['auth'])->group(function ()
{
    Route::get('/', [RoomTypeController::class, 'index'])->name('index');
    Route::get('/create', [RoomTypeController::class, 'create'])->name('create');
    Route::post('/', [RoomTypeController::class, 'store'])->name('store');
    Route::get('/edit', [RoomTypeController::class, 'edit'])->name('edit');
    Route::put('/', [RoomTypeController::class, 'update'])->name('update');
    Route::delete('/{room_type}', [RoomTypeController::class, 'destroy'])->name('destroy');

});


Route::prefix('admin/room')->as('admin.room.')->middleware(['auth'])->group(function ()
{
    Route::get('/', [RoomController::class, 'index'])->name('index');
    Route::get('/create', [RoomController::class, 'create'])->name('create');
    Route::post('/', [RoomController::class, 'store'])->name('store');
    Route::get('/edit', [RoomController::class, 'edit'])->name('edit');
    Route::put('/', [RoomController::class, 'update'])->name('update');
    Route::delete('/{room}', [RoomController::class, 'destroy'])->name('destroy');

});

Route::prefix('admin/dorm')->as('admin.dorm.')->middleware(['auth'])->group(function ()
{
    Route::get('/', [DormitoryController::class, 'index'])->name('index');
    Route::get('/create', [DormitoryController::class, 'create'])->name('create');
    Route::post('/', [DormitoryController::class, 'store'])->name('store');
    Route::get('/edit', [DormitoryController::class, 'edit'])->name('edit');
    Route::put('/', [DormitoryController::class, 'update'])->name('update');
    Route::delete('/{dorm}', [DormitoryController::class, 'destroy'])->name('destroy');

});
Route::prefix('admin/assign_student_dormetory')->as('admin.assing_student.')->middleware(['auth'])->group(function ()
{
    Route::get('/', [StudentDormitoryController::class, 'index'])->name('index');
    Route::get('/create', [StudentDormitoryController::class, 'create'])->name('create');
    Route::post('/', [StudentDormitoryController::class, 'store'])->name('store');
    Route::get('/edit', [StudentDormitoryController::class, 'edit'])->name('edit');
    Route::get('/get_rooms_data', [StudentDormitoryController::class, 'get_rooms_data'])->name('get_rooms_data');
    Route::put('/', [StudentDormitoryController::class, 'update'])->name('update');
    Route::delete('/{studentDorm}', [StudentDormitoryController::class, 'destroy'])->name('destroy');

});
