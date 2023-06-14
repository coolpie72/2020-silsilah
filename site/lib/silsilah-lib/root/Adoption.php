<?php
namespace silsilahApp;

class Adoption {

    public $parentId;
    public $childId;
    public $adoptDate;
    public $adoptPlace;
    public $num;
    public $note;

    function __construct() {

    }

    public function initDefault() {
        $this->parentId = null;
        $this->childId = null;
        $this->adoptDate = null;
        $this->adoptDate = null;
        $this->adoptPlace = null;
        $this->num = 0;
        $this->note = null;
    }


    // public function getId() {
    //     //TODO: bisa di automate di object meta
    //     $obj = new \stdClass;
    //     $obj->parentId = $this->parentId;
    //     $obj->childId = $this->childId;
    // }

}

