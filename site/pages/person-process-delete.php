<?php
    $id = $_GET["id"];

    $db = new DBManager();
    $db->connect();

    PersonService::delete($db, $id);

    $db->close();

    header("Location: index.php?page=person-list");
?>