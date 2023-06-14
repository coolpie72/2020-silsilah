<?php
namespace silsilahApp;

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

    public function __construct() {

    }

    public function initDefault() {
        $this->gender = Constants::GENDER_MALE;
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
        return $this->gender === Constants::GENDER_MALE;
    }

    public function isFemale() {
        return $this->gender === Constants::GENDER_FEMALE;
    }

    public function isDied() {
        return $this->diePlace !== null || $this->dieDate !== null || $this->dieDateExt !== null;
    }

}

