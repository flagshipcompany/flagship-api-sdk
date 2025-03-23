<?php
namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Shipping\Objects\Shipment;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\PrepareShipmentException;

class PrepareShipmentRequest extends ApiRequest{

    protected $responseCode;
    protected $apiUrl;

    public function __construct(
        protected string $baseUrl, 
        protected string $apiToken, 
        protected array $payload, 
        protected string $flagshipFor, 
        protected string $version
    ){
        $this->apiUrl = $baseUrl.'/ship/prepare';
    }

    public function execute() : ?Shipment  {
        try{
            $prepareShipmentRequest = $this->api_request($this->apiUrl,$this->payload,$this->apiToken,'POST',30,$this->flagshipFor,$this->version);
            $responseObject = count((array)$prepareShipmentRequest["response"]) == 0 ? new \stdClass() : $prepareShipmentRequest["response"]->content ;
            $prepareShipment = new Shipment($responseObject);
            $this->responseCode = $prepareShipmentRequest["httpcode"];
            return $prepareShipment;
        }
        catch(ApiException $e){
            throw new PrepareShipmentException($e->getMessage());
        }
    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){
            return $this->responseCode;
        }
        return NULL;
    }
}
