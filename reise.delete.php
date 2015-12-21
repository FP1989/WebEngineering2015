<?php

include("classes/database.class.php");
include_once("classes/reise.class.php");
include("includes/authentication.inc.php");

/* @var database $database*/
$database = database::getDatabase();

$res = array();

$reiseID = $_POST["ReiseID_L"];

$success = $database->deleteReise($reiseID);

if($success) {

    $res["message"] = "Datensatz wurde gelöscht";
    $res["flag"] = true;

}

else {

    $res["flag"] = false;
    $res["message"] = "Datensatz konnte nicht gelöscht werden, möglicherweise bestehen noch Abhängigkeiten.";

}

echo json_encode($res);




