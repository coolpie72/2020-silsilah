<?php

    function printIndent($level) {
        $c = $level;
        $len = 0;
        while ($c > 0) {
            // echo "--";
            $len += 40;
            $c--;
        }
        if ($len !== 0) {
            echo '<span style="margin-left: ' . $len . 'px"></span>';
        }
        echo " ";
    }

    


    //root id
    $id = $_GET["id"];

    $db = new DBManager();
    $db->connect();

    $personCache = new PersonCache($db);

    $rootPerson = $personCache->get($id);

    AppData::get()->data['title'] = "Hirarki Orang: {$rootPerson->name}";

    echo '<div class="ch-title">Hirarki Orang: ' . $rootPerson->name . '</div>';

    //build node
    $root = new Node($id, 0);

    //render tree
    $arr = [];
    array_push($arr, $root);

    



    while (!empty($arr)) {
        $node = array_shift($arr);

        printIndent($node->level);
        $person = $personCache->get($node->id);
        
        echo $person->name;
        echo " - " . Util::personDetailLink($person->id);
        if ($person->facebook !== null) {
            echo " - " . Util::personFacebookLink($person);
        }
        echo '<br>';
        
        $rowChilds = PersonService::getChilds($db, $node->id);
        // Util::printVar($rowChilds);die;

        // echo "[{$node->id}] childs: " . count($rowChilds) . "<br>";

        if (empty($rowChilds)) continue;
    
        foreach ($rowChilds as $rc) {
            // Util::printVar($rc);die;
            $node->add($rc['child_id'], $rc);
        }

        $childsReverse = $node->getChildsReverse();
        foreach ($childsReverse as $nc) {
            array_unshift($arr, $nc);
        }

    }


    // var_dump($person);

    $db->close();


    include "root.html";

?>

