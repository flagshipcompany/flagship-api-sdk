<?php

namespace Flagship\Shipping;

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
use Flagship\Shipping\objects\Rate;

class Flagship{

    public function __construct(string $apiToken, string $apiUrl){
        $this->apiUrl = $apiUrl;
        $this->apiToken = $apiToken;
    }

    public  function createQuoteRequest(array $payload) : QuoteRequest {
        $request = new QuoteRequest($this->apiToken,$this->apiUrl,$payload);
        return $request;    
    }

    public function getShipmentListRequest() : GetShipmentListRequest {
        $shipmentListRequest = new GetShipmentListRequest($this->apiUrl,$this->apiToken);
        return $shipmentListRequest;
    }

    public function prepareShipmentRequest(array $payload) : PrepareShipmentRequest {
        $prepareShipmentRequest = new PrepareShipmentRequest($this->apiUrl,$this->apiToken,$payload);
        return $prepareShipmentRequest;
    }

    public function editShipmentRequest(array $payload,int $shipmentId) : EditShipmentRequest {
        $editShipmentRequest = new EditShipmentRequest($this->apiUrl,$this->apiToken,$payload,$shipmentId);
        return $editShipmentRequest;

    }

    public function trackShipmentRequest(int $id) : TrackShipmentRequest {
        $trackShipment = new TrackShipmentRequest($this->apiUrl,$this->apiToken,$id);
        return $trackShipment;
    }

    public function confirmShipmentRequest(array $payload) : ConfirmShipmentRequest {
        $confirmShipmentRequest = new ConfirmShipmentRequest($this->apiUrl,$this->apiToken,$payload);
        return $confirmShipmentRequest;

    }

    public function cancelShipmentRequest(int $id) : CancelShipmentRequest {
        $cancelShipmentRequest = new CancelShipmentRequest($this->apiUrl,$this->apiToken,$id);
        return $cancelShipmentRequest;

    }

    public function createPickupRequest(array $pickupPayload) : CreatePickupRequest {
        $createPickupRequest = new CreatePickupRequest($this->apiUrl,$this->apiToken,$pickupPayload);
        return $createPickupRequest;
    }

    public function editPickupRequest(array $editPickupPayload,int $id) : EditPickupRequest {
        $editPickupRequest = new EditPickupRequest($this->apiUrl,$this->apiToken,$editPickupPayload,$id);
        return $editPickupRequest;
    }

    public function cancelPickupRequest(int $id) : CancelPickupRequest {
        $cancelPickupRequest = new CancelPickupRequest($this->apiUrl,$this->apiToken,$id);
        return $cancelPickupRequest;
    }

    public function getPickupListRequest() : GetPickupListRequest {
        $getPickupListRequest = new GetPickupListRequest($this->apiUrl,$this->apiToken);
        return $getPickupListRequest;
    }

}