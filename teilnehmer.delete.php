<?php

include("classes/database.class.php");
include_once("classes/teilnehmer.class.php");
include("includes/authentication.inc.php");

/* @var database $database*/
$database = database::getDatabase();


$res = array();

$teilnehmerID = $_POST["TeilnehmerID"];


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




