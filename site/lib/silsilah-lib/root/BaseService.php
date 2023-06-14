<?php
namespace silsilahApp;

use silsilahApp\metadata\Metadata;

class BaseService {

    protected $metaName;
    protected $db;
    protected $objMeta;

    public function __construct($db, $metaName) {
        $this->metaName = $metaName;
        $this->objMeta = Metadata::get()->getObject($this->metaName);
        $this->db = $db;
    }

    public function fromRow($row) {

        return SQLUtil::createObject($this->metaName, $row);

    }

    public function getDefaultList() {
        $list =  [];
        
        $sql = "select * from {$this->objMeta->dbTable}";
        $result = $this->db->execute($sql);

        while($row = $result->fetch_assoc()) {
            $p = $this->fromRow($row);

            $list[] = $p;
        }

        return $list;

    }

    private function getIdObject($id) {
        //id: bisa single, jika hanya 1 pk
        //array: jika multi pk, harus tau field yg mana
        //array[keyProp1] = val1
        //array[keyProp2] = $val2

        
        $idFields = $this->objMeta->getIdFields();

        $idObject = new \stdClass; //dummy object
        if (!is_array($id)) {
            $idField = $idFields[0];
            $idObject->{$idField} = $id;
        } else {
            //percaya kepada isi id array
            foreach ($id as $field => $value) {
                $idObject->{$field} = $value;
            }
        }

        return $idObject;
    }

    public function load($id) {

        $idObject = $this->getIdObject($id);

        // var_dump($idObject);die;

        $sql = SqlUtil::getLoad($this->metaName, $idObject);
        $result = $this->db->execute($sql);

        $row = $result->fetch_assoc();
        $entity = $this->fromRow($row); 

        return $entity;

    }

    public function save($obj) {

        $sql = SQLUtil::getInsert($this->metaName, $obj);
    
        $this->db->execute($sql);

    }    

    public function update($obj) {

        $sql = SQLUtil::getUpdate($this->metaName, $obj);

        // var_dump($sql);

        $this->db->execute($sql);

    }        

    //sementara belum dinaekin ke base class
    public function delete($id) {

        $idObject = $this->getIdObject($id);

        // var_dump($idObject);die;

        $sql = SqlUtil::getDelete($this->metaName, $idObject);
        $this->db->execute($sql);

    }       
}
