<?php
session_start();
require ("db_connect.php");
require ("reports_query.php");

$result = $conn->query($query);

if ($result->num_rows > 0) {

    echo "<table border='1'><tr>";

    while ($finfo = $result->fetch_field()) {
        echo "<td>" . $finfo->name . "</td>";
    }
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . $value . "</td>";
        }
        echo "</tr>";
    }
    echo "</table></div>";

} else echo "Keine Daten vorhanden zu dieser Abfrage.";
mysqli_close($conn);