<?php
namespace silsilahApp;

class PersonService {
    
    public static function getList(&$db) {
        $list =  array();
        
        $sql = "select * from person";
        $result = $db->execute($sql);

        while($row = $result->fetch_assoc()) {
            $p = self::fromRow($row);

            $list[] = $p;
        }

        return $list;

    }

    public static function fromRow($row) {

        return SQLUtil::createObject("Person", $row);

    }

    public static function load(&$db, $id) {
       
        $sql = "select * from person where id = '$id'";
        $result = $db->execute($sql);

        $row = $result->fetch_assoc();
        $p = self::fromRow($row); 

        return $p;

    }

    public static function save(&$db, $person) {

        $sql = SQLUtil::getInsert("Person", $person);
    
        $db->execute($sql);

    }    

    public static function update(&$db, $person) {

        $sql = SQLUtil::getUpdate("Person", $person);

        // var_dump($sql);

        $db->execute($sql);

    }        

    public static function delete(&$db, $id) {

        $sql = "delete from person where id='$id'";

        $db->execute($sql);

    }       

    //get list anak2 dari person root id
    //return result set: husband_id, wife_id, child_id
    //anak2 sudah sesuai urutan, tp perkawinan blm ada urutan
    public static function getChilds(&$db, $id) {
        $sql = <<< EOT
select m.husband_id, m.wife_id, mc.child_id from person p 
join marriage m
on p.id = m.husband_id or p.id = m.wife_id
join marriage_child mc
on m.id = mc.marriage_id
where p.id = '{$id}'
order by m.num asc, mc.num asc
EOT;
        $result = $db->execute($sql);

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

}

