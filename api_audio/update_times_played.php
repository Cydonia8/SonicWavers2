<?php
    require_once "../php_functions/general.php";
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $con = createConnection();
    $id = $_GET["id"];

    $query_actual_times = $con->query("SELECT times_played from songs where id = '$id'");
    $row = $query_actual_times->fetch_array(MYSQLI_ASSOC);
    $actual_times = $row["times_played"];

    $new_times = ++$actual_times;

    $query_update = $con->query("UPDATE songs set times_played = $new_times where id = $id");

    $con->close();
?>