<?php
use silsilahApp\DBManager;
use silsilahApp\MarriageService;
use silsilahApp\Marriage;
use silsilahApp\Util;

// var_dump($_POST);

$op_mode = $_POST["op_mode"];

$husband_id = Util::formProcessStringNull($_POST["tx_husband_id"]);
$wife_id = Util::formProcessStringNull($_POST["tx_wife_id"]);
$marriage_date = Util::formProcessStringNull($_POST["tx_mrg_date"]);
$marriage_place = Util::formProcessStringNull($_POST["tx_mrg_place"]);
$note = Util::formProcessStringNull($_POST["tx_note"]);
$marriage_id = $_POST["marriage_id"];
$marriage_num = Util::formProcessInt($_POST["tx_num"], 0);

$db = new DBManager();
$db->connect();

$marriage = new Marriage();
$marriage->husbandId = $husband_id;
$marriage->wifeId = $wife_id;
$marriage->marriageDate = $marriage_date;
$marriage->marriagePlace = $marriage_place;
$marriage->note = $note;
$marriage->num = $marriage_num;

if ($op_mode === "add") {
    $marriage->id = Util::generateId();

    // Util::printVar($marriage);die;
    MarriageService::save($db, $marriage);
} else if ($op_mode === "edit") {
    $marriage->id = $marriage_id;
    // Util::printVar($marriage);die;
    MarriageService::update($db, $marriage);
}

$db->close();

header("Location: index.php?page=marriage/list");
?>