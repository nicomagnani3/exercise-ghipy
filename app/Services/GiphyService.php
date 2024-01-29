<?php

namespace App\Services;

use GuzzleHttp\Exception\ClientException;

use GuzzleHttp\Client as HttpClient;
class GiphyService
{
    
    protected $apiKey;
    protected $apiUrl;
    protected $client;

    public function __construct()
    {
        $this->apiKey = config('services.giphy.api_key');
        $this->apiUrl = config('services.giphy.base_url');
        $this->client =new HttpClient([
			'base_uri' =>  $this->apiUrl,			
		]);
    }

    public function response($endPoint, array $params = [ ])
	{
        try{
            $response = $this->client->get($endPoint, ['query' => array_merge($params, ['api_key' => $this->apiKey])]);
            switch ($response->getHeader('content-type'))
            {
                case "application/json":
                    return $response->json();
                    break;
                default:
                    return $response->getBody()->getContents();
            }
        } catch (ClientException $e) {    
            return response()->json([
                'error' => [
                    'code' => $e->getResponse()->getStatusCode(),
                    'message' => $e->getResponse()->getBody()->getContents(),
                ]
            ], $e->getResponse()->getStatusCode());
        }
	}

    public function search($params)
    {
        return $this->response("gifs/search", $params);
    }

    public function getId($id)
	{
	    return $this->response("gifs/$id");
	}
}