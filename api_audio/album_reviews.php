<?php
    session_start();
    $usuario = $_SESSION["user"];
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    // sleep(1.5);
    $id = $_GET["id"];
    $sentencia_datos_album = $conexion->query("select titulo, a.foto foto, nombre autor, lanzamiento, g.foto_avatar avatar, g.id id_grupo from album a, grupo g where a.grupo = g.id and a.id = $id");
    $datos_album = [];
    
    while($fila = $sentencia_datos_album->fetch_array(MYSQLI_ASSOC)){
        $datos_album[] = $fila;
    }
    $datos['datos_album'] = $datos_album;

    $usuario_reseña_escrita = $conexion->query("SELECT count(*) comprobante from reseña r, usuario u where r.usuario = u.id and u.usuario = '$usuario' and r.album = $id");
    $fila = $usuario_reseña_escrita->fetch_array(MYSQLI_ASSOC);
    $reseña_usuario[] = $fila;
    $datos["reseña_escrita"] = $reseña_usuario;

    $sentencia_reseñas = $conexion->query("select titulo, contenido, fecha, u.usuario autor, u.foto_avatar foto from reseña r, usuario u where r.usuario = u.id and r.album = $id order by fecha desc");
    $datos_reseña = [];
    
    while($fila = $sentencia_reseñas->fetch_array(MYSQLI_ASSOC)){
        $datos_reseña[] = $fila;
    }
    $datos['reseñas'] = $datos_reseña;


    echo json_encode($datos);
    $conexion->close();