<?php

namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\QuoteException;
use Flagship\Shipping\Collections\RatesCollection;

class QuoteRequest extends ApiRequest{

    public function __construct(string $apiToken,string $baseUrl,array $payloadArray){
        $this->apiToken = $apiToken;
        $this->payload = $payloadArray;
        $this->url = $baseUrl . '/ship/rates';
    }

    public function execute() : RatesCollection {
        try {

            $responseArray = $this->api_request($this->url,$this->payload,$this->apiToken,'POST',10);
            $newQuotes = new RatesCollection();
            $newQuotes->importRates($responseArray["response"]->content);
            return $newQuotes;
        }

        catch (ApiException $e) {
            throw new QuoteException($e->getMessage());
        }
    }
}