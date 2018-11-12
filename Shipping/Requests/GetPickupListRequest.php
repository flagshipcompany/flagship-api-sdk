<?php

namespace Flagship\Shipping\Requests;
use Flagship\Apis\Requests\ApiRequest;
use Flagship\Shipping\Collections\GetPickupsListCollection;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\GetPickupListException;

class GetPickupListRequest extends ApiRequest{
    public function __construct($baseUrl,$token){
        $this->apiUrl = $baseUrl.'/pickups';
        $this->apiToken = $token;
    }

    public function execute() : GetPickupsListCollection {
        try{
            $getPickupListRequest = $this->api_request($this->apiUrl,[],$this->apiToken,'GET',10);
            $pickupList = new GetPickupsListCollection();
            $pickupList->importPickups($getPickupListRequest["response"]->content->records);
            return $pickupList;
        }
        catch(ApiException $e){
            throw new GetPickupListException($e->getMessage());
        }
    }
}
