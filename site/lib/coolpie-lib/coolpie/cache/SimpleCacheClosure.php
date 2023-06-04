<?php 

namespace coolpie\cache;

use coolpie\map\ArrayMap;


class SimpleCacheClosure {

    protected $map;
    
    public function __construct($providerFunc) {
        $this->map = new ArrayMap();

        //callable
        $this->providerFunc = $providerFunc;
    }

    //may be null: kalau tidak ada
    public function get($key) {
        if ($this->map->isExist($key)) {
            return $this->map->get($key);
        }

        $data = ($this->providerFunc)($key);

        $this->map->set($key, $data);

        return $data;
    }
    

}
