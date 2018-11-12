<?php
namespace Flagship\Shipping\Objects;

class Pickup{
    
    public function __construct(\stdClass $pickup){
        $this->pickup = $pickup;
    }

    public function getId() : int {
        return $this->pickup->id;
    }

    public function getConfirmation() : string {
        return $this->pickup->confirmation;
    }

    public function getFullAddress() : array {
        $address = json_decode(json_encode($this->pickup->address),TRUE);
        return $address;
    }

    public function getAddress() : string {
        return $this->pickup->address->address;
    }

    public function getCompany() : string {
        return $this->pickup->address->name;
    }

    public function getName() : string {
        return $this->pickup->address->attn;
    }

    public function getSuite() : ?string {
        return is_null($this->pickup->address->suite) ? NULL : $this->pickup->address->suite;
    }

    public function getCity() : string {
        return $this->pickup->address->city;
    }

    public function getCountry() : string {
        return $this->pickup->address->country;
    }

    public function getState() : string {
        return $this->pickup->address->state;
    }

    public function getPostalCode() : string {
        return $this->pickup->address->postal_code;
    }
    public function getPhone() : string {
        return $this->pickup->address->phone;
    }
    public function getPhoneExt() : ?string {
        return is_null($this->pickup->address->ext) ? NULL : $this->pickup->address->ext;
    }

    public function isAddressCommercial() : bool {
        return $this->pickup->address->is_commercial ? TRUE : FALSE;
    }

    public function getCourier() : string {
        return $this->pickup->courier;
    }

    public function getUnits() : string {
        return $this->pickup->units;
    }

    public function getBoxes() : string {
        return $this->pickup->boxes;
    }

    public function getWeight() : string {
        return $this->pickup->weight;
    }

    public function getPickupLocation() : string {
        return $this->pickup->location;
    }

    public function getDate() : ?string {
        return is_null($this->pickup->date) ? NULL : $this->pickup->date;
    }

    public function getFromTime() : string {
        return $this->pickup->from;
    }

    public function getUntilTime() : string {
        return $this->pickup->until;
    }

    public function getToCountry() : string {
        return $this->pickup->to_country;
    }

    public function getInstructions() : ?string {
        return is_null($this->pickup->instruction) ? NULL : $this->pickup->instruction ;
    }

    public function isCancelled() : bool {
        return ($this->pickup->cancelled) ? TRUE : FALSE ;
    }
}