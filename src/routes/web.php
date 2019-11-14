<?php


use Rocky\LaravelTwilio\Http\Controllers\Api\TwimlAppController;

Route::get('call', function () {
    return view('laravel-twilio::call');
});

// voice
Route::get('voice/token', [TwimlAppController::class, 'getCapabilityToken'])->name('voice.token')->middleware('auth');
