<?php

$db = new DBManager();
$db->connect();


$list = MarriageService::getListWithDetail($db);

//var_dump($list);

$db->close();




include "marriage-list.html";

?>