<?php
use silsilahApp\Marriage;
use silsilahApp\DBManager;
use silsilahApp\MarriageService;

//kalo ada id berrati edit
$id = isset($_GET["id"])? $_GET["id"] : null;

$IS_ADD = $id == null;

$op_mode = "add";
$title = "Tambah Pernikahan";

//default
$marriage = new Marriage();
$marriage->initDefault();


if (!$IS_ADD) {
    $op_mode = "edit";
    $title = "Ubah Pernikahan";

    $db = new DBManager();
    $db->connect();

    $marriage = MarriageService::load($db, $id);

    $db->close();

}


include "marriage-add.html";

?>