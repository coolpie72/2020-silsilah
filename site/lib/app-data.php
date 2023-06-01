<?php

class AppData {

    public $data;
    private static $instance = null;

    public static function get() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->data = [];
    }


}