<?php 

namespace  coolpie\data;


//TODO: deskripsi
class ArrayUtil {
	
	
	public static function trimArray(&$arr) {
	    $len = count($arr);
	    for ($i=0; $i < $len; $i++) {
	        $arr[$i] = trim($arr[$i]);
	    }
	}

	//tested typical case
	//- arr: array yg akan di modify
	//- idx: posisi yg akan diinsert after, elemen akan insert dibelakang idx ini
	//- val: scalar, elemen yg akan diinsert
	//return: void 
	public static function insertAfter(&$arr, int $idx, $val): void {
	    $len = count($arr);
	    $lastIdx = $len - 1;
	    if ($idx === $lastIdx) {
	        $arr[] = $val; //simple push
	        return;
	    } 
	    
	    $removeLen = $len - $idx - 1;
	    $removed = array_splice($arr, $idx + 1, $removeLen, $val);
	    $arr = array_merge($arr, $removed);
	    
	    
	    //bukan last6 idx
	    //a0,a1,a2,a3,a4: len = 5
	    //insert di posisi a2: idx = 2, val = x
	    //yg di remove start dari idx+1
	    //p1 = splice(a, idx + 1, x)
	    //rem = len - idx -1
	    //p1 = merge(a, p1) 
	    
	    //kalo first idx
	    //idx = 0
	}
	

	
}

?>