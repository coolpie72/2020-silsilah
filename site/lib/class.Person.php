<?php
class Person {
    public $id;
    public $name;
    public $gender;
    public $birthDate;
    public $birthPlace;
    public $birthDateExt;
    public $note;
    public $facebook;
    public $dieDate;
    public $dieDateExt;
    public $diePlace;

    // function __construct($id, $name) {
    //     $this->id = $id; 
    //     $this->name = $name;
    // }

    function __construct() {

    }

    public function initDefault() {
        $this->gender = "M";
        $this->birthDate = null;
        $this->birthPlace = null;
        $this->birthDateExt = null;
        $this->note = null;
        $this->facebook = null;
        $this->dieDate = null;
        $this->dieDateExt = null;
        $this->diePlace = null;
    }

    public function isMale() {
        return $this->gender == "M";
    }

    public function isFemale() {
        return $this->gender == "F";
    }

    public function isDied() {
        return $this->diePlace !== null;
    }

}
?>
