<?php

include("classes/database.class.php");
include("includes/authentication.inc.php");

/* @var database $database*/
$database = database::getDatabase();

$res = array();

$userID = $_POST['UserID'];

$success = $database->deleteUser($userID);

if($success) {
    $res['message'] = "User erfolgreich gelöscht";
    $res['flag'] = TRUE;
} else {
    $res['message'] = "Datensatz konnte nicht gelöscht werden";
    $res['flag'] = FALSE;
}

echo json_encode($res);
