<?php 

namespace coolpie\map;


class ArrayMap {
    protected $arr;
    
    public function __construct() {
        $this->arr = [];
    }
    
    public function isExist($name) {
        // print_r($this->arr);
        return array_key_exists($name, $this->arr);
    }
    
    public function get($name) {
        return $this->arr[$name];
    }
    
    //mirip dgn get, tp ada handling default value
    public function fetch($name, $defaultVal) {
        if (!$this->isExist($name)) return $defaultVal;
        return $this->get($name);
    }
    
    public function set($name, $val) {
        $this->arr[$name] = $val;
    }
    
    public function getArr() {
        return $this->arr;
    }
    
    public function getSize() {
        return count($this->arr);
    }
    
    public function iterate(callable $func) {
        foreach($this->arr as $key => $val) {
            call_user_func($func, $key, $val);
        }
    }

}


?>