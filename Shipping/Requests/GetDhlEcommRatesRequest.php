<?php

namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Collections\RatesCollection;
use Flagship\Shipping\Exceptions\GetDhlEcommRatesException;

class GetDhlEcommRatesRequest extends ApiRequest{

    protected int $responseCode;
    protected string $apiUrl;
    
    public function __construct(
        protected string $apiToken,
        string $baseUrl,
        protected array $payload,
        protected string $flagshipFor,
        protected string $version)
    {
        $this->apiUrl = $baseUrl.'/ship/edhl/rates';
    }

    public function execute() : RatesCollection {
        try{
            $responseArray = $this->api_request($this->apiUrl,$this->payload,$this->apiToken,'POST',30,$this->flagshipFor,$this->version);
            $responseObject = count((array)$responseArray["response"]) == 0 ? [] : $responseArray["response"]->content;
            $rates = new RatesCollection();
            $rates->importRates($responseObject);
            $this->responseCode = $responseArray["httpcode"];
            return $rates;
        } catch(ApiException $e){
            throw new GetDhlEcommRatesException($e->getMessage());
        }
    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){
            return $this->responseCode;
        }
        return NULL;
    }

}