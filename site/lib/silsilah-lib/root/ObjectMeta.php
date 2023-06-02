<?php
namespace silsilahApp;

class ObjectMeta {
    
    public $fields;
    public $dbTable;
    public $name;

    function __construct() {
        $this->fields = array();
    }

    public function addFieldPrimary($name, $type, $dbField) {
        $f = new FieldMeta();
        $f->name = $name;
        $f->type = $type;
        $f->nullable = false;
        $f->isPrimary = true;
        $f->dbField = $dbField;

        $this->fields[$name] = $f;
    }

    public function addField($name, $type, $nullable, $dbField) {
        $f = new FieldMeta();
        $f->name = $name;
        $f->type = $type;
        $f->nullable = $nullable;
        $f->isPrimary = false;
        $f->dbField = $dbField;

        $this->fields[$name] = $f;
    }

}

