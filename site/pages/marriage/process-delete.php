<?php
use silsilahApp\DBManager;
use silsilahApp\MarriageService;

$id = $_GET["id"];

$db = new DBManager();
$db->connect();

$marriageService = new MarriageService($db);

$marriageService->delete($id);

$db->close();

header("Location: index.php?page=marriage/list");
?>