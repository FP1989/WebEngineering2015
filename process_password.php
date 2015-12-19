<?php
session_start();
include_once("classes/database.class.php");
include("includes/authentication.inc.php");

$passold_error = $passnew_error = $passnew1_error = $error = "";
$valid = true;
$res = array();

/** @var database $verbindung */
$verbindung = database::getDatabase();
$userid = $_SESSION['userid'];
$pwhash = sha1($_POST['Passold']);
$rows = $verbindung->verifyLogin($userid, $pwhash);

if(empty($_POST['Passold'])) {
    $passold_error = "Bitte das aktuelle Passwort eingeben";
    $valid = false;
} elseif($rows < 1) {
    $passold_error = "Das aktuelle Passwort wurde falsch eingegeben";
    $valid = false;
}
if(empty($_POST['Passnew'])) {
    $passnew_error = "Bitte das neue Passwort eingeben";
    $valid = false;
}
if(empty($_POST['Passnew1'])) {
    $passnew1_error = "Bitte das neue Passwort wiederholen";
    $valid = false;
}
if(trim($_POST['Passnew']) != trim($_POST['Passnew1'])) {
    $error = "Das neue Passwort stimmt nicht überein";
    $valid = false;
}

if($valid) {

    $pwhash = sha1($_POST['Passnew']);
    $successful = $verbindung->insertPassword($userid, $pwhash);

    if($successful) {

        $res['flag'] = true;
        $res['message'] = "Passwort wurde geändert";
    } else {
        $res['flag'] = false;
        $res['message'] = "Das Passwort konnte nicht in die Datenbank geschrieben werden";
    }
}else {
    $res['flag'] = false;
    $res['message'] = "Die eingegeben Daten sind unkorrekt/unvollständig";
    $res['message'] = $res["message"] ."<ul>";
    if(!empty($passold_error)) $res['message'] = $res['message'] . "<li>" . $passold_error . "</li>";
    if(!empty($passnew_error)) $res['message'] = $res['message'] . "<li>" . $passnew_error . "</li>";
    if(!empty($passnew1_error)) $res['message'] = $res['message'] . "<li>" . $passnew1_error . "</li>";
    if(!empty($error)) $res['message'] = $res['message'] . "<li>" . $error . "</li>";
    $res["message"] = $res["message"] ."</ul>";
}

echo json_encode($res);