<?php include("includes/authentication.inc.php");?>
    <!doctype html>
    <html lang="de">
    <head>
        <?php
        $pagetitle = "Teilnehmer";
        include_once("includes/header.inc.php");
        ?>

        <script type="text/javascript">

            function searchTeilnehmer(){

                var user = document.getElementById("usr");
                var val = user.value;
                user.style.backgroundColor="white";

                if(!$.isNumeric(val)) {

                    $.ajax({

                        url: 'teilnehmer.multiple.read.php',
                        type: "POST",
                        dataType: 'json',
                        data: {teilnehmer: val},

                        success: function (data) {

                            if(data.length != 0) {

                                var counter = 0;

                                while(counter < data.length) {
                                    $(".insertnames").append("<button id = " + data[counter] + " onclick=\"setTimeout(searchExactTeilnehmer,500, this.id)\" class=\"btn btn-primary\" data-dismiss=\"modal\">" + data[counter+1] + " " + data[counter+2] + "</button>&nbsp");
                                    counter += 3;
                                }

//                                for(var i = 0; i < data.length; i) {
//                                    $("#insertnames").html("<button id = " + data[i] + " class=\"btn btn-primary\">" + data[i + 1] + " " + data[i + 2] + "</button>");
//                                    alert(data[i] + ", " + data[i+1] + " " + data[i+2]);
//                                }

                                $("#multiplenames").modal('show');

                            } else {

                                $.ajax({

                                    url: 'teilnehmer.read.php',
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        teilnehmer: val
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

                                        if (data.TeilnehmerID_R != '' && data.TeilnehmerID_R != null) $("#Mutationsformular").modal('show');
                                        else document.getElementById("usr").style.backgroundColor = "red";
                                    }
                                });

                            }
                        }
                    })
                } else {

                    $.ajax({

                        url: 'teilnehmer.read.php',
                        type: "POST",
                        dataType: 'json',
                        data: {
                            teilnehmer: val
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

                            if (data.TeilnehmerID_R != '' && data.TeilnehmerID_R != null) $("#Mutationsformular").modal('show');
                            else document.getElementById("usr").style.backgroundColor = "red";
                        }
                    });
                }
            }

            function searchExactTeilnehmer(id) {

                $(".insertnames").empty();
                $("#multiplenames").modal('hide');

                $.ajax({

                    url: 'teilnehmer.read.php',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        teilnehmer: id
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

                        if (data.TeilnehmerID_R != '' && data.TeilnehmerID_R != null) $("#Mutationsformular").modal('show');
                        else document.getElementById("usr").style.backgroundColor = "red";
                    }
                });

            }

                $(function () {

                $('#positive').hide();
                $('#negative').hide();
            });

        </script>
    </head>
<body>
<div id="wrapper">

<?php
include_once("includes/navigation.inc.php");
include_once("classes/database.class.php");
include_once("teilnehmer.modal.php");
?>
    <div class="modal custom fade" id="multiplenames" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h2>Namensüberschneidungen</h2>
                </div>

                <div class="modal-body">
                    <div id="insertnames" class="insertnames"></div>
                </div>
            </div>
        </div>
    </div>

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
                    <label for="usr">Teilnehmer-Nr oder Teilnehmer-Nachname:</label>
                    <input type="text" class="form-control" id="usr">
                </div>

                <button id="usr_suche" onclick="searchTeilnehmer()" class="btn btn-success btn-md">Suchen</button>



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