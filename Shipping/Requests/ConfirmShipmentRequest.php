<?php

namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Shipping\Objects\Shipment;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\ConfirmShipmentException;

class ConfirmShipmentRequest extends ApiRequest{

    public function __construct(string $baseUrl, string $token, array $payload, string $flagshipFor, string $version){
        $this->apiUrl = $baseUrl.'/ship/confirm';
        $this->apiToken = $token;
        $this->payload = $payload;
        $this->flagshipFor = $flagshipFor;
        $this->version = $version;
    }

    public function execute() : Shipment {
        try{
        $confirmShipmentRequest = $this->api_request($this->apiUrl,$this->payload,$this->apiToken,'POST',30,$this->flagshipFor,$this->version);
        $confirmShipment = new Shipment($confirmShipmentRequest["response"]->content);
        return $confirmShipment;
    }
    catch(ApiException $e){
        throw new ConfirmShipmentException($e->getMessage());
    }
    }
}
