<?php
class Dice {
    private $number;
    private $max; //1 to max
    private $result;
    private $isCritical;

    function __construct($number, $max) {
        $this->number = $number;
        $this->max = $max;
    }

    public static function create($number, $max) {
        $obj = new self($number, $max);
        return $obj;
    }

    
    public function roll() {
        $this->result = $this->random(1, $this->max);
        return $this->result;
    }

    public function rollWithCritical($critPercent) {
        $this->roll();
        $val = floor($critPercent * $this->max / 100);
        $this->isCritical = $this->result <= $val;
        return array($this->result, $this->isCritical);
    }

    function random($min, $max) {
        return rand(1, $this->max);
        
    }
}


?>