<?php

namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Shipping\Objects\Shipment;
use Flagship\Shipping\Exceptions\GetShipmentByIdException;
use Flagship\Apis\Exceptions\ApiException;

class GetShipmentByIdRequest extends ApiRequest{

    protected $responseCode;
    public function __construct(string $baseUrl,string $apiToken,string $flagshipFor,string $version,int $id){
        $this->apiUrl = $baseUrl.'/ship/shipments/'.$id;
        $this->apiToken = $apiToken;
        $this->flagshipFor = $flagshipFor;
        $this->version = $version;
    }

    public function execute() : Shipment {
        try{
            $response = $this->api_request($this->apiUrl,[],$this->apiToken,"GET",10,$this->flagshipFor,$this->version);
            $shipment = new Shipment($response["response"]->content);
            $this->responseCode = $response["httpcode"];
            return $shipment;
        } catch(ApiException $e){
            throw new GetShipmentByIdException($e->getMessage());
        }
    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){
            return $this->responseCode;
        }
        return NULL;
    }
}
