<?php
use silsilahApp\DBManager;
use silsilahApp\Person;
use silsilahApp\PersonService;
use silsilahApp\Util;

// var_dump($_POST);

$id = $_POST["tx_id"];
$name = $_POST["tx_name"];
$gender = $_POST["rd_gender"];
$birthPlace = Util::formProcessStringNull($_POST["tx_birth_place"]);
$birthDate = Util::formProcessStringNull($_POST["tx_birth_date"]);
$birthDateExt = Util::formProcessStringNull($_POST["tx_birth_date_ext"]);
$note = Util::formProcessStringNull($_POST["tx_note"]);
$facebook = Util::formProcessStringNull($_POST["tx_facebook"]);

$dieDate = Util::formProcessStringNull($_POST["tx_die_date"]);
$dieDateExt = Util::formProcessStringNull($_POST["tx_die_date_ext"]);
$diePlace = Util::formProcessStringNull($_POST["tx_die_place"]);


$op_mode = $_POST["op_mode"];

$person = new Person();
$person->id = $id;
$person->name = $name;
$person->gender = $gender;
$person->birthPlace = $birthPlace;
$person->birthDate = $birthDate;
$person->birthDateExt = $birthDateExt;
$person->note = $note;
$person->facebook = $facebook;
$person->dieDate = $dieDate;
$person->dieDateExt = $dieDateExt;
$person->diePlace = $diePlace;

$db = new DBManager();
$db->connect();

if ($op_mode == "add") {
    PersonService::save($db, $person);
} 
else
if ($op_mode == "edit") {
    PersonService::update($db, $person);
}    

$db->close();

header("Location: index.php?page=person/detail&id=$id");
// header("Location: index.php?page=person-list");
?>