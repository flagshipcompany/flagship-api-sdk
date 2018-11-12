<?php

namespace Flagship\Shipping\Collections;
use Illuminate\Support\Collection;
use Flagship\Shipping\Objects\Pickup;
use Flagship\Shipping\Exceptions\GetPickupListException;

class GetPickupsListCollection extends Collection{
    
    public function importPickups(array $pickups) : array {
        $allPickups = [];
        if(count($pickups) === 0){
            throw new GetPickupListException('No shipments found');
        }
        foreach ($pickups as  $value) {
            $allPickups[] = new Pickup($value);
        }
        parent::__construct($allPickups);
        return $allPickups;
    }

    public function getById(int $id) : Pickup {
        $result = $this->where('pickup.id',$id);
        if($result->isEmpty()){
            throw new GetPickupListException('No Pickups found for id : '.$id);
        }
        return $result->first();
    }

    public function getBySender(string $name) : GetPickupsListCollection {
        $result = $this->filter(
            function($value,$key) use ($name){
            return strcasecmp($value->pickup->address->attn,$name) === 0 ;
        });
        if($result->isEmpty()){
            throw new GetPickupListException('No pickups found for Sender : '.$name);
        }
        return $result;
    }

    public function getByPhone(string $phone) : GetPickupsListCollection {
        $result = $this->where('pickup.address.phone',$phone);
        if($result->isEmpty()){
            throw new GetPickupListException('No Pickups found for phone: '.$phone);
        }
        return $result;
    }

    public function getByCourier(string $courier) : GetPickupsListCollection {
        $result = $this->filter(
            function($value,$key) use ($courier){
                return strcasecmp($value->pickup->courier, $courier) === 0;
            });
        
        if($result->isEmpty()){
            throw new GetPickupListException('No pickups found for courier: '.$courier);
        }
        return $result;
    }

    public function getCommercialPickups() : GetPickupsListCollection {
        $result = $this->where('pickup.address.is_commercial',1);
        if($result->isEmpty()){
            throw new GetPickupListException ('No Commercial Pickups found');
        }
        return $result;
    }

    public function getByDate(string $date) : GetPickupsListCollection {
        $result = $this->where('pickup.date',$date);
        if($result->isEmpty()){
            throw new GetPickupListException('No pickups found for '.$date);
        }
        return $result;
    }

    public function getCancelledPickups() : GetPickupsListCollection {
        $result = $this->where('pickup.cancelled',true);
        if($result->isEmpty()){
            throw new GetPickupListException ('No Cancelled Pickups found');
        }
        return $result;
    }


}