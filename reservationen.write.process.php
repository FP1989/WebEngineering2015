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


if(($verbindung->existsTeilnehmer($teilnehmerID) == true) && ($verbindung->existsReise($reiseID)==true)) {
    if ($verbindung->getAnzahlTeilnehmer($reiseID) < $verbindung->getMaxAnzahlTeilnehmer($reiseID)) {
        if ($verbindung->existingReservation($reiseID, $teilnehmerID)) {
            $res["flag"] = false;
            $res["message"] = "Reservation besteht bereits";
        } else {
            $successful = $verbindung->insertReservation($reiseID, $teilnehmerID, $bezahlt);
            if ($successful) {
                $res["flag"] = true;
                $res["message"] = "Reservation erfolgreich gebucht";
            } else {
                $res["flag"] = false;
                $res["message"] = "DB-Transaktion nicht erfolgreich.";
            }
        }

    } else {
        $res["flag"] = false;
        $res["message"] = "Maximale Anzahl Teilnehmer wird überschritten.";
    }
}else{
    $res["flag"] = false;
    $res["message"] = "Reise/Teilnehmer existiert nicht.";
}

echo json_encode($res);

