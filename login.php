<?php
session_start();
?>
<!doctype html>
<html lang="de">
<head>
    <?php
    $pagetitle = "Home";
    include_once("includes/header.inc.php");
    ?>
    <!--    <meta charset="utf-8" />-->
    <!--    <title>Login</title>-->
    <!--    <meta name="viewport" content="width=device-width, initial-scale=1.0" />-->
    <!---->
    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">-->
    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">-->
    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/font-awesome.min.css">-->
    <!---->
    <!--    <script type="text/javascript" src="jquery-1.10.2.min.js"></script>-->
    <!--    <script type="text/javascript" src="bootstrap.min.js"></script>-->
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
                    <br>
                    <!--                    <div class="checkbox">-->
                    <!--                        <label>-->
                    <!--                            <input name="remember" type="checkbox" value="Remember Me"/>Remember Login</label>-->
                    <!--                    </div>-->
                    <button class="btn btn-sm btn-primary btn-block" type="submit">Einloggen</button>
                    <a href="#" id="reset" class="pull-right" data-toggle="modal" data-target="#resetmodal">Passwort vergessen?</a>
                    <!--                    <div id="reset" class="pull-right">Passwort vergessen?</div>-->
                    <br>
                    <div><?php echo (isset($_SESSION['falselogin']) && !empty($_SESSION['falselogin']))?$_SESSION['falselogin']:"";?></div>
                </form>
            </div>

            <!--Modal begins here-->
            <div class="modal fade" id="resetmodal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Passwort zusenden lassen</h4>
                        </div>
                        <div class="modal-body">
                            <form id="modalform" action="" method="post">
                                <div class="form-group">
                                    <p>Das Passwort wird Ihnen auf die registrierte Email-Adresse zugesandt.</p>
                                    <input type="text" name="pwdmodal" placeholder="Email" class="form-control"/>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
                            <button type="submit" name ="send" id="send" class="btn btn-primary">Passwort zusenden</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--Modal ends here-->

        </div>
    </div>
</div>

</body>
</html>