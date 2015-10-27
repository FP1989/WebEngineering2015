<?php
session_start();
?>
<html>
<head>
    <meta charset="utf-8" />
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/font-awesome.min.css">

    <script type="text/javascript" src="jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="bootstrap.min.js"></script>
</head>
<body>
<div class="container colored" >
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="container" style="margin-top: 50px">
            <div class="col-md-4">
                <form action="login_authorization.php" method="post">
                    <h3>Log In</h3>
                    <label for="UserID" class="sr-only">UserID </label>
                    <input type="text" name="userid" class="form-control" placeholder="UserID" required="required" autofocus="autofocus"/>
                    <label for="pwd" class="sr-only">Password</label>
                    <input type="password" name="pwd" class="form-control" placeholder="Password" required="required" />
                    <div class="checkbox">
                        <label>
                            <input name="remember" type="checkbox" value="Remember Me"/>Remember Login</label>
                    </div>
                    <button class="btn btn-sm btn-primary btn-block" type="submit">Sign in</button>
                    <br>
                    <div><?php echo (isset($_SESSION['falselogin']))?$_SESSION['falselogin']:"";?></div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>