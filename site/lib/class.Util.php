<?php
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
        $obj->ext = new stdClass();
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
        return "<a href=\"index.php?page=person-add&id=$personId\">Ubah</a>";
    }   


    public static function personDetailLink($id) {
        return "<a href=\"index.php?page=person-detail&id=$id\">Rinci</a>";
    }   

    public static function personDetailLinkWithSkip($id, $skipId) {
        if ($id == $skipId) return "";
        return "<a href=\"index.php?page=person-detail&id=$id\">Rinci</a>";
    }       

    public static function marriageDetailLink($marriageId) {
        return "<a href=\"index.php?page=marriage-detail&id=$marriageId\">Rinci</a>";
    } 

    public static function floorPercentage($num, $pct) {
        return floor($num * $pct / 100);
    }

}
?>