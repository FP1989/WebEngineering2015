<?php

session_start();

if(!($_SESSION['logged'])){

    echo "Bitte einloggen.<br>";
    echo "<a href='login.php'> zum Login </a>";
    exit();
}
