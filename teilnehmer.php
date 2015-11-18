<!doctype html>
<html lang="de">
<head>
    <?php
    $pagetitle = "Teilnehmer";
    include_once("includes/header.inc.php");
    ?>

</head>
<body>
<div id="wrapper">

    <?php
    include_once("includes/navigation.inc.php");
    include_once("classes/database.class.php");
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
            <div class="form-group">
                <h2>Teilnehmer ansehen / Teilnehmer editieren</h2> <br/><br/>
            </div>
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