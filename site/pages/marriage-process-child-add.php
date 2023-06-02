<?php
use silsilahApp\DBManager;
use silsilahApp\MarriageChildService;
use silsilahApp\MarriageChild;

// var_dump($_POST);

$marriage_id = $_POST["tx_marriage_id"];
$child_id = $_POST["tx_child_id"];
$child_num = $_POST["tx_child_num"];

$marriageChild = new MarriageChild();
$marriageChild->marriageId = $marriage_id;
$marriageChild->childId = $child_id;
$marriageChild->number = $child_num;


$db = new DBManager();
$db->connect();

MarriageChildService::save($db, $marriageChild);

$db->close();

header("Location: index.php?page=marriage-detail&id=$marriage_id");
?>