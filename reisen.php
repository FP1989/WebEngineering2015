
<!doctype html>
<html lang="de">
<head>
    <?php
    $pagetitle = "Reisen";
    include("includes/header.inc.php");
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
        <li class="active"><a data-toggle="tab" href="#createTravel">Neue Reise erfassen</a></li>
        <li><a data-toggle="tab" href="#editTravel">Reise ansehen / editieren</a></li>
    </ul>

    <div class="tab-content">
        <div id="createTravel" class="tab-pane fade in active">
            <?php include_once("reisen.write.php");?>
        </div> <!-- end tab-1 -->

        <div id="editTravel" class="tab-pane fade">
                <h2>Reise ansehen / Reise editieren</h2> <br/><br/>
                  <form role="form" method="post" action="">
                    <div class = "form-group">
                        <label for="reise">Reise ausw&auml;hlen</label>
                        <select name="reise" id="reise" class="form-control">

                            <?php
                            /** @var database $database*/
                            $database = database::getDatabase();

                            $link = $database->getLink();
                            $query = 'SELECT * FROM reise';

                            $result = $link->query($query);

                            $rows = $result->num_rows;
                            $spalten = $result->field_count;
                            while($datensatz = $result->fetch_assoc()){
                                echo "<option value = \"".$datensatz["ReiseID"]."\">".$datensatz["ReiseID"]." ".$datensatz["Ziel"]." Datum: ".$datensatz["Hinreise"]."</option>";
                            }?>
                        </select>
                    </div>
                </form>
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