<?php
include_once("classes/database.class.php");
include_once("classes/reise.class.php");
include("includes/authentication.inc.php");

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

    if($newDate< $time) $valid = false;

    return $valid;
}

function format_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

$ziel = format_input($_POST["Ziel_P"]);
$beschreibung = format_input($_POST["Beschreibung_P"]);
$bezeichnung = format_input($_POST["Bezeichnung_P"]);
$preis = format_input($_POST["Preis_P"]);
$hinreise = format_input($_POST["Hinreise_P"]);
$rueckreise = format_input($_POST["Rueckreise_P"]);
$max = format_input($_POST["Maximalanzahl_P"]);
$min = format_input($_POST["Mindestanzahl_P"]);


if (empty($ziel)) {
    $ziel_error = "Bitte ein <strong>Ziel</strong> eingeben.";
    $valid = false;
} else if(preg_match('#[\d]#',$ziel)){
    $ziel_error= "Bitte ein <strong>korrektes Ziel</strong> eingeben.";
    $valid = false;
}

if (empty($beschreibung)) {
    $beschreibung_error = "Bitte eine <strong>Beschreibung</strong> eingeben.";
    $valid = false;
}

if (empty($bezeichnung)) {
    $bezeichnung_error = "Bitte eine <strong>Bezeichnung</strong> eingeben.";
    $valid = false;
}

if (empty($preis)) {
    $preis_error= "Bitte einen <strong>Preis</strong> eingeben.";
    $valid = false;
}else if(!(is_numeric($preis)) OR $preis <= 0){
    $preis_error= "Bitte einen <strong>korrekten Preis</strong> eingeben.";
    $valid = false;
}
if (empty($hinreise)) {
    $hinreise_error= "Bitte ein <strong>Hinreisedatum</strong> eingeben.";
    $valid = false;
}else if (!is_valid_date($hinreise)) {
    $hinreise_error= "Bitte ein korrektes <strong>Datumsformat ['dd.mm.jjjj'] für die Hinreise</strong> eingeben";
    $valid = false;
}else if (!is_current_date($hinreise)){
    $hinreise_error= "Bitte ein <strong>aktuelles Hinreisedatum </strong> eingeben";
    $valid = false;
}

if (empty($rueckreise)) {
    $rueckreise_error= "Bitte ein <strong>Rückreisedatum</strong> eingeben.";
    $valid = false;
}else if (!is_valid_date($rueckreise)) {
    $rueckreise_error= "Bitte ein korrektes <strong>Datumsformat ['dd.mm.jjjj'] für die Rückreise</strong> eingeben";
    $valid = false;
}else if($rueckreise < $hinreise){
    $rueckreise_error= "Das <strong>Rückreisedatum</strong> muss nach der Hinreise sein";
    $valid = false;
}

if(empty($max)){
    $max_error= "Bitte eine <strong>maximale Anzahl Teilnehmer</strong> eingeben";
    $valid = false;
}else if($max<$min AND isset($min)){
    $max_error= "Die <strong>maximale Anzahl Teilnehmer </strong> muss grösser sein als die Mindestanzahl";
    $valid = false;
}else if($max> reise::MAX OR $max<reise::MIN){
    $max_error= "Bitte eine zulässige <strong>maximale Anzahl Teilnehmer </strong> eingeben (max. 20)";
    $valid = false;
}

if(empty($min)){
    $min_error = "Bitte eine <strong>Mindestanzahl Teilnehmer</strong> eingeben";
    $valid = false;
}else if($min<reise::MIN OR $min>reise::MAX){
    $max_error= "Bitte eine zulässige <strong>Mindestanzahl Teilnehmer </strong> eingeben (min. 12)";
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



