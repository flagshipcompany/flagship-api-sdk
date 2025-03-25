<?php

namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Shipping\Objects\Shipment;
use Flagship\Shipping\Exceptions\GetShipmentByIdException;
use Flagship\Apis\Exceptions\ApiException;

class GetShipmentByIdRequest extends ApiRequest{

    protected $responseCode;
    protected $apiUrl;

    public function __construct(
        string $baseUrl,
        protected string $apiToken,
        protected string $flagshipFor,
        protected string $version,
        int $id)
    {
        $this->apiUrl = $baseUrl.'/ship/shipments/'.$id;
    }

    public function execute() : Shipment {
        try{
            $response = $this->api_request($this->apiUrl,[],$this->apiToken,"GET",10,$this->flagshipFor,$this->version);
            $responseObject = count((array)$response["response"]) == 0 ? new \stdClass() : $response["response"]->content;
            $shipment = new Shipment($responseObject);
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
