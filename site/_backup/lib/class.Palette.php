<?php
//general palleted values
class Palette {
    private $vals;
    private $idx;
    private $len;

    function __construct() {    
        $this->vals = array();
        $this->idx = 0; //no item
        $this->len = 0;
    }   

    public static function create() {
        $obj = new self();

        return $obj;
    }

    public function add($val) {
        $this->vals[] = $val;
        $this->len++;

        return $this;
    }

    //return current, and cycle to next
    public function next() {
        $val = $this->vals[$this->idx];

        $this->idx++;
        if ($this->idx == $this->len) {
            $this->idx = 0; //cycle
        }

        return $val;
    }


}

?>