<!doctype html>
<html lang="de">
<head>
    <?php
    $pagetitle = "Teilnehmer";
    include_once("includes/header.inc.php");
    ?>

<!--
    <script type = text/javascript>

        function deleteReiseID(button){

            var id = button.id;

            var div = document.getElementById("loeschen");

            div.innerHTML("<button id= "+id+"class=\"btn btn-danger btn-sm\" onclick=\"loeschen(this)\" >Loeschen</button>");

        }

        function loeschen(button){

            var id = button.id;


        }


    </script>-->

    <script type="text/javascript">

        function searchName(){

            var nachname = document.getElementById("usr").value;

            $.ajax({

                url: 'teilnehmer.read.php',
                type: "POST",
                dataType: 'json',
                data: {
                    Nachname_R: nachname
                },


                success: function (data) {

                    document.getElementById("TeilnehmerID_R").value = data.TeilnehmerID_R;
                    document.getElementById("Vorname_R").value = data.Vorname_R;
                    document.getElementById("Nachname_R").value = nachname;
                    document.getElementById("Strasse_R").value = data.Strasse_R;
                    document.getElementById("Hausnummer_R").value = data.Hausnummer_R;
                    document.getElementById("PLZ_R").value = data.PLZ_R;
                    document.getElementById("Ort_R").value = data.Ort_R;
                    document.getElementById("Telefon_R").value = data.Telefon_R;
                    document.getElementById("Mail_R").value = data.Mail_R;

                }
            });




        }

        function searchNr() {

            var id = document.getElementById("nr").value;

            $.ajax({

                url: 'teilnehmer.read.php',
                type: "POST",
                dataType: 'json',
                data: {

                    TeilnehmerID_R: id

                },

                success: function (data) {

                    document.getElementById("TeilnehmerID_R").value = data.TeilnehmerID_R;
                    document.getElementById("Vorname_R").value = data.Vorname_R;
                    document.getElementById("Nachname_R").value = data.Nachname_R;
                    document.getElementById("Strasse_R").value = data.Strasse_R;
                    document.getElementById("Hausnummer_R").value = data.Hausnummer_R;
                    document.getElementById("PLZ_R").value = data.PLZ_R;
                    document.getElementById("Ort_R").value = data.Ort_R;
                    document.getElementById("Telefon_R").value = data.Telefon_R;
                    document.getElementById("Mail_R").value = data.Mail_R;

                }

            });
        }

    </script>
</head>
<body>
<div id="wrapper">

    <?php
    include_once("includes/navigation.inc.php");
    include_once("classes/database.class.php");
    include_once("teilnehmer.modal.php");
    ?>

<div id="content" class="container">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#createParticipant">Neuen Teilnehmer erfassen</a></li>
        <li><a data-toggle="tab" href="#editParticipant">Teilnehmer ansehen / editieren</a></li>
    </ul>

    <div class="tab-content">

        <div id="createParticipant" class="tab-pane fade in active">
            <?php include_once("teilnehmer.write.php");?>
        </div> <!-- end tab-1 -->

        <div id="editParticipant" class="tab-pane fade">

            <h2>Teilnehmer ansehen / Teilnehmer editieren</h2> <br/><br/>

            <div class="form-group">
                <label for="nr">Teilnehmer Nummer:</label>
                <input type="number" class="form-control" id="nr">
            </div>

            <button id="nr_suche" onclick="searchNr()" class="btn btn-success btn-md" data-toggle="modal" data-target="#Mutationsformular">Suchen</button>
            <br/>
            <br/>

            <div class="form-group">
                <label for="usr">Teilnehmer Nachname:</label>
                <input type="text" class="form-control" id="usr">
            </div>

            <button id="usr_suche" onclick="searchName()" class="btn btn-success btn-md" data-toggle="modal" data-target="#Mutationsformular">Suchen</button>



        </div> <!-- end tab-2 -->
    </div> <!-- end tabs -->
</div> <!-- end content div -->

<!--<script type="text/javascript">

    $(function() {
        $( "#tabs" ).tabs();
    });


    $(function() {
        var defaultTab = parseInt(getParam('tab'));
        $( "#tabs" ).tabs(
            {active: defaultTab}
        );
    });
    function getParam(name) {
        var query = location.search.substring(1);
        if (query.length) {
            var parts = query.split('&');
            for (var i = 0; i < parts.length; i++) {
                var pos = parts[i].indexOf('=');
                if (parts[i].substring(0,pos) == name) {
                    return parts[i].substring(pos+1);
                }
            }
        }
        return 0;
    }
</script>-->

<?php
include("includes/footer.inc.php");