<?php

use silsilahApp\AdoptionService;
use silsilahApp\DBManager;
use silsilahApp\AppData;
use silsilahApp\PersonService;
use silsilahApp\MarriageService;
use silsilahApp\MarriageChildService;

$id = $_GET["id"];

$db = new DBManager();
$db->connect();

$personService = new PersonService($db);
$marriageService = new MarriageService($db);
$marriageChildService = new MarriageChildService($db);

$person = $personService->load($id);

AppData::get()->data['title'] = "Rincian Orang: {$person->name}";

//parent info
$parentMarriages = $marriageService->getParentOf($id);
$parentMarriage = count($parentMarriages) == 1 ? $parentMarriages[0] : null;

//siblings info
$parentMarriageId = $parentMarriage == null ? null : $parentMarriage->id;
$siblings = array();
$siblings = $marriageChildService->getListWithDetail($parentMarriageId);


//marriages
$marriages = $marriageService->getMarriages($person->id, $person->gender);
$haveMarriages = count($marriages) > 0;
$spouseRole = null;
if ($haveMarriages) {
    $spouseRole = $person->isMale() ? "Istri" : "Suami";
    $spouseFieldName = $person->isMale() ? "wife_name" : "husband_name";
    $spouseFieldId = $person->isMale() ? "wifeId" : "husbandId";
}

//childs, store in assoc array
$marriageChilds = [];
foreach ($marriages as $m) {
    $marriageChilds[$m->id] = $marriageChildService->getListWithDetail($m->id);
}

//adoptions
$adoptionService = new AdoptionService($db);
$adoptedChilds = $adoptionService->getChildsWithDetail($person->id);
$haveAdoptedChild = count($adoptedChilds) > 0;


$db->close();


include "detail.html";
 
?>

