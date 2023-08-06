<?php
    
    header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    // sleep(1);
    $id = $_GET["id"];
    $sentencia_grupo = $conexion->query("select nombre, foto, foto_avatar, biografia, discografica from grupo where id = $id");
    $datos_grupo = [];
    
    while($fila = $sentencia_grupo->fetch_array(MYSQLI_ASSOC)){
        $datos_grupo[] = $fila;
        $disc = $fila["discografica"];
    }
    $datos['datos_grupo'] = $datos_grupo;

    // $consulta_canciones = $conexion->query("select titulo, duracion, archivo from cancion c, incluye i where c.id = i.cancion and i.album = $id");
    // $datos_canciones = [];
    // while($fila = $consulta_canciones->fetch_array(MYSQLI_ASSOC)){
    //     $datos_canciones[] = $fila;
    // }
    // $datos["lista_canciones"] = $datos_canciones;

    $sentencia_discos_grupo = $conexion->query("SELECT titulo, foto, id from album where activo = 1 and grupo = $id");
    $datos_discos = [];

    while($fila = $sentencia_discos_grupo->fetch_array(MYSQLI_ASSOC)){
        $datos_discos[] = $fila;
    }
    $datos["discos_grupo"] = $datos_discos;

        $sentencia_publicaciones = $conexion->query("SELECT id, contenido, titulo, foto, fecha from publicacion where grupo = $id");
        $datos_publicaciones = [];

        while($fila = $sentencia_publicaciones->fetch_array(MYSQLI_ASSOC)){
            $datos_publicaciones[] = $fila;
        }
        $datos["publicaciones_grupo"] = $datos_publicaciones;


    echo json_encode($datos);
    $conexion->close();