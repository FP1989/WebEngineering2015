<?php include("../includes/authentication.inc.php");?>

    <!doctype html>
    <html lang="de">
    <head>
        <?php
        $pagetitle = "Beguenstigter";
        include_once("../includes/header.inc.php");
        ?>

        <script type="text/javascript">

            $(function () {

                $('#positive').hide();
                $('#negative').hide();

                $( "#beguenstigter" ).autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url: "../autosuggest_recipient.php",
                            type:"GET",
                            dataType: "json",
                            data: {term: request.term},
                            success: function (data) {
                                if(data.length > 0){
                                    response($.map(data, function (item) {
                                        return {
                                            label: item.label,
                                            value: item.value
                                        }
                                    }));
                                }else{
                                    response([{ label: 'No results found.', value: -1}]);
                                }
                            }
                        });
                    },
                    select: function (event, ui) {

                        if (ui.item.value == -1) {
                            return false;
                        }
                    }

                });


            });


            function searchBeguenstigter(){

                var rec = document.getElementById("beguenstigter");
                var val = rec.value;

                rec.style.backgroundColor="white";

                if(isNaN(val)) {

                    $.ajax({

                        url: 'beguenstigter.read.php',
                        type: "POST",
                        dataType: 'json',
                        data: {
                            Name_R: val
                        },

                        success: function (data) {

                            document.getElementById("BeguenstigterID_R").value = data.BeguenstigterID_R;
                            document.getElementById("Name_R").value = data.Name_R;
                            document.getElementById("Strasse_R").value = data.Strasse_R;
                            document.getElementById("Hausnummer_R").value = data.Hausnummer_R;
                            document.getElementById("PLZ_R").value = data.PLZ_R;
                            document.getElementById("Ort_R").value = data.Ort_R;

                            if (data.BeguenstigterID_R != '' && data.BeguenstigterID_R != null) {

                                $("#Mutationsformular").modal('show');
                                $("#beguenstigter").val("");
                            }
                            else document.getElementById("beguenstigter").style.backgroundColor = "red";
                        }
                    });
                }
                else{

                    $.ajax({

                        url: 'beguenstigter.read.php',
                        type: "POST",
                        dataType: 'json',
                        data: {
                            BeguenstigterID_R: val
                        },

                        success: function (data) {

                            document.getElementById("BeguenstigterID_R").value = data.BeguenstigterID_R;
                            document.getElementById("Name_R").value = data.Name_R;
                            document.getElementById("Strasse_R").value = data.Strasse_R;
                            document.getElementById("Hausnummer_R").value = data.Hausnummer_R;
                            document.getElementById("PLZ_R").value = data.PLZ_R;
                            document.getElementById("Ort_R").value = data.Ort_R;

                            if (data.BeguenstigterID_R != '' && data.BeguenstigterID_R != null) {

                                $("#Mutationsformular").modal('show');
                                $("#beguenstigter").val("");
                            }
                            else document.getElementById("beguenstigter").style.backgroundColor = "red";
                        }
                    });
                }
            }
        </script>
    </head>
<body>
<div id="wrapper">
<?php
include_once("../includes/navigation.inc.php");
include_once("beguenstigter.modal.php");
?>


    <div id="content" class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#createRecipient">Neuen Begünstigten erfassen</a></li>
            <li><a data-toggle="tab" href="#editRecipient">Begünstigten ansehen / editieren</a></li>
        </ul>

        <div class="tab-content">
            <div id="createRecipient" class="tab-pane fade in active">
                <?php include("beguenstigter.write.php"); ?>
            </div> <!-- end tab-1 -->


            <div id="editRecipient" class="tab-pane fade">
                <h2>Begünstigten ansehen / Begünstigten editieren</h2> <br/><br/>

                <div class="form-group">
                    <label for="usr">Begünstigter-Nr oder Begünstigter-Nachname:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="beguenstigter">
                        <span class="input-group-btn">
                            <button id="recipient_suche" onclick="searchBeguenstigter()" class="btn btn-primary btn-md">Suchen</button>
                        </span>
                    </div>
                </div>
            </div>  <!-- end tab-2 -->
        </div> <!-- end tabs -->
    </div> <!-- end content div -->
<?php include("../includes/footer.inc.php");