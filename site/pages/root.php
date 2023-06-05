<?php
use coolpie\date\CDate;
use silsilahApp\DBManager;
use silsilahApp\PersonCache;
use silsilahApp\AppData;
use silsilahApp\Node;
use silsilahApp\Util;
use silsilahApp\PersonService;

function getIndent($level) {
    $text = "";
    $c = $level;
    $len = 0;
    while ($c > 0) {
        // echo "--";
        $len += 40;
        $c--;
    }
    if ($len !== 0) {
        $text = '<span style="margin-left: ' . $len . 'px"></span>';
    }
    return $text;
}

//opt[print]=1
//artinya jika set, maka print mode, minimal embel2

//opt[age]=0
//artinya disable show age

$OPT = [];
$OPT['print'] = false;
if (isset($_GET['opt']) && isset($_GET['opt']['print'])) {
    $OPT['print'] = true;
}

$OPT['age'] = true;
if (isset($_GET['opt']) && isset($_GET['opt']['age']) && $_GET['opt']['age'] === '0') {
    $OPT['age'] = false;
}



$now = CDate::create()->fromNow();

//root id
$id = $_GET["id"];

$db = new DBManager();
$db->connect();

$personCache = new PersonCache($db);

$rootPerson = $personCache->get($id);


AppData::get()->data['title'] = "Hirarki Orang: {$rootPerson->name}";

echo '<div align="center">';
echo '<div class="ch-title">Hirarki Orang: ' . $rootPerson->name . '</div>';

//build node
$root = new Node($id, 0);

//render tree
$arr = [];
array_push($arr, $root);

Util::table1Start();
while (!empty($arr)) {
    $node = array_shift($arr);


    $text = getIndent($node->level);
    $text .= "L{$node->level}. ";
    $person = $personCache->get($node->id);
    
    $text .= $person->name;

    if ($OPT['age']) {
        $ageLabel = Util::getAgeLabel($person, $now);
        if ($ageLabel) {
            $text .= " - " . $ageLabel;
        }    
    }
    if (!$OPT['print']) {
        $text .= " - " . Util::personDetailLink($person->id);
        if ($person->facebook !== null) {
            $text .= " - " . Util::personFacebookLink($person);
        }    
    }

    $clsDied = Util::getDiedClass($person);

    Util::tableRowStart([$clsDied]);
    Util::tableCell($text);
    Util::tableRowEnd();
    
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
Util::tableEnd();

$now = CDate::create()->fromNowWib();
echo "<br/>";
echo "Dihasilkan oleh Aplikasi Silsilah - {$now->toLiteral()} WIB<br/>";
echo '</div>';

// var_dump($person);

$db->close();


include "root.html";

?>

