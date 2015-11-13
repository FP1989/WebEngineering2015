<?php
include("classes/database.class.php");
include("classes/reise.class.php");

// define variables and set to empty values
$destination_error = $description_error = $travelname_error = $price_error = $todate_error = $fromdate_error = "";
$destination =  $description = $travelname = $price= $todate =$fromdate="";
$valid = true;
$success_alert="";
$error_alert="";

function is_valid_date($enddatum) {
    @$enddatum_array = explode('.',$enddatum);
    @$tag=$enddatum_array[0];
    @$monat=$enddatum_array[1];
    @$jahr=$enddatum_array[2];
    if (is_numeric($tag) && is_numeric($monat) && is_numeric($jahr))
    {
        return checkdate($monat, $tag, $jahr); //returns true or false
    }
}

if(isset($_POST['gesendet'])) {
    if (empty($_POST['destination'])) {
        $destination_error = "Bitte ein Ziel eingeben";
        $valid="false";
    }
    if (empty($_POST['description'])) {
        $description_error = "Bitte eine Beschreibung eingeben";
        $valid="false";
    }
    if (empty($_POST['travelname'])) {
        $travelname_error = "Bitte eine Bezeichnung eingeben";
        $valid="false";
    }
    if (empty($_POST['price'])) {
        $price_error = "Bitte einen Preis eingeben";
        $valid="false";
    }
    if (empty($_POST['fromdate'])) {
        $fromdate_error = "Bitte ein Hinreisedatum eingeben";
        $valid="false";
    }else if (is_valid_date($_POST['fromdate'])==false) {
        $fromdate_error = "Bitte ein korrektes Datum Format eingeben [dd.mm.jjjj]";
        $valid = "false";
    }

    if (empty($_POST['todate'])) {
        $todate_error = "Bitte ein R&uuml;ckreisedatum eingeben";
        $valid="false";
    }else if (is_valid_date($_POST['todate'])==false) {
        $todate_error = "Bitte ein korrektes Datum Format eingeben [dd.mm.jjjj]";
        $valid = "false";
    }


    if ($valid) {
        $traveldata = array();
        $traveldata['Ziel']= $_POST['destination'];
        $traveldata['Beschreibung'] = $_POST['description'];
        $traveldata['Bezeichnung'] = $_POST['travelname'];
        $traveldata['Preis'] = $_POST['price'];
        $traveldata['Hinreise'] = $_POST['fromdate'];
        $traveldata['Rueckreise']= $_POST['todate'];


        $reise = reise::newReise($traveldata);

        //make insert-statement
        /** @var database $verbindung */
        $verbindung = database::getDatabase();
        $successful = $verbindung->insertReise($reise);

        //set all variables to default
        unset($_POST['destination']);
        unset($_POST['description']);
        unset($_POST['travelname']);
        unset($_POST['price']);
        unset($_POST['fromdate']);
        unset($_POST['fromdate']);
        unset($_POST['todate']);

        $success_alert= "<div class='alert alert-success' role='alert'>Neue Reise erfasst.</div>";

    }else{
        $error_alert = "<div class='alert alert-warning' role='alert'>Das Formular enthält Fehler/Unvollständigkeiten.</div>";
    }
}

?>


<form role="form" method="post" action="">
    <h2>Reise erfassen</h2> </br></br>
    <?php echo ($valid) ? $success_alert: $error_alert; ?>
    <div class="form-group">
        <label>Reise-ID</label>
        <input class="form-control" type="text" readonly>
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
        <input class="form-control" type="number" name="price" value="<?php echo @$_POST['price']?>">
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

    <div class="form-group pull-right">
        <button type="submit" name="gesendet" class="btn btn-primary">Reise erfassen</button>
        <button type="reset" class="btn btn-primary">Felder l&ouml;schen</button>
    </div>

</form>