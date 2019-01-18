<?php
namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\PackingException;
use Flagship\Shipping\Collections\PackingCollection;

class PackingRequest extends ApiRequest{
    public function __construct(string $apiUrl,string $apiToken, array $payload, string $flagshipFor, string $version){
        $this->apiToken = $apiToken;
        $this->apiUrl = $apiUrl.'/ship/packing';
        $this->payload = $payload;
        $this->flagshipFor = $flagshipFor;
        $this->version = $version;
    }

    public function execute() : PackingCollection {
        try{
            $packingRequest = $this->api_request($this->apiUrl,$this->payload,$this->apiToken,'POST',30,$this->flagshipFor,$this->version);

            $packages = new PackingCollection();

            $packages->importPackages($packingRequest["response"]->content->packages);

            return $packages;
        }
        catch(ApiException $e){
            throw new PackingException($e->getMessage());
        }
    }
}
