<?php
include_once("classes/database.class.php");
include_once("classes/beguenstigter.class.php");



$recipientData = array();
$res = array();
if(isset($_POST['type']))
{
    if($_POST['type'] =="claim") {

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
            $res["message"] = "Data Inserted Successfully";
        } else {
            $res["flag"] = false;
            $res["message"] = "Oppes Errors";
        }


    }
}
else{
    $res["flag"] = false;
    $res["message"] = "Invalid format";
}

echo json_encode($res);


?>
