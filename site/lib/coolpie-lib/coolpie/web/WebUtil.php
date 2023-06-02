<?php 
namespace coolpie\web;

class WebUtil {

    public static function printVar($var) {
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
    }

    public static function println($var) {
        echo $var . "<br>";
    }    

    private static function buildAttrString($attrMap) {
        if (empty($attrMap)) return "";

        $arr = [];
        foreach ($attrMap as $field => $val) {
            //TODO: pastikan tidak ada karakter " di val
            $arr[] = "{$field}=\"{$val}\"";
        }
        return implode(" ", $arr);
    }

    public static function tagStart($name, $attrMap = [], $output = true) {

        $attrString = self::buildAttrString($attrMap);
        $val = "<{$name} {$attrString}>";
        if ($output) {
            echo $val;
            return;
        }
        return $val;
    }

    public static function tagEnd($name, $output = true) {
        $val = "</{$name}>";
        if ($output) {
            echo $val;
            return;
        }
        return $val;
    }
    
}

?>