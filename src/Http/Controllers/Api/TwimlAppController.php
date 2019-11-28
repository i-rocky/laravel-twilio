<?php

namespace Rocky\LaravelTwilio\Http\Controllers\Api;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Rocky\LaravelTwilio\Contracts\CallRecord;
use Rocky\LaravelTwilio\Contracts\CallStatus;
use Rocky\LaravelTwilio\Contracts\InboundCall;
use Rocky\LaravelTwilio\Contracts\OutboundCall;
use Rocky\LaravelTwilio\Events\LaravelTwilioCallRecord;
use Rocky\LaravelTwilio\Events\LaravelTwilioCallStatusUpdate;
use Rocky\LaravelTwilio\Events\LaravelTwilioInboundCall;
use Rocky\LaravelTwilio\Events\LaravelTwilioInboundCallRejected;
use Rocky\LaravelTwilio\Events\LaravelTwilioOutboundCall;
use Rocky\LaravelTwilio\Exceptions\IdentityMethodNotImplementedException;
use Rocky\LaravelTwilio\Foundation\TwilioCall;
use Rocky\LaravelTwilio\Http\Controllers\Controller;
use Twilio\Jwt\ClientToken;
use Twilio\TwiML\VoiceResponse;

class TwimlAppController extends Controller
{
    /**
     * @param  Request  $request
     *
     * @return ResponseFactory|Response
     */
    public function incomingVoiceRequest(Request $request)
    {
        $response = new VoiceResponse();

        $call = new InboundCall($request->all());
        if ($call->hungup()) {
            $this->_hangup($response);
        } elseif ( ! config('laravel-twilio.call.enable')) {
            $message = config('config.call.message');
            if ($message) {
                $response->say($message);
            } else {
                $response->reject();
            }
            // call rejected
            event(new LaravelTwilioInboundCallRejected($call));
        } elseif ($call->To) {
            $callerId = $call->From;
            $this->_bootstrapCall($response, $call, $callerId);
            // incoming call
            event(new LaravelTwilioInboundCall($call));
        }

        return response($response->asXML(), 200, ['Content-Type' => 'application/xml']);
    }

    /**
     * @param  Request  $request
     *
     * @return ResponseFactory|Response
     */
    public function outgoingVoiceRequest(Request $request)
    {
        $response = new VoiceResponse();

        $call = new OutboundCall($request->all());
        if ($call->hungup()) {
            $this->_hangup($response);
        } elseif ($call->To) {
            $callerId = config('services.twilio.caller_id');
            $this->_bootstrapCall($response, $call, $callerId);
            // outgoing call
            event(new LaravelTwilioOutboundCall($call));
        }

        return response($response->asXML(), 200, ['Content-Type' => 'application/xml']);
    }

    /**
     * @param  VoiceResponse  $response
     */
    private function _hangup(VoiceResponse &$response)
    {
        //  hangup the call
        $response->hangup();

        if (config('laravel-twilio.call.record')) {
            // we have the call recording
            $response->record(['Status' => 'stopped']);
        }
    }

    /**
     * @param  VoiceResponse  $response
     * @param  TwilioCall  $call
     * @param  string  $callerId
     */
    private function _bootstrapCall(VoiceResponse &$response, TwilioCall &$call, string $callerId)
    {
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

        if (preg_match("/^[\d\+\-\(\) ]+$/", $call->To)) {
            $dial->number($call->To, $attrs);
        } else {
            $dial->client($call->To, $attrs);
        }

    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function getCapabilityToken(Request $request)
    {
        $user     = $request->user();
        $identity = null;

        if (method_exists($user, 'laravelTwilioIdentity')) {
            $identity = $user->laravelTwilioIdentity();
        } elseif ($user->username) {
            $identity = $user->username;
        }

        if ( ! $identity) {
            $ex = new IdentityMethodNotImplementedException();

            // not an API route
            return response()->json(['message' => $ex->getMessage()], 500);
        }

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
