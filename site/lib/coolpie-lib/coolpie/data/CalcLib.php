<?php 
namespace  coolpie\data;

class CalcLib {
    // https://stackoverflow.com/questions/8208922/which-rounding-mode-to-be-used-for-currency-manipulation-in-java
    // default: PHP_ROUND_HALF_UP
    // bankers: PHP_ROUND_HALF_EVEN
    public static function percent($num, $total, $isRound = false, $roundNumber = 2, $roundMode = PHP_ROUND_HALF_UP) {
        if ($total == 0) return null;

        //kali 100 dulu biar desimal tidak terpotong round
        $res = $num / $total * 100;
        // echo "res:$res\n";

        if ($isRound) {
            $res = round($res, $roundNumber, $roundMode);
            // echo "res:$res\n";

            //chop off decimal .00 jika ada
            // $res = +$res;
        }

        return $res;
    }



}

?>