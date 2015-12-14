<?php
session_start();
if(!isset($_SESSION['logged'])) {
        header("Location:logout.php");
}
if(isset($_SESSION['user_activity']) AND (time() - $_SESSION['user_activity']) > 1800){
    header("Location:logout.php");
} else $_SESSION['user_activity'] = time();