<?php 
namespace  coolpie\data;

class NumberUtil {

    //NOTE: cek apakah fungsi chop off decimal masih diperlukan
    
    // public static function floatRound($num, $roundNumber = 2) {
    //     //potong ke 2 digit decimal
    //     $res = sprintf("%." . $roundNumber . "f", $num); 

    //     //chop off decimal .00 jika ada
    //     $res = +$res;

    //     return $res;
    // }

    public static function round($num, $roundNumber = 2, $roundMode = PHP_ROUND_HALF_UP) {
        //potong ke 2 digit decimal
        $res = round($num, $roundNumber, $roundMode);

        //chop off decimal .00 jika ada
        // $res = +$res;

        return $res;
    }

    public static function stringToNumber($strNum) {
        $type = gettype($strNum);
        if ($type == "integer" or $type == "double") {
            return $strNum;
        }

        $result = $strNum;
        if ($type == "string") {
            // if (strpos($strNum, ".") == false) {
            //     $result = (int) $strNum;
            // } else {
            //     $result = (float) $strNum;
            // }
            $fval = floatval($strNum);
            $ival = intval($strNum);

            $result = ($ival == $fval) ? $ival : $fval;

            // $result = $result + 0;
        }

        return $result;
    }    



}

?>