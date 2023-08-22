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

    $id_album = $_GET["id"];

    $query_user = $con->prepare("SELECT id from user where username = ?");
    $query_user->bind_param('s', $user);
    $query_user->bind_result($user_id);
    $query_user->execute();
    $query_user->fetch();
    $query_user->close();

    $delete = $con->prepare("DELETE FROM favorite where album = ? and user = ?");
    $delete->bind_param('ii', $id_album, $user_id);
    $delete->execute();
    $delete->close();
    
    $con->close();