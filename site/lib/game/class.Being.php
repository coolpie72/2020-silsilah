<?php
class Being {
    private $hp;
    private $id;
    private $name;
    

    function __construct() {

    }

    public static function create() {
        $obj = new self();
        return $obj;
    }

?>