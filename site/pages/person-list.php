<?php
use silsilahApp\DBManager;
use silsilahApp\AppData;
use silsilahApp\PersonService;


$db = new DBManager();
$db->connect();

AppData::get()->data['title'] = "Daftar Orang";

$list = PersonService::getList($db);

//var_dump($list);

$db->close();

function personListFacebookLink($person) {
    if ($person->facebook == null) return "";
    return "<a href=\"{$person->facebook}\">FB</a>";
}   


include "person-list.html";


?>