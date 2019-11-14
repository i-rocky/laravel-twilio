<?php

namespace Rocky\LaravelTwilio\Http\Controllers\Api;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Rocky\LaravelTwilio\Contracts\FaxDeliveryReport;
use Rocky\LaravelTwilio\Contracts\IncomingFax;
use Rocky\LaravelTwilio\Contracts\MessageDeliveryReport;
use Rocky\LaravelTwilio\Contracts\IncomingMessage;
use Rocky\LaravelTwilio\Events\LaravelTwilioFaxDeliveryReport;
use Rocky\LaravelTwilio\Events\LaravelTwilioIncomingFax;
use Rocky\LaravelTwilio\Events\LaravelTwilioIncomingMessage;
use Rocky\LaravelTwilio\Events\LaravelTwilioMessageDeliveryReport;
use Rocky\LaravelTwilio\Http\Controllers\Controller;
use Twilio\TwiML\FaxResponse;
use Twilio\TwiML\MessagingResponse;

class MessageController extends Controller
{

    /**
     * @param  Request  $request
     *
     * @return ResponseFactory|Response
     */
    public function receiveMessage(Request $request)
    {
        $from       = $request->get('From');
        $to         = $request->get('To');
        $messageSid = $request->get('MessageSid');
        $accountSid = $request->get('AccountSid');
        $body       = $request->get('Body');
        $mediaUrl   = $request->get('OriginalMediaUrl');

        $message = new IncomingMessage($from, $to, $accountSid, $messageSid, $body, $mediaUrl);

        event(new LaravelTwilioIncomingMessage($message));

        $twiml = new MessagingResponse();
        if (config('laravel-twilio.message')) {
            $twiml->message(config('laravel-twilio.message'));
        }

        return response($twiml->asXML(), 200, ['Content-Type' => 'application/xml']);
    }

    /**
     * @return ResponseFactory|Response
     */
    public function faxPing()
    {
        $twiml = new FaxResponse();
        $twiml->receive(['action' => route('api.laravel-twilio.fax.receive')]);

        return response($twiml->asXML(), 200, ['Content-Type' => 'application/xml']);
    }

    /**
     * @param  Request  $request
     *
     * @return ResponseFactory|Response
     */
    public function receiveFax(Request $request)
    {
        $from       = $request->get('From');
        $to         = $request->get('To');
        $faxSid     = $request->get('FaxSid');
        $accountSid = $request->get('AccountSid');
        $mediaUrl   = $request->get('OriginalMediaUrl');

        $message = new IncomingFax($from, $to, $accountSid, $faxSid, $mediaUrl);

        event(new LaravelTwilioIncomingFax($message));

        return response('');
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function messageDeliveryReport(Request $request)
    {
        $accountSid    = $request->get('AccountSid');
        $messageSid    = $request->get('MessageSid');
        $messageStatus = $request->get('MessageStatus');
        $report        = new MessageDeliveryReport($accountSid, $messageSid, $messageStatus);
        event(new LaravelTwilioMessageDeliveryReport($report));

        return response()->json(['message' => 'Delivery Report Received']);
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function faxDeliveryReport(Request $request)
    {
        $accountSid = $request->get('AccountSid');
        $faxSid     = $request->get('FaxSid');
        $faxStatus  = $request->get('FaxStatus');
        $report     = new FaxDeliveryReport($accountSid, $faxSid, $faxStatus);
        event(new LaravelTwilioFaxDeliveryReport($report));

        return response()->json(['message' => 'Delivery Report Received']);
    }
}
