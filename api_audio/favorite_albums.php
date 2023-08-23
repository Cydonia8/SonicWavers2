<?php
    require_once "../php_functions/login_register_functions.php";
    require_once "../php_functions/general.php";
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $con = createConnection();

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);
    $user = $decoded["data"]["user"];

    $query_user = $con->prepare("SELECT id from user where username = ?");
    $query_user->bind_param('s', $user);
    $query_user->bind_result($user_id);
    $query_user->execute();
    $query_user->fetch();
    $query_user->close();

    $query_albums = $con->query("SELECT a.id id, a.picture picture, title, g.name author from album a, artist g, favorite f where a.active = 1 and f.album = a.id and a.artist = g.id and f.user = $user_id");
    $data_albums = [];

    while($row = $query_albums->fetch_array(MYSQLI_ASSOC)){
        $data_albums[] = $row;
    }
    $data["albums"] = $data_albums;

    $con->close();
    echo json_encode($data);