<?php 

namespace coolpie\cache;

use coolpie\config\AppConfig;
use coolpie\file\FileUtil;

class CacheFile {
    protected $map;

    public function __construct($name) {
        $this->name = $name;
        $this->path = Fileutil::joinPath(AppConfig::getInstance()->get("coolpie.cache.folder"), $name);
    }

    public function isExist() {
        return FileUtil::isExist($this->path);
    }

    public function saveSerialize(&$data) {
        $str = serialize($data);
        file_put_contents($this->path, $str);
    }

    public function loadSerialize() {
        $str = file_get_contents($this->path);
        $data = unserialize($str);
        return $data;
    }

}


?>