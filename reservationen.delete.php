<?php

include("classes/database.class.php");

/* @var database $database*/
$database = database::getDatabase();
$link = $database->getLink();

$res = array();

$teilnehmerID = $_POST["TeilnehmerID_L"];
$reiseID = $_POST["ReiseID_L"];

$success = $database->deleteReservation($teilnehmerID, $reiseID);

if($success) {

    $res["message"] = "Datensatz wurde gelöscht";
    $res["flag"] = true;

}

else {

    $res["flag"] = false;
    $res["message"] = "Datensatz konnte nicht gelöscht werden";

}

echo json_encode($res);




