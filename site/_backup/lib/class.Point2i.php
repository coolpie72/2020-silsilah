<?php
class Point2i {
    public $x;
    public $y;

    function __construct() {    
    }   

    public static function create($x, $y) {
        $obj = new self();

        return $obj->set($x, $y);
    }

    public function set($x, $y) {
        $this->x = $x;
        $this->y = $y;

        return $this;
    }

    public function str() {
        return "($this->x,$this->y)";
    }

    public function add($dx, $dy) {
        return self::create($this->x + $dx, $this->y + $dy);
    }

    public function copy() {
        return self::create($this->x, $this->y);
    }

    public function transform(&$transformer) {
        return $transformer->transform($this);
    }

}