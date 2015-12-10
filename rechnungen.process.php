<?php
include_once("classes/database.class.php");
include_once("classes/rechnung.class.php");

$betrag_error=$iban_error=$swift_error=$beguenstigter_error=$faelligkeit_error=$bemerkung_error=$reise_error="";
$valid = true;




$res = array();



        if (empty($_POST['Betrag_P']) OR $_POST['Betrag_P']<=0) {
            $betrag_error = "Bitte einen <strong>Betrag</strong> eingeben.";
            $valid = false;
        }
        if (!(preg_match("/[a-zA-Z]{2}\d{2}[ ]\d{4}[ ]\d{4}[ ]\d{4}[ ]\d{4}[ ]\d{1}|[a-zA-Z]{2}\d{22}/", $_POST['IBAN_P']))) {
            $iban_error = "Bitte eine korrekte <strong>IBAN</strong> eingeben.";
            $valid = false;
        }
        if (empty($_POST['Swift_P'])) {
            $swift_error = "Bitte einen <strong>Swift-Code</strong> eingeben.";
            $valid = false;
        }elseif(!(preg_match('/^[a-z]{6}[0-9a-z]{2}([0-9a-z]{3})?\z/i', $_POST['Swift_P']))){
            $swift_error = "Bitte ein korrektes Format eingeben";
            $valid = false;
        }
        if (empty($_POST['Beguenstigter_P'])) {
            $beguenstigter_error = "Bitte einen <strong>Begünstigten</strong> eingeben.";
            $valid = false;
        }

        if (empty($_POST['Hinreise_P'])){
            $faelligkeit_error = "Bitte ein <strong>Fälligkeitsdatum</strong> eingeben.";
            $valid = false;
        }else if (is_valid_date($_POST['Hinreise_P'])==false) {
            $faelligkeit_error = "Bitte ein korrektes Datumsformat ['dd.mm.jjjj'] eingeben";
            $valid = false;
        }

        if (empty($_POST['Bemerkung_P'])) {
            $bemerkung_error = "Bitte eine <strong>Bemerkung</strong> eingeben.";
            $valid = false;
        }

        if (empty($_POST['Reise_P'])) {
            $reise_error = "Bitte eine <strong>Reise</strong> eingeben.";
            $valid = false;
        }

        if($valid) {

            $rechnungsdaten = array();

            @$rechnungsdaten['RechnungsID'] = $_POST["RechnungsID_P"];
            @$rechnungsdaten['Rechnungsart'] = $_POST["RechnungsArt_P"];
            @$rechnungsdaten['Betrag'] = $_POST["Betrag_P"];
            @$rechnungsdaten['Waehrung'] = $_POST["Waehrung_P"];
            @$rechnungsdaten['IBAN'] = $_POST["IBAN_P"];
            @$rechnungsdaten['SWIFT'] = $_POST["Swift_P"];
            @$rechnungsdaten['Beguenstigter'] = $_POST["Beguenstigter_P"];
            @$rechnungsdaten['Kostenart'] = $_POST["Kostenart_P"];
            @$rechnungsdaten['Faelligkeit'] = $_POST["Faelligkeit_P"];
            @$rechnungsdaten['Bemerkung'] = $_POST["Bemerkung_P"];
            @$rechnungsdaten['Reise'] = $_POST["Reise_P"];
            @$rechnungsdaten['bezahlt'] = $_POST["Bez_P"];

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

