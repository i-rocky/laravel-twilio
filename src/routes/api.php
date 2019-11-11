<?php

use Rocky\LaravelTwilio\Http\Controllers\Api\MessageDeliveryReportController;
use Rocky\LaravelTwilio\Http\Controllers\Api\TwimlVoiceController;

// call
Route::post('voice', [TwimlVoiceController::class, 'respond'])->name('api.voice');
//Route::get('voice/token', [TwimlVoiceController::class, 'getCapabilityToken'])->name('api.voice.token');

Route::post('report/{laravel_twilio_message}/status', [MessageDeliveryReportController::class, 'report'])
     ->name('api.laravel-twilio.report');