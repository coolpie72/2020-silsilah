<?php
namespace silsilahApp;

class PersonService extends BaseService {

    public function __construct($db) {
        parent::__construct($db, "Person");
    }
    
    public function getList() {
        return $this->getDefaultList();
    }

    //get list anak2 dari person root id
    //return result set: husband_id, wife_id, child_id
    //anak2 sudah sesuai urutan, tp perkawinan blm ada urutan
    public function getChilds($id) {
        $sql = <<< EOT
select m.husband_id, m.wife_id, mc.child_id 
from 
    person p 
join marriage m
on 
    p.id = m.husband_id or p.id = m.wife_id
join marriage_child mc
on 
    m.id = mc.marriage_id
where p.id = '{$id}'
order by 
    m.num asc, mc.num asc
EOT;
        $result = $this->db->execute($sql);

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

}

