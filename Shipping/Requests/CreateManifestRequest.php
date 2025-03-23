<?php

namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\CreateManifestException;
use Flagship\Shipping\Objects\Manifest;

class CreateManifestRequest extends ApiRequest
{
    protected $responseCode;

    public function __construct(
        protected string $apiToken,
        protected string $baseUrl,
        protected array $payload,
        protected string $flagshipFor,
        protected string $version
    ){
        $this->baseUrl = $baseUrl.'/ship/edhl/create';
    }

    public function execute() : Manifest {
        try{
            $response = $this->api_request($this->baseUrl,$this->payload,$this->apiToken,'POST',30,$this->flagshipFor,$this->version);
            $createdManifest = count((array) $response["response"]) == 0 ? new \stdClass() : $response["response"]->content;
            $manifest = new Manifest($createdManifest);
            $this->responseCode = $response["httpcode"];
            return $manifest;
        } catch (ApiException $e){
            throw new CreateManifestException($e->getMessage());
        }
    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){
            return $this->responseCode;
        }
        return NULL;
    }

}