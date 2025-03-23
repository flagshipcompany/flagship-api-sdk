<?php

namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\QuoteException;
use Flagship\Shipping\Collections\RatesCollection;

class QuoteRequest extends ApiRequest{

    protected $responseCode;
    protected $apiUrl;

    public function __construct(
        protected string $apiToken,
        protected string $baseUrl,
        protected array $payload, 
        protected string $flagshipFor, 
        protected string $version
    ){
        $this->apiUrl = $baseUrl . '/ship/rates';
    }

    public function execute() : RatesCollection {

        try {
            $responseArray = $this->api_request($this->apiUrl,$this->payload,$this->apiToken,'POST',10,$this->flagshipFor,$this->version);
            $responseObject = count((array)$responseArray["response"]) == 0 ? [] : $responseArray["response"]->content;
            $newQuotes = new RatesCollection();
            $newQuotes->importRates($responseObject);
            $this->responseCode = $responseArray["httpcode"];
            return $newQuotes;
        }
        catch (ApiException $e) {
            throw new QuoteException($e->getMessage());
        }
    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){
            return $this->responseCode;
        }
        return NULL;
    }
}
