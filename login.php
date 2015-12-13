<?php
session_start();
//$_SESSION = array();
?>
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

            <!--Modal begins here-->
<!--            <div class="modal fade" id="resetmodal" tabindex="-1" role="dialog">-->
<!--                <div class="modal-dialog" role="document">-->
<!--                    <div class="modal-content">-->
<!--                        <div class="modal-header">-->
<!--                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--                            <h4 class="modal-title">Passwort zusenden lassen</h4>-->
<!--                        </div>-->
<!--                        <div class="modal-body">-->
<!--                            <form id="modalform" action="" method="post">-->
<!--                                <div class="form-group">-->
<!--                                    <p>Das Passwort wird Ihnen auf die registrierte Email-Adresse zugesandt.</p>-->
<!--                                    <input type="text" name="pwdmodal" placeholder="Email" class="form-control"/>-->
<!--                                </div>-->
<!--                            </form>-->
<!--                        </div>-->
<!--                        <div class="modal-footer">-->
<!--                            <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>-->
<!--                            <button type="submit" name ="send" id="send" class="btn btn-primary">Passwort zusenden</button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
            <!--Modal ends here-->

        </div>
    </div>
</div>

</body>
</html>