<?php

use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\InteriorController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\StayController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/book', [PageController::class, 'book'])->name('book');

Route::get('/real-estate', [PropertyController::class, 'index'])->name('real-estate.index');
Route::get('/real-estate/{property:slug}', [PropertyController::class, 'show'])->name('real-estate.show');

Route::get('/interiors', [InteriorController::class, 'index'])->name('interiors.index');
Route::get('/interiors/projects/{project:slug}', [InteriorController::class, 'show'])->name('interiors.show');

Route::get('/stays', [StayController::class, 'index'])->name('stays.index');
Route::get('/stays/{stay:slug}', [StayController::class, 'show'])->name('stays.show');

Route::middleware('throttle:enquiries')->group(function () {
    Route::post('/enquiries', [EnquiryController::class, 'store'])->name('enquiries.store');
    Route::post('/stays/{stay:slug}/request', [StayController::class, 'request'])->name('stays.request');
});
