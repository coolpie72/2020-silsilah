<?php
namespace silsilahApp\metadata;

use coolpie\cache\SimpleCacheClosure;
use coolpie\file\FileUtil;

class Metadata {

    private $metaCache;

    private static $instance;

    function __construct() {
        $me = $this;
        $providerFunc = function ($key) use ($me) {
            return $me->loadMeta($key);
        };
        $this->metaCache = new SimpleCacheClosure($providerFunc);
    }

    public static function get() {
        if (self::$instance == null) {
            self::$instance = new Metadata();
        }

        return self::$instance;
    }

    public function getObject($name) {
        return $this->metaCache->get($name);
    }   

    private function loadMeta($name) {
        $objMetaReader = new ObjectMetaReader();
        $file = FileUtil::joinPath(__DIR__, "meta", "{$name}.meta");
        $obj = $objMetaReader->read($file);
        return $obj;
    }

}
