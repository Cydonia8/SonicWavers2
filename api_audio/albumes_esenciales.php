<?php
    require_once "../php_functions/login_register_functions.php";
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);
    $user = $decoded["data"]["user"];
    // sleep(1.4);

    $usuario_consulta = $conexion->prepare("SELECT id from usuario where usuario = ?");
    $usuario_consulta->bind_param('s', $user);
    $usuario_consulta->bind_result($user_id);
    $usuario_consulta->execute();
    $usuario_consulta->fetch();
    $usuario_consulta->close();

    $consulta_albumes = $conexion->query("SELECT a.id id, a.foto foto, titulo, g.nombre autor from album a, grupo g, favorito f where a.activo = 1 and f.album = a.id and a.grupo = g.id and f.usuario = $user_id");
    $datos_albumes = [];

    while($fila = $consulta_albumes->fetch_array(MYSQLI_ASSOC)){
        $datos_albumes[] = $fila;
    }
    $datos["albumes"] = $datos_albumes;

    $conexion->close();
    echo json_encode($datos);