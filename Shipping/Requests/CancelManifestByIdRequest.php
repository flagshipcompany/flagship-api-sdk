<?php
namespace Flagship\Shipping\Requests;

use Flagship\Apis\Requests\ApiRequest;
use Flagship\Apis\Exceptions\ApiException;
use Flagship\Shipping\Exceptions\CancelManifestByIdException;

class CancelManifestByIdRequest extends ApiRequest{
    
    protected $apiUrl;
    protected $responseCode;

    public function __construct(
        protected string $apiToken,
        protected string $baseUrl,
        int $manifestId,
        protected string $flagshipFor,
        protected string $version
    ){
        $this->apiUrl = $baseUrl.'/ship/edhl/'.$manifestId;
    }

    public function execute() : bool {
        try{    
            $cancelManifestRequest = $this->api_request($this->apiUrl,[],$this->apiToken,'DELETE',30,$this->flagshipFor,$this->version);
            $this->responseCode = $cancelManifestRequest["httpcode"];
            return $this->responseCode == 200 ? TRUE : FALSE;
        } catch (ApiException $e) {
            throw new CancelManifestByIdException($e->getMessage());
        }
    }

    public function getResponseCode() : ?int {
        if(isset($this->responseCode)){
            return $this->responseCode;
        }
        return NULL;
    }

}
