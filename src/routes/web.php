<?php


use Rocky\LaravelTwilio\Http\Controllers\Api\TwimlVoiceController;

Route::get('voice/token', [TwimlVoiceController::class, 'getCapabilityToken'])->name('api.voice.token')->middleware('auth');