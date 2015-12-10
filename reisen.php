<!doctype html>
<html lang="de">
<head>
    <?php
    $pagetitle = "Reisen";
    include("includes/header.inc.php");
    ?>

    <script type = text/javascript>


        function deleteReiseID(button){

            var id = button.id;

            var div = document.getElementById("loeschen");

            div.innerHTML("<button id= "+id+"class=\"btn btn-danger btn-sm\" onclick=\"loeschen(this)\" >Loeschen</button>");

        }

        function loeschen(button){

            var id = button.id;


        }

        function getReiseID(button) {

            var id = button.id;

            $.ajax({

                url: 'reisen.read.php',
                type: "POST",
                dataType: 'json',
                data: {
                    ReiseID_R: id
                },

                success: function (data) {

                    document.getElementById("ReiseID_R").value = id;
                    document.getElementById("Ziel_R").value = data.Ziel_R;
                    document.getElementById("Beschreibung_R").value = data.Beschreibung_R;
                    document.getElementById("Bezeichnung_R").value = data.Bezeichnung_R;
                    document.getElementById("Preis_R").value = data.Preis_R;
                    document.getElementById("Hinreise_R").value = data.Hinreise_R;
                    document.getElementById("Rueckreise_R").value = data.Rueckreise_R;

                }

            });
        }
    </script>

    <script id="source" language="javascript" type="text/javascript">

        $(function(){

            $.ajax({

                url: 'reisen.read.php',
                data: "",
                dataType: 'json',
                success: function (data) {

                    var string = "<tr><th>Reise-ID</th><th>Reiseziel</th><th>Bezeichnung</th><th colspan=3>Abreise</th></tr>";

                    for (var i = 0; i < data.length; i++) {

                        string += "<tr><td>"+data[i].ReiseID+"</td><td>"+data[i].Ziel+"</td><td>"+data[i].Bezeichnung+"</td><td>"+data[i].Hinreise+"</td><td align=\"right\"><button id="+data[i].ReiseID+" onclick=\"getReiseID(this)\" class=\"btn btn-success btn-sm\" data-toggle=\"modal\" data-target=\"#Mutationsformular\">mutieren</button><td><button class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#Reiseloeschen\" >löschen</button></td></tr>";

                    }

                    $('#Reise_mutieren').html(string);

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
    include_once("reisen.modal.php");
    ?>

<div id="content" class="container">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#createTravel">Neue Reise erfassen</a></li>
        <li><a data-toggle="tab" href="#editTravel">Reise ansehen / editieren</a></li>
    </ul>

    <div class="tab-content">
        <div id="createTravel" class="tab-pane fade in active">
            <?php include_once("reisen.write.php");?>
        </div> <!-- end tab-1 -->

        <div id="editTravel" class="tab-pane fade">
                <h2>Reise ansehen / Reise editieren</h2> <br/><br/>

                <h3>Reise ausw&auml;hlen</h3>
                <table id="Reise_mutieren" class='table table-striped'></table>


        </div> <!-- end tab-2 -->
    </div> <!-- end tabs -->
</div> <!-- end content div -->



<script type="text/javascript">

    $(function() {
        $( "#hinreise" ).datepicker({
            onClose: function( selectedDate ) {
                $( "#rueckreise" ).datepicker( "option", "minDate", selectedDate );
            }
        });
        $( "#rueckreise" ).datepicker({
            onClose: function( selectedDate ) {
                $( "#hinreise" ).datepicker( "option", "maxDate", selectedDate );
            }
        });

        $.datepicker.setDefaults($.datepicker.regional["de"]);
    });


</script>

<?php
include("includes/footer.inc.php");