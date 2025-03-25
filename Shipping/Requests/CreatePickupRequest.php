<?php

namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Shipping\Objects\Pickup;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\CreatePickupException;

class CreatePickupRequest extends ApiRequest{
    
    protected $responseCode;
    protected $apiUrl;

    public function __construct(
        protected string $baseUrl,
        protected string $apiToken,
        protected array $payload, 
        protected string $flagshipFor, 
        protected string $version
    ){
        $this->apiUrl = $baseUrl.'/pickups';
    }

    public function execute() : Pickup {
        try{
            $pickupRequest = $this->api_request($this->apiUrl,$this->payload,$this->apiToken,'POST',30,$this->flagshipFor,$this->version);
            $pickupObject = count((array)$pickupRequest["response"]) == 0 ? 
                            new \stdClass() : 
                            ( is_array($pickupRequest["response"]->content) ? 
                                (object)$pickupRequest["response"]->content[0]: 
                                $pickupRequest["response"]->content );

            $pickup = new Pickup($pickupObject);
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
