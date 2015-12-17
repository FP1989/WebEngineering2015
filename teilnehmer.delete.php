<?php

include("classes/database.class.php");
include_once("classes/teilnehmer.class.php");

/* @var database $database*/
$database = database::getDatabase();
$link = $database->getLink();

$res = array();

$teilnehmerID = $_POST["TeilnehmerID_L"];

$success = $database->deleteTeilnehmer($teilnehmerID);

if($success) {

    $res["message"] = "Datensatz wurde gelöscht";
    $res["flag"] = true;

}

else {

    $res["flag"] = false;
    $res["message"] = "Datensatz konnte nicht gelöscht werden";

}

echo json_encode($res);




