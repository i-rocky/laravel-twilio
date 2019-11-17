<?php

use Rocky\LaravelTwilio\Http\Controllers\Api\MessageController;
use Rocky\LaravelTwilio\Http\Controllers\Api\TwimlAppController;

Route::group(['middleware' => 'verify-twilio-request'], function () {

// voice
    Route::post('voice', [TwimlAppController::class, 'outgoingVoiceRequest'])->name('api.laravel-twilio.voice.outgoing');
    Route::post('voice/incoming', [TwimlAppController::class, 'incomingVoiceRequest'])->name('api.laravel-twilio.voice.incoming');
    Route::post('voice/status', [TwimlAppController::class, 'voiceStatusReport'])->name('api.laravel-twilio.voice.status');
    Route::post('voice/record', [TwimlAppController::class, 'voiceRecord'])->name('api.laravel-twilio.voice.record');

// fax
    Route::post('fax/incoming', [MessageController::class, 'faxPing'])->name('api.laravel-twilio.fax.ping');
    Route::post('fax/receive', [MessageController::class, 'receiveFax'])->name('api.laravel-twilio.fax.receive');
    Route::post('report/fax/status', [MessageController::class, 'faxDeliveryReport'])->name('api.laravel-twilio.fax.report');

// message
    Route::post('message/incoming', [MessageController::class, 'receiveMessage'])->name('api.laravel-twilio.message.incoming');
    Route::post('message/status', [MessageController::class, 'messageDeliveryReport'])->name('api.laravel-twilio.message.status');
});
