<?php
namespace Flagship\Shipping\Requests;
use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\CancelShipmentException;

class CancelShipmentRequest extends ApiRequest{

    protected $apiUrl;
    protected $responseCode;

    public function __construct(
        protected string $baseUrl,
        protected string $apiToken, 
        int $id, 
        protected string $flagshipFor, 
        protected string $version
    ){
        $this->apiUrl = $baseUrl.'/ship/shipments/'.$id;
    }

    public function execute() : bool {
        try{
            $cancelShipmentRequest = $this->api_request($this->apiUrl,[],$this->apiToken,'DELETE',0,$this->flagshipFor,$this->version);
            $this->responseCode = $cancelShipmentRequest["httpcode"];
            return $cancelShipmentRequest["httpcode"] ==200 ? TRUE : FALSE;
        }
        catch(ApiException $e){
            throw new CancelShipmentException($e->getMessage());
        }
    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){
            return $this->responseCode;
        }
        return NULL;
    }
}
