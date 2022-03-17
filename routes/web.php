<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\VoucherController;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

//admin
Route::redirect('admin', '/admin/login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('admin/login', function(){
    if(Auth::check())
        if(Auth::user()->role == 1)
            return redirect()->route('admin.dashboard');
    return view('admin.login');
})->name('login');
Route::post('admin/login', [AuthController::class, 'login']);
Route::post('callback-xendit', [ReservasiController::class, 'xenditInvoiceCallback']);

Route::middleware('admin')->group(function(){
    Route::name('admin.')->group(function(){
        Route::prefix('admin')->group(function(){
            Route::get('dashboard', function(){
                return view('admin.dashboard');
            })->name('dashboard');
        
            Route::resource('banner', BannerController::class)->except('show');
            Route::delete('room/image', [RoomController::class, 'deleteImage'])->name('room.delete.image');
            Route::resource('room', RoomController::class);

            Route::get('reservasi', [ReservasiController::class,  'index'])->name('reservasi.index');
            Route::post('reservasi/update', [ReservasiController::class, 'updateStatus'])->name('reservasi.status');

            Route::get('tamu', [ReservasiController::class, 'tamu'])->name('tamu.index');

            Route::post('generate-voucher', [VoucherController::class, 'generate'])->name('voucher.generate');
            Route::patch('voucher/{id}/change-status', [VoucherController::class, 'changeStatus'])->name('voucher.status');
            Route::resource('voucher', VoucherController::class)->except('show');

            Route::get('check-detail-harga', [ReservasiController::class, 'checkDetailHarga'])->name('check.detail.harga');
        });
    });
});

Route::get('invoices', [SiteController::class, 'invoiceMail'])->name('mail.invoice');

Route::redirect('/', 'id');
Route::prefix('{language}')->group(function(){
    Route::get('/', [SiteController::class, 'index'])->name('home');

    Route::get('rooms/{id}', [SiteController::class, 'roomDetail'])->name('room.detail');

    Route::post('reservasi/{id}', [SiteController::class, 'reservasi'])->name('room.reservasi');

    Route::post('check-voucher', [SiteController::class, 'checkVoucher'])->name('check.voucher');
});
