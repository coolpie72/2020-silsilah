<?php
namespace silsilahApp;

class Marriage {

    public $id;
    public $husbandId;
    public $wifeId;
    public $marriagePlace;
    public $marriageDate;
    public $note;

    public function __construct() {

    }

    public function initDefault() {
        $this->husbandId = null;
        $this->wifeId = null;
        $this->marriagePlace = null;
        $this->marriageDate = null;
        $this->note = null;
    }

}
