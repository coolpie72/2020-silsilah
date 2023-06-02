<?php
namespace silsilahApp;

class Node {
    
    public $id;
    public $childs;
    public $level;
    public $data;
    
    public function __construct($id, $level) {
        $this->id = $id;
        $this->level = $level;
        $this->childs = [];
        $this->data = null;
    }

    // public static function create($label) {
    //     return new self($label);
    // }

    public function haveChild() {
        return $this->childCount() > 0;
    }

    public function childCount() {
        return count($this->childs);
    }

    public function add($id, $data) {
        $n = new self($id, $this->level + 1);
        $n->data = $data;
        $this->childs[] = $n;
        return $this;
    }

    public function getChildsReverse() {
        return array_reverse($this->childs);
    }

    public function addNode(&$node) {
        $this->childs[] = $node;
        return $this;
    }
}



?>