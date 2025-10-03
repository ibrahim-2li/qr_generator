<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\QrCodeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('q/{qr}', [QrCodeController::class, 'sh'])->name('qr.sh');
Route::get('qr/{qr}/vcard', [QrCodeController::class, 'downloadVcard'])->name('qr.vcard');
