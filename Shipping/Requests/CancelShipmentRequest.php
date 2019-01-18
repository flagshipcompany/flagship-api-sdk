<?php
namespace Flagship\Shipping\Requests;
use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\CancelShipmentException;

class CancelShipmentRequest extends ApiRequest{
    public function __construct(string $baseUrl,string $token, int $id, string $flagshipFor, string $version){

        $this->apiUrl = $baseUrl.'/ship/shipments/'.$id;
        $this->apiToken = $token;
        $this->flagshipFor = $flagshipFor;
        $this->version = $version;
    }

    public function execute() : int {
        try{
            $cancelShipmentRequest = $this->api_request($this->apiUrl,[],$this->apiToken,'DELETE',0,$this->flagshipFor,$this->version);
            return $cancelShipmentRequest["httpcode"] ;
        }
        catch(ApiException $e){
            throw new CancelShipmentException($e->getMessage());
        }
    }
}
