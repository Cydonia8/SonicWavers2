<?php
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $con = new mysqli('localhost', 'root', '', 'sonicwaves');

    $styles = $con->query("SELECT id, name from styles where id <> 0");
    $data_styles = [];

    while($row = $styles->fetch_array(MYSQLI_ASSOC)){
        $data_styles[] = $row;
    }

    $data["styles"] = $data_styles;

    echo json_encode($data);
    $con->close();