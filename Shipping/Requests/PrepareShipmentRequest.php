<?php
namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Shipping\Objects\Shipment;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\PrepareShipmentException;

class PrepareShipmentRequest extends ApiRequest{
    public function __construct(string $baseUrl, string $token, array $payload){

        $this->url = $baseUrl.'/ship/prepare';
        $this->token = $token;
        $this->payload = $payload;
    }

    public function execute() : Shipment  {
        try{
            $prepareShipmentRequest = $this->api_request($this->url,$this->payload,$this->token,'POST',30);
            $prepareShipment = new Shipment($prepareShipmentRequest["response"]->content);
            
            return $prepareShipment;
        }
        catch(ApiException $e){
            throw new PrepareShipmentException($e->getMessage());
        }
    }
}