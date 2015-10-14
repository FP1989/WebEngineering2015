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
<?php
//Session starten oder neu aufnehmen
session_start();
////

//Session beenden
if(isset($_COOKIE[session_name()]))
{
    setcookie(session_name(), '', time()-86400, '/');
}

?>
<div class="container colored" >
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="container" style="margin-top: 50px">
            <div class="col-md-4">
                <form action="test.php" method="post">
                    <h3>Log In</h3>
                    <label for="Email" class="sr-only">Email </label>
                    <input type="email" name="email" id="Email" class="form-control" placeholder="Email" required="required" autofocus="autofocus"/>
                    <label for="pwd" class="sr-only">Password</label>
                    <input type="password" id="pwd1" class="form-control" placeholder="Password" required="required" />
                    <div class="checkbox">
                        <label>
                            <input name="remember" type="checkbox" value="Remember Me"/>Remember Login</label>
                    </div>
                    <button class="btn btn-sm btn-primary btn-block" type="submit">Sign in</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>