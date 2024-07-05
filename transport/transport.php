<?php

namespace transport;

use app\dispetcher;

/**
 * Абстрактний клас транспортного засобу
 * 
 * Від нього будуть наслідуватися усі реальні транспортні засоби
 * 
 * У класі реалізована частина функціоналу, яка виконується однаково для 
 * більшості транспортних засобів.
 * Окремо у класах-потомках є перевизначення окремих методів, які мають особливості
 * роботи із специфічними транспортними засобами (для класі велосипеда та рікші
 * перевизначена функція розрахуку вартості, так як вони не витрачають паливо, 
 * тому і формула в них трохи інша)
 */
abstract class transport {

    protected $type;
    protected $name;
    protected $id;
    protected $max_passengers;
    protected $max_baggage;
    protected $fuel;
    protected $fuel_consumption;
    protected $max_distance;
    protected $amortization;
    protected $km_price;
    protected $driver_category;

    /**
     * У конструкторі виконуємо ініціалізацію атрибутів класу
     * @param type $param
     */
    public function __construct($param = []) {
        foreach ($param as $key => $value)
            if (property_exists(__CLASS__, $key))
                $this->$key = $value;
    }
 
    /**
     * Повертає значення типу транспортного засобу
     * @return string
     */
    public function getType(){
        return $this->type;
    }
    
    /**
     * Повертає назву транспортного засобу
     * @return string
     */
    public function getName(){
        return $this->name;
    }
    
    /**
     * Повертає номер або ідентифікатор транспортного засобу
     * @return string
     */
    public function getId(){
        return $this->id;
    }

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
            $fuel_price = ($this->fuel_consumption * $distance / 100) * $config['fuel'][$this->fuel];
            $price = $driver_price +  ($fuel_price * $this->amortization);
            
            return $price;
        }
        
        return false;
    }
}
