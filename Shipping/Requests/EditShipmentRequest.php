<?php
namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Objects\Shipment;
use Flagship\Shipping\Exceptions\EditShipmentException;

class EditShipmentRequest extends Apirequest{

    public function __construct($baseUrl,$token,$payload,$shipmentId){
        $this->apiUrl = $baseUrl.'/ship/shipments/'.$shipmentId;
        $this->apiToken = $token;
        $this->payload = $payload;
    }

    public function execute() : Shipment {
        try{
            $editShipmentRequest = $this->api_request($this->apiUrl,$this->payload,$this->apiToken,'PUT',30);
            $editShipment = new Shipment($editShipmentRequest["response"]->content);
            return $editShipment;
        }
        catch(ApiException $e){
            throw new EditShipmentException($e->getMessage());
        }
    }

}
