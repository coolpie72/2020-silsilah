<?php
use silsilahApp\DBManager;
use silsilahApp\Person;
use silsilahApp\PersonService;

//kalo ada id berrati edit
$id = isset($_GET["id"])? $_GET["id"]: null;

$IS_ADD = $id == null;

// var_dump($id);
// var_dump($IS_ADD);

$op_mode = "add";
$title = "Tambah Orang";

//default
$person = new Person();
$person->initDefault();
$person->gender = "M";
$person->birthDate = null;
$person->birthPlace = null;


if (!$IS_ADD) {
    $op_mode = "edit";
    $title = "Ubah Orang";

    $db = new DBManager();
    $db->connect();

    $person = PersonService::load($db, $id);

    $db->close();

}

include "add.html";

?>