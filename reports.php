<?php include("includes/authentication.inc.php");

//Executed first to avoid any information sent by client, which prevents FPDF from creating PDF
if(isset($_POST['pdfbutton'])) {
    $_SESSION['type'] = $_POST['type'];
    if(isset($_POST['radioreise'])) $_SESSION['radioreise'] = $_POST['radioreise'];
    header("Location:print_pdf.php");
};?>
    <!doctype html>
    <html lang="de">
    <head>
        <?php
        $pagetitle = "Reports";
        include_once("includes/header.inc.php");
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#selectlistreports').change(function() {
                    if($(this).val() == 'Reiseteilnehmer') {
                        $('#reisenhidden').css("display", "inline");
                        return false;
                    } else {
                        $('#reisenhidden').css("display", "none");
                    }
                });
            });
        </script>
    </head>
<body>
<div id="wrapper">

<?php
include_once("includes/navigation.inc.php");
include_once("classes/database.class.php");
?>

    <div id="content" class="container">
        <div class="form-group">
            <form action="" method="post" role="form" id="report_form">
                <h2>Reports</h2>
                <div class="form-group">
                    <label for="selectlistreports">Report auswählen:</label>
                    <select name="type" id="selectlistreports" class="form-control">
                        <optgroup label="Kunden Reports">
                            <option value="Reisebuchungen" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Reisebuchungen') ? "selected" : ""?>>Kunden pro Reise anzeigen (alle)</option>
                            <option value="Reiseteilnehmer">Kunden pro Reise anzeigen (konkrete Reise)</option>
                            <option value="Kundenadressen" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Kundenadressen') ? "selected" : ""?>>Alle Kunden Adressdaten anzeigen</option>
                            <option value="Kundenkontakt" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Kundenkontakt') ? "selected" : ""?>>Alle Kunden Kontaktdaten anzeigen</option>
                        </optgroup>
                        <optgroup label="Finanzreports">
                            <option value="Kreditoren" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Kreditoren') ? "selected" : ""?>>Offene Rechnungen anzeigen</option>
                            <option value="Debitoren" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Debitoren') ? "selected" : ""?>>Kunden mit offenen Rechnungen anzeigen</option>
                            <option value="Finanzübersicht" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Finanzübersicht') ? "selected" : ""?>>Finanzübersicht pro Reise anzeigen</option>
                            <option value="Begünstigte" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Begünstigte') ? "selected" : ""?>>Alle Begünstigte anzeigen</option>
                        </optgroup>
                        <optgroup label="Reisereports">
                            <option value="Reiseübersicht" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Reiseübersicht') ? "selected" : ""?>>Alle Reisen anzeigen</option>
                            <option value="Reisen demnächst" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Reisen demnächst') ? "selected" : ""?>>Ausstehende Reisen anzeigen</option>
                        </optgroup>
                    </select><br>
                </div>
                <div class="form-group">
                    <div id="reisenhidden" style="display:none">
                        <?php
                        /** @var database $verbindung */
                        $verbindung = database::getDatabase();
                        $result = $verbindung->reportReisen();

                        if($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                foreach($row as $value) {
                                    echo "<input type=\"radio\" value=\"" . $value . "\" name=\"radioreise\"> Reise " . $value . "&nbsp;&nbsp;&nbsp;&nbsp;";
                                }
                            }
                        } else echo "Keine Reisen erfasst";
                        ?>
                        <br><br></div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Report generieren"/>
                    <input type="submit" name="pdfbutton" class="btn btn-primary" value="Report als PDF generieren"/>
                </div>
            </form>
        </div>
        <?php

        if (isset($_POST['type'], $_POST['submit'])) {

            /** @var database $verbindung */
            $verbindung = database::getDatabase();
            if(isset($_POST['radioreise'])) $result = $verbindung->generateReport($_POST['type'], $_POST['radioreise']);
            else $result = $verbindung->generateReport($_POST['type']);

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

            } else echo "<div class='container'>Keine Daten vorhanden zu dieser Abfrage.</div>";
        }
        ?>
    </div>
<?php
require ("includes/footer.inc.php");