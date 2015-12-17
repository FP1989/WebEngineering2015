<?php
ini_set('display_errors', E_ALL);
include_once("classes/database.class.php");
include_once("classes/beguenstigter.class.php");

$recipientData = array();
$success_alert = "";
$error_alert = "";
$valid = true;
$id = $name = $strasse = $hausnummer = $plz = $ort = "";
$id_err = $name_err = $strasse_err = $hausnummer_err = $plz_err = $ort_err = "";

if(isset($_POST['gesendet'])) {

    if (isset($_POST["BeguenstigterID_R"])) @$recipientData["BeguenstigterID"] = $_POST["BeguenstigterID_R"];
    @$recipientData['BeguenstigterName'] = $_POST['Name'];
    @$recipientData['Strasse'] = $_POST['Strasse'];
    @$recipientData['Hausnummer'] = $_POST['Hausnummer'];
    @$recipientData['PLZ'] = $_POST['PLZ'];
    @$recipientData['Ort'] = $_POST['Ort'];
    $recipient = beguenstigter::newBeguenstigter($recipientData);

    if (empty($_POST['Name'])) {
        $name_err = "Bitte einen <strong>Namen</strong> eingeben.";
        $valid = false;
    }
    if (empty($_POST['Strasse'])) {
        $strasse_err = "Bitte eine <strong>Strasse</strong> eingeben.";
        $valid = false;
    } else if (is_numeric($_POST['Strasse'])) {
        $strasse_err = $strasse_err . "Bitte eine korrekte<strong>Strasse</strong> eingeben.";
        $valid = false;
    }
    if (empty($_POST['Hausnummer'])) {
        $hausnummer_err = "Bitte eine <strong>Hausnummer</strong> eingeben.";
        $valid = false;
    }
    if (empty($_POST['PLZ'])) {
        $plz_err = "Bitte eine <strong>Postleitzahl</strong> eingeben.";
        $valid = false;
    } else if (!(is_numeric($_POST['PLZ']))) {
        $plz_err = $plz_err . " Beim Feld PLZ sind nur Zahlen sind erlaubt";
        $valid = false;
    }
    if (empty($_POST['Ort'])) {
        $ort_err = "Bitte einen <strong>Ort</strong> eingeben.";
        $valid = false;
    } else if (is_numeric($_POST['Ort'])) {
        $ort_err = $ort_err . " Beim Feld Ort sind nur Buchstaben erlaubt.";
        $valid = false;
    }

    if ($valid) {
        /** @var database $verbindung */
        $verbindung = database::getDatabase();
        $successful = $verbindung->insertBeguenstigter($recipient);

        if ($successful) {
            $success_alert = "<div class='alert alert-success' role='alert'>Neuen Beguenstigten erfasst.</div>";
        } else {
            $error_alert = "<div class='alert alert-warning' role='alert'>Datenbank-Befehl fehlgeschlagen.</div>";
        }
    }

}
    else{
        $error_alert = "<div class='alert alert-warning' role='alert'>Das Formular enthält Fehler/Unvollständigkeiten.</div>";
    }


?>

<form method="post" action="">
    <h2>Beg&uuml;nstigten erfassen</h2> </br></br>
    <?php echo (!empty($valid)) ? $success_alert: $error_alert; ?>
    <div class="form-group <?php echo (!empty($name_err)) ? 'has-error':''; ?>">
        <label>Name</label>
        <input type="text" name="Name" id="name" value="<?php echo @$_POST['Name'];?>" class="form-control" />
        <?php echo "<div><p class='help-block'>$name_err</p></div>";?>
    </div>
    <div class="form-group ">
        <div class="row">
            <div class="col-md-8 <?php echo (!empty($strasse_err)) ? 'has-error':''; ?>">
                <label>Strasse</label>
                <input type="text" name="Strasse" id="strasse" value="<?php echo @$_POST['Strasse'];?>" class="form-control"/>
                <?php echo "<div><p class='help-block'>$strasse_err</p></div>";?>
            </div>
            <div class="col-md-4 <?php echo (!empty($hausnummer_err)) ? 'has-error':''; ?>">
                <label>Hausnummer</label>
                <input type="text" name="Hausnummer" id="hausnummer" value="<?php echo @$_POST['Hausnummer'];?>" class="form-control"/>
                <?php echo "<div><p class='help-block'>$hausnummer_err</p></div>";?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-8 <?php echo (!empty($plz_err)) ? 'has-error':''; ?>">
                <label>PLZ</label>
                <input type="number" name="PLZ" id="plz" value="<?php echo @$_POST['PLZ'];?>" class="form-control"/>
                <?php echo "<div><p class='help-block'>$plz_err</p></div>";?>
            </div>
            <div class="col-md-4 <?php echo (!empty($ort_err)) ? 'has-error':''; ?>">
                <label>Ort</label>
                <input type="text" name="Ort" id="ort" value="<?php echo @$_POST['Ort'];?>" class="form-control"/>
                <?php echo "<div><p class='help-block'>$ort_err</p></div>";?>
            </div>
        </div>
    </div>
    <div class="form-group pull-right">
        <button type="submit" name ="gesendet" id="send" class="btn btn-primary">Neuen Beg&uuml;nstigten anlegen</button>
        <button type="reset" class="btn btn-default" data-dismiss="modal">Felder l&ouml;schen</button>
    </div>
</form>