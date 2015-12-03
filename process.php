<?php
include_once("classes/database.class.php");
include_once("classes/beguenstigter.class.php");

$name_error=$strasse_error=$hausnummer_error=$plz_error=$ort_error="";
$valid = true;
$recipientData = array();
$res = array();

if(isset($_POST['type']))
{
    if($_POST['type'] =="claim") {

        if (empty($_POST['Name'])) {
            $name_error = "Bitte einen <strong>Namen</strong> eingeben.";
            $valid = false;
        }
        if (empty($_POST['Strasse'])) {
            $strasse_error = "Bitte eine <strong>Strasse</strong> eingeben.";
            $valid = false;
        }
        if (empty($_POST['Hausnummer'])) {
            $hausnummer_error = "Bitte eine <strong>Hausnummer</strong> eingeben.";
            $valid = false;
        }
        if (empty($_POST['PLZ'])) {
            $plz_error = "Bitte eine <strong>Postleitzahl</strong> eingeben.";
            $valid = false;
        }else if(!(is_numeric($_POST['PLZ']))){
            $plz_error = $plz_error . " Beim Feld PLZ sind nur Zahlen sind erlaubt";
            $valid = false;
        }
        if (empty($_POST['Ort'])) {
            $ort_error = "Bitte einen <strong>Ort</strong> eingeben.";
            $valid = false;
        }else if(is_numeric($_POST['Ort'])){
            $ort_error = $ort_error. " Beim Feld Ort sind nur Buchstaben erlaubt.";
            $valid = false;
        }

        if($valid) {

            @$recipientData['BeguenstigterName'] = $_POST['Name'];
            @$recipientData['Strasse'] = $_POST['Strasse'];
            @$recipientData['Hausnummer'] = $_POST['Hausnummer'];
            @$recipientData['PLZ'] = $_POST['PLZ'];
            @$recipientData['Ort'] = $_POST['Ort'];


            $recipient = beguenstigter::newBeguenstigter($recipientData);


            /** @var database $verbindung */
            $verbindung = database::getDatabase();
            $successful = $verbindung->insertBeguenstigter($recipient);

            if ($successful) {


                $res["flag"] = true;
                $res["message"] = "Daten erfolgreich erfasst";
            } else {
                $res["flag"] = false;
                $res["message"] = "Die Daten konnten nicht in die Datenbank geschrieben werden";
            }
        }else {
            $res["flag"] = false;
            $res["message"] = "Die eingegeben Daten sind unkorrekt/unvollständig. ";
            $res["message"] = $res["message"] ."<ul>";
            if(!empty($name_error)){$res["message"] = $res["message"] ."<li>".$name_error."</li>";}
            if(!empty($strasse_error)){$res["message"] = $res["message"]."<li>".$strasse_error."</li>";}
            if(!empty($hausnummer_error)){$res["message"] = $res["message"]."<li>".$hausnummer_error."</li>";}
            if(!empty($plz_error)){$res["message"] = $res["message"] . "<li>".$plz_error."</li>";}
            if(!empty($ort_error)){$res["message"] = $res["message"] . "<li>".$ort_error."</li>";}
            $res["message"] = $res["message"] ."</ul>";

        }


    }
}
else{
    $res["flag"] = false;
    $res["message"] = "Invalid format";
}

echo json_encode($res);


?>
