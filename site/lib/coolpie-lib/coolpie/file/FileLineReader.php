<?php

namespace coolpie\file;

class FileLineReader {
    private $currentLine;

    public function __construct() {
        
    }
    
//     public function setHandle($handle) {
//     	$this->handle = $handle;
//     }

    public function openFile($file) {
        $this->file = $file;
        $this->handle = fopen($this->file, "r");
    }

    public function openStdin() {
        return $this->openFile("php://stdin");
    }

    public function readLine() {
        $res = fgets($this->handle);
        if (!$res) {
            $this->currentLine = null;
        } else {
            $this->currentLine = $res;
        }

        return $res;
    }

    public function getCurrentLine() {
        return $this->currentLine;
    }

    public function close() {
        fclose($this->handle);
    }
    
    public static function processFile($file, $objHandler, $handlerFunctionName) {
    	$reader = new self();
    	if ($file == null) {
    		#echo "no param file given. reading from stdin\n";
    		$reader->openStdin();
    	} else {
    		$reader->openFile($file);
    	}
    	
    	$no = 0;
    	while($reader->readLine()) {
    		$no++;
    		$line = $reader->getCurrentLine();
    		$line = trim($line);
    		$objHandler->$handlerFunctionName($no, $line);
    	}
    	
    	$reader->close();
    }
    
//     public static function processHandle($handle) {
    	
//     	$reader = new self();
//     	$reader->handle = $handle;
    	
//     	$no = 0;
//     	$str = "";
//     	while($reader->readLine()) {
//     		$no++;
//     		$line = $reader->getCurrentLine();
//     		$line = trim($line);
//     		$str .= $line;
//     	}
    	
//     	$reader->close();
//     	return $str;
   
//     }
    
    


}

?>