<?php
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    $id = $_GET["id"];

    $query_actual_times = $conexion->query("SELECT times_played from cancion where id = '$id'");
    $row = $query_actual_times->fetch_array(MYSQLI_ASSOC);
    $actual_times = $row["times_played"];

    $new_times = ++$actual_times;

    $query_update = $conexion->query("UPDATE cancion set times_played = $new_times where id = $id");

    $conexion->close();
?>