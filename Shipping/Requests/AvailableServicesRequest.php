<?php
namespace Flagship\Shipping\Requests;
use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\AvailableServiceException;
use Flagship\Shipping\Collections\AvailableServicesCollection;

class AvailableServicesRequest extends ApiRequest{
    public function __construct($apiToken, $baseUrl){
        $this->apiToken = $apiToken;
        $this->apiUrl = $baseUrl.'/ship/available_services';
    }

    public function execute() : AvailableServicesCollection {
        try{
            $response = $this->api_request($this->apiUrl,[],$this->apiToken,'GET',10);
            $availableServicesArray = $this->createArrayOfServices($response);
            $availableServicesCollection = new AvailableServicesCollection();
            $availableServicesCollection->importServices($availableServicesArray);
            return $availableServicesCollection;
        }
        catch(ApiException $e){
            throw new AvailableServicesException($e->getMessage());
        }
    }

    protected function createArrayOfServices($responseArray) : array {
        $couriers = $responseArray["response"]->content;

        $couriers = get_object_vars($couriers);
        $couriersArray = [];

        foreach ($couriers as $key => $value) {
            if($key === 'fedex'){
                foreach ($value as $service) {
                    $service->courier_description = 'FedEx '.$service->courier_description;
                }
            }
            $couriersArray = array_merge($couriersArray,$value);
        }
        return $couriersArray;
    }

}
