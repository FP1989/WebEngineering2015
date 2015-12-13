<?php include("includes/authentication.inc.php");?>
    <!doctype html>
    <html lang="de">
    <head>
        <?php
        $pagetitle = "Home";
        include_once("includes/header.inc.php");
        ?>

    </head>
<body>
<div id="wrapper">
    <?php

    include_once("includes/navigation.inc.php");
    include_once("classes/database.class.php");
    include_once("passwort_modal.php");

    $bezahlt = $reiseid_error = $teilnehmerid_error = $bezahlt_error = $success_alert = $error_alert = "";
    $valid = true;

    if(isset($_POST['gesendet'])) {
        if(empty($_POST['teilnehmerid'])) {
            $teilnehmerid_error = "Bitte Teilnehmer ID eingeben";
            $valid = false;
        }
        if(empty($_POST['reiseid'])) {
            $reiseid_error = "Bitte Reise ID eingeben";
            $valid = false;
        }
        if(empty($_POST['bezahlt'])) {
            $bezahlt_error = "Bitte 'Y' oder 'N' angeben";
            $valid = false;
        }elseif(!preg_match("/[YNyn]/", $_POST['bezahlt'])) {
            $bezahlt_error = "Bitte nur 'Y' oder 'N' angeben";
            $valid = false;
        }elseif(strlen($_POST['bezahlt']) > 1) {
            $bezahlt_error = "Bitte nur 'Y' oder 'N' angeben";
            $valid = false;
        }
        if($_POST['bezahlt'] == 'Y') $bezahlt = 1;
        else $bezahlt = 0;

        if($valid) {
            /* @var database $verbindung */
            $verbindung = database::getDatabase();
            $successful = $verbindung->insertReservation($_POST['reiseid'], $_POST['teilnehmerid'], $bezahlt);

            $success_alert = "<div class='alert alert-success pull-right' role='alert'>Teilnehmer erfolgreich zugewiesen.</div>";
        }
        else $error_alert = "<div class='alert alert-warning pull-right' role='alert'>Das Formular enthält Fehler/Unvollständigkeiten.</div>";
    }
    ?>
    <div id="content" class="container">

        <div class="jumbotron col-md-8" id="margingiver">
            <h2>Herzlich willkommen zum Online-Planungstool der Star Reisen AG!</h2>
            <p>Verwenden Sie die Navigation um Rechnungen, Reisen, Reservationen oder Teilnehmer einzusehen oder zu mutieren. Zusätzlich können Sie sich unter 'Reports' vorgefertigte Berichte ausstellen lassen.</p>
            <p>Auf dieser Seite finden Sie aktuelle Daten zu anstehenden Reisen sowie fällige Rechnungen. Weiter können Sie mit dem Schnellzugriff rechts Kunden entsprechenden Reisen zuweisen.</p>
            <a href="" id="passreset" name="passreset" data-toggle="modal" data-target="#passresetmodal">Klicken Sie hier, um Ihr Zugangspasswort zu ändern.</a>
        </div>

        <div class="jumbotron col-md-3 pull-right">
            <?php echo (!empty($success_alert)) ? $success_alert:''; ?>

            <form action="" method="post" name="schnellzugriff">
                <div class="form-group <?php echo (!empty($teilnehmerid_error)) ? 'has-error':''; ?>">
                    <label for="teilnehmerid">Teilnehmer ID</label>
                    <input type="number" id="teilnehmerid" name="teilnehmerid" class="form-control"/>
                    <?php echo "<span class='help-block'>$teilnehmerid_error</span>";?><br>
                </div>
                <div class="form-group <?php echo (!empty($reiseid_error)) ? 'has-error':''; ?>">
                    <label for="reiseid">Reise ID</label>
                    <input type="number" id="reiseid" name="reiseid" class="form-control"/>
                    <?php echo "<span class='help-block'>$reiseid_error</span>";?><br>
                </div>
                <div class="form-group <?php echo (!empty($bezahlt_error)) ? 'has-error':''; ?>">
                    <label for="bezahlt">Bezahlt? Y/N</label>
                    <input type="text" id="bezahlt" name="bezahlt" class="form-control"/>
                    <?php echo "<span class='help-block'>$bezahlt_error</span>";?><br>
                </div>
                <div class="form-group">
                    <input type="submit" name="gesendet" class="btn btn-primary pull-right" value="Hinzuf&uuml;gen"/><br>
                </div>
            </form>
        </div>

        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">Reisen demnächst</div>
                <div class="panel-body">

                    <?php
                    /* @var database $database */
                    $database = database::getDatabase();
                    $result = $database->getNextReisen();

                    echo "<table>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        foreach($row as $value) {
                            if (preg_match('/[0-9]+[-]+/', $value)) {
                                $date = date("d-m-Y", strtotime($value));
                                echo "<td><b>" . $date . "</b></td>";
                            }
                            else echo "<td>" . $value . "<td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">Fällige Rechnungen</div>
                <div class="panel-body">
                    <?php
                    /* @var database $database */
                    $database = database::getDatabase();
                    $result = $database->getNextRechnungen();

                    echo "<table>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        foreach($row as $value) {
                            if (preg_match('/[0-9]+[-]+/', $value)) {
                                $date = date("d-m-Y", strtotime($value));
                                echo "<td><b>" . $date . "</b></td>";
                            }
                            else echo "<td>" . $value . "<td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include ("includes/footer.inc.php");