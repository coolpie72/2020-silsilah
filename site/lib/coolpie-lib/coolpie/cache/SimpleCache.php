<?php 

namespace coolpie\cache;

use coolpie\map\ArrayMap;


class SimpleCache {
    protected $map;
    
    public function __construct($dataProvider) {
        $this->map = new ArrayMap();

        //callable
        $this->dataProvider = $dataProvider;
    }

    //may be null: kalau tidak ada
    public function get($key) {
        if ($this->map->isExist($key)) {
            return $this->map->get($key);
        }

        $data = $this->dataProvider->get($key);

        $this->map->set($key, $data);

        return $data;
    }
    

}


?>