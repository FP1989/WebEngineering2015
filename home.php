<?php
require("includes/authentication.inc.php");
?>

<html>
<head>
    <title>Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</head>
<body>


<div class="container">
    <div class="row">

            <div class="dropdown col-sm-6 col-md-4 col-lg-2">
                <button href="#" class="btn btn-squared-default btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown">
                    <i class="fa fa-plane fa-5x"></i><br/>
                    <h2>Reisen</h2>
                </button>

                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="menu1" role="menu">
                    <li role="presentation"><a role="menuitem" href="reisen.php?tab=0#tabs">Neue Reise erfassen</a></li>
                    <li role="presentation"><a role="menuitem" href="reisen.php?tab=1#tabs">Reise einsehen / editieren</a></li>
                </ul>
            </div>

            <div class="clearfix visible-sm-block"></div>



        <div class="dropdown col-sm-6 col-md-4 col-lg-2">
            <button href="#" class="btn btn-squared-default btn-success" id="menu2" type="button" data-toggle="dropdown">
                <i class="fa fa-balance-scale fa-5x"></i><br/>
                <h2>Rechnungen</h2>
            </button>

            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="menu2" role="menu">
                <li role="presentation"><a role="menuitem" href="rechnungen.php?tab=0#tabs">Rechnung erfassen</a></li>
                <li role="presentation"><a role="menuitem" href="rechnungen.php?tab=1#tabs">Rechnung einsehen / editieren</a></li>
            </ul>
        </div>

        <div class="clearfix visible-sm-block"></div>


        <div class="dropdown col-sm-6 col-md-4 col-lg-2">
            <button href="#" class="btn btn-squared-default btn-warning" id="menu3" type="button" data-toggle="dropdown">
                <i class="fa fa-users fa-5x"></i><br/>
                <h2>Teilnehmer</h2>
            </button>

            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="menu3" role="menu">
                <li role="presentation"><a role="menuitem" href="teilnehmer.php?tab=0#tabs">Neuen Teilnehmer erfassen</a></li>
                <li role="presentation"><a role="menuitem" href="teilnehmer.php?tab=1#tabs">Teilnehmer einsehen / editieren</a></li>
            </ul>
        </div>

        <div class="clearfix visible-sm-block"></div>


        <div class="dropdown col-sm-6 col-md-4 col-lg-2">
            <button href="#" class="btn btn-squared-default btn-danger" id="menu4" type="button" data-toggle="dropdown">
                <i class="fa fa-table fa-5x"></i><br/>
                <h2>Report</h2>
            </button>

            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="menu4" role="menu">
                <li role="presentation"><a role="menuitem" href="rechnungen.php?tab=0#tabs">Neuen Report erfassen</a></li>
                <li role="presentation"><a role="menuitem" href="rechnungen.php?tab=1#tabs">Report einsehen / editieren</a></li>
            </ul>
        </div>



</div>

    <script>

    </script>

    <style>


        .btn-squared-default {
            width: 200px !important;
            height: 200px !important;
            font-size: 10px;
            margin-top: 150px;
        }



        .btn-squared-default:hover {
            font-weight: 800;
            border: 3px solid white;
        }


    </style>

</body>
</html>