<?php
namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Objects\Shipment;
use Flagship\Shipping\Exceptions\EditShipmentException;

class EditShipmentRequest extends Apirequest{

    protected $responseCode;
    protected $apiUrl;

    public function __construct(
        protected string $baseUrl,
        protected string $apiToken,
        protected array $payload,
        string $shipmentId, 
        protected string $flagshipFor, 
        protected string $version
    ){
        $this->apiUrl = $baseUrl.'/ship/shipments/'.$shipmentId;
    }

    public function execute() : Shipment {
        try{
            $editShipmentRequest = $this->api_request($this->apiUrl,$this->payload,$this->apiToken,'PUT',30,$this->flagshipFor,$this->version);
            $editShipmentObject = count((array)$editShipmentRequest["response"]) == 0 ? new \stdClass() : $editShipmentRequest["response"]->content;
            $editShipment = new Shipment($editShipmentObject);
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
