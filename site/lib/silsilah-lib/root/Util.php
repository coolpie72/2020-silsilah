<?php
namespace silsilahApp;

use coolpie\date\CDate;

class Util {

    public static function printVar(&$var) {
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
    }

    public static function generateId() {
        return uniqid();
    }

    public static function displayGender($gender) {
        if ($gender == "M") return "Pria";
        if ($gender == "F") return "Wanita";

        return "None";
    }

    public static function displayGenderHtml($gender) {
        if ($gender == "M") return '<span class="ch-gender-m">Pria</span>';
        if ($gender == "F") return '<span class="ch-gender-f">Wanita</span>';

        return "None";
    }

    public static function addExt(&$obj, $row, $fields) {
        $obj->ext = new \stdClass();
        foreach($fields as $f) {
            $obj->ext->$f = $row[$f];
        }
    }

    public static function htmlChecked($cond) {
        if ($cond) {
            return 'checked="true"';
        }
        return "";
    }

    public static function sqlAssign($field, $val) {
        if ($val != null) {
            return "$field = '$val'";
        }
        return "$field = null";
    }    

    public static function formProcessStringNull($val) {
        if ($val == null) return null;
        $str = trim($val);
        if ($str == "") return null;

        return $str;
    }

    public static function cutText($val, $max) {
        if ($val == null) return $val;

        $len = strlen($val);

        if ($len <= $max) return $val;

        $cut = substr($val, 0, $max);
        return $cut . "...";
    }

    public static function personFacebookLink($person) {
        if ($person->facebook == null) return "";
        return "<a href=\"{$person->facebook}\">FB</a>";
    }   

    public static function personEditLink($personId) {
        return "<a href=\"index.php?page=person/add&id=$personId\">Ubah</a>";
    }   

    public static function personRootLink($id) {
        return "<a href=\"index.php?page=root&id=$id\">Hirarki</a>";
    }   

    public static function personDetailLink($id) {
        return "<a href=\"index.php?page=person/detail&id=$id\">Rinci</a>";
    }   

    public static function personDetailLinkWithSkip($id, $skipId) {
        if ($id == $skipId) return "";
        return "<a href=\"index.php?page=person/detail&id=$id\">Rinci</a>";
    }       

    public static function marriageDetailLink($marriageId) {
        return "<a href=\"index.php?page=marriage/detail&id=$marriageId\">Rinci</a>";
    } 

    public static function floorPercentage($num, $pct) {
        return floor($num * $pct / 100);
    }

    public static function personDisplayBirthDate($person) {
        if ($person->birthDate !== null) {
            return $person->birthDate;
        }
        if ($person->birthDateExt !== null) {
            return $person->birthDateExt;
        }
        return null;
    }

    public static function personDisplayDieDate($person) {
        if ($person->dieDate !== null) {
            return $person->dieDate;
        }
        if ($person->dieDateExt !== null) {
            return $person->dieDateExt;
        }
        return null;
    }

    public static function table1Start() {
        echo <<< EOF
<table border="0" cellpadding="0" cellspacing="0" class="ch-tab-1">        
EOF;
    }

    public static function tableRowStart($attrs = []) {
        $attrString = "";
        if (!empty($attrs)) {
            $attrString = " " . implode(" ", $attrs);
        }

        echo "<tr {$attrString}>";        
    }

    public static function tableCell($data) {
        echo <<< EOF
<td>{$data}</td>
EOF;     
    }

    public static function tableRowEnd() {
        echo '</tr>';        
    }

    public static function tableEnd() {
        echo <<< EOF
</table>        
EOF;
    }

    public static function getDiedClass($person) {
        $clsDied = $person->isDied() ? 'class="ch-row-died"' : '';
        return $clsDied;
    }

    public static function getAgeLabel($person, $now) {
        if (!$person->birthDate) {
            return "";
        }
        $died = $person->isDied();

        if (!$died) {
            $dt = CDate::create()->fromLiteral($person->birthDate . " 00:00:00");
            $comp = \coolpie\duration\DurationUtil::secondsInYears($dt, $now, true);
            return "H" . $comp["years"];
        }

        //died
        //cek apakah tanggal mati ada
        if (!$person->dieDate) {
            return "";
        }        
        $birthDt = CDate::create()->fromLiteral($person->birthDate . " 00:00:00");
        $dieDt = CDate::create()->fromLiteral($person->dieDate . " 00:00:00");
        $comp = \coolpie\duration\DurationUtil::secondsInYears($birthDt, $dieDt, true);
        return "M" . $comp["years"];

    }

}
