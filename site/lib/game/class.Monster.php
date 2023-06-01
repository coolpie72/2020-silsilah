<?php
class Monster extends Being {

    function __construct() {

    }

    public static function create() {
        $obj = new self();
        return $obj;
    }

?>