<?php 

namespace coolpie\map;

//Berguna utk mapping
//key tertentu (biasanya string)
//ke integer counter (default 0)

//primary use case, use incr(key), atau decr(key)
//otomatis key akan dibuat jika belum ada

//NOTE: utk summarize di akhir, gunakan method fetch(key, default) (eg: default = 0)
//karena belum tentu key ada di map (misal tidak ada di data)
class MapCounter extends ArrayMap {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function incr($key, $val = 1) {
        $curr = $this->fetch($key, 0);
        $next = $curr + $val;
        $this->set($key, $next);
    }

    public function decr($key, $val = 1) {
        $curr = $this->fetch($key, 0);
        $next = $curr - $val;
        $this->set($key, $next);
    }

}


?>