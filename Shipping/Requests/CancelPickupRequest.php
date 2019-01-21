<?php
namespace Flagship\Shipping\Requests;
use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\CancelPickupException;

class CancelPickupRequest extends ApiRequest{
    public function __construct(string $baseUrl,string $token,int $id, string $flagshipFor, string $version){
        $this->apiUrl = $baseUrl.'/pickups/'.$id;
        $this->apiToken = $token;
        $this->flagshipFor = $flagshipFor;
        $this->version = $version;
    }

    public function execute() : int {
        try{
            $cancelPickupRequest = $this->api_request($this->apiUrl,[],$this->apiToken,'DELETE',30,$this->flagshipFor,$this->version);
            return $cancelPickupRequest["httpcode"];

        }
        catch(ApiException $e){
            throw new CancelPickupException($e->getMessage());
        }
    }
}
