<?php
class MarriageChildService {
    public static function getListWithDetail(&$db, $marriageId) {
        $list =  array();
 
        $sql = "select mc.*, 
        p.name as person_name,
        p.gender as person_gender 
        from marriage_child mc, person p 
        where mc.marriage_id = '$marriageId' and p.id = mc.child_id order by mc.num";
        
        $result = $db->execute($sql);

        while($row = $result->fetch_assoc()) {
            $mc = self::fromRow($row);

            Util::addExt($mc, $row, array("person_name", "person_gender"));

            $list[] = $mc;
        }

        return $list;

    }

    // public static function getSiblingsForPerson(&$db, $personId) {
    //     $list = array();
 
    //     $sql = "select mc.*, 
    //     p.name as person_name,
    //     p.gender as person_gender 
    //     from marriage_child mc, person p 
    //     where 
    //     mc.marriage_id in (SELECT mc.marriage_id FROM marriage_child mc where mc.child_id='$personId') and
    //     p.id = mc.child_id 
    //     order by mc.marriage_id, mc.num";
        
    //     $result = $db->execute($sql);

    //     while($row = $result->fetch_assoc()) {
    //         $mc = self::fromRow($row);

    //         Util::addExt($mc, $row, array("person_name", "person_gender"));

    //         $list[] = $mc;
    //     }

    //     return $list;

    // }    

    public static function modifyOrder(&$db, $marriageId, $isUp, $curr) {
        $pair = 0;
        if ($isUp) {
            $pair = $curr -1;
        }
        else {
            $pair = $curr + 1;
        }

        $sql = "update marriage_child set num = -99 where num = $pair and marriage_id = '$marriageId'";
        $db->execute($sql);

        $sql = "update marriage_child set num = $pair where num = $curr and marriage_id = '$marriageId'";
        $db->execute($sql);      

        $sql = "update marriage_child set num = $curr where num = -99 and marriage_id = '$marriageId'";
        $db->execute($sql);              


    }

    public static function deleteOrder(&$db, $marriageId, $curr, $count) {

        //asumsi size = 8
        //curr = 4

        //delete no 4
        $sql = "delete from marriage_child where num = $curr and marriage_id = '$marriageId'";
        // var_dump($sql);
        $db->execute($sql);      

        if ($curr < $count) {
            //change order: 5,6,7,8 -> n-1
            $sql = "update marriage_child set num = num - 1 where num > $curr and marriage_id = '$marriageId'";
            // var_dump($sql);
            $db->execute($sql);  
        }

    }


    public static function fromRow($row) {
        $mc = new MarriageChild();
        $mc->marriageId = $row["marriage_id"];
        $mc->childId = $row["child_id"];
        $mc->number = $row["num"];

        return $mc;

    }

    public static function load(&$db, $id) {
       
        $sql = "select * from person where id = '$id'";
        $result = $db->execute($sql);

        $row = $result->fetch_assoc();
        $p = self::fromRow($row); 

        return $p;

    }

    public static function save(&$db, $marriageChild) {

        $sql = "insert into marriage_child (marriage_id, child_id, num) values('$marriageChild->marriageId', '$marriageChild->childId', '$marriageChild->number')";

    
        $db->execute($sql);

    }    

    public static function delete(&$db, $id) {

        $sql = "delete from person where id='$id'";

        $db->execute($sql);

    }       

}
?>
