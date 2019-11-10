<?php

namespace Rocky\LaravelTwilio\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rocky\LaravelTwilio\Http\Controllers\Controller;
use Rocky\LaravelTwilio\Models\LaravelTwilioMessage;

class MessageDeliveryReportController extends Controller
{
    /**
     * @param  LaravelTwilioMessage  $message
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function report(LaravelTwilioMessage $message, Request $request)
    {
        $message->status = $request->get('MessageStatus', $message->status);
        $message->save();

        return response()->json(['message' => 'Message status updated.']);
    }
}
