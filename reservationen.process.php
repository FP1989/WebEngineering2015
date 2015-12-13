<?php

include("classes/database.class.php");

/* @var database $database*/
$database = database::getDatabase();
$link = $database->getLink();

$res = array();

$teilnehmerID = $_POST["TeilnehmerID_L"];
$reiseID = $_POST["ReiseID_L"];

$success = $database->setBezahlt($teilnehmerID, $reiseID);

if($success) {

    $res["message"] = "Rechnung wurde als bezahlt markiert";
    $res["flag"] = true;

}

else {

    $res["flag"] = false;
    $res["message"] = "Rechnung konnte nicht als bezahlt markiert werden";

}

echo json_encode($res);




