<?php
    require_once "../php_functions/login_register_functions.php";
    require_once "../php_functions/general.php";
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);
    $user = $decoded["data"]["user"];

    if(isset($_REQUEST["contenido"]) and isset($_REQUEST["titulo"]) and isset($_REQUEST["id-album"])){
        $title = $_REQUEST["titulo"];
        $content = $_REQUEST["contenido"];
        $album = $_REQUEST["id-album"];
        $con = createConnection();
        $query = $con->prepare("SELECT id from user where username = ?");
        $query->bind_param('s', $user);
        $query->bind_result($user_id);
        $query->execute();
        $query->fetch();
        $query->close();

        $date = date('Y-m-d');
        $insert = $con->prepare("INSERT INTO review (title, content, user, album, r_date) values (?,?,?,?,?)");
        $insert->bind_param('ssiis', $title, $content, $user_id, $album, $date);
        $insert->execute();
        $insert->close();
        $con->close();
    }
    
