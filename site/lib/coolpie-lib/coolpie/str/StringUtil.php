<?php

namespace coolpie\str;

class StringUtil {

    //ambil paling banyak num karakter dari string
    public static function getPrefix($str, $num) {
        if ($str === null) return null;

        $len = strlen($str);
        if ($len <= $num) return $str;

        return substr($str, 0, $num);
    }

    public static function chopEnd($str, $num = 1) {
        if ($str === null) return null;
        
        $len = strlen($str);
        if ($len <= $num) return "";
    
        //len = 6, chop = 2 -> 0 sebanyak $len - $num  
        //0 1 2 3 4 5
        //a b c d e f
        return substr($str, 0, $len - $num);

    }

    public static function startsWith($str, $prefix) {
        if (empty($prefix)) return true;

        $idx = strpos($str, $prefix);
        if ($idx === false) {
            return false;
        }

        return $idx == 0;
    }
    
    //abcdef
    //012345
    //len = 6
    //ef -> pos = 4
    public static function endsWith($str, $end) {
        if (empty($end)) return true;
        
        $len = strlen($str);
        $endLen = strlen($end);
        
        $pos = $len - $endLen;
        
        $sub = substr($str, $pos, $endLen);
        
        return $sub == $end;
        
    }
    
    public static function makeFit($str, $size) {
       $len = strlen($str);
       if ($len <= $size) return $str;
       
       $str = substr($str, 0, $size - 3) . "...";
       return $str;
       
    }
    
    public static function fixWindowsLine($str) {
        return str_replace("\r\n", "\n", $str);
    }
    
    public static function contains($str, $sub, $ignoreCase = false) {
        if (empty($sub)) return true;
        
        if (!$ignoreCase) {
            return strpos($str, $sub) !== false;
        }
        
        return self::contains(strtoupper($str), strtoupper($sub));
    } 
    
    public static function templateReplace($str, $field, $val) {
    	$res = str_replace("{{" . $field . "}}", $val, $str);
    	return $res;
    }
    
    public static function splitByFirstChar($str, $char) {    	
    	$idx = strpos($str, $char);
    	
    	//tidak ketemu, berarti return whole string sbg single element array
    	if ($idx === false) {
    		return [$str];
    	}
    	
    	$len = strlen($str);
    	//     	aaa=bbb
    	//     	0123456 len = 7
    	$key = substr($str, 0, $idx);
    	$val = substr($str, $idx+1, $len - $idx -1);
    	
//     	$arr = [$key, $val];
    	return [$key, $val];

    }
    
    //merapihkan heredoc agar sama dengan single line string
    //line sep bisa di override:
    //contoh dikasi string kosong untuk menggabung long string
    public static function makeOneLineString($input, $lineSep = " ") {
    	//split berdasarkan baris
    	$arr = explode(PHP_EOL, $input);
		$arr2 = [];
		//proses tiap baris
		foreach ($arr as $v) {
			//trim depan dan belakang baris
			$str = trim($v);
			if (empty($str)) continue;
			//masukkan ke array baru
			$arr2[] = $str;
		}
		//kembalikan array baru dengan dijoin satu spasi
		return implode($lineSep, $arr2);
    }

    //bisa skip line dengan comment char
    public static function makeOneLineStringCode($input, $lineSep = " ") {
        //split berdasarkan baris
        $arr = explode(PHP_EOL, $input);
        $arr2 = [];
        //proses tiap baris
        foreach ($arr as $v) {
            //trim depan dan belakang baris
            $str = trim($v);
            if (empty($str)) continue;
            if (StringUtil::startsWith($str, "#")) continue;
            //masukkan ke array baru
            $arr2[] = $str;
        }
        //kembalikan array baru dengan dijoin satu spasi
        return implode($lineSep, $arr2);
    }
    
    public static function loadFile($input, $makeOneLine = false, $lineSep = " ") {
        $str = file_get_contents($input);
        if ($makeOneLine) {
            $str = self::makeOneLineString($str, $lineSep);
        }
        return $str;
    }
    
    //load file raw dari file
    public static function loadFileRaw(string $input) {
        return self::loadFile($input, false, "");
//         $fp = fopen($input, "r");
//         $out = "";
//         while (true) {
//             $eof = feof($fp);
            
//             if ($eof) break;
               
//             $buffer = fgets($fp, 4096);
// //             echo DebugUtil::checkData($eof) . PHP_EOL;
// //             echo DebugUtil::debugString($buffer) . PHP_EOL;
//             $out .= $buffer;
//         }
//         fclose($fp); 
//         return $out;
    }
    
       
//     public static function loadFileV2($input, $makeOneLine = false) {
//         $str = file_get_contents($input);
        
// //     	$reader = new class {
// //     		public $str = "";
// //     		public function processLine($lineNo, $line) {
// //     			$this->str .= $line . "\n";
// //     		}
// //     	};
    	
// //     	FileLineReader::processFile($input, $reader, "processLine");
    	
// //     	$str = $reader->str;

//     	if ($makeOneLine) {
//     		$str = self::makeOneLineString($str);
//     	}
//     	return $str;
//     }

    public static function replaceNthPart($str, string $sep, int $n, $replacement) {
        $arr = explode($sep, $str);
        $arr[$n] = $replacement;
        return implode($sep, $arr);
    }
    
    public static function getNthPart($str, string $sep, int $n) {
        $arr = explode($sep, $str);
        return $arr[$n];
    }

    //cek apakah suatu string punya spasi di belakang atau di depan (dapat di trim)
    public static function haveTrimSpace(string $str): bool {
        $val = trim($str);
        return $val !== $str; //jika tidak sama berarti berhasil di trim
    }

    //valid string: tidak null, kalau di trim (default: true) tidak kosong
    public static function isValidString(string $str, bool $useTrim = true): bool {
        if ($str === null) return false;

        $val = $useTrim ? trim($str) : $str;

        return !empty($val);
    }

}

?>