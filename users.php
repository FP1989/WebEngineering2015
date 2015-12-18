<!doctype html>
<html lang="de">
<head>
    <?php
    $pagetitle = "Users";
    include("includes/header.inc.php");
    ?>

    <script type="text/javascript">

        function intermediary(button){
            var id = button.id;
            $("#goodbye").html("<button id="+id +" class=\"btn btn-primary pull-left\" onclick=\"deleteUsers(this)\">User löschen</button>");
        }

        function deleteUsers(button) {

            var id = button.id;

            $.ajax({

                url: "users_process_delete.php",
                type: "POST",
                dataType: "json",
                data: {UserID:id},

                success: function(data) {

                    if(data.flag) {
                        $('#deletepositive').show().html(data.message).delay(2000).fadeOut();
                    } else {
                        $('#deletenegative').show().html(data.message);
                        $('#userdeletemodal').effect("shake", {times:2}, 500);
                    }
                }
            });
        }
    </script>

    <script id="source" language="javascript" type="text/javascript">

        $(function(){
            $('#deletepositive').hide();
            $('#deletenegative').hide();
        });
    </script>

</head>
<body>
<div id="wrapper">

    <?php
    include_once("includes/navigation.inc.php");
    include_once("classes/database.class.php");

    /* @var database $verbindung */
    $verbindung = database::getDatabase();
    $userid_error = $pw_error = $success_alert = $error_alert = "";
    $valid = true;

    if(isset($_POST['gesendet'])) {
        if(empty($_POST['userid'])) {
            $userid_error = "Bitte Login eingeben";
            $valid = false;
        } elseif($verbindung->existsUser($_POST['userid']) != 0) {
            $userid_error = "Dieser Login ist bereits vergeben";
            $valid = false;
        }
        if(empty($_POST['passwort'])) {
            $pw_error = "Bitte Passwort eingeben";
            $valid = false;
        }elseif(strlen($_POST['passwort']) <= 3) {
            $pw_error = "Bitte mindestens vier Zeichen für das Passwort verwenden";
            $valid = false;
        }

        if($valid) {
            $user = $_POST['userid'];
            $pwhash = sha1($_POST['passwort']);

            $successful = $verbindung->insertUser($user, $pwhash);

            $success_alert = "<div class='alert alert-success' role='alert'>User erfolgreich erstellt.</div>";
        }
        else $error_alert = "<div class='alert alert-warning' role='alert'>Das Formular enthält Fehler, User wurde nicht erfasst.</div>";
    }
    ?>

    <div id="content" class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#createUser">Neuen User erfassen</a></li>
            <li><a data-toggle="tab" href="#editUser">Users ansehen / editieren</a></li>
        </ul>

        <div class="tab-content">
            <div id="createUser" class="tab-pane fade in active">
                <form role="form" method="post" action="">
                    <h2>User erfassen</h2><br><br>
                    <?php echo (!empty($success_alert)) ? $success_alert:''; ?>

                    <div class="form-group <?php echo (!empty($userid_error)) ? 'has-error':''; ?>">
                        <label for="userid">User Login</label>
                        <input class="form-control" id="userid" name="userid" type="text">
                        <?php echo "<span class='help-block'>$userid_error</span>";?>
                    </div>

                    <div class="form-group <?php echo (!empty($pw_error)) ? 'has-error':''; ?>">
                        <label for="passwort">Passwort</label>
                        <input class="form-control" id="passwort" name="passwort" type="text">
                        <?php echo "<span class='help-block'>$pw_error</span>";?><br>
                    </div>
                    <div class="form-group pull-right">
                        <button type="submit" name="gesendet" class="btn btn-primary">User erfassen</button>
                    </div>
                </form>

            </div> <!-- end tab-1 -->

            <div id="editUser" class="tab-pane fade">

                <h2>User ansehen / User löschen</h2> <br/><br/>

                <h3>User auswählen</h3>
                <?php

                /** @var database $verbindung */
                $verbindung = database::getDatabase();
                $result = $verbindung->getAllUsers();

                if ($result->num_rows > 0) {

                    echo "<table class='table table-striped'><tr>";

                    while ($finfo = $result->fetch_field()) {
                        echo "<th align='left' style='font-size:medium'>" . $finfo->name . "</th>";
                        echo "<th colspan=2></th>";
                    }
                    echo "</tr>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr style='font-size:small'>";
                        foreach ($row as $value) {
                            echo "<td>" . $value . "</td>";
                            echo "<td><button id=" . $value . " onclick=\"intermediary(this)\" class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#userdeletemodal\">User löschen</button></td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";

                } else echo "<div>Keine Daten vorhanden zu dieser Abfrage.</div>";
                ?>

                <!--Modal begins here-->
                <div class="modal fade" id="userdeletemodal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h2>User löschen</h2>
                            </div>

                            <div class="modal-body">
                                <p class="alert alert-success" role="alert" id="deletepositive"></p>
                                <p class="alert alert-warning" role="alert" id="deletenegative"></p>
                                <p>Sind Sie sicher, dass Sie diesen User löschen wollen?</p>
                            </div>
                            <div class="modal-footer" id="goodbye"></div>
                        </div>
                    </div>
                </div>
                <!--Modal ends here-->

            </div> <!-- end tab-2 -->
        </div> <!-- end tabs -->
    </div> <!-- end content div -->

<?php include("includes/footer.inc.php");