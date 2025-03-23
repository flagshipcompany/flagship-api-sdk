<?php

namespace Flagship\Shipping\Requests;
use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\EditPickupException;
use Flagship\Shipping\Objects\Pickup;

class EditPickupRequest extends ApiRequest{

    protected $responseCode;
    protected $apiUrl;
    
    public function __construct(
        protected string $baseUrl,
        protected string $apiToken,
        protected array $payload,
        protected string $id, 
        protected string $flagshipFor, 
        protected string $version
    ){
        $this->apiUrl = $baseUrl.'/pickups/'.$id;
    }

    public function execute() : Pickup {
        try{
            $editPickupRequest = $this->api_request($this->apiUrl,$this->payload,$this->apiToken,'PUT',30,$this->flagshipFor,$this->version);
            $pickupObject = count((array)$editPickupRequest["response"]) == 0 ? new \stdClass() : $editPickupRequest["response"]->content;
            $editPickup = new Pickup($pickupObject);
            $this->responseCode = $editPickupRequest["httpcode"];
            return $editPickup;
        }
        catch(ApiException $e){
            throw new EditPickupException($e->getMessage());
        }
    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){
            return $this->responseCode;
        }
        return NULL;
    }
}
