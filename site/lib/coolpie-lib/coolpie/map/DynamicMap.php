<?php 

namespace coolpie\map;

//extend class ini untuk membuat class
//yang method get nya selalu ready
//jika tidak ada entrynya maka akan dibuat melalui method createData()
abstract class DynamicMap extends ArrayMap {
    
    public function __construct() {
        parent::__construct();
    }
    
    //selalu mengembalikan nilai
    //jika tidak ada, initialize entry createData()
    public function get($key) {
        if (!$this->isExist($key)) {
            $this->set($key, $this->createData($key));
        }
        return parent::get($key);
    }
    
    //proses untuk membuat data baru jika tidak ada
    abstract protected function createData($key);
 
}


?>