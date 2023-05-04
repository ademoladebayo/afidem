<?php

namespace App\Http\Middleware;

use App\Model\ActivityLogModel;
use App\Util\Utils;
use Illuminate\Support\Facades\Log;

use Closure;

class ActivityLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function terminate($request, $response)
    {
        // REQUEST
        $token = $request->header("Authorization");
        $request_data = $request->input();
        $request_method = $request->method();
        $request_url = $request->fullUrl();

        // RESPONSE
        $response_status = $response->status();
        $response_content = $response->content();


        // Log::debug($token);
        // Log::debug($request_data);
        // Log::debug($request_method);
        // Log::debug($request_url);
        // Log::debug($response_status);
        // Log::debug($response_content);

        $request_data = count($request_data) > 0 ? $request_data : "NO DATA WAS SENT";
        $utils = new Utils();
        $activityLog = new ActivityLogModel();
        $activityLog->request = $request_method . " | " . $request_url . "\n" . json_encode($request_data). "\n" . $request->header("User-Agent");
        $activityLog->date_time = $response->getdate();
        $response = strlen($response_content) > 500 ? "RETURNED A LONG DATA" : $response_content;
        $req = strlen($activityLog->request) > 500 ? $request_method . " | " . $request_url . "\n"  . $request->header("User-Agent") : $activityLog->request;

        $activityLog->request = $req;
        $activityLog->response = $response_status . " :::: " . $response;
        $utils->logUserActivity($token, $activityLog);
    }
}
