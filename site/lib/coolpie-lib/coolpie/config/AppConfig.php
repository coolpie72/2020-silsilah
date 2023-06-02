<?php 

namespace coolpie\config;

use coolpie\file\FileUtil;

class AppConfig  {
    private $config;
    
    private static $instance;
    private static $basePath;
    private static $file;
    
    public static function setParam(string $configFolder, string $configFile) {
        //set parameters
        self::$basePath = $configFolder;
        self::$file = $configFile;
    }
    
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self();
            self::$instance->config = require_once(FileUtil::joinPath(self::$basePath, self::$file));
        }
        
        return self::$instance;   
    }
    
    public function get(string $key) {
        return $this->config[$key];
    }
    
    public function getInt(string $key) {
        return (int)($this->config[$key]);
    }
}

?>