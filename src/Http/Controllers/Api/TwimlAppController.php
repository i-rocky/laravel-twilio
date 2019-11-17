<?php

namespace Rocky\LaravelTwilio\Http\Controllers\Api;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Rocky\LaravelTwilio\Contracts\CallRecord;
use Rocky\LaravelTwilio\Contracts\CallStatus;
use Rocky\LaravelTwilio\Contracts\InboundCall;
use Rocky\LaravelTwilio\Contracts\OutboundCall;
use Rocky\LaravelTwilio\Events\LaravelTwilioCallRecord;
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
        /** @var InboundCall|OutboundCall $contract */
        $contract = new $contractClass($request->all());

        // check if we got hangup status from recording or wherever
        if ($contract->hungup()) {
            $response->hangup();

            return response($response->asXML(), 200, ['Content-Type' => 'application/xml']);
        }

        $canGetIn = $outbound || config('laravel-twilio.call.enable');
        if ($canGetIn && $request->get('To')) {
            // call acceptable
            $callerId = $outbound ? config('services.twilio.caller_id') : $request->get('From');

            // setup dial attributes
            $dialAttrs = ['callerId' => $callerId];
            if (config('laravel-twilio.call.record')) {
                $dialAttrs['record']                       = 'record-from-answer';
                $dialAttrs['recordingStatusCallback']      = route('api.laravel-twilio.voice.record');
                $dialAttrs['recordingStatusCallbackEvent'] = 'in-progress completed absent failed';
            }
            $dial = $response->dial(null, $dialAttrs);

            // setup number/client attributes
            $attrs = [
                'statusCallbackEvent'  => 'initiated ringing answered completed',
                'statusCallback'       => route('api.laravel-twilio.voice.status'),
                'statusCallbackMethod' => 'POST',
            ];

            if (preg_match("/^[\d\+\-\(\) ]+$/", $request->get('To'))) {
                $dial->number($request->get('To'), $attrs);
            } else {
                $dial->client($request->get('To'), $attrs);
            }

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
        $identity = Str::snake($request->user()->first_name); // TODO: patch for username

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
        $status = new CallStatus($request->all());

        event(new LaravelTwilioCallStatusUpdate($status));

        return response('');
    }

    /**
     * @param  Request  $request
     *
     * @return ResponseFactory|Response
     */
    public function voiceRecord(Request $request)
    {
        // dispatch the call record event
        $record = new CallRecord($request->all());
        event(new LaravelTwilioCallRecord($record));

        return response('');
    }
}
