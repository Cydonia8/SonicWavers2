<?php
    require_once "../php_functions/login_register_functions.php";
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin:*");

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);

    $user = $decoded["data"]["user"];
    $con = new mysqli('localhost', 'root', '', 'sonicwaves');
    $query_profile = $con->prepare("SELECT style from user where id <> 0 and username = ?");
    $query_profile->bind_param('s', $user);
    $query_profile->bind_result($check_profile);
    $query_profile->execute();
    $query_profile->fetch();
    $query_profile->close();

    $data["profile_completed"] = $check_profile;

    $query = $con->prepare("select u.pass pass, u.avatar avatar, u.name name, surname, username, u.mail mail, e.name style, g.name artist from user u, styles e, artist g where u.style = e.id and u.artist = g.id and u.username = ?");
    $user_data = [];
    $query->bind_param('s', $user);
    $query->execute();
    $result = $query->get_result();
    
    while($row = $result->fetch_assoc()){
        $user_data[] = $row;
    }
    $data['data'] = $user_data;
    

    echo json_encode($data);