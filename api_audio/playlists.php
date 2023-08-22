<?php
    require_once "../php_functions/login_register_functions.php";
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);
    $user = $decoded["data"]["user"];

    $con = createConnection();
    $id_user = $con->prepare("SELECT id from user where username = ?");
    $id_user->bind_param('s', $user);
    $id_user->bind_result($id);
    $id_user->execute();
    $id_user->fetch();
    $id_user->close();

    $playlist_data = [];

    $query_playlists = $con->prepare("SELECT l.id id, l.title title, image, u.username user from playlists l, user u where l.user = u.id and l.user = ?");
    $query_playlists->bind_param('i', $id);
    $query_playlists->execute();
    $result=$query_playlists->get_result();

    while($row = $result->fetch_assoc()){
        $playlist_data[] = $row;
    }

    $data["playlists"] = $playlist_data;
    $query_playlists->close();
    $con->close();
    echo json_encode($data);