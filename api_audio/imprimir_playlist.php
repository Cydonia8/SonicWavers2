<?php
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    $id = $_GET["id"];

    $consulta_lista_datos = $conexion->prepare("SELECT l.nombre nombre, foto, fecha_creacion, u.usuario autor, foto_avatar from lista l, usuario u where u.id = l.usuario and l.id = ?");
    $consulta_lista_datos->bind_param('i', $id);
    $consulta_lista_datos->execute();
    $resultado_datos = $consulta_lista_datos->get_result();

    $datos_lista = [];

    while($fila = $resultado_datos->fetch_assoc()){
        $datos_lista[] = $fila;
    }

    $datos["datos_lista"] = $datos_lista;
    $consulta_lista_datos->close();

    $consulta_canciones_lista = $conexion->prepare("SELECT distinct a.id album, c.titulo titulo, duracion, c.id id, archivo, g.nombre autor from grupo g, cancion c, contiene co, album a, incluye i where c.id = co.cancion and a.id = i.album and i.cancion = co.cancion and a.activo = 1 and g.id = a.grupo and co.lista = ? group by c.id order by orden asc");
    $consulta_canciones_lista->bind_param('i', $id);
    $consulta_canciones_lista->execute();
    $resultado_lista_canciones = $consulta_canciones_lista->get_result();

    $datos_canciones = [];
    
    while($fila = $resultado_lista_canciones->fetch_assoc()){
        $datos_canciones[] = $fila;
    }

    $datos["datos_canciones"] = $datos_canciones;

    echo json_encode($datos);