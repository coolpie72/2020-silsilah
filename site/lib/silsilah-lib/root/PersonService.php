<?php
namespace silsilahApp;

class PersonService {
    
    public static function getList(&$db) {
        $list =  array();
        
        // $list[] = new Orang("001", "Chris");
        // $list[] = new Orang("002", "Sari");
        // $list[] = new Orang("003", "Lita");

        $sql = "select * from person";
        $result = $db->execute($sql);

        while($row = $result->fetch_assoc()) {
            $p = self::fromRow($row);
            //  Person();
            // $p->id = $row["id"];
            // $p->name = $row["name"];
            // $p->gender = $row["gender"];

            $list[] = $p;
        }

        return $list;

    }

    public static function fromRow($row) {
        // $p = new Person();
        // $p->id = $row["id"];
        // $p->name = $row["name"];
        // $p->gender = $row["gender"];
        // $p->birthDate = $row["birth_date"];
        // $p->birthPlace = $row["birth_place"];

        // return $p;

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

        // $sql = "insert into person (id, name, gender, birth_date, birth_place) 
        // values('$person->id', '$person->name', '$person->gender', '$person->birthDate', '$person->birthPlace')";

        $sql = SQLUtil::getInsert("Person", $person);

    
        $db->execute($sql);

    }    

    public static function update(&$db, $person) {


        // $strBirthDate = Util::sqlAssign("birth_date", $person->birthDate);
        // $strBirthPlace = Util::sqlAssign("birth_place", $person->birthPlace);


        // $sql = "update person set 
        //     name = '$person->name', 
        //     gender = '$person->gender',
        //     $strBirthDate,
        //     $strBirthPlace
        // where id = '$person->id'";

        

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
order by mc.num asc
EOT;
        $result = $db->execute($sql);

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

}

