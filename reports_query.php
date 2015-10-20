<?php

switch ($_SESSION['uniquery']) {

case "kreditoren":
break;
case "reiseteilnehmer":
$query = "SELECT R.ReiseID, R.Ziel, R.Hinreise, T.Vorname, T.Nachname, O.PLZ, O.Ortname FROM Teilnehmer T JOIN Reservation Re ON T.TeilnehmerID=Re.TeilnehmerID JOIN Reise R ON Re.ReiseID=R.ReiseID JOIN Ort O ON T.Ort=O.PLZ";
break;
case "offene_rechnungen":
$query = "SELECT T.Nachname, T.Vorname, R.Ziel, R.Hinreise FROM Teilnehmer T JOIN Reservation Re ON T.TeilnehmerID=Re.TeilnehmerID JOIN Reise R ON Re.ReiseID=R.ReiseID WHERE Re.bezahlt = 0";
break;
case "alle_kunden":
$query = "SELECT T.TeilnehmerID, T.Vorname, T.Nachname, T.Strasse, T.Hausnummer, O.PLZ, O.Ortname, T.Telefon, T.Mail FROM Teilnehmer T JOIN Ort O ON T.Ort= O.PLZ";
break;
case "alle_reisen":
$query = "SELECT R.ReiseID, R.Ziel, R.Beschreibung, R.Bezeichnung, R.Preis, R.Hinreise, R.Rueckreise FROM Reise R";
break;
case "ausstehende_reisen":
$query = "SELECT R.Ziel, R.Hinreise, T.Nachname, T.Vorname FROM Reise R JOIN Reservation Re ON R.ReiseID=Re.ReiseID JOIN Teilnehmer T ON Re.TeilnehmerID=T.TeilnehmerID WHERE R.Hinreise > CURDATE()";
break;
case "finanzuebersicht":
break;
case "reisegruppe":
break;
}