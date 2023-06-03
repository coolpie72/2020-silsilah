<?php
namespace silsilahApp;

class MarriageService {

    public static function getList(&$db) {
        $list =  array();
        
        $sql = "select * from marriage";
        $result = $db->execute($sql);

        while($row = $result->fetch_assoc()) {
            $marriage = self::fromRow($row);

            $list[] = $marriage;
        }

        return $list;

    }

    public static function getListWithDetail(&$db) {
        $list =  array();
        
        //$sql = "select from marriage";
        $sql = "SELECT m.*, h.name as husband_name, w.name as wife_name FROM `marriage` m, person h, person w where m.husband_id = h.id and m.wife_id = w.id";
        $result = $db->execute($sql);

        while($row = $result->fetch_assoc()) {
            $marriage = $marriage = self::fromRow($row);

            Util::addExt($marriage, $row, array("husband_name", "wife_name"));

            $list[] = $marriage;
        }

        return $list;

    }

    public static function fromRow($row) {

        return SQLUtil::createObject("Marriage", $row);

    }

    //marriages for this person
    public static function getMarriages(&$db, $personId, $personGender) {
        $list =  [];
        $roleId = $personGender == "M" ? "husband_id" : "wife_id";

        // $sql = "SELECT m.* from marriage m where m.$roleId = '$personId'";
        $sql = "SELECT m.*, h.name as husband_name, w.name as wife_name FROM `marriage` m, person h, person w where 
        m.husband_id = h.id and m.wife_id = w.id and 
        m.$roleId = '$personId'";

        $result = $db->execute($sql);

        while($row = $result->fetch_assoc()) {
            $marriage = $marriage = self::fromRow($row);

            Util::addExt($marriage, $row, array("husband_name", "wife_name"));

            $list[] = $marriage;
        }

        return $list;        
    }

    public static function load(&$db, $id) {
        
        $sql = "select * from marriage where id = '$id'";
        $result = $db->execute($sql);

        $row = $result->fetch_assoc();

        $marriage = self::fromRow($row);

        return $marriage;

    }

    //return list marriages (list: should be 0 or 1 marriage object)
    public static function getParentOf(&$db, $childId) {
        $list = [];
        
        $sql = <<< EOF
SELECT 
    m.*, 
    h.name as husband_name, 
    w.name as wife_name 
FROM marriage m, person h, person w 
where 
    m.husband_id = h.id and 
    m.wife_id = w.id and 
    m.id in (select marriage_id from marriage_child where child_id = '{$childId}')
EOF;

        $result = $db->execute($sql);

        while ($row = $result->fetch_assoc()) {
            $marriage = $marriage = self::fromRow($row);

            Util::addExt($marriage, $row, array("husband_name", "wife_name"));

            $list[] = $marriage;
        }

        return $list;

    }

    public static function save(&$db, $marriage) {


        $sql = SQLUtil::getInsert("Marriage", $marriage);

        // var_dump($sql);die;

        $db->execute($sql);

    }    

    public static function update(&$db, $marriage) {

        $sql = SQLUtil::getUpdate("Marriage", $marriage);

        // var_dump($sql);die;

        $db->execute($sql);

    }      

    public static function delete(&$db, $id) {

        $sql = "delete from marriage where id='$id'";

        $db->execute($sql);

    }       

}
