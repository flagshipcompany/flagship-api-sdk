<?php

namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\GetShipmentListException;
use Flagship\Shipping\Collections\GetShipmentsListCollection;

class GetShipmentListRequest extends ApiRequest{
    
    public function __construct(string $baseUrl,string $apiToken) {
        $this->apiToken = $apiToken;
        $this->url = $baseUrl . '/ship/shipments';
    }

    public function execute() : GetShipmentsListCollection {
        try{
            $request = $this->api_request($this->url,[],$this->apiToken,"GET",30);
            $shipments = new GetShipmentsListCollection();
            $shipments->importShipments($request["response"]->content->records);
            return $shipments;
        }
        catch(ApiException $e){
            throw new GetShipmentListException($e->getMessage());
        }
        
    }

}