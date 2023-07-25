<?php

use App\Http\Controllers\Controller;
use App\Http\Livewire\Payment\Payment;
use App\Livewire\Payment\StripePayment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/welcome', function () {
    return view('welcome');
});


Route::get('/', function () {
    return view('home');
});


Route::get('/appointment', function () {
    return view('appointment');
})->name("appointment");
Route::get('/patient', function () {
    return view('patients');
});

Route::get('/detail-page', function ($doctorDetail) {
    return view('detail-page', compact('doctorDetail'));
});

Route::get('/confirm', function () {
    return view('confirm');
});

Route::get('/payments', [StripePayment::class,'makePayment']);

Route::get('/success', [StripePayment::class,'success']);

// Route::post('/payment', [Payment::class, 'make_payment'])->name('make.payment');
Route::get('/secret', [Controller::class, 'client_secret']);
