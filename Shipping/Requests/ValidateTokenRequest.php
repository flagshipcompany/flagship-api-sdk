<?php

namespace Flagship\Shipping\Requests;
use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\ValidateTokenException;

class ValidateTokenRequest extends ApiRequest{
    public function __construct(string $url,$token){
        $this->apiUrl = $url.'/check-token';
        $this->token = $token;
    }

    public function execute() : int {
        try{
            $response = $this->api_request($this->apiUrl,[],$this->token,'GET',30);
            return $response["httpcode"];
        }
        catch(ApiException $e){
            throw new ValidateTokenException($e->getMessage(),$e->getCode());
        }
    }
}