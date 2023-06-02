<?php 

namespace coolpie\data;

class ByteLib {
    //giga, tera, peta, exa
    private static $units = ["b", "k", "M", "G", "T", "P", "E"];

    private static function divByte($num) {
        $res = $num / 1024;
        return $res;
    }

    private static function scale($num, $direction) {
        $res = $num;
        if ($direction < 0) {
            $res = $num * 1024;
        } else if ($direction > 0) {
            $res = $num / 1024;
        }
        return $res;
    }

    private static function getUnitAt($idx) {
        return self::$units[$idx];
    }

    private static function findStartIdx($unit) {
        $unitIdx = 0;
        foreach (self::$units as $u) {
            if ($u == $unit) break;
            $unitIdx++;
        }

        return $unitIdx;
    }

    private static function format($val, $unit, $numberOnly = false) {

        //potong ke 2 digit decimal
        $res = sprintf("%.2f", $val); 

        //chop off decimal .00 jika ada
        $res = +$res;

        return $numberOnly ? $res : $res . $unit;

    }   

    public static function humanFormat($num, $unit = "b") {
        // $units = ["b", "k", "M", "G", "T, "P];

        $unitIdx = self::findStartIdx($unit);
        $lastIdx = count(self::$units) - 1;

        $r = $num;
        

        while (true) {
            $res = self::format($r, self::getUnitAt($unitIdx));

            //jika angka < 1000 atau sudah last idx (mentok)
            //maka stop
            if ($r <= 1024 || $unitIdx == $lastIdx) break;

            $r = self::divByte($r);
            $unitIdx++;

        }

        return $res;
    }

    //eg: 8 G -> k besar -> kecil : minus
    public static function humanFormatConvert($num, $unitFrom, $unitTo = "b", $numberOnly = false) {
        //sama
        if ($unitFrom == $unitTo) {
            return $numberOnly ? $num : $num . $unitTo;
        }

        //tidak sama
        $idxFrom = self::findStartIdx($unitFrom);
        $idxTo = self::findStartIdx($unitTo);

        //arah scale unit
        //kalo besar ke kecil: negatif
        //kalo kecil ke besar: positif
        $direction = $idxTo - $idxFrom;

        //delta agar direction jadi mengarah 0
        //kalau minus, ditambah
        //kalau plus, dikurang
        $delta = ($direction > 0) ? -1 : 1;


        // echo "idxFrom: $idxFrom idxTo: $idxTo direction: $direction delta: $delta\n";
        // exit();
        $res = $num;

        while ($direction != 0) {
            // echo "direction: $direction\n";
            $res = self::scale($res, $direction);
            $direction += $delta;
            // echo "res: $res\n";
        }

        $out = self::format($res, self::getUnitAt($idxTo), $numberOnly);

        return $out;


    }

    //numstr: 8G
    public static function humanFormatConvertString($numStr, $unitTo = "b", $numberOnly = false) {
        $unitFrom = substr($numStr, -1); //last char
        $num = (int) (substr($numStr, 0, strlen($numStr)-1));
        // echo "$num $unitFrom\n";

        return self::humanFormatConvert($num, $unitFrom, $unitTo, $numberOnly);
    }


}

?>