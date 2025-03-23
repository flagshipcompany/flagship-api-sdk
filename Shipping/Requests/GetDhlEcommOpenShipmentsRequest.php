<?php
namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\GetDhlEcommOpenShipmentsException;
use Flagship\Shipping\Collections\GetShipmentListCollection;

class GetDhlEcommOpenShipmentsRequest extends ApiRequest{

    protected int $responseCode;
    protected string $apiUrl;
    public function __construct(
        protected string $apiToken,
        string $baseUrl,
        protected string $flagshipFor,
        protected string $version)
    {
        $this->apiUrl = $baseUrl.'/ship/edhl/open-shipments';
    }

    public function execute() : GetShipmentListCollection {
        try{    
            $responseArray = $this->api_request($this->apiUrl,[],$this->apiToken,'GET',30,$this->flagshipFor,$this->version);
            $this->responseCode = $responseArray["httpcode"];
            $shipments = count((array)$responseArray["response"]->content) == 0 ? [] : $responseArray["response"]->content->records;
            $openShipments = new GetShipmentListCollection();
            $openShipments->importShipments($shipments);
            return $openShipments;
        } catch (ApiException $e){
            throw new GetDhlEcommOpenShipmentsException($e->getMessage());
        }
    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){
            return $this->responseCode;
        }
        return NULL;
    }
}
