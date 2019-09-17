<?php

namespace Flagship\Shipping\Objects;

use Flagship\Shipping\Responses\QuoteResponse;

class Rate
{
    public function __construct( \stdClass $rate ) 
    {
        $this->rate = $rate;
    }

    public function getTotal() : float
    {
        return $this->rate->price->total;      
    }

    public function getSubtotal() : float
    {
        return $this->rate->price->subtotal;
    }

    public function getTaxesTotal() : float
    {
        $total = 0;
        foreach ($this->rate->price->taxes as $key => $value) {
            $total += $value;
        }
        return $total;
    }

    public function getTaxesDetails() : array
    {
        foreach ($this->rate->price->taxes as $key => $value) {
            $taxes[$key] = $value;
        }
        return $taxes;
    }

    public function getServiceCode() : int
    {
        return $this->rate->service->courier_code;
    }

    public function getDeliveryDate() : string
    {
        return $this->rate->service->estimated_delivery_date;
    }
    public function getCourierDescription() : string
    {
        return $this->rate->service->courier_desc;
    }
}
