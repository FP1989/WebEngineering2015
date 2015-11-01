
<?php
$pagetitle = "Teilnehmer";
include("includes/header.inc.php");
include("includes/navigation.inc.php");
?>
<div id="content" class="container">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#createParticipant">Neuen Teilnehmer erfassen</a></li>
        <li><a data-toggle="tab" href="#editParticipant">Teilnehmer ansehen / editieren</a></li>
    </ul>

    <div class="tab-content">

        <div id="createParticipant" class="tab-pane fade in active">
            <h2>Teilnehmer erfassen</h2><br><br>

            <div class="form-group">
                <label>Teilnehmer-ID</label>
                <input class="form-control" type="text" readonly>
            </div>

            <div class="form-group">
                <label>Vorname</label>
                <input class="form-control" type="text">
            </div>

            <div class="form-group">
                <label>Nachname</label>
                <input class="form-control" type="text">
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-8">
                        <label>Strasse</label>
                        <input class="form-control" type="text">
                    </div>
                    <div class="col-md-4">
                        <label>Hausnummer</label>
                        <input class="form-control" type="number">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Ort</label>
                <input class="form-control" type="text">
            </div>

            <div class="form-group">
                <label>Telefon Nr.</label>
                <input class="form-control" type="number">
            </div>

            <div class="form-group">
                <label>E-Mail Adresse</label>
                <input class="form-control" type="text">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-default">Teilnehmer erfassen</button>
                <button type="reset" class="btn btn-default">Felder l&ouml;schen</button>
            </div>
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