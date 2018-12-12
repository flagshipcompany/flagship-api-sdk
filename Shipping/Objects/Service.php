<?php

namespace Flagship\Shipping\Objects;

class Service
{
    public function __construct( \stdClass $service )
    {
        $this->service = $service;
    }

    public function getCode() : string {
        return $this->service->courier_code;
    }

    public function getDescription() : string {
        return $this->service->courier_description;
    }

    public function getFlagshipCode() : string {
        return $this->service->flagship_code;
    }
}
