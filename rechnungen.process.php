<?php
include_once("classes/database.class.php");
include_once("classes/rechnung.class.php");

$betrag_error=$iban_error=$swift_error=$beguenstigter_error=$faelligkeit_error=$bemerkung_error=$reise_error="";
$valid = true;

/** @var database $verbindung */
$verbindung = database::getDatabase();

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

function format_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

$res = array();
$id = $_POST["RechnungsID_P"];
$art = $_POST["RechnungsArt_P"];
$betrag = format_input($_POST["Betrag_P"]);
$iban = format_input($_POST["IBAN_P"]);
$beguenstigter = format_input($_POST["Beguenstigter_P"]);
$faelligkeit = format_input($_POST["Faelligkeit_P"]);
$bemerkung = format_input($_POST["Bemerkung_P"]);
$reise = format_input($_POST["Reise_P"]);
$swift = format_input($_POST["Swift_P"]);
$kostenart = format_input($_POST["Kostenart_P"]);
$bez = $_POST["Bez_P"];
$waehrung = $_POST["Waehrung_P"];

if (empty($betrag)) {
    $betrag_error = "Bitte einen <strong>Betrag</strong> eingeben.";
    $valid = false;
}else if (!is_numeric($betrag) OR $betrag<=0 OR $betrag >500000) {
    $betrag_error = "Bitte einen korrekten <strong>Betrag</strong> eingeben.";
    $valid = false;
}
if (!(preg_match("/[a-zA-Z]{2}\d{2}[ ]\d{4}[ ]\d{4}[ ]\d{4}[ ]\d{4}[ ]\d{1}|[a-zA-Z]{2}\d{22}/", $iban))) {
    $iban_error = "Bitte eine korrekte <strong>IBAN</strong> eingeben.";
    $valid = false;
}

if (empty($beguenstigter)) {
    $beguenstigter_error = "Bitte einen <strong>Begünstigten</strong> eingeben.";
    $valid = false;
}else if(!$verbindung->existsBeguenstigter($beguenstigter)){

    $beguenstigter_error = "Bitte einen <strong>existierenden Begünstigten</strong> eingeben.";
    $valid = false;
}

if (empty($faelligkeit)){
    $faelligkeit_error = "Bitte ein <strong>Fälligkeitsdatum</strong> eingeben.";
    $valid = false;
}else if (!is_valid_date($faelligkeit)) {
    $faelligkeit_error = "Bitte ein korrektes <strong>Datumsformat ['dd.mm.jjjj']</strong> eingeben";
    $valid = false;
}else if (!is_current_date($faelligkeit)){
    $faelligkeit_error = "Bitte ein <strong>aktuelles Fälligkeitsdatum</strong> eingeben";
    $valid = false;
}

if (empty($bemerkung)) {
    $bemerkung_error = "Bitte eine <strong>Bemerkung</strong> eingeben.";
    $valid = false;
}

if (empty($reise)) {
    $reise_error = "Bitte eine <strong>Reise</strong> eingeben.";
    $valid = false;
} else if (!$verbindung->existsReise($reise)) {
    $reise_error = "Bitte eine <strong>korrekte Reise</strong> eingeben.";
    $valid = false;
}

if($valid) {

    $rechnungsdaten = array();

    @$rechnungsdaten['RechnungsID'] = $id;
    @$rechnungsdaten['Rechnungsart'] = $art;
    @$rechnungsdaten['Betrag'] = $betrag;
    @$rechnungsdaten['Waehrung'] = $waehrung;
    @$rechnungsdaten['IBAN'] = $iban;
    @$rechnungsdaten['SWIFT'] = $swift;
    @$rechnungsdaten['Beguenstigter'] = $beguenstigter;
    @$rechnungsdaten['Kostenart'] = $kostenart;
    @$faelligkeit_array = explode('.', $faelligkeit);
    @$tag = $faelligkeit_array[0];
    @$monat = $faelligkeit_array[1];
    @$jahr = $faelligkeit_array[2];
    $newDate = $jahr . "-" . $monat . "-" . $tag;
    @$rechnungsdaten['Faelligkeit'] = $newDate;
    @$rechnungsdaten['Bemerkung'] = $bemerkung;
    @$rechnungsdaten['Reise'] = $reise;
    @$rechnungsdaten['bezahlt'] = $bez;

    $rechnung = rechnung::newRechnung($rechnungsdaten);

    $successful = $verbindung->insertRechnung($rechnung);

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
                if(!empty($betrag_error)){$res["message"] = $res["message"] ."<li>".$betrag_error."</li>";}
                if(!empty($iban_error)){$res["message"] = $res["message"]."<li>".$iban_error."</li>";}
                if(!empty($swift_error)){$res["message"] = $res["message"]."<li>".$swift_error."</li>";}
                if(!empty($beguenstigter_error)){$res["message"] = $res["message"] . "<li>".$beguenstigter_error."</li>";}
                if(!empty($faelligkeit_error)){$res["message"] = $res["message"] . "<li>".$faelligkeit_error."</li>";}
                if(!empty($bemerkung_error)){$res["message"] = $res["message"] . "<li>".$bemerkung_error."</li>";}
                if(!empty($reise_error)){$res["message"] = $res["message"] . "<li>".$reise_error."</li>";}
                $res["message"] = $res["message"] ."</ul>";

    }

echo json_encode($res);

