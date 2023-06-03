<?php
namespace silsilahApp;

class Metadata {

    public $objects;

    private static $instance;

    function __construct() {
        $this->init();
    }

    public static function get() {
        if (self::$instance == null) {
            self::$instance = new Metadata();
        }

        return self::$instance;
    }

    public function getObject($obj) {
        return $this->objects[$obj];
    }   

    private function init() {
        $this->objects = [];

        $obj = new ObjectMeta();
        $obj->dbTable = "person";
        $obj->name = "silsilahApp\\Person";

        $obj->addFieldPrimary("id", "string", "id");
        $obj->addField("name", "string", false, "name");
        $obj->addField("gender", "string", false, "gender");
        $obj->addField("birthDate", "date", true, "birth_date");
        $obj->addField("birthDateExt", "string", true, "birth_date_ext");
        $obj->addField("birthPlace", "string", true, "birth_place");
        $obj->addField("note", "string", true, "note");
        $obj->addField("facebook", "string", true, "facebook");
        $obj->addField("dieDate", "date", true, "die_date");
        $obj->addField("dieDateExt", "string", true, "die_date_ext");
        $obj->addField("diePlace", "string", true, "die_place");

        $this->objects["Person"] = $obj;

        $obj = new ObjectMeta();
        $obj->dbTable = "marriage";
        $obj->name = "silsilahApp\\Marriage";

        $obj->addFieldPrimary("id", "string", "id");
        $obj->addField("husbandId", "string", false, "husband_id");
        $obj->addField("wifeId", "string", false, "wife_id");
        $obj->addField("marriagePlace", "date", true, "mrg_place");
        $obj->addField("marriageDate", "string", true, "mrg_date");
        $obj->addField("note", "string", true, "note");

        $this->objects["Marriage"] = $obj;        

    }



}

//$META = new Metadata();
