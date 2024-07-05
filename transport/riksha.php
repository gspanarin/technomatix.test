<?php

namespace transport;

use app\dispetcher;

/**
 * Класс рікша має перевизначений метод price, так як у розрахунку не приймає
 * участь значення палива
 */
class riksha extends transport{

    /**
     * Функція перевіряє можливість виконання поточної поїздки конкретним транспортним засобом
     * Якщо така поїздка можлива, то повертається її ціна
     * Якщо поїздка неможлива, то повертається логічне значення false
     * @param int $passengers - кількість пасажирів
     * @param float $baggage = вага багажу у кілограмах
     * @param float $distance - дистанція поїздки у кілометрах
     * @return float|false
     */
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