<?php
include_once("classes/database.class.php");
include_once("classes/rechnung.class.php");

/*
$name_error=$strasse_error=$hausnummer_error=$plz_error=$ort_error="";
$valid = true;
$recipientData = array();


$_POST["RechnungsID_P"] = 3;
$_POST["RechnungsArt_P"] = "RoterES";
$_POST["Betrag_P"] = 555;
$_POST["Waehrung_P"] = "EUR";
$_POST["IBAN_P"]="CH12 2345 1234 1243 3456 8";
$_POST["Swift_P"] = "BLKBCH22";
$_POST["Beguenstigter_P"] ="2";
$_POST["Kostenart_P"] = "Hotel";
$_POST["Faelligkeit_P"] ="2016-01-01";
$_POST["Bemerkung_P"] = "12";
$_POST["Reise_P"]=2;
$_POST["Bez_P"]=0;
*/

$res = array();


        /*
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
*/
        $rechnungsdaten = array();

        @$rechnungsdaten['RechnungsID'] = $_POST["RechnungsID_P"];
        @$rechnungsdaten['Rechnungsart'] =$_POST["RechnungsArt_P"];
        @$rechnungsdaten['Betrag']= $_POST["Betrag_P"];
        @$rechnungsdaten['Waehrung']=$_POST["Waehrung_P"];
        @$rechnungsdaten['IBAN']=$_POST["IBAN_P"];
        @$rechnungsdaten['SWIFT'] = $_POST["Swift_P"];
        @$rechnungsdaten['Beguenstigter']= $_POST["Beguenstigter_P"];
        @$rechnungsdaten['Kostenart']= $_POST["Kostenart_P"];
        @$rechnungsdaten['Faelligkeit']= $_POST["Faelligkeit_P"];
        @$rechnungsdaten['Bemerkung']= $_POST["Bemerkung_P"];
        @$rechnungsdaten['Reise']= $_POST["Reise_P"];
        @$rechnungsdaten['bezahlt']= $_POST["Bez_P"];

        $rechnung = rechnung::newRechnung($rechnungsdaten);


            /** @var database $verbindung */
            $verbindung = database::getDatabase();
            $successful = $verbindung->insertRechnung($rechnung);

            if ($successful) {

                $res["flag"] = true;
                $res["message"] = "Daten erfolgreich erfasst";

            } else {
                $res["flag"] = false;
                $res["message"] = "Die Daten konnten nicht in die Datenbank geschrieben werden";


                /*else {
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
                */

            }

echo json_encode($res);

