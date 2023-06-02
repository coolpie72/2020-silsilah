<?php 

namespace  coolpie\data;

use coolpie\str\StringUtil;

//TODO: deskripsi
class ObjectUtil {
	
	public function __construct() {
		
	}
	
	//mengcopy property dari fromObj to toObj
	//dengan property yg sesuai dengan spesifikasi fetchSpec
	public static function fetchProperties($fromObj, $toObj, $fetchSpec) {
		//iterate from object properties
		foreach ($fromObj as $field => $val) {
			//cek satu2 property apakah match dengan salah satu spec
			$found = false;
			foreach ($fetchSpec as $fieldSpec) {
				list($mode, $name) = explode(":", $fieldSpec);
				if ($mode == "match") {
					$found = $field == $name;
					if ($found) break;
				} else if ($mode == "prefix") {
					$found = StringUtil::startsWith($field, $name);
					if ($found) break;
				}
			}
			if ($found) {
				//trust this property
				$toObj->$field = $val;
			}
		}
	}
	

	public static function propToArray($obj, &$arr, array $attrList) {
		foreach ($attrList as $field) {
			$arr[$field] = $obj->{$field};
		}
	}

	public static function arrayToProp($arr, &$obj, array $attrList) {
		foreach ($attrList as $field) {
			$obj->{$field} = $arr[$field];
		}
	}
}

?>