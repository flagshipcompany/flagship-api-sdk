<?php
namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\PackingException;
use Flagship\Shipping\Collections\PackingCollection;

class PackingRequest extends ApiRequest{

    protected $responseCode;
    protected $apiUrl;
    
    public function __construct(
        protected string $baseUrl,
        protected string $apiToken, 
        protected array $payload, 
        protected string $flagshipFor, 
        protected string $version)
    {
        $this->apiUrl = $baseUrl.'/v2/ship/packing';
    }

    public function execute() : PackingCollection {
        try{
            $packingRequest = $this->api_request($this->apiUrl,$this->payload,$this->apiToken,'POST',30,$this->flagshipFor,$this->version);
            $packagingObject = count((array)$packingRequest["response"]) == 0 ? [] : $packingRequest["response"]->content->packages;
            $packages = new PackingCollection();

            $packages->importPackages($packagingObject);
            $this->responseCode = $packingRequest["httpcode"];
            return $packages;
        }
        catch(ApiException $e){
            throw new PackingException($e->getMessage());
        }
    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){
            return $this->responseCode;
        }
        return NULL;
    }
}
