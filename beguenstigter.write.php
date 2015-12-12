<?php
ini_set('display_errors', E_ALL);
include_once("classes/database.class.php");
include_once("classes/beguenstigter.class.php");
if(isset($_POST['gesendet'])) {
    $recipientData = array();
    @$recipientData['BeguenstigterName'] = $_POST['Name'];
    @$recipientData['Strasse'] = $_POST['Strasse'];
    @$recipientData['Hausnummer'] = $_POST['Hausnummer'];
    @$recipientData['PLZ'] = $_POST['PLZ'];
    @$recipientData['Ort'] = $_POST['Ort'];
    $recipient = beguenstigter::newBeguenstigter($recipientData);

    /** @var database $verbindung */
    $verbindung = database::getDatabase();
    $successful = $verbindung->insertBeguenstigter($recipient);

}


?>

<form method="post" action="">
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="Name" id="name" class="form-control" />
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-8">
                <label>Strasse</label>
                <input type="text" name="Strasse" id="strasse" class="form-control"/>
            </div>
            <div class="col-md-4">
                <label>Hausnummer</label>
                <input type="text" name="Hausnummer" id="hausnummer" class="form-control"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-8">
                <label>PLZ</label>
                <input type="number" name="PLZ" id="plz" class="form-control"/>
            </div>
            <div class="col-md-4">
                <label>Ort</label>
                <input type="text" name="Ort" id="ort" class="form-control"/>
            </div>
        </div>
    </div>
    <div class="form-group pull-right">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
        <button type="submit" name ="gesendet" id="send" class="btn btn-primary">Neuen Beg&uuml;nstigten anlegen</button>
    </div>
</form>