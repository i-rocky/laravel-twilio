<?php

namespace Rocky\LaravelTwilio\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Twilio\Security\RequestValidator;

class  VerifyTwilioRequest
{
    /**
     * @param  Request  $request
     * @param  Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token     = config('services.twilio.auth_token');
        $signature = $request->server('HTTP_X_TWILIO_SIGNATURE');
        $url       = str_replace('http', 'https', $request->fullUrl()); // cloudflare https patch
        $validator = new RequestValidator($token);

        $postVars = $request->request->all();

        if ($validator->validate($signature, $url, $postVars)) {
            return $next($request);
        } else {
            abort(401);
        }
    }
}
