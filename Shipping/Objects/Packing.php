<?php

namespace Flagship\Shipping\Objects;

class Packing{
    public function __construct(\stdClass $packing){
        $this->packing = $packing;
    }

    public function getBoxModel() : string {
        return $this->packing->box_model;
    }

    public function getLength() : string {
        return $this->packing->length;
    }

    public function getWidth() : string {
        return $this->packing->width;
    }

    public function getHeight() : string {
        return $this->packing->height;
    }

    public function getWeight() : int {
        return $this->packing->weight;
    }

    public function getItems() : array {
        return $this->packing->items;
    }
}
