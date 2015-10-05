<?php
    include ("htmltopdf/html2pdf.class.php");
    require ("db_connect.php");

    session_start();

        switch ($_SESSION['pdfquery']) {

        case "kreditoren":
            break;
        case "reiseteilnehmer":
            $query = "SELECT R.ReiseID, R.Ziel, R.Hinreise, T.Vorname, T.Nachname, O.PLZ, O.Ortname FROM Teilnehmer T JOIN Reservation Re ON T.TeilnehmerID=Re.TeilnehmerID JOIN Reise R ON Re.ReiseID=R.ReiseID JOIN Ort O ON T.Ort=O.PLZ";
            break;
        case "offene_rechnungen":
            $query = "SELECT T.Nachname, T.Vorname, R.Ziel, R.Hinreise FROM Teilnehmer T JOIN Reservation Re ON T.TeilnehmerID=Re.TeilnehmerID JOIN Reise R ON Re.ReiseID=R.ReiseID WHERE Re.bezahlt = 0";
            break;
        case "alle_kunden":
            $query = "SELECT T.TeilnehmerID, T.Vorname, T.Nachname, T.Strasse, T.Hausnummer, O.PLZ, O.Ortname, T.Telefon, T.Mail FROM Teilnehmer T JOIN Ort O ON T.Ort= O.PLZ";
            break;
        case "alle_reisen":
            $query = "SELECT R.ReiseID, R.Ziel, R.Beschreibung, R.Bezeichnung, R.Preis, R.Hinreise, R.Rueckreise FROM Reise R";
            break;
        case "ausstehende_reisen":
            $query = "SELECT R.Ziel, R.Hinreise, T.Nachname, T.Vorname FROM Reise R JOIN Reservation Re ON R.ReiseID=Re.ReiseID JOIN Teilnehmer T ON Re.TeilnehmerID=T.TeilnehmerID WHERE R.Hinreise > CURDATE()";
            break;
        case "finanzuebersicht":
            break;
        case "reisegruppe":
            break;
    }

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        ob_start();
        echo "<div class='container'><table class='table table-striped'><tr>";

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
        echo "</table></div>";
        $content = ob_get_clean();

        $pdf = new HTML2PDF('P', 'A4', 'en', 'true', 'UTF-8');
        $pdf->writeHTML($content);
        $pdf->Output('table.pdf');
    } else echo "<div class='container'>Keine Daten vorhanden zu dieser Abfrage.</div>";
    mysqli_close($conn);
