<?php
namespace silsilahApp;

class MarriageService extends BaseService {

    public function __construct($db) {
        parent::__construct($db, "Marriage");
    }

    public function getList() {

        return $this->getDefaultList();

    }

    public function getListWithDetail() {
        $list = [];
        
        //$sql = "select from marriage";
        $sql = <<< EOT
SELECT 
    m.*, 
    h.name as husband_name, 
    w.name as wife_name 
FROM 
    marriage m, 
    person h, 
    person w 
where 
    m.husband_id = h.id and 
    m.wife_id = w.id        
EOT;
        $result = $this->db->execute($sql);

        while ($row = $result->fetch_assoc()) {
            $marriage = $marriage = $this->fromRow($row);

            Util::addExt($marriage, $row, ["husband_name", "wife_name"]);

            $list[] = $marriage;
        }

        return $list;

    }

    //marriages for this person
    public function getMarriages($personId, $personGender) {
        $list =  [];
        $roleId = $personGender == "M" ? "husband_id" : "wife_id";

        // $sql = "SELECT m.* from marriage m where m.$roleId = '$personId'";
        $sql = <<< EOT
SELECT 
    m.*, 
    h.name as husband_name, 
    w.name as wife_name 
FROM 
    marriage m, person h, person w 
where 
    m.husband_id = h.id and m.wife_id = w.id and 
    m.{$roleId} = '{$personId}'
EOT;
        
        $result = $this->db->execute($sql);

        while ($row = $result->fetch_assoc()) {
            $marriage = $marriage = $this->fromRow($row);

            Util::addExt($marriage, $row, ["husband_name", "wife_name"]);

            $list[] = $marriage;
        }

        return $list;        
    }

    //return list marriages (list: should be 0 or 1 marriage object)
    public function getParentOf($childId) {
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

        $result = $this->db->execute($sql);

        while ($row = $result->fetch_assoc()) {
            $marriage = $marriage = self::fromRow($row);

            Util::addExt($marriage, $row, ["husband_name", "wife_name"]);

            $list[] = $marriage;
        }

        return $list;

    }

}
