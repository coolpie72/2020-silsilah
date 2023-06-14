<?php
use silsilahApp\DBManager;
use silsilahApp\MarriageService;

$db = new DBManager();
$db->connect();

$marriageService = new MarriageService($db);

$list = $marriageService->getListWithDetail();

//var_dump($list);

$db->close();


include "list.html";

?>