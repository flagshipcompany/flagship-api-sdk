<?php
namespace Flagship\Shipping\Requests;
use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\AvailableServicesException;
use Flagship\Shipping\Collections\AvailableServicesCollection;

class AvailableServicesRequest extends ApiRequest{
    
    protected $responseCode;
    protected $apiUrl;
    
    public function __construct(
        protected string $apiToken,
        string $baseUrl,
        protected string $flagshipFor,
        protected string $version
    ){
        $this->apiUrl = $baseUrl.'/ship/available_services';
    }

    public function execute() : AvailableServicesCollection {
        try{
            $response = $this->api_request($this->apiUrl,[],$this->apiToken,'GET',10,$this->flagshipFor,$this->version);
            $availableServicesArray = $this->createArrayOfServices($response);
            $availableServicesCollection = new AvailableServicesCollection();
            $availableServicesCollection->importServices($availableServicesArray);
            $this->responseCode = $response["httpcode"];
            return $availableServicesCollection;
        }
        catch(ApiException $e){
            throw new AvailableServicesException($e->getMessage());
        }
    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){
            return $this->responseCode;
        }
        return NULL;
    }

    protected function createArrayOfServices($responseArray) : array {

        if(count((array)$responseArray["response"]) == 0){
            return [];
        }

        $couriers = $responseArray["response"]->content;

        $couriers = get_object_vars($couriers);
        $couriersArray = [];

        foreach ($couriers as $key => $value) {
            $this->editDescriptionForFedex($key,$value);
            $this->editDescriptionForInternational($value);
            $couriersArray = array_merge($couriersArray,$value);
        }
        return $couriersArray;
    }

    protected function editDescriptionForFedex($key,&$value) : int {
        foreach ($value as $service) {
            $service->courier_description = strcasecmp($key,'fedex') === 0 ? 'FedEx '.$service->courier_description : $service->courier_description;
        }
        return 0;
    }

    protected function editDescriptionForInternational(&$value) : int {
        foreach ($value as $service) {
            $service->courier_description = stripos($service->flagship_code,'intl') !== FALSE && stripos($service->courier_description,'international') === FALSE ? $service->courier_description.' - International' : $service->courier_description;
        }
        return 0;
    }

}
