<?php
include_once("classes/database.class.php");
include_once("classes/reise.class.php");

/** @var database $verbindung */
$verbindung = database::getDatabase();

$ziel_error=$beschreibung_error=$bezeichnung_error=$preis_error=$hinreise_error=$rueckreise_error=$min_error=$max_error="";
$valid = true;

$res = array();

function is_valid_date($enddatum) {

    $valid = true;

    @$enddatum_array = explode('.',$enddatum);
    @$tag=$enddatum_array[0];
    @$monat=$enddatum_array[1];
    @$jahr=$enddatum_array[2];

    if (is_numeric($tag) && is_numeric($monat) && is_numeric($jahr)) $valid = checkdate($monat, $tag, $jahr);

    return $valid;
}

function is_current_date($faelligkeit){

    $valid = true;

    $time = date("Y-m-d");

    @$faelligkeit_array = explode('.', $faelligkeit);
    @$tag = $faelligkeit_array[0];
    @$monat = $faelligkeit_array[1];
    @$jahr = $faelligkeit_array[2];
    $newDate = $jahr . "-" . $monat . "-" . $tag;

    if($newDate<= $time) $valid = false;

    return $valid;
}

if (empty($_POST['Ziel_P'])) {
    $ziel_error = "Bitte ein <strong>Ziel</strong> eingeben.";
    $valid = false;
} else if(preg_match('#[\d]#',$_POST["Ziel_P"])){
    $ziel_error= "Bitte ein <strong>korrektes Ziel</strong> eingeben.";
    $valid = false;
}

if (empty($_POST['Beschreibung_P'])) {
    $beschreibung_error = "Bitte eine <strong>Beschreibung</strong> eingeben.";
    $valid = false;
}

if (empty($_POST['Bezeichnung_P'])) {
    $bezeichnung_error = "Bitte eine <strong>Bezeichnung</strong> eingeben.";
    $valid = false;
}

if (empty($_POST['Preis_P'])) {
    $preis_error= "Bitte einen <strong>Preis</strong> eingeben.";
    $valid = false;
}else if(!(is_numeric($_POST['Preis_P'])) OR $_POST["Preis_P"] <= 0){
    $preis_error= "Bitte einen <strong>korrekten Preis</strong> eingeben.";
    $valid = false;
}
if (empty($_POST['Hinreise_P'])) {
    $hinreise_error= "Bitte ein <strong>Hinreisedatum</strong> eingeben.";
    $valid = false;
}else if (!is_valid_date($_POST['Hinreise_P'])) {
    $hinreise_error= "Bitte ein korrektes <strong>Datumsformat ['dd.mm.jjjj'] für die Hinreise</strong> eingeben";
    $valid = false;
}else if (!is_current_date($_POST["Hinreise_P"])){
    $hinreise_error= "Bitte ein <strong>aktuelles Hinreisedatum </strong> eingeben";
    $valid = false;
}

if (empty($_POST['Rueckreise_P'])) {
    $rueckreise_error= "Bitte ein <strong>Rückreisedatum</strong> eingeben.";
    $valid = false;
}else if (!is_valid_date($_POST['Rueckreise_P'])) {
    $rueckreise_error= "Bitte ein korrektes <strong>Datumsformat ['dd.mm.jjjj'] für die Rückreise</strong> eingeben";
    $valid = false;
}else if($_POST["Rueckreise_P"]<$_POST["Hinreise_P"]){
    $rueckreise_error= "Die <strong>Rückreisedatum</strong> muss nach der Hinreise sein";
    $valid = false;
}

if(empty($_POST["Maximalanzahl_P"])){
    $max_error= "Bitte eine <strong>maximale Anzahl Teilnehmer</strong> eingeben";
    $valid = false;
}else if($_POST["Maximalanzahl_P"]<$_POST["Mindestanzahl_P"] AND isset($_POST["Mindestanzahl_P"])){
    $max_error= "Die <strong>maximale Anzahl Teilnehmer </strong> muss grösser sein als die Mindestanzahl";
    $valid = false;
}else if($_POST["Maximalanzahl_P"]> reise::MAX OR $_POST["Maximalanzahl_P"]<reise::MIN){
    $max_error= "Bitte eine zulässige <strong>maximale Anzahl Teilnehmer </strong> eingeben";
    $valid = false;
}

if(empty($_POST["Mindestanzahl_P"])){
    $min_error = "Bitte eine <strong>Mindestanzahl Teilnehmer</strong> eingeben";
    $valid = false;
}else if($_POST["Mindestanzahl_P"]<reise::MIN OR $_POST["Mindestanzahl_P"]>reise::MAX){
    $max_error= "Bitte eine zulässige <strong>Mindestanzahl Teilnehmer </strong> eingeben";
    $valid = false;
}



if($valid) {

    $reisesdaten = array();

    @$reisedaten['ReiseID'] = $_POST["ReiseID_P"];
    @$reisedaten['Ziel'] =$_POST["Ziel_P"];
    @$reisedaten['Beschreibung']= $_POST["Beschreibung_P"];
    @$reisedaten['Bezeichnung']=$_POST["Bezeichnung_P"];
    @$reisedaten['Preis']=$_POST["Preis_P"];

    @$hinreise_array = explode('.', $_POST['Hinreise_P']);
    @$tag = $hinreise_array[0];
    @$monat = $hinreise_array[1];
    @$jahr = $hinreise_array[2];
    $newDate = $jahr . "-" . $monat . "-" . $tag;
    @$reisedaten['Hinreise'] = $newDate;

    @$hinreise_array = explode('.', $_POST['Rueckreise_P']);
    @$tag = $hinreise_array[0];
    @$monat = $hinreise_array[1];
    @$jahr = $hinreise_array[2];
    $newDate = $jahr . "-" . $monat . "-" . $tag;
    @$reisedaten['Rueckreise']= $newDate;
    @$reisedaten['MaxAnzahl'] = $_POST["Maximalanzahl_P"];
    @$reisedaten['MinAnzahl'] = $_POST["Mindestanzahl_P"];

    $reise = reise::newReise($reisedaten);

    $successful = $verbindung->insertReise($reise);

    if ($successful) {

        $res["flag"] = true;
        $res["message"] = "Daten erfolgreich erfasst";

    } else {
        $res["flag"] = false;
        $res["message"] = "Die Daten konnten nicht in die Datenbank geschrieben werden";

    }

}

else {

    $res["flag"] = false;
    $res["message"] = "Die eingegeben Daten sind unkorrekt/unvollständig. ";
    $res["message"] = $res["message"] ."<ul>";
    if(!empty($ziel_error)){$res["message"] = $res["message"] ."<li>".$ziel_error."</li>";}
    if(!empty($beschreibung_error)){$res["message"] = $res["message"]."<li>".$beschreibung_error."</li>";}
    if(!empty($bezeichnung_error)){$res["message"] = $res["message"]."<li>".$bezeichnung_error."</li>";}
    if(!empty($preis_error)){$res["message"] = $res["message"] . "<li>".$preis_error."</li>";}
    if(!empty($hinreise_error)){$res["message"] = $res["message"] . "<li>".$hinreise_error."</li>";}
    if(!empty($rueckreise_error)){$res["message"] = $res["message"] . "<li>".$rueckreise_error."</li>";}
    if(!empty($max_error)){$res["message"] = $res["message"] . "<li>".$max_error."</li>";}
    if(!empty($min_error)){$res["message"] = $res["message"] . "<li>".$min_error."</li>";}
    $res["message"] = $res["message"] ."</ul>";

}

echo json_encode($res);



