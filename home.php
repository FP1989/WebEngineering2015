<?php
$pagetitle = "Home";
include("includes/header.inc.php");
include("includes/navigation.inc.php");
?>
<div id="content" class="container">

    <div class="jumbotron">
        <h2>Herzlich willkommen zum Online-Planungstool der Star Reisen AG!</h2>
        <p>Verwenden Sie die Navigation links um Rechnungen, Reisen oder Teilnehmer einzusehen oder zu mutieren. Zus&auml;tzlich k&ouml;nnen Sie sich unter 'Reports' vorgefertigte Berichte ausstellen lassen.</p>
        <p>Auf dieser Seite finden Sie aktuelle Daten zu anstehenden Reisen sowie f&auml;llige Rechnungen. Weiter k&ouml;nnen Sie mit dem Schnellzugriff Kunden entsprechenden Reisen zuweisen.</p>
    </div>

    <div class="panel panel-primary col-md-4">
        <div class="panel-heading">Reisen demn&auml;chst</div>
        <div class="panel-body">Text</div>
    </div>
    <div class="panel panel-primary col-md-4">
        <div class="panel-heading">F&auml;llige Rechnungen</div>
        <div class="panel-body">Text</div>
    </div>

    <div class=" cold-md-3 pull-right jumbotron">
        <form action="" name="schnellzugriff">
            <label for="teilnehmerid">Teilnehmer ID</label>
            <input type="number" id="teilnehmerid" name="teilnehmerid" class="form-control"/>
            <label for="reiseid">Reise ID</label>
            <input type="number" id="reiseid" name="reiseid" class="form-control"/><br>
            <input type="submit" name="submit" class="btn btn-primary" value="Hinzuf&uuml;gen"/>
        </form>
    </div>
</div>