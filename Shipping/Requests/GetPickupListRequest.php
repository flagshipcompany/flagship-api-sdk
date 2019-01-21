<?php

namespace Flagship\Shipping\Requests;
use Flagship\Apis\Requests\ApiRequest;
use Flagship\Shipping\Collections\GetPickupsListCollection;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\GetPickupListException;

class GetPickupListRequest extends ApiRequest{

    protected $responseCode;
    public function __construct(string $baseUrl,string $token, string $flagshipFor, string $version){
        $this->apiUrl = $baseUrl.'/pickups';
        $this->apiToken = $token;
        $this->flagshipFor = $flagshipFor;
        $this->version = $version;
    }

    public function execute() : GetPickupsListCollection {
        try{
            $getPickupListRequest = $this->api_request($this->apiUrl,[],$this->apiToken,'GET',10,$this->flagshipFor,$this->version);
            $pickupList = new GetPickupsListCollection();
            $pickupList->importPickups($getPickupListRequest["response"]->content->records);
            $this->responseCode = $getPickupListRequest["httpcode"];
            return $pickupList;
        }
        catch(ApiException $e){
            throw new GetPickupListException($e->getMessage());
        }
    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){
            return $this->responseCode;
        }
        return NULL;
    }
}
