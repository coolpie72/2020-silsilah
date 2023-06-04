<?php
use silsilahApp\DBManager;
use silsilahApp\AppData;
use silsilahApp\PersonService;
use silsilahApp\MarriageService;
use silsilahApp\MarriageChildService;

$id = $_GET["id"];

$db = new DBManager();
$db->connect();

$person = PersonService::load($db, $id);

AppData::get()->data['title'] = "Rincian Orang: {$person->name}";

//parent info
$parentMarriages = MarriageService::getParentOf($db, $id);
$parentMarriage = count($parentMarriages) == 1 ? $parentMarriages[0] : null;

//siblings info
$parentMarriageId = $parentMarriage == null ? null : $parentMarriage->id;
$siblings = array();
$siblings = MarriageChildService::getListWithDetail($db, $parentMarriageId);


//marriages
$marriages = MarriageService::getMarriages($db, $person->id, $person->gender);
$haveMarriages = count($marriages) > 0;
$spouseRole = null;
if ($haveMarriages) {
    $spouseRole = $person->isMale() ? "Istri" : "Suami";
    $spouseFieldName = $person->isMale() ? "wife_name" : "husband_name";
    $spouseFieldId = $person->isMale() ? "wifeId" : "husbandId";
}

//childs, store in assoc array
$marriageChilds = array();
foreach ($marriages as $m) {
    $marriageChilds[$m->id] = MarriageChildService::getListWithDetail($db, $m->id);
}

$db->close();


include "detail.html";
 
?>

