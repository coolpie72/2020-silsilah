<?php 

namespace coolpie\map;


//TODO: jangan dipakai
//class ini masih pertimbangan utk digunakan di codebase CNF
class DynamicMapObject extends DynamicMap {
    
    public function __construct() {
        parent::__construct();
    }
    
    //TODO: masih error
    public function createData() {
        return new \stdClass();
    }
 
}


?>