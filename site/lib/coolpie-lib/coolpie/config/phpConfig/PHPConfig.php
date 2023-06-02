<?php 
namespace coolpie\config\phpConfig;

//Config based on PHP array
class PHPConfig {
    
    public function __construct() {
        
    }
    
    public function load($file) {
        $this->data = require $file;
    }
    
    //keyPath: nested key dalam format aa.bb.cc.dd 
    //return: objek isi dari key (bisa null, jika memang objek isinya null)
    //- nilai sesuai defaultValue jika tidak ketemu
    public function get($keyPath, $defaultValue = null) {
        $keys = explode(".", $keyPath);
        
        $res = $this->data;
        foreach ($keys as $idx) {
            if (!array_key_exists($idx, $res)) {
                return $defaultValue; //tidak ada ditengah
            }
            $res = $res[$idx];
        }

        return $res;
    }

    //keyPath: nested key dalam format aa.bb.cc.dd 
    //return: objek isi dari key (bisa null, jika memang objek isinya null)
    //throw: exception, jika ada key yg tidak ketemu dalam key path
    public function getRequired($keyPath) {
        $keys = explode(".", $keyPath);
        
        $res = $this->data;
        foreach ($keys as $idx) {
            if (!array_key_exists($idx, $res)) {
                throw new \Exception("PHPConfig: key: $keyPath not found");
            }
            $res = $res[$idx];
        }

        return $res;
    }

    //keyPath: nested key dalam format aa.bb.cc.dd 
    //return: boolean, jika keyPath secara full terdefinisi
    public function isExist($keyPath) {
        $keys = explode(".", $keyPath);
        
        $res = $this->data;
        foreach ($keys as $idx) {
            if (!array_key_exists($idx, $res)) {
                return false; //tidak ada ditengah
            }
            $res = $res[$idx];
        }

        return true;
    }
    
}

?>