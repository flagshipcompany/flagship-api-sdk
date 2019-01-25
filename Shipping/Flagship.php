<?php

namespace Flagship\Shipping;

use Flagship\Shipping\Requests\ValidateTokenRequest;
use Flagship\Shipping\Requests\AvailableServicesRequest;
use Flagship\Shipping\Requests\QuoteRequest;
use Flagship\Shipping\Requests\RateRequest;
use Flagship\Shipping\Requests\CreatePickupRequest;
use Flagship\Shipping\Requests\GetShipmentListRequest;
use Flagship\Shipping\Requests\PrepareShipmentRequest;
use Flagship\Shipping\Requests\EditShipmentRequest;
use Flagship\Shipping\Requests\ConfirmShipmentRequest;
use Flagship\Shipping\Requests\CancelShipmentRequest;
use Flagship\Shipping\Requests\CancelPickupRequest;
use Flagship\Shipping\Requests\EditPickupRequest;
use Flagship\Shipping\Requests\TrackShipmentRequest;
use Flagship\Shipping\Requests\GetPickupListRequest;
use Flagship\Shipping\Requests\PackingRequest;
use Flagship\Shipping\Requests\GetShipmentByIdRequest;
use Flagship\Shipping\objects\Rate;

class Flagship{

    public function __construct(string $apiToken, string $apiUrl, string $flagshipFor=null, string $version=null){
        $this->apiUrl = $apiUrl;
        $this->apiToken = $apiToken;
        $this->flagshipFor = $flagshipFor;
        $this->version = $version;
    }

    public function availableServicesRequest() : AvailableServicesRequest {
        $availableServicesRequest = new AvailableServicesRequest($this->apiToken,$this->apiUrl,$this->flagshipFor,$this->version);
        return $availableServicesRequest;
    }

    public function validateTokenRequest(string $token) : ValidateTokenRequest {
        $validateTokenRequest = new ValidateTokenRequest($this->apiUrl,$token,$this->flagshipFor,$this->version);
        return $validateTokenRequest;
    }

    public  function createQuoteRequest(array $payload) : QuoteRequest {
        $request = new QuoteRequest($this->apiToken,$this->apiUrl,$payload,$this->flagshipFor,$this->version);
        return $request;
    }

    public function getShipmentListRequest() : GetShipmentListRequest {
        $shipmentListRequest = new GetShipmentListRequest($this->apiUrl,$this->apiToken,$this->flagshipFor,$this->version);
        return $shipmentListRequest;
    }

    public function getShipmentByIdRequest(int $id) : GetShipmentByIdRequest {
        $shipmentRequest = new GetShipmentByIdRequest($this->apiUrl,$this->apiToken,$this->flagshipFor,$this->version,$id);
        return $shipmentRequest;
    }

    public function prepareShipmentRequest(array $payload) : PrepareShipmentRequest {
        $prepareShipmentRequest = new PrepareShipmentRequest($this->apiUrl,$this->apiToken,$payload,$this->flagshipFor,$this->version);
        return $prepareShipmentRequest;
    }

    public function packingRequest(array $payload) : PackingRequest {
        $packingRequest = new PackingRequest($this->apiUrl,$this->apiToken,$payload,$this->flagshipFor,$this->version);
        return $packingRequest;
    }

    public function editShipmentRequest(array $payload,int $shipmentId) : EditShipmentRequest {
        $editShipmentRequest = new EditShipmentRequest($this->apiUrl,$this->apiToken,$payload,$shipmentId,$this->flagshipFor,$this->version);
        return $editShipmentRequest;

    }

    public function trackShipmentRequest(int $id) : TrackShipmentRequest {
        $trackShipment = new TrackShipmentRequest($this->apiUrl,$this->apiToken,$id,$this->flagshipFor,$this->version);
        return $trackShipment;
    }

    public function confirmShipmentRequest(array $payload) : ConfirmShipmentRequest {
        $confirmShipmentRequest = new ConfirmShipmentRequest($this->apiUrl,$this->apiToken,$payload,$this->flagshipFor,$this->version);
        return $confirmShipmentRequest;

    }

    public function cancelShipmentRequest(int $id) : CancelShipmentRequest {
        $cancelShipmentRequest = new CancelShipmentRequest($this->apiUrl,$this->apiToken,$id,$this->flagshipFor,$this->version);
        return $cancelShipmentRequest;

    }

    public function createPickupRequest(array $pickupPayload) : CreatePickupRequest {
        $createPickupRequest = new CreatePickupRequest($this->apiUrl,$this->apiToken,$pickupPayload,$this->flagshipFor,$this->version);
        return $createPickupRequest;
    }

    public function editPickupRequest(array $editPickupPayload,int $id) : EditPickupRequest {
        $editPickupRequest = new EditPickupRequest($this->apiUrl,$this->apiToken,$editPickupPayload,$id,$this->flagshipFor,$this->version);
        return $editPickupRequest;
    }

    public function cancelPickupRequest(int $id) : CancelPickupRequest {
        $cancelPickupRequest = new CancelPickupRequest($this->apiUrl,$this->apiToken,$id,$this->flagshipFor,$this->version);
        return $cancelPickupRequest;
    }

    public function getPickupListRequest() : GetPickupListRequest {
        $getPickupListRequest = new GetPickupListRequest($this->apiUrl,$this->apiToken,$this->flagshipFor,$this->version);
        return $getPickupListRequest;
    }

}
