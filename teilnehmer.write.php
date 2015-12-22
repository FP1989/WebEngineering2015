<?php
include_once("classes/database.class.php");
include_once("classes/teilnehmer.class.php");
include("includes/authentication.inc.php");

// define variables and set to empty values
$surname_error = $lastname_error = $street_error = $housenumber_error = $plz_error = $town_error = $telefon_error = $email_error = "";
$surname =  $lastname = $street = $housenumber= $plz= $town = $telefon = $email ="";
$valid = true;
$success_alert="";
$error_alert="";

function format_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

if(isset($_POST["zuruecksetzen"])){

    unset($_POST['surname']);
    unset($_POST['lastname']);
    unset($_POST['street']);
    unset($_POST['housenumber']);
    unset($_POST['plz']);
    unset($_POST['town']);
    unset($_POST['telefon']);
    unset($_POST['email']);

}

if(isset($_POST['gesendet'])) {
    if (empty(format_input($_POST['surname']))) {
        $surname_error = "Bitte einen Vornamen eingeben";
        $valid=false;
    }else if (!preg_match("/^[a-zA-ZäöüÄÖÜéèàÉÈÀç \-]*$/",format_input($_POST['surname']))) {
        $surname_error = $surname_error . "Nur Buchstaben und Leerzeichen erlaubt.";
        $valid = false;
    }
    if (empty(format_input($_POST['lastname']))) {
        $lastname_error = "Bitte einen Nachname eingeben";
        $valid=false;
    }else if (!preg_match("/^[a-zA-ZäöüÄÖÜéèàÉÈÀç \-]*$/",format_input($_POST['lastname']))) {
        $lastname_error = $lastname_error . "Nur Buchstaben und Leerzeichen erlaubt.";
        $valid = false;
    }

    if (empty(format_input($_POST['street']))) {
        $street_error = "Bitte eine Strasse eingeben";
        $valid=false;
    }elseif(!preg_match("/^[a-zA-ZäöüÄÖÜéèàÉÈÀç ]*$/",format_input($_POST['street']))) {
        $street_error = "Bitte eine korrekte Strasse eingeben";
        $valid=false;
    }

    if (empty(format_input($_POST['plz']))) {
        $plz_error = "Bitte eine PLZ eingeben";
        $valid=false;
    }else if(!(is_numeric(format_input($_POST['plz'])))){
        $plz_error = $plz_error . "Bitte nur Zahlen als Eingabe.";
        $valid = false;
    }
    if (empty(format_input($_POST['town']))) {
        $town_error = "Bitte eine Stadt eingeben";
        $valid=false;
    }elseif(!preg_match("/^[a-zA-ZäöüÄÖÜéèàÉÈÀç \-]*$/",($_POST['town']))) {
        $town_error = "Bitte eine Stadt eingeben";
        $valid=false;
    }
    if (empty(format_input($_POST['telefon']))) {
        $telefon_error = "Bitte eine Telefon-Nr. eingeben";
        $valid=false;
    }else if(format_input($_POST['telefon'])>999999999999) {
        $telefon_error = "Bitte eine korrekte Telefon-Nr. eingeben";
        $valid=false;
    }
    if (empty(format_input($_POST['email']))) {
        $email_error = "Bitte eine E-Mail-Adresse eingeben";
        $valid=false;
    }if (filter_var(format_input($_POST['email']), FILTER_VALIDATE_EMAIL) === false) {
        $email_error = $email_error . "Bitte eine korrekte E-Mail-Adresse eingeben";
        $valid=false;
    }
    if ($valid) {
        $participantData = array();
        $participantData['Vorname'] = format_input($_POST['surname']);
        $participantData['Nachname']= format_input($_POST['lastname']);
        $participantData['Strasse']= format_input($_POST['street']);
        $participantData['Hausnummer']= format_input($_POST['housenumber']);
        $participantData['PLZ']= format_input($_POST['plz']);
        $participantData['Ort']= format_input($_POST['town']);
        $participantData['Telefon']= format_input($_POST['telefon']);
        $participantData['Mail']= format_input($_POST['email']);

        $participant = teilnehmer::newTeilnehmer($participantData);

        //make insert-statement
        /** @var database $verbindung */
        $verbindung = database::getDatabase();
        $command = $verbindung->insertTeilnehmner($participant);

        if($command){
            unset($_POST['surname']);
            unset($_POST['lastname']);
            unset($_POST['street']);
            unset($_POST['housenumber']);
            unset($_POST['plz']);
            unset($_POST['town']);
            unset($_POST['telefon']);
            unset($_POST['email']);
            $success_alert= "<div class='alert alert-success' role='alert'>Neuen Teilnehmer erfasst.</div>";
        }else{
            $error_alert = "<div class='alert alert-warning' role='alert'>Datenbank-Befehl fehlgeschlagen.</div>";
        }

    }else{
        $error_alert = "<div class='alert alert-warning' role='alert'>Das Formular enthält Fehler/Unvollständigkeiten.</div>";
    }

}


?>

<form role="form" method="post" action="">
    <h2>Teilnehmer erfassen</h2><br><br>
    <?php echo (!empty($valid)) ? $success_alert: $error_alert; ?>
    <div class="form-group">
        <label>Teilnehmer-ID</label>
        <input class="form-control" type="text" <?php
        /** @var database $database*/
        $database = database::getDatabase();
        $result = $database->getID('TeilnehmerID', 'Teilnehmer');

        while ($row = mysqli_fetch_assoc($result)){
            settype($row['id'], "int");
            $id = $row['id'] +1;
            echo "value=".$id;
        }
        ?> readonly>
    </div>

    <div class="form-group <?php echo (!empty($surname_error)) ? 'has-error':''; ?>">
        <label>Vorname</label>
        <input class="form-control" name="surname" type="text" value="<?php echo @$_POST['surname'];?>">
        <?php echo "<span class='help-block'>$surname_error</span>";?>
    </div>

    <div class="form-group <?php echo (!empty($lastname_error)) ? 'has-error':''; ?>">
        <label>Nachname</label>
        <input class="form-control" name="lastname" type="text" value="<?php echo @$_POST['lastname'];?>">
        <?php echo "<span class='help-block'>$lastname_error</span>";?>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-8 <?php echo (!empty($street_error)) ? 'has-error':''; ?>">
                <label>Strasse</label>
                <input class="form-control" name="street" type="text" value="<?php echo @$_POST['street'];?>">
                <?php echo "<span class='help-block'>$street_error</span>";?>
            </div>
            <div class="col-md-4 <?php echo (!empty($housenumber_error)) ? 'has-error':''; ?>">
                <label>Hausnummer</label>
                <input class="form-control" name="housenumber" type="text" value="<?php echo @$_POST['housenumber'];?>">
                <?php echo "<span class='help-block'>$housenumber_error</span>";?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-4 <?php echo (!empty($plz_error)) ? 'has-error':''; ?>">
                <label>PLZ</label>
                <input class="form-control" name="plz" type="text" value="<?php echo @$_POST['plz'];?>">
                <?php echo "<span class='help-block'>$plz_error</span>";?>
            </div>
            <div class="col-md-8 <?php echo (!empty($town_error)) ? 'has-error':''; ?>">
                <label>Ort</label>
                <input class="form-control" name="town" type="text" value="<?php echo @$_POST['town'];?>">
                <?php echo "<span class='help-block'>$town_error</span>";?>
            </div>
        </div>
    </div>


    <div class="form-group <?php echo (!empty($telefon_error)) ? 'has-error':''; ?>">
        <label>Telefon Nr.</label>
        <input class="form-control" name="telefon" type="number" value="<?php echo @$_POST['telefon'];?>">
        <?php echo "<span class='help-block'>$telefon_error</span>";?>
    </div>

    <div class="form-group <?php echo (!empty($email_error)) ? 'has-error':''; ?>">
        <label>E-Mail Adresse</label>
        <input class="form-control" name="email" type="text" value="<?php echo @$_POST['email'];?>">
        <?php echo "<span class='help-block'>$email_error</span>";?>
    </div>

    <div class="form-group pull-right">
        <button type="submit" name="gesendet" class="btn btn-primary">Teilnehmer erfassen</button>
        <button type="submit" name="zuruecksetzen" class="btn btn-primary">Felder l&ouml;schen</button>
    </div>
</form>
