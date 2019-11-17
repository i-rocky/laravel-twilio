<?php


use Rocky\LaravelTwilio\Http\Controllers\Api\TwimlAppController;

// voice
Route::get('voice/token', [TwimlAppController::class, 'getCapabilityToken'])->name('voice.token')->middleware('auth');
