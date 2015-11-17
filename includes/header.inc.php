<!doctype html>
<html lang="de">
<head>
    <title><?php echo $pagetitle; ?> </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript" src="http://jquery-ui.googlecode.com/svn/tags/latest/ui/minified/i18n/jquery-ui-i18n.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/3.1.1/bootstrap3-typeahead.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script id="source" language="javascript" type="text/javascript">

        $(document).ready(function (){

            $.ajax({
                url: 'reisen.read.php', //   Skript, das aufgerufen wird
                data: "", //   Übergebene Daten
                dataType: 'json', //   Datenformat JSON
                success: function (data) { //   Erhalt des Ergebnisses => mehrere Datensätze

                    for (i = 0; i < data.length; i++) {

                        $('#reise').append("<option value= \""+ data[i].ReiseID +"\">ReiseID: "+ data[i].ReiseID +", Reiseziel: " + data[i].Ziel+ ", Abreise: "+ data[i].Hinreise+ "</option>");

                    }


                }
            });

            var reiseID;

            $("#reise").change(function(){

                reiseID =  $("#reise option:selected").val();

                $.ajax({

                    url: 'rechnung.read.php',
                    type: "POST",
                    dataType: 'json',
                    data:{
                            ReiseID_R:  $("#reise option:selected").val(),
                    },

                    success: function (data) { //   Erhalt des Ergebnisses => mehrere Datensätze

                        var string;

                        for (i = 0; i < data.length; i++) {

                           string += "<option value= \""+ data[i].RechnungsID +"\">RechnungsID: "+ data[i].RechnungsID +", Betrag: " + data[i].Betrag + ", Fälligkeit: "+ data[i].Faelligkeit + "</option>";

                        }

                        $('#rechnung').html(string);

                    }


                })

            });

        });
    </script>
    <script id="source" language="javascript" type="text/javascript">


    </script>

</head>
<body>
<!--Open Wrapper-->
<div id="wrapper">