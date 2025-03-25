<?php

namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\ManifestListException;
use Flagship\Shipping\Collections\ManifestListCollection;

class GetManifestsListRequest extends ApiRequest{

    protected int $responseCode;
    protected string $apiUrl;

    public function __construct(
        protected string $apiToken, 
        string $baseUrl,
        protected string $flagshipFor,
        protected string $version)
    {
        $this->apiUrl = $baseUrl.'/ship/edhl/';
    }

    public function execute() : ManifestListCollection {
        try{
            $responseArray = $this->api_request($this->apiUrl,[],$this->apiToken,'GET',30,$this->flagshipFor,$this->version);
            $manifests = count((array)$responseArray["response"]) == 0 ? [] : $responseArray["response"]->content->records;
            $manifestList = new ManifestListCollection();
            $this->responseCode = $responseArray["httpcode"];
            $manifestList->importManifests($manifests);
            return $manifestList;
        } catch (ApiException $e){
            throw new ManifestListException($e->getMessage());
        }
    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){    
            return $this->responseCode;
        }
        return NULL;
    }   
}
