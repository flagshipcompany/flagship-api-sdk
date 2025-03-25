<?php

namespace Flagship\Shipping\Requests;
use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\TrackShipmentException;
use Flagship\Shipping\Objects\TrackShipment;

class TrackShipmentRequest extends ApiRequest{

    protected int $responseCode;
    protected string $apiUrl;
    
    public function __construct(
        protected string $baseUrl,
        protected string $apiToken,
        int $id,
        protected string $flagshipFor,
        protected string $version
    ){
        $this->apiUrl= $baseUrl.'/ship/track?shipment_id='.$id;
    }

    public function execute() {
        try{
            $trackShipment = $this->api_request($this->apiUrl,[],$this->apiToken,'GET',30,$this->flagshipFor,$this->version);
            $this->responseCode = $trackShipment["httpcode"];
            $trackingObject = count((array)$trackShipment["response"]) == 0 ? new \stdClass() : $trackShipment["response"]->content ;
            return new TrackShipment($trackingObject);
        }
        catch(ApiException $e){
            throw new TrackShipmentException($e->getMessage(),$e->getCode());
        }
    }
    public function getResponseCode() : int {
        return $this->responseCode;
    }
}
