<?php
include_once("classes/database.class.php");
include("includes/authentication.inc.php");
?>
<br/>
<br/>


<p class="alert alert-success" role="alert" id="feedback_positive"></p>
<p class="alert alert-warning" role="alert" id="feedback_negative"></p>

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

<br/>
<br/>

<div class="form-group">
    <label>Rechnung bezahlt?</label> </br>
    <label class="radio-inline"><input type="radio" value="1" name="paidBill">Ja</label>
    <label class="radio-inline"><input type="radio" value="0" checked="checked" name="paidBill">Nein</label>
</div>

<br/>
<br/>

<div class="form-group pull-right">
    <button type="submit" type="button" id="send" name="gesendet" class="btn btn-primary">Reservation buchen</button>
    <button type="reset" type="button" id="clear" name="gesendet" class="btn btn-primary">Felder l&ouml;schen</button>
</div>

<script type="text/javascript">
    $(document).ready(function(){


        $("#send").on("click", function(e){
            e.preventDefault();

            var ReiseID = $('#reiseID').val();
            var TeilnehmerID = $('#teilnehmerID').val();
            var Bezahlt = $("input[name=paidBill]:checked").val();

            $.ajax({
                url:"reservationen.write.process.php",
                type:"POST",
                dataType:"json",
                data:{ReiseID:ReiseID,TeilnehmerID:TeilnehmerID, Bezahlt:Bezahlt},

                ContentType:"application/json",
                success: function(response){
                    var status = response.flag;
                    if(status){
                        $('#feedback_negative').hide();
                        $('#feedback_positive').show().html(response.message).delay(500).fadeOut();

                        $("#reiseNr").val("");
                        $("#reiseID").val("");
                        $("#reiseZiel").val("");
                        $("#teilnehmerNr").val("");
                        $("#teilnehmerID").val("");
                        $("#teilnehmerName").val("");
                    }else {
                        $('#feedback_negative').show().html(response.message).delay(2000).fadeOut();
                    }
                }

            })
        });
        $("#clear").on("click", function(e){
            e.preventDefault();
            $("#reiseNr").val("");
            $("#reiseID").val("");
            $("#reiseZiel").val("");
            $("#teilnehmerNr").val("");
            $("#teilnehmerID").val("");
            $("#teilnehmerName").val("");
        });
    });

</script>