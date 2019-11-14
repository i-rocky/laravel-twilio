<?php

return [

    'base_url' => env('LARAVEL_TWILIO_BASE_URL', 'laravel-twilio'),


    'call'    => [
        /**
         * Enable/disable the incoming calls
         */
        'enable'  => env('LARAVEL_TWILIO_ENABLE_CALL', false),

        /**
         * Read this message when call is disabled
         * Set message to null to just reject calls
         */
        'message' => env('LARAVEL_TWILIO_REJECT_CALL_MESSAGE', 'Thank you for calling us.'),
    ],


    /**
     * Response to send to incoming message
     */
    'message' => env('LARAVEL_TWILIO_REPLY_MESSAGE', null),
];
