<?php

namespace Flagship\Shipping\Requests;
use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\TrackShipmentException;

class TrackShipmentRequest extends ApiRequest{

    public function __construct(string $baseUrl,string $token,int $id, string $flagshipFor, string $version){
        $this->apiUrl= $baseUrl.'/ship/track?shipment_id='.$id;
        $this->apiToken = $token;
        $this->flagshipFor = $flagshipFor;
        $this->version = $version;
    }

    public function execute() : int {
        try{
            $trackShipment = $this->api_request($this->apiUrl,[],$this->apiToken,'GET',30,$this->flagshipFor,$this->version);
            return $trackShipment["httpcode"];
        }
        catch(ApiException $e){
            throw new TrackShipmentException($e->getMessage(),$e->getCode());
        }
    }
}
