<?php

namespace Rocky\LaravelTwilio\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Rocky\LaravelTwilio\Http\Controllers\Controller;
use Twilio\Jwt\ClientToken;
use Twilio\TwiML\VoiceResponse;

class TwimlVoiceController extends Controller
{
    /**
     * @param  Request  $request
     *
     * @return string
     */
    public function respond(Request $request)
    {
        $response = new VoiceResponse();
        if ($request->get('To')) {
            $response->dial($request->get('To'), ['callerId' => config('services.twilio.caller_id')]);
        } else {
            $response->say('Thank you for calling us.');
        }
        $xml = $response->asXML();

//        Log::info($xml);

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function getCapabilityToken(Request $request)
    {
        $identity = Str::snake($request->user()->first_name);

        $clientToken = new ClientToken(config('services.twilio.account_sid'), config('services.twilio.auth_token'));
        $clientToken->allowClientOutgoing(config('services.twilio.app_sid'));
        $clientToken->allowClientIncoming($identity);

        return response()->json([
            'token'    => $clientToken->generateToken(),
            'identity' => $identity,
        ]);
    }
}
