<?php
    // var_dump($_POST);

    $op = $_GET["op"];

    //action: order
    function marriageDetailProcess_order(){
        $marriageId = $_GET["mid"];
        $curr = $_GET["curr"];
        $act = $_GET["act"];
    
        $db = new DBManager();
        $db->connect();
    
        MarriageChildService::modifyOrder($db, $marriageId, $act == "up", $curr);
    
        $db->close();
    
        header("Location: index.php?page=marriage-detail&id=$marriageId");
    }

    //action: del
    function marriageDetailProcess_del(){
        $marriageId = $_GET["mid"];
        $curr = $_GET["curr"];
        $count = $_GET["cnt"];
    
        $db = new DBManager();
        $db->connect();
    
        MarriageChildService::deleteOrder($db, $marriageId, $curr, $count);
    
        $db->close();
    
        header("Location: index.php?page=marriage-detail&id=$marriageId");
    }    


    $funcName = "marriageDetailProcess_$op";
    $funcName();

?>