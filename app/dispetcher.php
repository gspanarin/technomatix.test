<?php

namespace app;

class dispetcher {
    private $park = [];
    public static $config = null;
    
    public static function getConfig(){
        return include_once __dir__ . '/../config/config.php'; 
    }
    
    public function __construct($argv = []) {
        $park = include_once __dir__ . '/../config/park.php';
        foreach ($park as $item){
            $class = 'transport\\' . $item['type'];
            $this->park[] = new $class($item);
        }
    }
    
    public function calculate($passengers = 0, $baggage = 0, $distance = 0){
        print "=====================================\r\n";
        print "Пошук варіантів транспорту\r\n";
        print "Кількість пасажирів: $passengers\r\n";
        print "Вага багажу: $baggage\r\n";
        print "Відстань поїздки: $distance\n";
        
        if (!$this->checkVal($passengers, $baggage, $distance))
            return;
        
        foreach ($this->park as $transport){
            $price = $transport->price($passengers, $baggage, $distance);
            if ($price){
                print "=====================================\r\n";
                print "Тип транспортного засобу: " . $transport->getType() . "\r\n";
                print "Назва: " .$transport->getName() . "\r\n";
                print "Номерний знак/ідентифікатор: " . $transport->getId() . "\r\n";
                print "Ціна поїздки: $price\r\n";       
            }
        }
    }
    
    
    private function checkVal($passengers, $baggage, $distance){   
        $errors = [];
        if ($passengers < 0)
            $errors[] = 'Невірний формат кількості пасажирів';
        if ($baggage < 0)
            $errors[] = 'Невірний формат кількості багажу';
        if ($distance < 0 || $distance == 0)
            $errors[] = 'Невірний формат відстані';
        if ($passengers == 0 && $baggage == 0)
            $errors[] = "Для здійснення поїздки треба обов'язково задати або кількість пасажирів, або вагу багажу";
        
        if (count($errors) > 0){
            print "=====================================\r\n";
            print "УВАГА! Параметри для підрахунку вартості поїздки мають помилки!\r\n";
            foreach ($errors as $error)
                print $error . "\r\n";
            return false;
        }
        
        
        
        return true;
    }
      
}

dispetcher::$config = dispetcher::getConfig();