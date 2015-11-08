<?php
session_start();

$pagetitle = "Reports";
include("includes/header.inc.php");
include("includes/navigation.inc.php");
include("classes/database.class.php");
?>
    <div id="content" class="container">
        <div class="form-group">
            <form action="" method="post" role="form" id="report_form">
                <h2>Reports</h2>
                <div class="form-group">
                    <label for="select1">Report ausw&auml;hlen:</label>
                    <select name="report_type" id="select1" class="form-control">
                        <option value="Kreditoren">Offene Rechnungen anzeigen</option>
                        <option value="Reiseteilnehmer">Kunden pro Reise</option>
                        <option value="Debitoren">Kunden mit offenen Rechnungen anzeigen</option>
                        <option value="Kundenuebersicht">Alle Kunden anzeigen</option>
                        <option value="Reiseuebersicht">Alle Reisen anzeigen</option>
                        <option value="Reisen demnaechst">Ausstehende Reisen anzeigen</option>
                        <option value="Finanzuebersicht">Finanz&uuml;bersicht anzeigen</option>
                        <option value="Reisegruppen">Reisegruppen anzeigen</option>
                    </select><br>
                </div>
                <div class="form-group pull-right">
                    <input type="submit" name="submit" class="btn btn-primary" value="Report generieren"/>
                    <input type="submit" name="pdfbutton" class="btn btn-primary" value="Report als PDF generieren"/>
                </div>
            </form>
        </div>

        <?php

        if(isset($_POST['pdfbutton'])) {
            $_SESSION['type'] = $_POST['report_type'];
            header("Location:reports_pdf.php");
        }

        if (isset($_POST['report_type'], $_POST['submit'])) {

            /** @var database $verbindung */
            $verbindung = database::getDatabase();
            $result = $verbindung->generateReport($_POST['report_type']);

            if ($result->num_rows > 0) {

                echo "<table class='table table-striped'><tr>";

                while ($finfo = $result->fetch_field()) {
                    echo "<th align='left' style='font-size:medium'>" . $finfo->name . "</th>";
                }
                echo "</tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr style='font-size:small'>";
                    foreach ($row as $value) {
                        echo "<td>" . $value . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";

            } else echo "<div class='container'>Keine Daten vorhanden zu dieser Abfrage.</div>";
//            mysqli_close($link);
        }
        ?>
    </div>
<?php
require ("includes/footer.inc.php");