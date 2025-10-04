<?php

use App\Models\Faq;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    $faqs = Faq::all();
    return view('welcome',['faqs' => $faqs]);
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('q/{qr}', [QrCodeController::class, 'sh'])->name('qr.sh');
Route::get('qr/{qr}/vcard', [QrCodeController::class, 'downloadVcard'])->name('qr.vcard');
