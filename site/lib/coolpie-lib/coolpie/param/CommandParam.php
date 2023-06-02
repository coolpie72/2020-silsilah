<?php
namespace coolpie\param;

use coolpie\file\FileLineReader;
use coolpie\str\StringUtil;

use coolpie\data\ArrayUtil;


class CommandParam {
    private $mapParam;
    
    public function __construct() {
        $this->mapParam = [];
        
    }

    public function fromStd() {
        global $argv;

        $arr = $argv;

        if (count($arr) == 1) {
            # tidak ada parameter
            return;
        }

        //buang argv[0]
        array_shift($arr);

        $this->parseArrayLines($arr, $this->mapParam);

    }
    
    public function parseOptionFile($keyName) {
    	$file = $this->getParam($keyName);
    	$this->extArgs = [];
    	FileLineReader::processFile($file, $this, "parseParamFile");
    	
    	//apply ext args
    	foreach ($this->extArgs as $k => $v) {
    		//skip jika sudah ada param manual given
    		if ($this->haveParam($k)) continue;
    		$this->mapParam[$k] = $v;
    	}
    }
    
    
    //dipanggil dari process param file
    public function parseParamFile($lineNo, $line) {
    	if (empty($line)) return;
    	
    	//skip comment
    	if (StringUtil::startsWith($line, "#")) return;
    	
    	$this->parseParamLine($line, $this->extArgs);
    }   
    
    
	//array of key=value string
    private function parseArrayLines($arr, &$arrDest) {
        foreach ($arr as $val) {
        	$this->parseParamLine($val, $arrDest);
        }
    }
    
    private function parseParamLine($line, &$arrDest) {
    	if (strpos($line, "=") !== false) {
    		list($key, $val) = StringUtil::splitByFirstChar($line, "=");
    		$key = trim($key);
    		$val = trim($val);
    		
    		$arrDest[$key] = $val;
    	} else {
    		//single param
    		$arrDest[$line] = null;
    	}
    	
    }

    public function haveParam($key) {
        return array_key_exists($key, $this->mapParam);
    }

    //akan deprecated
    public function getParam($key) {
        if (!$this->haveParam($key)) return null;
        return $this->mapParam[$key];
    }
    
    public function get($key) {
        if (!$this->haveParam($key)) return null;
        return $this->mapParam[$key];
    }
    
    public function getInt($key) {
        if (!$this->haveParam($key)) return null;
        return (int) ($this->mapParam[$key]);
    }
    
    public function getWithDefault($key, $default) {
        $val = $default;
        if ($this->haveParam($key)) {
            $val = $this->get($key);
        }
        return $val;
    }

    public function getParamKeys() {
        return array_keys($this->mapParam);
    }
    
    public function print() {
    	foreach ($this->mapParam as $k => $v) {
    		echo "[$k][$v]" . PHP_EOL;
    	}
    }
    
    //jika ada param key= aaa, bbb, ccc, ddd
    //maka parse value dan juga trim menjadi array [aaa,bbb,ccc,ddd]
    public function getAsArray($key, $separator, $trim = true) {
        if (!$this->haveParam($key)) return null;
        $arr = explode($separator, $this->getParam($key));
        if ($trim) {
            ArrayUtil::trimArray($arr);
        }
        return $arr;
    }
}