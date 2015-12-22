<?php include("../includes/authentication.inc.php");?>
    <!doctype html>
    <html lang="de">
    <head>
        <?php
        $pagetitle = "Teilnehmer";
        include_once("../includes/header.inc.php");
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
                                    $(".insertnames").append("<button id = " + data[counter] + " onclick=\"setTimeout(searchExactTeilnehmer,250, this.id)\" class=\"btn btn-primary btn-sm btn-multiple\" data-dismiss=\"modal\">" + data[counter+1] + " " + data[counter+2] + "</button>&nbsp");
                                    counter += 3;
                                }

                                $("#multiplenames").modal('show');
                                $('#multiplenames').on('hidden.bs.modal', function () {
                                    $(".insertnames").empty();
                                });

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
include_once("../includes/navigation.inc.php");
include_once("../classes/database.class.php");
include_once("teilnehmer.modal.php");
include_once("multiple_modal.php");
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
                    <label for="usr">Teilnehmer-Nr oder Teilnehmer-Nachname:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="usr">
                        <span class="input-group-btn">
                            <button id="usr_suche" onclick="searchTeilnehmer()" class="btn btn-primary">Suchen</button>
                        </span>
                    </div>
                </div>
            </div> <!-- end tab-2 -->
        </div> <!-- end tabs -->
    </div> <!-- end content div -->
<?php
include("../includes/footer.inc.php");