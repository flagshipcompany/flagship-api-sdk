<?php
namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Shipping\Objects\Shipment;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\ConfirmShipmentByIdException;

class ConfirmShipmentByIdRequest extends ApiRequest{
    
    protected $responseCode;
    protected $apiUrl;

    public function __construct(
        protected string $baseUrl,
        protected string $apiToken, 
        int $id, 
        protected string $flagshipFor,
        protected string $version
    ){
        $this->apiUrl = $baseUrl.'/ship/'.$id.'/confirm';
    }

    public function execute() : Shipment {
        try{
            $confirmShipmentRequest = $this->api_request
                                ($this->apiUrl,[],$this->apiToken,'PUT',30,$this->flagshipFor,$this->version);
            $confirmShipmentObject = count((array)$confirmShipmentRequest["response"]) == 0
                                        ? new \stdClass() : $confirmShipmentRequest["response"]->content;
            $confirmShipment = new Shipment($confirmShipmentObject);
            $this->responseCode = $confirmShipmentRequest["httpcode"];
            return $confirmShipment;
        }
        catch(ApiException $e){
            throw new ConfirmShipmentByIdException($e->getMessage());
        }
    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){
            return $this->responseCode;
        }
        return NULL;
    }
}
