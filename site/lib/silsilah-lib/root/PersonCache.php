<?php
namespace silsilahApp;

class PersonCache {
    
    private $cache = [];

    public function __construct(&$db) {
        $this->db = $db;
    }

    public function get($id) {
        if (array_key_exists($id, $this->cache)) {
            return $this->cache[$id];
        }
        $person = PersonService::load($this->db, $id);
        $this->cache[$id] = $person;
        return $person;
    }
}