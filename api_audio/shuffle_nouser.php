<?php
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');

    $consulta_aleatorio = $conexion->query("select a.id album_id, archivo, g.nombre autor, a.foto caratula, c.titulo titulo, c.id cancion_id from cancion c, incluye i, album a, grupo g where i.cancion = c.id and a.id = i.album and a.grupo = g.id and a.activo = 1 order by c.times_played desc");
    $datos_lista = [];

    while($fila = $consulta_aleatorio->fetch_array(MYSQLI_ASSOC)){
        $datos_lista[] = $fila;
    }
    $datos["lista_aleatorio"] = $datos_lista;

    $conexion->close();
    echo json_encode($datos);