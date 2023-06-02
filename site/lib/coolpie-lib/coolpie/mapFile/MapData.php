<?php
namespace coolpie\mapFile;

use coolpie\mapFile\MapFile;

class MapData {

    public function __construct($file) {
        $this->mapFile = new MapFile();
        $this->mapFile->load($file);

        //cached maps
        $this->maps = [];
    }

    //get map dari field: fkey ke fval
    //store map tsb ke cache: this.maps 
    //jadi gak perlu proses ulang
    public function getMap($fkey, $fval) {
        $key = "{$fkey}-{$fval}";
        if (!isset($this->maps[$key])) {
            $this->maps[$key] = $this->mapFile->getMap($fkey, $fval);
        }
        return $this->maps[$key];
    }

    public function lookup($fkey, $fval, $key, $defaultVal) {
        $map = $this->getMap($fkey, $fval);
        // print_r($map);
        if (isset($map[$key])) {
            return $map[$key];
        }       
        return $defaultVal;
    }
}


?>