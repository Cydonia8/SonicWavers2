<?php
    require_once "../php_functions/login_register_functions.php";
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin:*");

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);

    $user = $decoded["data"]["user"];

    $con = new mysqli('localhost', 'root', '', 'sonicwaves');

    $id_msg = $_GET["id"];

    $query_id_user = $con->prepare("SELECT id from usuario where usuario = ?");
    $query_id_user->bind_param('s', $user);
    $query_id_user->bind_result($id_user);
    $query_id_user->execute();
    $query_id_user->fetch();
    $query_id_user->close();

    $query = $con->prepare("UPDATE member_receives_message set estado = 1 where mensaje = ? and usuario  = ?");
    $query->bind_param('ii', $id_msg, $id_user);
    $query->execute();
    $query->close();

    $con->close();
?>