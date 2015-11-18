<?php
include_once("classes/database.class.php");
include_once("classes/teilnehmer.class.php");
// define variables and set to empty values
$surname_error = $lastname_error = $street_error = $housenumber_error = $plz_error = $town_error = $telefon_error = $email_error = "";
$surname =  $lastname = $street = $housenumber= $plz= $town = $telefon = $email ="";
$valid = true;
$success_alert="";
$error_alert="";

if(isset($_POST['gesendet'])) {
    if (empty($_POST['surname'])) {
        $surname_error = "Bitte einen Vornamen eingeben";
        $valid="false";
    }
    if (empty($_POST['lastname'])) {
        $lastname_error = "Bitte einen Nachname eingeben";
        $valid="false";
    }
    if (empty($_POST['street'])) {
        $street_error = "Bitte eine Strasse eingeben";
        $valid="false";
    }
    if (empty($_POST['housenumber'])) {
        $housenumber_error = "Bitte eine Strasse eingeben";
        $valid="false";
    }
    if (empty($_POST['plz'])) {
        $plz_error = "Bitte eine PLZ eingeben";
        $valid="false";
    }
    if (empty($_POST['town'])) {
        $town_error = "Bitte eine Stadt eingeben";
        $valid="false";
    }
    if (empty($_POST['telefon'])) {
        $telefon_error = "Bitte eine Strasse eingeben";
        $valid="false";
    }
    if (empty($_POST['email'])) {
        $email_error = "Bitte eine E-Mail Adresse eingeben";
        $valid="false";
    }
    if ($valid) {
        $participantData = array();
        $participantData['Vorname'] = $_POST['surname'];
        $participantData['Nachname']= $_POST['lastname'];
        $participantData['Strasse']= $_POST['street'];
        $participantData['Hausnummer']= $_POST['housenumber'];
        $participantData['PLZ']= $_POST['plz'];
        $participantData['Ort']= $_POST['town'];
        $participantData['Telefon']= $_POST['telefon'];
        $participantData['Mail']= $_POST['email'];

        $participant = teilnehmer::newTeilnehmer($participantData);

        //make insert-statement
        /** @var database $verbindung */
        $verbindung = database::getDatabase();
        $successful = $verbindung->insertTeilnehmner($participant);

        $success_alert= "<div class='alert alert-success' role='alert'>Neuen Teilnehmer erfasst.</div>";
    }else{
        $error_alert = "<div class='alert alert-warning' role='alert'>Das Formular enthält Fehler/Unvollständigkeiten.</div>";
    }

}


?>

<form role="form" method="post" action="">
    <h2>Teilnehmer erfassen</h2><br><br>

    <div class="form-group">
        <label>Teilnehmer-ID</label>
        <input class="form-control" type="text" readonly>
    </div>

    <div class="form-group <?php echo (!empty($surname_error)) ? 'has-error':''; ?>">
        <label>Vorname</label>
        <input class="form-control" name="surname" type="text">
        <?php echo "<span class='help-block'>$surname_error</span>";?>
    </div>

    <div class="form-group <?php echo (!empty($lastname_error)) ? 'has-error':''; ?>">
        <label>Nachname</label>
        <input class="form-control" name="lastname" type="text">
        <?php echo "<span class='help-block'>$lastname_error</span>";?>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-8 <?php echo (!empty($street_error)) ? 'has-error':''; ?>">
                <label>Strasse</label>
                <input class="form-control" name="street" type="text">
                <?php echo "<span class='help-block'>$street_error</span>";?>
            </div>
            <div class="col-md-4 <?php echo (!empty($housenumber_error)) ? 'has-error':''; ?>">
                <label>Hausnummer</label>
                <input class="form-control" name="housenumber" type="number">
                <?php echo "<span class='help-block'>$housenumber_error</span>";?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-4 <?php echo (!empty($plz_error)) ? 'has-error':''; ?>">
                <label>PLZ</label>
                <input class="form-control" name="plz" type="text">
                <?php echo "<span class='help-block'>$plz_error</span>";?>
            </div>
            <div class="col-md-8 <?php echo (!empty($town_error)) ? 'has-error':''; ?>">
                <label>Ort</label>
                <input class="form-control" name="town" type="text">
                <?php echo "<span class='help-block'>$town_error</span>";?>
            </div>
        </div>
    </div>


    <div class="form-group <?php echo (!empty($telefon_error)) ? 'has-error':''; ?>">
        <label>Telefon Nr.</label>
        <input class="form-control" name="telefon" type="number">
        <?php echo "<span class='help-block'>$telefon_error</span>";?>
    </div>

    <div class="form-group <?php echo (!empty($email_error)) ? 'has-error':''; ?>">
        <label>E-Mail Adresse</label>
        <input class="form-control" name="email" type="text">
        <?php echo "<span class='help-block'>$email_error</span>";?>
    </div>

    <div class="form-group pull-right">
        <button type="submit" name="gesendet" class="btn btn-primary">Teilnehmer erfassen</button>
        <button type="reset" class="btn btn-primary">Felder l&ouml;schen</button>
    </div>
</form>
