<?php
include_once("classes/database.class.php");
include_once("classes/reise.class.php");
include_once("classes/teilnehmer.class.php");



$res = array();

$reiseID = $_POST['ReiseID'];
$teilnehmerID = $_POST['TeilnehmerID'];
$bezahlt = $_POST['Bezahlt'];


/** @var database $verbindung */
$verbindung = database::getDatabase();
$res["flag"] = true;
$valid = true;


    if(!$verbindung->existsTeilnehmer($teilnehmerID) || !$verbindung->existsReise($reiseID)) {
        $res["flag"] = false;
        $res["message"] = "Reise oder Teilnehmer existiert nicht.";
        $valid = false;
    }


    if (($verbindung->getAnzahlTeilnehmer($reiseID)) >= ($verbindung->getMaxAnzahlTeilnehmer($reiseID))) {
        $res["flag"] = false;
        $res["message"] = "Maximale Anzahl Teilnehmer wird überschritten.";
        $valid = false;
    }

    if ($verbindung->existingReservation($reiseID, $teilnehmerID)) {
        $res["flag"] = false;
        $res["message"] = "Reservation besteht bereits";
        $valid = false;
    }

   if($valid){
        $successful = $verbindung->insertReservation($reiseID, $teilnehmerID, $bezahlt);
        if ($successful) {
            $res["flag"] = true;
            $res["message"] = "Reservation erfolgreich gebucht";
        } else {
            $res["flag"] = false;
            $res["message"] = "DB-Transaktion nicht erfolgreich.";
        }
    }




echo json_encode($res);

