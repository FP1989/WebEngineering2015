<?php

include("classes/database.class.php");
include_once("classes/beguenstigter.class.php");

//jklljj

/* @var database $database*/
$database = database::getDatabase();
$link = $database->getLink();

$res = array();

$begID = $_POST["BeguenstigterID_L"];

$success = $database->deleteBeguenstigter($begID);

if($success) {

    $res["message"] = "Datensatz wurde gelöscht";
    $res["flag"] = true;

}

else {

    $res["flag"] = false;
    $res["message"] = "Datensatz konnte nicht gelöscht werden";

}

echo json_encode($res);




