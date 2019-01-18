<?php

namespace Flagship\Shipping\Requests;
use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\EditPickupException;
use Flagship\Shipping\Objects\Pickup;

class EditPickupRequest extends ApiRequest{

    public function __construct(string $baseUrl,string $token,array $payload,string $id, string $flagshipFor, string $version){

        $this->apiUrl = $baseUrl.'/pickups/'.$id;
        $this->apiToken = $token;
        $this->editPickupPayload = $payload;
        $this->flagshipFor = $flagshipFor;
        $this->version = $version;
    }

    public function execute() : Pickup {
        try{
            $editPickupRequest = $this->api_request($this->apiUrl,$this->editPickupPayload,$this->apiToken,'PUT',30,$this->flagshipFor,$this->version);
            $editPickup = new Pickup($editPickupRequest["response"]->content);
            return $editPickup;
        }
        catch(ApiException $e){
            throw new EditPickupException($e->getMessage());
        }
    }
}
