<!doctype html>
<html lang="de">
<head>
    <?php
    $pagetitle = "Beguenstigter";
    include_once("includes/header.inc.php");
    ?>



</head>
<body>
<div id="wrapper">
    <?php
    include_once("includes/navigation.inc.php");
    include_once("beguenstigter_modal.php");
    include_once("rechnungen.modal.php");
    ?>


    <div id="content" class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#createRecipient">Neuen Beguenstigten erfassen</a></li>
            <li><a data-toggle="tab" href="#editRecipient">Beguenstigten ansehen / editieren</a></li>
        </ul>

        <div class="tab-content">
            <div id="createRecipient" class="tab-pane fade in active">
                <?php include("beguenstigter.write.php"); ?>
            </div> <!-- end tab-1 -->


            <div id="editRecipient" class="tab-pane fade">
                <h2>Beg&uuml;nstigten ansehen / Beg&uuml;nstigten editieren</h2> <br/><br/>

                <h3>Beg&uuml;nstigten ausw&auml;hlen</h3>





            </div>  <!-- end tab-2 -->
        </div> <!-- end tabs -->
    </div> <!-- end content div -->


<?php
include("includes/footer.inc.php");