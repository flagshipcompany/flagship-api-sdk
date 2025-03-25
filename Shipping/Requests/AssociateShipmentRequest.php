<?php

namespace Flagship\Shipping\Requests;
use Flagship\Apis\Requests\ApiRequest;
use Flagship\Shipping\Exceptions\AssociateShipmentException;
use Flagship\Apis\Exceptions\ApiException;

class AssociateShipmentRequest extends ApiRequest{
    protected $responseCode;
    protected $apiUrl;

    public function __construct(
        protected string $apiToken, 
        string $baseUrl, 
        int $manifestId,
        protected array $payload,
        protected string $flagshipFor, 
        protected string $version
    ){
        $this->apiUrl = $baseUrl.'/ship/edhl/associate/'.$manifestId;
    }

    public function execute() : bool {
        try{
            $responseArray = $this->api_request($this->apiUrl,$this->payload,$this->apiToken,'PATCH',30,$this->flagshipFor,$this->version);
            $this->responseCode = $responseArray["httpcode"];
            return $responseArray["httpcode"] == 204 ? TRUE : FALSE;
        } catch(ApiException $e){
            throw new AssociateShipmentException($e->getMessage());
        }
    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){
            return $this->responseCode;
        }
        return NULL;
    }
}
