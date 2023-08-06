<?php
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    $patron = $_GET["patron"];
    $patron_formateado = '%'.$patron.'%';
    $busqueda_grupos = $conexion->prepare("SELECT id, nombre, foto_avatar, discografica from grupo where activo = 1 and nombre like ?");
    $busqueda_grupos->bind_param('s', $patron_formateado);
    $busqueda_grupos->execute();
    $resultado_grupos = $busqueda_grupos->get_result();
    $coincidencias_grupo = [];

    while($fila = $resultado_grupos->fetch_assoc()){
        $coincidencias_grupo[] = $fila;
    }
    $datos["grupos"] = $coincidencias_grupo;
    $busqueda_grupos->close();

    $busqueda_albumes = $conexion->prepare("SELECT a.id id, a.foto foto, titulo, g.nombre grupo from album a, grupo g where a.grupo = g.id and a.activo = 1 and a.titulo like ?");
    $busqueda_albumes->bind_param('s', $patron_formateado);
    $busqueda_albumes->execute();
    $resultado_albumes = $busqueda_albumes->get_result();
    $coincidencias_albumes = [];

    while($fila = $resultado_albumes->fetch_assoc()){
        $coincidencias_albumes[] = $fila;
    }
    $datos["albumes"] = $coincidencias_albumes;
    $busqueda_albumes->close();

    $busqueda_canciones = $conexion->prepare("SELECT c.id id, archivo, c.titulo titulo, a.foto caratula, g.nombre autor from cancion c, album a, incluye i, grupo g where c.id = i.cancion and a.id = i.album and g.id = a.grupo and a.activo = 1 and c.titulo like ?");
    $busqueda_canciones->bind_param('s', $patron_formateado);
    $busqueda_canciones->execute();
    $resultado_canciones = $busqueda_canciones->get_result();
    $coincidencias_canciones = [];

    while($fila = $resultado_canciones->fetch_assoc()){
        $coincidencias_canciones[] = $fila;
    }
    $datos["canciones"] = $coincidencias_canciones;
    $busqueda_canciones->close();
    $conexion->close();

    echo json_encode($datos);
