<?php

namespace App\Http\Controllers\Infrastructure\Gateway;

use App\Http\Controllers\Domain\Gateway\ExternalGateway;
use GuzzleHttp\Client;

class Feegow implements ExternalGateway
{
    private $headers;
    private $body;
    private $method;
    private $url;
    /**
     * @var mixed
     */
    private $clientId;
    /**
     * @var mixed
     */
    private $clientSecret;

    public function __construct()
    {
        $this->url = env('FEEGOW_API');
        $this->clientSecret = env("FEEGOW_TOKEN");

        $this->method = 'GET';

        $this->setBodyRequest();

        $this->defineHeaders();
    }

    public function callFeegow($uri = null)
    {
        $client = new Client();
        $response = $client->request($this->method , $this->url.$uri, $this->defineHeaders());
        $data = json_decode($response->getBody(),true);
        $data['success']=true;
        return $data;
    }

    public function setBodyRequest()
    {
        /**
         * star/end off collect
         */
        // $startOfYesterday = Carbon::today()->subDays(3)->timestamp;
        // $endOfYesterday = Carbon::today()->timestamp;

        // /**
        //  * payload graphql
        //  */
        // $payload = '{"query":"{\\n  conversionReport(purchaseTimeStart: \\"' . $startOfYesterday . '\\",';
        // $payload .= 'purchaseTimeEnd: \\"' . $endOfYesterday . '\\") {\\n  ';
        // $payload .= 'nodes {\\n    device\\n  checkoutId\\n   orders{\\n  orderId\\n items{\\n actualAmount\\n }} ';
        // $payload .= 'utmContent\\n  }\\n  }\\n}\\n","variables":{}}';

        // $this->body = $payload;
    }


    private function defineHeaders()
    {
        return $this->headers =  array('headers'=>[
            'Content-Type' => 'application/json',
            'x-access-token'=> $this->clientSecret
        ]);
    }


    public function getMethodCaller(): string
    {
        return $this->method;
    }

    public function setMethodCaller($method = 'GET')
    {
        $this->method = $method;
    }

    public function getHeadersCaller(): array
    {
        return $this->headers;
    }

    public function urlCaller(): string
    {
        return $this->url;
    }

    public function bodyCaller(): string
    {
        return $this->body;
    }
}
