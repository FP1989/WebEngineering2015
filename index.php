<?php session_start(); ?>
<!doctype html>
<html lang="de">
<head>
    <?php
    $pagetitle = "Login";
    include_once("includes/header.inc.php");
    ?>
</head>
<body>
<div class="container colored" >
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="container" id="loginwindow">
            <div class="col-md-4">
                <form action="login_authorization.php" method="post">
                    <h3>Login</h3>
                    <label for="UserID" class="sr-only">UserID</label>
                    <input type="text" name="userid" class="form-control" placeholder="UserID" required="required" autofocus="autofocus"/>
                    <label for="pwd" class="sr-only">Password</label>
                    <input type="password" name="pwd" class="form-control" placeholder="Password" required="required" />
                    <br><button class="btn btn-sm btn-primary btn-block" type="submit">Einloggen</button>
<!--                    <a href="#" id="reset" class="pull-right" data-toggle="modal" data-target="#resetmodal">Passwort vergessen?</a>-->
                    <br>
                    <div><?php echo (isset($_SESSION['falselogin']) && !empty($_SESSION['falselogin']))?$_SESSION['falselogin']:"";?></div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>