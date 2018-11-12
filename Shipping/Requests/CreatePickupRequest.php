<?php

namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Shipping\Objects\Pickup;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\CreatePickupException;


class CreatePickupRequest extends ApiRequest{

    public function __construct(string $baseUrl,string $token,array $pickupPayload){
        $this->apiUrl = $baseUrl.'/pickups';
        $this->apiToken = $token;
        $this->pickupPayload = $pickupPayload;
    }

    public function execute() : Pickup {
        try{
            $pickupRequest = $this->api_request($this->apiUrl,$this->pickupPayload,$this->apiToken,'POST',30);
            $pickup = new Pickup($pickupRequest["response"]->content);
            return $pickup;
        }
        catch(ApiException $e){
            throw new CreatePickupException($e->getMessage());
        }
    }

}