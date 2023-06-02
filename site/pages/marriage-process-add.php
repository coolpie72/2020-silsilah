<?php
use silsilahApp\DBManager;
use silsilahApp\MarriageService;
use silsilahApp\Marriage;
use silsilahApp\Util;

// var_dump($_POST);

$husband_id = $_POST["tx_husband_id"];
$wife_id = $_POST["tx_wife_id"];

$marriage = new Marriage();
$marriage->id = Util::generateId();
$marriage->husbandId = $husband_id;
$marriage->wifeId = $wife_id;


$db = new DBManager();
$db->connect();

MarriageService::save($db, $marriage);

$db->close();

header("Location: index.php?page=marriage-list");
?>