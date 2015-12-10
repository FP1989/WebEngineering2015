<!doctype html>
<html lang="de">
<head>
    <?php
    $pagetitle = "Users";
    include_once("includes/header.inc.php");
    ?>

</head>
<body>
<div id="wrapper">

    <?php
    include_once("includes/navigation.inc.php");
    include_once("classes/database.class.php");

    $userid_error = $pw_error = $success_alert = $error_alert = "";
    $valid = true;

    if(isset($_POST['gesendet'])) {
        if(empty($_POST['userid'])) {
            $userid_error = "Bitte User-ID eingeben";
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
            /* @var database $verbindung */
            $verbindung = database::getDatabase();
            $successful = $verbindung->insertUser($user, $pwhash);

            $success_alert = "<div class='alert alert-success pull-right' role='alert'>User erfolgreich erstellt.</div>";
        }
        else $error_alert = "<div class='alert alert-warning pull-right' role='alert'>Das Formular enthält Fehler, User wurde nicht erfasst.</div>";
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

                    <div class="form-group">
                        <?php echo (!empty($success_alert)) ? $success_alert:''; ?>
                        <label for="userid">User-ID</label>
                        <input class="form-control" id="userid" name="userid" type="text" <?php
                        /** @var database $database*/
                        $database = database::getDatabase();
                        $link = $database->getLink();
                        $query = 'SELECT MAX(LoginID) as id FROM logindaten';
                        $result = $link->query($query);
                        while ($row = mysqli_fetch_assoc($result)){
                            settype($row['id'], "int");
                            $id = $row['id'] + 10;
                            echo "value=".$id;
                        }
                        ?> readonly>
                    </div>

<!--                    <div class="form-group --><?php //echo (!empty($userid_error)) ? 'has-error':''; ?><!--">-->
<!--                        --><?php //echo (!empty($success_alert)) ? $success_alert:''; ?>
<!--                        <label for="userid">User-ID</label>-->
<!--                        <input class="form-control" id="userid" name="userid" type="number">-->
<!--                        --><?php //echo "<span class='help-block'>$userid_error</span>";?><!--<br>-->
<!--                    </div>-->

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
                <div class="form-group">
                    <h2>User ansehen / User editieren</h2> <br/><br/>
                </div>
            </div> <!-- end tab-2 -->
        </div> <!-- end tabs -->
    </div> <!-- end content div -->
