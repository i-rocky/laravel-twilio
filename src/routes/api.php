<?php

use Rocky\LaravelTwilio\Http\Controllers\Api\MessageDeliveryReportController;

Route::post('report/{laravel_twilio_message}/status', [MessageDeliveryReportController::class, 'report'])
     ->name('api.laravel-twilio.report');