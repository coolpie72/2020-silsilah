<?php
use silsilahApp\DBManager;
use silsilahApp\MarriageService;
use silsilahApp\PersonService;
use silsilahApp\MarriageChildService;

$id = $_GET["id"];

$db = new DBManager();
$db->connect();

$personService = new PersonService($db);

$marriageService = new MarriageService($db);

$marriageChildService = new MarriageChildService($db);

$marriage = $marriageService->load($id);

$husband = $personService->load($marriage->husbandId);

$wife = $personService->load($marriage->wifeId);

$childList = $marriageChildService->getListWithDetail($marriage->id);

$childNumber = count($childList);


$db->close();

function mclinkUp($idx, $count, $mcId) {
    if ($idx > 1) {
        return "<a href=\"index.php?page=marriage/detail-process&op=order&act=up&mid=$mcId&curr=$idx\">Naik</a>";
    }
    return "Naik";
}

function mclinkDown($idx, $count, $mcId) {
    if ($idx < $count) {
        return "<a href=\"index.php?page=marriage/detail-process&op=order&act=down&mid=$mcId&curr=$idx\">Turun</a>";
    }
    return "Turun";
}

function mcLinkDelete($idx, $count, $mcId) {
    return "<a href=\"index.php?page=marriage/detail-process&op=del&mid=$mcId&curr=$idx&cnt=$count\">Hapus</a>";
}   

include "detail.html";

?>

