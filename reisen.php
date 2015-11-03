
<?php
$pagetitle = "Reisen";
include("includes/header.inc.php");
include("includes/navigation.inc.php");
?>
<div id="content" class="container">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#createTravel">Neue Reise erfassen</a></li>
        <li><a data-toggle="tab" href="#editTravel">Reise ansehen / editieren</a></li>
    </ul>

    <div class="tab-content">
        <div id="createTravel" class="tab-pane fade in active">
            <h2>Reise erfassen</h2> </br></br>

            <div class="form-group">
                <label>Reise-ID</label>
                <input class="form-control" type="text" readonly>
            </div>

            <div class="form-group">
                <label>Ziel</label>
                <input class="form-control" type="text">
            </div>

            <div class="form-group">
                <label>Beschreibung</label>
                <textarea class="form-control" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>Bezeichnung</label>
                <input class="form-control" type="text">
            </div>
            
            <div class="form-group">
                <label>Preis</label>
                <input class="form-control" type="number">
            </div>

            <div class="form-group">
                <label>Hinreise</label>
                <div class="input-group date">
                    <input type='text' class="form-control" id="hinreise"/>
                                    <span class="input-group-addon">
                                     <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                </div>
            </div>

            <div class="form-group">
                <label>R&uuml;ckreise</label>
                <div class="input-group date">
                    <input type='text' class="form-control" id="rueckreise"/>
                                    <span class="input-group-addon">
                                     <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                </div>
            </div>

            <div class="form-group pull-right">
                <button type="submit" class="btn btn-primary">Reise erfassen</button>
                <button type="reset" class="btn btn-primary">Felder l&ouml;schen</button>
            </div>

        </div> <!-- end tab-1 -->

        <div id="editTravel" class="tab-pane fade">
            <div role="form">
                <h2>Reise ansehen / Reise editieren</h2> <br/><br/>
            </div>
        </div> <!-- end tab-2 -->
    </div> <!-- end tabs -->
</div> <!-- end content div -->



<!--<script type="text/javascript">

    $(function() {
        $( "#hinreise" ).datepicker();
        $( "#rueckreise" ).datepicker();
        dateFormat: "dd-mm-yyyy",
            $.datepicker.setDefaults($.datepicker.regional["de"]);
    });

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