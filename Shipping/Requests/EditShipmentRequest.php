<?php
namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Objects\Shipment;
use Flagship\Shipping\Exceptions\EditShipmentException;

class EditShipmentRequest extends Apirequest{

    protected $responseCode;

    public function __construct(string $baseUrl,string $token,array $payload,string $shipmentId, string $flagshipFor, string $version){
        $this->apiUrl = $baseUrl.'/ship/shipments/'.$shipmentId;
        $this->apiToken = $token;
        $this->payload = $payload;
        $this->flagshipFor = $flagshipFor;
        $this->version = $version;
    }

    public function execute() : Shipment {
        try{
            $editShipmentRequest = $this->api_request($this->apiUrl,$this->payload,$this->apiToken,'PUT',30,$this->flagshipFor,$this->version);
            $editShipment = new Shipment($editShipmentRequest["response"]->content);
            $this->responseCode = $editShipmentRequest["httpcode"];
            return $editShipment;
        }
        catch(ApiException $e){
            throw new EditShipmentException($e->getMessage());
        }
    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){
            return $this->responseCode;
        }
        return NULL;
    }

}
