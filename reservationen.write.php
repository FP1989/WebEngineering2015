<?php
include_once("classes/database.class.php");

?>
<br/>
<br/>




<div class="form-group">
    <label>Teilnehmer-Nr oder Teilnehmer-Nachname:</label>
    <div class="input-group">
        <input type="text" class="form-control" id="teilnehmerNr">
        <span class="input-group-btn">
            <button onclick="sucheTeilnehmer()" class="btn btn-success btn-md">Suche Teilnehmer</button>
        </span>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class ="col-md-4">
            <label>Teilnehmer-ID</label>
            <input id="teilnehmerID" class="form-control " name="id" type="text" readonly>
        </div>
        <div class="col-md-8">
            <label>Teilnehmer-Nachname</label>
            <input id="teilnehmerName" class="form-control" name="name" type="text" readonly>
        </div>
    </div>
</div>

<br/>
<br/>

<div class="form-group">
    <label>Reise-Nr oder Reise-Ziel:</label>
    <div class="input-group">
        <input type="text" class="form-control" id="reiseNr">
        <span class="input-group-btn">
            <button onclick="sucheReise()" class="btn btn-success btn-md">Suche Reise</button>
        </span>
    </div>
</div>


<div class="form-group">
    <div class="row">
        <div class ="col-md-4">
            <label>Reise-ID</label>
            <input id="reiseID" class="form-control " name="id" type="text" readonly>
        </div>
        <div class="col-md-8">
            <label>Reise-Ziel</label>
            <input id="reiseZiel" class="form-control" name="name" type="text" readonly>
        </div>
    </div>
</div>
