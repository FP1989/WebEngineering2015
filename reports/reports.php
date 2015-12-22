<?php include("../includes/authentication.inc.php");

//Executed first to avoid any information sent by client, which prevents FPDF from creating PDF
if(isset($_POST['pdfbutton'])) {
    $_SESSION['type'] = $_POST['type'];
    $_SESSION['option'] = $_POST['option'];
    header("Location:print_pdf.php");
};?>
    <!doctype html>
    <html lang="de">
    <head>
        <?php
        $pagetitle = "Reports";
        include_once("../includes/header.inc.php");
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#selectlistreports').change(function() {
                    if($(this).val() == 'Reiseteilnehmer') {
                        $('#reisenhidden1').css("display", "inline");
                        return false;
                    } else {
                        $('#reisenhidden1').css("display", "none");
                    }
                });
            });
            $(document).ready(function() {
                $('#selectlistreports').change(function() {
                    if($(this).val() == 'Zuletzt erfasste Teilnehmer') {
                        $('#reisenhidden2').css("display", "inline");
                        return false;
                    } else {
                        $('#reisenhidden2').css("display", "none");
                    }
                });
            });
        </script>
    </head>
<body>
<div id="wrapper">

<?php
include_once("../includes/navigation.inc.php");
include_once("../classes/database.class.php");
?>

    <div id="content" class="container">
        <div class="form-group">
            <form action="" method="post" role="form" id="report_form">
                <h2>Reports</h2>
                <div class="form-group">
                    <label for="selectlistreports">Report auswählen:</label>
                    <select name="type" id="selectlistreports" class="form-control">
                        <optgroup label="Kundenreports">
                            <option value="Reisebuchungen" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Reisebuchungen') ? "selected" : ""?>>Kundentotal pro Reise anzeigen</option>
                            <option value="Reiseteilnehmer">Kunden pro konkrete Reise anzeigen</option>
                            <option value="Kundenadressen" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Kundenadressen') ? "selected" : ""?>>Alle Kunden - Adressdaten anzeigen</option>
                            <option value="Kundenkontakt" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Kundenkontakt') ? "selected" : ""?>>Alle Kunden - Kontaktdaten anzeigen</option>
                            <option value="Zuletzt erfasste Teilnehmer">Die zuletzt erfassten Kunden anzeigen</option>
                        </optgroup>
                        <optgroup label="Finanzreports">
                            <option value="Kreditoren" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Kreditoren') ? "selected" : ""?>>Offene Rechnungen anzeigen</option>
                            <option value="Debitoren" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Debitoren') ? "selected" : ""?>>Kunden mit offenen Rechnungen anzeigen</option>
                            <option value="Finanzübersicht" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Finanzübersicht') ? "selected" : ""?>>Finanzübersicht pro Reise anzeigen</option>
                            <option value="Begünstigte" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Begünstigte') ? "selected" : ""?>>Alle Begünstigte anzeigen</option>
                        </optgroup>
                        <optgroup label="Reisereports">
                            <option value="Reiseübersicht" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Reiseübersicht') ? "selected" : ""?>>Alle Reisen anzeigen</option>
                        </optgroup>
                    </select>
                </div>
                <div class="form-group">
                    <div id="reisenhidden1" style="display:none">
                        <?php
                        /** @var database $verbindung */
                        $verbindung = database::getDatabase();
                        $result = $verbindung->getallReisen('all');

                        if($result->num_rows > 0) {
                            echo "<select name=\"option\" class=\"form-control\"><option value=0 selected>Bitte Reise wählen...</option>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value=" . $row['ReiseID'] . ">Reise-ID: " . $row['ReiseID'] . ", Reiseziel: " . $row['Ziel'] . ", Abreise: " . $row['Hinreise'] . "</option>";
                            }
                            echo "</select>";
                        } else echo "Keine Reisen erfasst";
                        ?>
                    </div>
                    <div id="reisenhidden2" style="display:none">
                        <label class="radio-inline"><input type="radio" name="option" value=3 />3 Kunden</label>
                        <label class="radio-inline"><input type="radio" name="option" value=5  />5 Kunden</label>
                        <label class="radio-inline"><input type="radio" name="option" value=10 />10 Kunden</label>
                        <label class="radio-inline"><input type="radio" name="option" value=15 />15 Kunden</label>
                    </div>
                    <div class="form-group">
                        <br>
                        <input type="submit" name="submit" class="btn btn-primary" value="Report generieren"/>
                        <input type="submit" name="pdfbutton" class="btn btn-primary" value="Report als PDF generieren"/>
                    </div>
                </div>
            </form>
        </div>
        <?php

        if (isset($_POST['type'], $_POST['submit'])) {

            /** @var database $verbindung */
            $verbindung = database::getDatabase();
            $result = $verbindung->generateReport($_POST['type'], $_POST['option']);

            if ($result->num_rows > 0) {

                echo "<table class='table table-striped'><tr>";

                while ($finfo = $result->fetch_field()) {
                    echo "<th align='left' style='font-size:medium'>" . $finfo->name . "</th>";
                }
                echo "</tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr style='font-size:small'>";
                    foreach ($row as $value) {
                        if (preg_match('/[0-9]+[-]+/', $value)) {
                            $date = date("d-m-Y", strtotime($value));
                            echo "<td>" . $date . "</td>";
                        } else echo "<td>" . $value . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";

            } else {
                echo "<div class='container'>Keine Daten vorhanden zu dieser Abfrage</div>";
            }
        }
        ?>
    </div>
<?php
require("../includes/footer.inc.php");