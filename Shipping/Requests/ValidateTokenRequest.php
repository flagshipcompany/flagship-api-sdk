<?php

namespace Flagship\Shipping\Requests;
use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\ValidateTokenException;

class ValidateTokenRequest extends ApiRequest{

    protected string $apiUrl;
    public function __construct(
        protected string $baseUrl,
        protected string $apiToken, 
        protected string $flagshipFor, 
        protected string $version
    ){
        $this->apiUrl = $baseUrl.'/check-apiToken';
    }

    public function execute() : int {
        try{
            $response = $this->api_request($this->apiUrl,[],$this->apiToken,'GET',30,$this->flagshipFor,$this->version);
            return $response["httpcode"];
        }
        catch(ApiException $e){
            throw new ValidateTokenException($e->getMessage(),$e->getCode());
        }
    }
}
