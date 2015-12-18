<?php
include_once("classes/database.class.php");
include_once("classes/reise.class.php");

// define variables and set to empty values
$destination_error = $description_error = $travelname_error = $price_error =
$todate_error = $fromdate_error =$maxParticipant_error=$minParticipant_error= "";
$destination =  $description = $travelname = $price= $todate =$fromdate=$minParticipant=$maxParticipant="";
$valid = true;
$success_alert="";
$error_alert="";
$today = strtotime(date("d.m.Y"));

function is_valid_date($enddatum) {
    @$enddatum_array = explode('.',$enddatum);
    @$tag=$enddatum_array[0];
    @$monat=$enddatum_array[1];
    @$jahr=$enddatum_array[2];
    if (is_numeric($tag) && is_numeric($monat) && is_numeric($jahr))
    {
        return checkdate($monat, $tag, $jahr); //returns true or false
    }

    else return false;
}
function format_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

if(isset($_POST["zuruecksetzen"])){

    unset($_POST['destination']);
    unset($_POST['description']);
    unset($_POST['travelname']);
    unset($_POST['price']);
    unset($_POST['fromdate']);
    unset($_POST['fromdate']);
    unset($_POST['todate']);
    unset($_POST["minParticipant"]);
    unset($_POST["maxParticipant"]);

}

if(isset($_POST['gesendet'])) {
    if (empty(format_input($_POST['destination']))) {
        $destination_error = "Bitte ein Ziel eingeben";
        $valid=false;
    }else if (!preg_match("/^[a-zA-Z ]*$/",format_input($_POST['destination']))) {
        $destination_error = $destination_error . "Nur Buchstaben und Leerzeichen erlaubt.";
        $valid = false;
    }
    if (empty(format_input($_POST['description']))) {
        $description_error = "Bitte eine Beschreibung eingeben";
        $valid=false;
    }
    if (empty(format_input($_POST['travelname']))) {
        $travelname_error = "Bitte eine Bezeichnung eingeben";
        $valid=false;
    }
    if (empty(format_input($_POST['price']))) {
        $price_error = "Bitte einen Preis eingeben";
        $valid=false;
    }else if(!(is_numeric(format_input($_POST['price'])))){
        $price_error = $price_error . "Bitte nur Zahlen als Eingabe.";
        $valid = false;
    }
    if (empty(format_input($_POST['fromdate']))) {
        $fromdate_error = "Bitte ein Hinreisedatum eingeben";
        $valid=false;
    }else if (is_valid_date(format_input($_POST['fromdate']))==false) {
        $fromdate_error = $fromdate_error. "Bitte ein korrektes Datum Format eingeben [dd.mm.jjjj]";
        $valid=false;
    }else if(strtotime(format_input($_POST['fromdate'])) < $today){
        $fromdate_error = $fromdate_error. "Das Datum muss gr&ouml;sser oder gleich sein dem heutigen Datum.";
        $valid=false;
    }else if(strtotime(format_input($_POST['fromdate'])) > strtotime(format_input($_POST['todate']))){
        $fromdate_error = $fromdate_error. "Das Hinreisedatum muss kleiner sein als das R&uml;ckreisedatum.";
        $valid=false;
    }

    if (empty(format_input($_POST['todate']))) {
        $todate_error = "Bitte ein R&uuml;ckreisedatum eingeben";
        $valid=false;
    }else if (is_valid_date(format_input($_POST['todate']))==false) {
        $todate_error = $todate_error . "Bitte ein korrektes Datum Format eingeben [dd.mm.jjjj]";
        $valid=false;
    }else if (strtotime(format_input($_POST['todate'])) < $today) {
        $todate_error = $todate_error . "Das Datum muss gr&ouml;sser sein als das heutige Datum.";
        $valid=false;
    }

    if (empty(format_input($_POST['minParticipant']))) {
        $minParticipant_error = "Bitte einen Mindestanzahl Teilnehmer eingeben.";
        $valid = false;
    }else if(!(is_numeric(format_input($_POST['minParticipant'])))){
        $minParticipant_error = $minParticipant_error . "Bitte nur Zahlen als Eingabe.";
        $valid = false;
    }else if(format_input($_POST['minParticipant']) < 12){
        $minParticipant_error = $minParticipant_error. "Mindestanzahl Teilnehmer kleiner als zul&auml;ssiger Wert.";
        $valid = false;
    }else if(format_input($_POST['minParticipant']) > 20){
        $minParticipant_error = $minParticipant_error. "Mindestanzahl Teilnehmer gr&uml;sser als zul&auml;ssiger Wert.";
        $valid = false;
    }

    if (empty(format_input($_POST['maxParticipant']))) {
        $maxParticipant_error = "Bitte einen Maximalanzahl Teilnehmer eingeben.";
        $valid = false;
    }else if(!(is_numeric(format_input($_POST['maxParticipant'])))){
        $maxParticipant_error = $maxParticipant_error . "Bitte nur Zahlen als Eingabe.";
        $valid = false;
    }else if(format_input($_POST['maxParticipant']) > 20){
        $maxParticipant_error = $maxParticipant_error . "Maximalanzahl gr&ouml;sser als zul&auml;ssiger Wert.";
        $valid = false;
    }else if(format_input($_POST['maxParticipant']) < 12){
        $maxParticipant_error = $maxParticipant_error . "Maximalanzahl darf nicht kleiner als Mindestanzahl sein.";
        $valid = false;
    }

    if ($valid) {
        $traveldata = array();
        $traveldata['Ziel']= format_input($_POST['destination']);
        $traveldata['Beschreibung'] = format_input($_POST['description']);
        $traveldata['Bezeichnung'] = format_input($_POST['travelname']);
        $traveldata['Preis'] = format_input($_POST['price']);
        @$enddatum_array = explode('.', format_input($_POST['fromdate']));
        @$tag = $enddatum_array[0];
        @$monat = $enddatum_array[1];
        @$jahr = $enddatum_array[2];
        $newDate = $jahr . "-" . $monat . "-" . $tag;
        $traveldata['Hinreise'] = $newDate;
        @$datum_array = explode('.', format_input($_POST['todate']));
        @$tag = $datum_array[0];
        @$monat = $datum_array[1];
        @$jahr = $datum_array[2];
        $NeuesDatum = $jahr . "-" . $monat . "-" . $tag;
        $traveldata['Rueckreise'] = $NeuesDatum;
        $traveldata['MinAnzahl'] = format_input($_POST['minParticipant']);
        $traveldata['MaxAnzahl'] = format_input($_POST['maxParticipant']);
        $reise = reise::newReise($traveldata);

        //make insert-statement
        /** @var database $verbindung */
        $verbindung = database::getDatabase();
        $command = $verbindung->insertReise($reise);

        if($command){
        unset($_POST['destination']);
        unset($_POST['description']);
        unset($_POST['travelname']);
        unset($_POST['price']);
        unset($_POST['fromdate']);
        unset($_POST['fromdate']);
        unset($_POST['todate']);
        unset($_POST["minParticipant"]);
        unset($_POST["maxParticipant"]);
        $success_alert = "<div class='alert alert-success' role='alert'>Neue Reise erfasst.</div>";
        }else{
            $error_alert = "<div class='alert alert-warning' role='alert'>Datenbank-Befehl fehlgeschlagen.</div>";
        }

    }else{
        $error_alert = "<div class='alert alert-warning' role='alert'>Das Formular enthält Fehler/Unvollständigkeiten.</div>";
    }

}

?>


<form role="form" method="post" action="">
    <h2>Reise erfassen</h2> </br></br>
    <?php echo (!empty($valid)) ? $success_alert: $error_alert; ?>
    <div class="form-group">
        <label>Reise-ID</label>
        <input class="form-control" type="text" <?php
        /** @var database $database*/
        $database = database::getDatabase();
        $result = $database->getID('ReiseID', 'Reise');

        while ($row = mysqli_fetch_assoc($result)){
            settype($row['id'], "int");
            $id = $row['id'] +1;
            echo "value=".$id;
        }
        ?> readonly>
    </div>

    <div class="form-group <?php echo (!empty($destination_error)) ? 'has-error':''; ?>">
        <label>Ziel</label>
        <input class="form-control" name="destination" value="<?php echo @$_POST['destination'];?>" type="text">
        <?php echo "<span class='help-block'>$destination_error</span>";?>
    </div>

    <div class="form-group <?php echo (!empty($description_error)) ? 'has-error':''; ?>">
        <label>Beschreibung</label>
        <textarea class="form-control" name="description" rows="3"><?php echo @$_POST['description']?></textarea>
        <?php echo "<span class='help-block'>$description_error</span>";?>
    </div>

    <div class="form-group <?php echo (!empty($travelname_error)) ? 'has-error':''; ?>">
        <label>Bezeichnung</label>
        <input class="form-control" name="travelname" value="<?php echo @$_POST['travelname']?>" type="text">
        <?php echo "<span class='help-block'>$travelname_error</span>";?>
    </div>

    <div class="form-group <?php echo (!empty($price_error)) ? 'has-error':''; ?>">
        <label>Preis</label>
        <input class="form-control" type="number" step="any" name="price" value="<?php echo @$_POST['price']?>">
        <?php echo "<span class='help-block'>$price_error</span>";?>
    </div>

    <div class="form-group <?php echo (!empty($fromdate_error)) ? 'has-error':''; ?>">
        <label>Hinreise</label>
        <div class="input-group date">
            <input type='text' class="form-control" name="fromdate" value="<?php echo @$_POST['fromdate']?>" id="hinreise"/>
            <?php echo "<span class='help-block'>$fromdate_error</span>";?>
            <span class="input-group-addon">
                                     <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
        </div>
    </div>

    <div class="form-group <?php echo (!empty($todate_error)) ? 'has-error':''; ?>">
        <label>R&uuml;ckreise</label>
        <div class="input-group date">
            <input type='text' class="form-control" name="todate" value="<?php echo @$_POST['todate']?>" id="rueckreise"/>
            <?php echo "<span class='help-block'>$todate_error</span>";?>
            <span class="input-group-addon">
                                     <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-6 <?php echo (!empty($minParticipant_error)) ? 'has-error':''; ?>">
                <label>Min. Teilnehmeranzahl</label>
                <input type="number" name="minParticipant" value="<?php echo @$_POST['minParticipant'];?>" class="form-control"/>
                <?php echo "<span class='help-block'>$minParticipant_error</span>";?>
            </div>
            <div class="col-md-6 <?php echo (!empty($maxParticipant_error)) ? 'has-error':''; ?>">
                <label>Max. Teilnehmeranzahl</label>
                <input type="number" name="maxParticipant" value="<?php echo @$_POST['maxParticipant'];?>" class="form-control"/>
                <?php echo "<span class='help-block'>$maxParticipant_error</span>";?>
            </div>
        </div>
    </div>

    <div class="form-group pull-right">
        <button type="submit" name="gesendet" class="btn btn-primary">Reise erfassen</button>
        <button type="submit" name="zuruecksetzen" class="btn btn-primary">Felder l&ouml;schen</button>
    </div>

</form>