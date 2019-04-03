<?php

namespace Flagship\Shipping\Objects;

class TrackShipment {

    public function __construct(\stdClass $trackShipment){
        $this->trackShipment = $trackShipment;
    }

    public function getCurrentStatus() : string {
        return $this->trackShipment->current_status;
    }

    public function getShipmentId() : int {
        return $this->trackShipment->shipment_id;
    }

    public function getStatusDescription() : string {
        return $this->trackShipment->status_desc;
    }

    public function getCourierUpdate() : ?string{
        return $this->trackShipment->courier_update;
    }
}
