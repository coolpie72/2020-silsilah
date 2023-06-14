<?php

use silsilahApp\AdoptionService;
use silsilahApp\PersonService;

require_once "base-test.php";

class TestAdopsi extends BaseTest {

    public function __construct() {
        parent::__construct();
        
    }

    private function testLoad() {
        $adopsiService = new AdoptionService($this->db);
        $id = ["parentId" => "mm-silas", "childId" => "mm-henny-damping"];
        $adopsi = $adopsiService->load($id);
        var_dump($adopsi);
    }

    private function testPersonLoad() {
        $personService = new PersonService($this->db);
        $id = "chris";
        $person = $personService->load($id);
        var_dump($person);
    }

    private function testPersonList() {
        $personService = new PersonService($this->db);
        $list = $personService->getList();
        var_dump($list);
    }


    public function main() {
        //$this->testLoad();
        $this->testPersonLoad();
        $this->testPersonList();
    }

}

$app = new TestAdopsi();
$app->run();