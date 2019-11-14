<?php

use Rocky\LaravelTwilio\Http\Controllers\Api\MessageController;
use Rocky\LaravelTwilio\Http\Controllers\Api\TwimlAppController;

Route::group(['middleware' => 'verify-twilio-request'], function () {

// voice
    Route::post('voice', [TwimlAppController::class, 'respondToVoiceRequest'])->name('api.laravel-twilio.voice');
    Route::post('voice/status',
        [TwimlAppController::class, 'voiceStatusReport'])->name('api.laravel-twilio.voice.status');

// fax
    Route::post('fax', [MessageController::class, 'faxPing'])->name('api.laravel-twilio.fax.ping');
    Route::post('fax/receive', [MessageController::class, 'receiveFax'])->name('api.laravel-twilio.fax.receive');
    Route::post('report/fax/status', [MessageController::class, 'faxDeliveryReport'])
         ->name('api.laravel-twilio.fax.report');

// message
    Route::post('message', [MessageController::class, 'receiveMessage'])->name('api.laravel-twilio.message');
    Route::post('message/status', [MessageController::class, 'messageDeliveryReport'])
         ->name('api.laravel-twilio.message.status');
});
