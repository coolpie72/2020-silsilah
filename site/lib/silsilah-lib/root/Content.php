<?php
namespace silsilahApp;

class Content {

    private static $content = null;

    public static function start() {
        ob_start();
    }

    public static function end() {
        self::$content = ob_get_contents();
        ob_end_clean();
    }

    public static function get() {
        return self::$content;
    }


}