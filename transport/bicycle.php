<?php

namespace transport;

class bicycle extends transport{
    
    public function price( $passengers, $baggage, $distance){
        $config = dispetcher::$config;
        
        if ($this->max_passengers >= $passengers &&
            $this->max_baggage >= $baggage &&
            $this->max_distance >= $distance){
            
            $driver_price = $distance * $this->km_price * $this->driver_category;
            $fuel_price = $distance;
            $price = $driver_price + ($fuel_price * $this->amortization);
            
            return $price;
        }
        
        return false;
    }
}
