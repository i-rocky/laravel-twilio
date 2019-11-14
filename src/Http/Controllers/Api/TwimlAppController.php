<?php

namespace Rocky\LaravelTwilio\Http\Controllers\Api;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Rocky\LaravelTwilio\Contracts\CallStatus;
use Rocky\LaravelTwilio\Contracts\InboundCall;
use Rocky\LaravelTwilio\Contracts\OutboundCall;
use Rocky\LaravelTwilio\Events\LaravelTwilioCallStatusUpdate;
use Rocky\LaravelTwilio\Events\LaravelTwilioInboundCall;
use Rocky\LaravelTwilio\Events\LaravelTwilioInboundCallRejected;
use Rocky\LaravelTwilio\Events\LaravelTwilioOutboundCall;
use Rocky\LaravelTwilio\Http\Controllers\Controller;
use Twilio\Jwt\ClientToken;
use Twilio\TwiML\VoiceResponse;

class TwimlAppController extends Controller
{
    /**
     * @param  Request  $request
     *
     * @return string
     */
    public function respondToVoiceRequest(Request $request)
    {
        $response = new VoiceResponse();

        $outbound = $request->get('Called') === null;

        // construct the call resource
        $contractClass = $outbound ? OutboundCall::class : InboundCall::class;
        $contract      = new $contractClass(
            $request->get('From'),
            $request->get('To'),
            $request->get('AccountSid'),
            $request->get('CallSid'),
            $request->get('CallStatus')
        );

        $canGetIn = $outbound || config('laravel-twilio.call.enable');
        if ($canGetIn && $request->get('To')) {
            // call acceptable
            $response
                ->dial(null, ['callerId' => config('services.twilio.caller_id')])
                ->number($request->get('To'), [
                    'statusCallbackEvent'  => ['initiated', 'ringing', 'answered', 'completed'],
                    'statusCallback'       => route('api.laravel-twilio.voice.status'),
                    'statusCallbackMethod' => 'POST',
                ]);

            // dispatch event
            $eventClass = $outbound ? LaravelTwilioOutboundCall::class : LaravelTwilioInboundCall::class;
            event(new $eventClass($contract));
        } else {
            $message = config('config.call.message');
            if ($message) {
                $response->say($message);
            } else {
                $response->reject();
            }

            if ( ! $canGetIn) {
                // rejected inbound call
                event(new LaravelTwilioInboundCallRejected($contract));
            }
        }
        $xml = $response->asXML();

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

    /**
     * @param  Request  $request
     *
     * @return ResponseFactory|Response
     */
    public function voiceStatusReport(Request $request)
    {
        $accountSid = $request->get('AccountSid');
        $callSid    = $request->get('CallSid');
        $callStatus = $request->get('CallStatus');

        $status = new CallStatus($accountSid, $callSid, $callStatus);

        event(new LaravelTwilioCallStatusUpdate($status));

        return response('');
    }
}
