<?php

include ("htmltopdf/html2pdf.class.php");
require ("db_connect.php");

session_start();

ob_start();
require ("reports_query.php");
$content = ob_get_clean();
$pdf = new HTML2PDF('L', 'A4', 'en', 'true', 'UTF-8');
$pdf->writeHTML($content);
$pdf->Output('table.pdf');