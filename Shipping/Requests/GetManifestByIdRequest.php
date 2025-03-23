<?php
namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\GetManifestByIdException;
use Flagship\Shipping\Objects\Manifest;

class GetManifestByIdRequest extends ApiRequest {

    protected int $responseCode;
    protected string $apiUrl;
    
    public function __construct(
        protected string $apiToken, 
        protected string $baseUrl, 
        int $manifestId, 
        protected string $flagshipFor, 
        protected string $version)
    {
        $this->apiUrl = $baseUrl.'/ship/edhl/'.$manifestId;
    }

    public function execute() : Manifest {
        try{
            $responseArray = $this->api_request($this->apiUrl,[],$this->apiToken,'GET',30,$this->flagshipFor,$this->version);
            $returnedManifest = count((array) $responseArray["response"]) == 0 ? new \stdClass() : $responseArray["response"]->content;
            $this->responseCode = $responseArray["httpcode"];

            $manifest = new Manifest($returnedManifest);
            return $manifest;
        } catch (ApiException $e){
            throw new GetManifestByIdException($e->getMessage());
        }
    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){
            return $this->responseCode;
        }
        return NULL;
    }
}
