<?php

include("classes/database.class.php");
session_start();
$verbindung = database::getDatabase();

if(isset($_POST['userid']) AND isset($_POST['pwd'])) {
    $user = $_POST['userid'];
    $pwdhash = sha1($_POST['pwd']);
    $_SESSION['userid'] = $user;
    $_SESSION['falselogin'] = "";

    /** @var database $verbindung */
    if($verbindung->verifyLogin($user, $pwdhash) > 0) {
        $_SESSION['logged'] = TRUE;
        if($user == 'admin') $_SESSION['admintrue'] = TRUE;
        $_SESSION['user_activity'] = time();
        header("Location:home.php");
    } else {
        $_SESSION['falselogin'] = "<span style=\"color:#ff0100;\">Login Falsch, bitte nochmals versuchen.</span>";
        header("Location:index.php");
    }
}