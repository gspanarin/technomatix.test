<?php

namespace transport;

use app\dispetcher;

abstract class transport {

    private $type;
    private $name;
    private $id;
    private $max_passengers;
    private $max_baggage;
    private $fuel_consumption;
    private $max_distance;
    private $amortization;
    private $km_price;
    private $driver_category;

    public function __construct($param = []) {
        foreach ($param as $key => $value)
            if (property_exists(__CLASS__, $key))
                $this->$key = $value;
    }
 
    public function getType(){
        return $this->type;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function getId(){
        return $this->id;
    }

    public function price( $passengers, $baggage, $distance){
        if ($this->max_passengers >= $passengers &&
            $this->max_baggage >= $baggage &&
            $this->max_distance >= $distance){
            
            $driver_price = $distance * $this->km_price * $this->driver_category;
            $fuel_price = ($this->fuel_consumption * $distance / 100) * 56;
            $price = $driver_price +  ($fuel_price * $this->amortization);
            return $price;
        }
        
        return false;
    }
}
