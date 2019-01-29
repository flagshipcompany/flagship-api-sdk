<?php
namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\PackingException;
use Flagship\Shipping\Collections\PackingCollection;

class PackingRequest extends ApiRequest{

    protected $responseCode;
    public function __construct(string $baseUrl,string $token, array $payload, string $flagshipFor, string $version){
        $this->token = $token;
        $this->url = $baseUrl.'/ship/packing';
        $this->payload = $payload;
        $this->flagshipFor = $flagshipFor;
        $this->version = $version;
    }

    public function execute() : PackingCollection {
        try{
            $packingRequest = $this->api_request($this->url,$this->payload,$this->token,'POST',30,$this->flagshipFor,$this->version);

            $packages = new PackingCollection();

            $packages->importPackages($packingRequest["response"]->content->packages);
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
