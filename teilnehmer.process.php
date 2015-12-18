<?php
include_once("classes/database.class.php");
include_once("classes/teilnehmer.class.php");

$vornamen_error=$nachnamen_error=$strasse_error=$PLZ_error=$mail_error=$ort_error=$telefon_error="";
$valid = true;

$res = array();

$id = format_input($_POST["TeilnehmerID_P"]);
$vorname = format_input($_POST["Vorname_P"]);
$nachname = format_input($_POST["Nachname_P"]);
$strasse = format_input($_POST["Strasse_P"]);
$hausnummer = format_input($_POST["Hausnummer_P"]);
$plz = format_input($_POST["PLZ_P"]);
$ort = format_input($_POST["Ort_P"]);
$tel = format_input($_POST["Telefon_P"]);
$mail = format_input($_POST["Mail_P"]);

if (empty($_POST['Vorname_P'])) {
    $vornamen_error = "Bitte einen <strong>Vornamen</strong> eingeben.";
    $valid = false;
}else if(preg_match('#[\d]#',$_POST["Vorname_P"])){
    $vornamen_error = "Bitte einen <strong>korrekten Vornamen</strong> eingeben.";
    $valid = false;
}

if (empty($_POST['Nachname_P'])) {
    $nachnamen_error = "Bitte einen <strong>Nachnamen</strong> eingeben.";
    $valid = false;
}else if(preg_match('#[\d]#',$_POST["Nachname_P"])){
    $nachnamen_error = "Bitte einen <strong>korrekten Nachnamen</strong> eingeben.";
    $valid = false;
}

if (empty($_POST['Strasse_P'])) {
    $strasse_error = "Bitte eine <strong>Strasse</strong> eingeben.";
    $valid = false;
}else if(preg_match('#[\d]#',$_POST["Strasse_P"])){
    $strasse_error = "Bitte eine <strong>korrekte Strasse</strong> eingeben.";
    $valid = false;
}

if (empty($_POST['PLZ_P'])) {
    $PLZ_error = "Bitte eine <strong>Postleitzahl</strong> eingeben.";
    $valid = false;
}else if(!(is_numeric($_POST['PLZ_P']))){
    $PLZ_error = "Bitte eine <strong>Postleitzahl</strong> eingeben.";
    $valid = false;
}

if (empty($_POST['Ort_P'])) {
    $ort_error = "Bitte einen <strong>Ort</strong> eingeben.";
    $valid = false;
}else if(preg_match('#[\d]#', $_POST['Ort_P'])){
    $ort_error = "Bitte einen <strong>korrekten Ort</strong> eingeben.";
    $valid = false;
}

if (empty($_POST['Telefon_P'])) {
    $telefon_error = "Bitte eine <strong>Telefonnummer</strong> eingeben.";
    $valid = false;
}else if(!is_numeric($_POST['Telefon_P'])){
    $telefon_error = "Bitte eine <strong>korrekte Telefonnummer</strong> eingeben.";
    $valid = false;
}else if(($_POST['Telefon_P'])>9999999999){
    $telefon_error = "Bitte eine <strong>korrekte Telefonnummer</strong> eingeben.";
    $valid = false;
}

if (empty($_POST['Mail_P'])) {
    $mail_error = "Bitte eine <strong>E-Mail-Adresse</strong> eingeben.";
    $valid = false;
}else if(!filter_var($_POST["Mail_P"], FILTER_VALIDATE_EMAIL)){
    $mail_error = "Bitte eine <strong>korrekte E-Mail-Adresse</strong> eingeben.";
    $valid = false;
}

if($valid) {

    $teilnehmerdaten = array();

    @$teilnehmerdaten['TeilnehmerID'] = $id;
    @$teilnehmerdaten['Vorname'] = $vorname;
    @$teilnehmerdaten['Nachname'] = $nachname;
    @$teilnehmerdaten['Strasse'] = $strasse;
    @$teilnehmerdaten['Hausnummer'] = $hausnummer;
    @$teilnehmerdaten['PLZ'] = $plz;
    @$teilnehmerdaten['Ort'] = $ort;
    @$teilnehmerdaten['Telefon'] = $tel;
    @$teilnehmerdaten['Mail'] = $mail;

    $teilnehmer = teilnehmer::newTeilnehmer($teilnehmerdaten);


    /** @var database $verbindung */
    $verbindung = database::getDatabase();
    $successful = $verbindung->insertTeilnehmner($teilnehmer);

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
        if(!empty($vornamen_error)){$res["message"] = $res["message"]."<li>".$vornamen_error."</li>";}
        if(!empty($nachnamen_error)){$res["message"] = $res["message"]."<li>".$nachnamen_error."</li>";}
        if(!empty($strasse_error)){$res["message"] = $res["message"]."<li>".$strasse_error."</li>";}
        if(!empty($PLZ_error)){$res["message"] = $res["message"]."<li>".$PLZ_error."</li>";}
        if(!empty($ort_error)){$res["message"] = $res["message"]."<li>".$ort_error."</li>";}
        if(!empty($telefon_error)){$res["message"] = $res["message"]."<li>".$telefon_error."</li>";}
        if(!empty($mail_error)){$res["message"] = $res["message"]."<li>".$mail_error."</li>";}
        $res["message"] = $res["message"]."</ul>";

}

echo json_encode($res);

