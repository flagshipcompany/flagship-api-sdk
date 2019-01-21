<?php

namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Shipping\Objects\Pickup;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\CreatePickupException;


class CreatePickupRequest extends ApiRequest{
    protected $responseCode;
    public function __construct(string $baseUrl,string $token,array $pickupPayload, string $flagshipFor, string $version){
        $this->apiUrl = $baseUrl.'/pickups';
        $this->apiToken = $token;
        $this->pickupPayload = $pickupPayload;
        $this->flagshipFor = $flagshipFor;
        $this->version = $version;
    }

    public function execute() : Pickup {
        try{
            $pickupRequest = $this->api_request($this->apiUrl,$this->pickupPayload,$this->apiToken,'POST',30,$this->flagshipFor,$this->version);
            $pickup = new Pickup($pickupRequest["response"]->content);
            $this->responseCode = $pickupRequest["httpcode"];
            return $pickup;
        }
        catch(ApiException $e){
            throw new CreatePickupException($e->getMessage());
        }
    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){
            return $this->responseCode;
        }
        return NULL;
    }

}
