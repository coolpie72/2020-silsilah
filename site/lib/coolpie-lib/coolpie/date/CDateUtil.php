<?php
namespace coolpie\date;

class CDateUtil {

    private static function getTotalMinuteFromString(string $minuteStamp): int {
        list($hh, $mm) = explode(":", $minuteStamp);

        return 60 * $hh + $mm;
    }


    //- minStart: menit awal, dalam hh:mm
    //- minEnd: menit akhir, dalam hh:mm
    //return: total menit end - start
    public static function getMinuteDiff(string $minStart, string $minEnd): int {
        $start = self::getTotalMinuteFromString($minStart);
        $end = self::getTotalMinuteFromString($minEnd);

        return $end - $start;
    }
}

?>