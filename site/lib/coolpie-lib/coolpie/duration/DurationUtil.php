<?php
namespace coolpie\duration;

use coolpie\date\CDate;

class DurationUtil {
 
    public static function secondsInHours($totalSecs) {
    //     # to minutes
        $totalMins = (int)($totalSecs / 60);
        $secs = $totalSecs % 60;

        $totalHours = (int)($totalMins / 60);
        $mins = $totalMins % 60;

        return sprintf("%d:%02d:%02d", $totalHours, $mins, $secs);

    }

    //year month day hour min sec
    //assume d1 <= d2
    public static function secondsInYears(CDate $d1, CDate $d2, $returnComp = false) {
        static $units = [60, 60, 24, 30, 12, null];
        $totalSecs = $d2->diff($d1);
        
        $negative = false;
        if ($totalSecs < 0) {
            $totalSecs = abs($totalSecs);
            $negative = true;
        }
        
        $result = [];
        
        $idx = 0;
        $total = $totalSecs;
        foreach ($units as $idx => $size) {
            if ($size === null) {
                $result[$idx] = $total;
                break;
            }
            
            $totalNext = intval($total / $size);
            $currRemain = $total % $size;
            
            $result[$idx] = $currRemain;
            $total = $totalNext;
        }
                
        list($secs, $mins, $hours, $days, $months, $years) = $result;

        if ($returnComp) {
            $comp = [];
            $comp['secs'] = $secs;
            $comp['mins'] = $mins;
            $comp['hours'] = $hours;
            $comp['days'] = $days;
            $comp['months'] = $months;
            $comp['years'] = $years;

            return $comp;
        }
        
        $str = sprintf("%d:%02d:%02d %02d:%02d:%02d", $years, $months, $days, $hours, $mins, $secs);

        
        
        if ($negative) {
            $str = "- {$str}";
        }
        
        return $str;
        
    }

}

?>