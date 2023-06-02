<?php
namespace coolpie\debug;

class DebugUtil {
	public static function debug($var, $label) {
		echo $label . ":";
		var_dump($var);
		echo PHP_EOL;
	}
	
	public static function checkData($data) {
	    if (is_null($data)) {
	        return "[null]";
	    }
	    if (is_bool($data)) {
	        $str = $data ? "TRUE" : "FALSE";
	        return "[bool:$str]";
	    }
	    if (is_int($data)) {
	        return "[int:$data]";
	    }
	    if (is_double($data)) {
	        return "[double:$data]";
	    }
	    if (is_string($data)) {
			//NOTE: jika pakai empty(), maka string 0 juga dianggap empty
	        if ($data === "") {
	            return "[string:<empty>]";
	        }
	        return "[string:$data]";
	    }
	    if (is_array($data)) {
	        $len = count($data);
	        return "[array:$len]";
	    }
	    if (is_object($data)) {
	        $cls = get_class($data);
	        return "[object:$cls]";
	    }
	    
        return "[unknown]";
	}
	
	public static function debugString($str, $includeLen = true) {
	    $len = strlen($str);
	    $str = str_replace(" ", "<SP>", $str);
	    $str = str_replace("\r", "<CR>", $str);
	    $str = str_replace("\n", "<LF>", $str);
	    $str = str_replace("\t", "<TB>", $str);
	    if ($includeLen) return "[$len:$str]";
	    return "[$str]";
	}
}

?>