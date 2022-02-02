<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SiteController;
use App\Models\Room;
use Illuminate\Http\Request;
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
Route::redirect('/', 'id');
Route::prefix('{language}')->group(function(){
    Route::get('/', [SiteController::class, 'index'])->name('home');

    Route::get('rooms/{id}', [SiteController::class, 'roomDetail'])->name('room.detail');

    Route::post('reservasi/{id}', [SiteController::class, 'reservasi'])->name('room.reservasi');
});


//admin
Route::name('admin.')->group(function(){
    Route::prefix('admin')->group(function(){
        Route::get('', function(){
            return view('admin.dashboard');
        });
    
        Route::resource('banner', BannerController::class)->except('show');
        Route::delete('room/image', [RoomController::class, 'deleteImage'])->name('room.delete.image');
        Route::resource('room', RoomController::class);
    });
});