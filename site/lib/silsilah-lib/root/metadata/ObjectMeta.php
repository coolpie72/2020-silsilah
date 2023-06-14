<?php
namespace silsilahApp\metadata;

class ObjectMeta {
    
    public $fields;
    public $dbTable;
    public $name;
    public $ids;

    function __construct() {
        $this->fields = [];
        $this->ids = [];
    }

    public function addFieldPrimary($name, $type, $dbField) {
        $f = new FieldMeta();
        $f->name = $name;
        $f->type = $type;
        $f->nullable = false;
        $f->isPrimary = true;
        $f->dbField = $dbField;

        $this->fields[$name] = $f;

        //mark id field by name
        $this->ids[$name] = 1;
    }

    public function getIdFields() {
        return array_keys($this->ids);
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

