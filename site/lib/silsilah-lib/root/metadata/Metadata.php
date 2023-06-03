<?php
namespace silsilahApp\metadata;

use coolpie\cache\SimpleCache;
use coolpie\file\FileUtil;
use coolpie\map\ArrayMap;

class Metadata {

    public $objects;

    private static $instance;

    function __construct() {
        $this->objects = [];
    }

    public static function get() {
        if (self::$instance == null) {
            self::$instance = new Metadata();
        }

        return self::$instance;
    }

    public function getObject($name) {
        if (array_key_exists($name, $this->objects)) {
            return $this->objects[$name];
        }
        $this->loadMeta($name);
        return $this->objects[$name];
    }   

    private function loadMeta($name) {
        $objMetaReader = new ObjectMetaReader();
        $file = FileUtil::joinPath(__DIR__, "meta", "{$name}.meta");
        $obj = $objMetaReader->read($file);
        $this->objects[$name] = $obj;
    }

    // private function init() {
    //     $this->objects = [];

    //     $this->loadMeta("Person");

    //     $this->loadMeta("Marriage");

    // }

}

//$META = new Metadata();
