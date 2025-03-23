<?php

namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\GetShipmentListException;
use Flagship\Shipping\Collections\GetShipmentListCollection;
use Flagship\Shipping\Exceptions\FilterException;

class GetShipmentListRequest extends ApiRequest{

    protected $responseCode;
    protected $filters;
    protected $apiUrl;
    
    public function __construct(
        protected string $baseUrl,
        protected string $apiToken, 
        protected string $flagshipFor, 
        protected string $version) 
    {
        $this->apiUrl = $baseUrl . '/ship/shipments';
        $this->filters = [
                    'courier',
                    'status',
                    'reference',
                    'tracking_number',
                    'package_pin',
                    'page',
                    'limit'
                ];
    }

    public function execute() : GetShipmentListCollection {
        try{
            $request = $this->api_request($this->apiUrl,[],$this->apiToken,"GET",30,$this->flagshipFor,$this->version);
            $shipmentRecords = count((array)$request["response"]) == 0 ? [] : $request["response"]->content->records;
            $shipments = new GetShipmentListCollection();
            $shipments->importShipments($shipmentRecords);
            $this->responseCode = $request["httpcode"];
            return $shipments;
        }
        catch(ApiException $e){
            throw new GetShipmentListException($e->getMessage());
        }

    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){
            return $this->responseCode;
        }
        return NULL;
    }

    public function addFilter($key,$value) : GetShipmentListRequest {
        try{
            return $this->addRequestFilter($key,$value);
        }catch(FilterException $e){
            throw new GetShipmentListException($e->getMessage(),$e->getCode());
        }
    }

}
