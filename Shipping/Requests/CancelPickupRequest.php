<?php
namespace Flagship\Shipping\Requests;
use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\CancelPickupException;

class CancelPickupRequest extends ApiRequest{

    protected $apiUrl;
    protected $responseCode;

    public function __construct(
        string $baseUrl,
        protected string $apiToken,
        int $id,
        protected string $flagshipFor, 
        protected string $version
    ){
        $this->apiUrl = $baseUrl.'/pickups/'.$id;
    }

    public function execute() : bool {
        try{
            $cancelPickupRequest = $this->api_request($this->apiUrl,[],$this->apiToken,'DELETE',30,$this->flagshipFor,$this->version);
            $this->responseCode = $cancelPickupRequest["httpcode"];
            return $cancelPickupRequest["httpcode"] == 200 ? TRUE : FALSE;
        }
        catch(ApiException $e){
            throw new CancelPickupException($e->getMessage());
        }
    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){
            return $this->responseCode;
        }
        return NULL;
    }
}
