<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

//bootstrap utk coolpie lib
require_once "../lib/coolpie-lib/coolpie-lib.php";
require_once "../lib/coolpie-lib/coolpie-loader.php";
require_once "../lib/silsilah-lib/silsilah-loader.php";

use silsilahApp\DBManager;


abstract class BaseTest {

    protected $db;

    public function __construct() {
        $this->db = new DBManager();
    }

    public function run() {
        $this->db->connect();

        $this->main();
        $this->db->close();
    }

    abstract public function main();

}
