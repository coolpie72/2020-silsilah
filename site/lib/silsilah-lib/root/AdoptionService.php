<?php
namespace silsilahApp;

class AdoptionService extends BaseService {

    public function __construct($db) {
        parent::__construct($db, "Adoption");
    }

    public function getChildIds($parentId) {
        $list = [];
 
        $sql = <<< EOF
select child_id
from adoption 
where 
    parent_id = '{$parentId}' 
order by num
EOF;
        $result = $this->db->execute($sql);

        while ($row = $result->fetch_assoc()) {
            $list[] = $row["child_id"];
        }

        return $list;

    }


    public function getChildsWithDetail($parentId) {
        $list = [];
 
        $sql = <<< EOF
select 
    a.*, 
    p.name as person_name,
    p.gender as person_gender 
from 
    adoption a, person p 
where 
    a.parent_id = '{$parentId}' and 
    a.child_id = p.id 
order by a.num
EOF;
        $result = $this->db->execute($sql);

        while ($row = $result->fetch_assoc()) {
            $adopt = $this->fromRow($row);

            Util::addExt($adopt, $row, ["person_name", "person_gender"]);

            $list[] = $adopt;
        }

        return $list;

    }

}
