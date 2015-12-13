<?php

include("classes/database.class.php");

/* @var database $database*/
$database = database::getDatabase();


if(isset($_POST["TeilnehmerID_R"]) AND isset($_POST["ReiseID_R"])){

    $result = $database->fetchReservation($_POST["ReiseID_R"], $_POST["TeilnehmerID_R"]);

    $reise = $database->fetchReise($result["ReiseID"]);

    $result["Ziel"] = $reise->getZiel();
    $result["Hinreise"] = $reise->getHinreise();

    $teilnehmer = $database->fetchTeilnehmer($result["ReiseID"]);

    $result["Nachname"] = $teilnehmer->getNachname();

    $date = date("d-m-Y", strtotime($result["Hinreise"]));
    @$hinreise_array = explode('-', $date);
    @$tag = $hinreise_array[0];
    @$monat = $hinreise_array[1];
    @$jahr = $hinreise_array[2];
    $newDate = $tag . "." . $monat . "." . $jahr;
    $result["Hinreise"] = $newDate;

    echo json_encode($result);

}

else if(isset($_POST["TeilnehmerID_R"])) {

    $teilnehmerID = $_POST["TeilnehmerID_R"];
    $res = $database->fetchReservation(null, $teilnehmerID);

    if(!$res) $res[0]["TeilnehmerID"]  = null;

    else {

        $teilnehmer = $database->fetchTeilnehmer($_POST["TeilnehmerID_R"]);

        for ($i = 0; $i < count($res); $i++) {

            $reise = $database->fetchReise($res[$i]["ReiseID"]);
            $res[$i]["Ziel"] = $reise->getZiel();
            $res[$i]["Hinreise"] = $reise->getHinreise();

            $res[$i]["Nachname"] = $teilnehmer->getNachname();

            if($res[$i]["bezahlt"]==1) $res[$i]["bezahlt"] = "Ja";
            else $res[$i]["bezahlt"] = "Nein";

            $date = date("d-m-Y", strtotime($res[$i]["Hinreise"]));
            @$hinreise_array = explode('-', $date);
            @$tag = $hinreise_array[0];
            @$monat = $hinreise_array[1];
            @$jahr = $hinreise_array[2];
            $newDate = $tag . "." . $monat . "." . $jahr;
            $res[$i]["Hinreise"] = $newDate;
        }
    }
    echo json_encode($res);
}

else if(isset($_POST["ReiseID_R"])){

    $reiseID = $_POST["ReiseID_R"];
    $res = $database->fetchReservation($reiseID);

    if(!$res) $res[0]["ReiseID"]  = null;

    else {

        $reise = $database->fetchReise($_POST["ReiseID_R"]);

        for ($i = 0; $i < count($res); $i++) {

            $res[$i]["Ziel"] = $reise->getZiel();
            $res[$i]["Hinreise"] = $reise->getHinreise();

            $teilnehmer = $database->fetchTeilnehmer($res[$i]["TeilnehmerID"]);
            $res[$i]["Nachname"] = $teilnehmer->getNachname();

            $date = date("d-m-Y", strtotime($res[$i]["Hinreise"]));
            @$hinreise_array = explode('-', $date);
            @$tag = $hinreise_array[0];
            @$monat = $hinreise_array[1];
            @$jahr = $hinreise_array[2];
            $newDate = $tag . "." . $monat . "." . $jahr;
            $res[$i]["Hinreise"] = $newDate;

        }
    }

    echo json_encode($res);


}

