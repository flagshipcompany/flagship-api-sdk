<?php

namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\QuoteException;
use Flagship\Shipping\Collections\RatesCollection;

class QuoteRequest extends ApiRequest{

    protected $responseCode;

    public function __construct(string $apiToken,string $baseUrl,array $payloadArray, string $flagshipFor, string $version){
        $this->apiToken = $apiToken;
        $this->payload = $payloadArray;
        $this->url = $baseUrl . '/ship/rates';
        $this->flagshipFor = $flagshipFor;
        $this->version = $version;
    }

    public function execute() : RatesCollection {

        try {
            $responseArray = $this->api_request($this->url,$this->payload,$this->apiToken,'POST',10,$this->flagshipFor,$this->version);
            $newQuotes = new RatesCollection();
            $newQuotes->importRates($responseArray["response"]->content);
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
