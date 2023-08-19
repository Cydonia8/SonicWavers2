<?php
    require_once "../php_functions/login_register_functions.php";
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);
    $user = $decoded["data"]["user"];

    $consulta_estilo = $conexion->prepare("SELECT estilo from usuario where usuario = ?");
    $consulta_estilo->bind_param('s', $user);
    $consulta_estilo->bind_result($estilo);
    $consulta_estilo->execute();
    $consulta_estilo->fetch();
    $consulta_estilo->close();

    $consulta_aleatorio = $conexion->query("select a.id album_id, archivo, g.nombre autor, a.foto caratula, c.titulo titulo, c.id cancion_id from cancion c, incluye i, album a, grupo g where i.cancion = c.id and a.id = i.album and a.grupo = g.id and c.estilo = $estilo and a.activo = 1 order by rand()");
    $datos_lista = [];

    while($fila = $consulta_aleatorio->fetch_array(MYSQLI_ASSOC)){
        $datos_lista[] = $fila;
    }
    $datos["lista_aleatorio"] = $datos_lista;

    $conexion->close();
    echo json_encode($datos);