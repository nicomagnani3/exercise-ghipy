<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestIp;
class InteractionEvent
{
    use SerializesModels;

    public $userId;
    public $serviceName;
    public $request;
    public $responseCode;
    public $responseData;
    public $ip;

    public function __construct(Request $request,$response)
    {
        $this->userId =$request->user()->id;        
        $this->serviceName = $request->method();
        $this->request =  $request;
        $this->responseCode = $response->status();
        $this->responseData = $response;
        $this->ip = RequestIp::ip();
    }
}