<?php
namespace coolpie\mapFile;

use coolpie\file\FileLineReader;
use coolpie\str\StringUtil;

//membaca file .map dan menyimpan dalam struktur data internal
//seperti tabel berisi row dengan setiap row mempunyai field
class MapFile {

    public function __construct() {
        
    }

    public function load($file) {
        $this->fields = [];

        $this->rows = [];
        FileLineReader::processFile($file, $this, "processLine");
        // print_r($this->rows);
    }

    public function processLine($no, $line) {
        //line sudah ter-trim
        //skip comment
        if (StringUtil::startsWith($line, "#")) return;
        if (StringUtil::startsWith($line, "@field")) {
            //@field:id:int
            list(, $field, $type) = explode(":", $line);
            $this->fields[] = [$field, $type];
        } else {
            //f1:f2:fn ...
            // echo "got row: $line\n";
            $arr = explode(":", $line);
            $row = [];
            $idx = 0;
            foreach ($arr as $val) {
                list($field, $type) = $this->fields[$idx];
                $fval = $this->readType($val, $type);
                $row[$field] = $fval;
                $idx++;
            }
            $this->rows[] = $row;
        }
    }

    public function readType($val, $type) {
        $method = "read_$type";
        return $this->$method($val);
    }

    public function read_int($val) {
        return intval($val);
    }

    public function read_str($val) {
        return "$val";
    }

    public function getMap($fkey, $fval) {
        $map = [];
        // print_r($this->rows);
        foreach ($this->rows as $row) {
            $map[$row[$fkey]] = $row[$fval];
        }
        // print_r($map);
        return $map;
    }
}


?>