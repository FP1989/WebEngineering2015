<?php

include("classes/database.class.php");
session_start();
$verbindung = database::createDatabase();

if(isset($_POST['userid']) AND isset($_POST['pwd'])) {
    $_SESSION['logged'] = TRUE;
    $user = $_POST['userid'];
    $pwdhash = sha1($_POST['pwd']);
    $_SESSION['userid'] = $user;

    /** @var database $verbindung */
    if($verbindung->verifyLogin($user, $pwdhash)->num_rows > 0) {
        header("Location:home.php");
    } else {
        $_SESSION['logged'] = FALSE;
        $_SESSION['falselogin'] = "<span style=\"color:#ff0100;font-weight:bolder\">Login Falsch, bitte nochmals versuchen.</span>";
        header("Location:login.php");
    }
}


//$query = "SELECT * FROM logindaten WHERE LoginID = '$user' AND Loghash = '$pwdhash'";
//$result = $conn->query($query);

