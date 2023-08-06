<?php
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $con = new mysqli('localhost', 'root', '', 'sonicwaves');
    $id = $_GET["id"];

    $consulta_publicacion = $con->query("SELECT titulo, contenido, foto, fecha, grupo from publicacion where id = $id");
    $datos_publicacion = [];
    while($fila = $consulta_publicacion->fetch_array(MYSQLI_ASSOC)){
        $datos_publicacion[] = $fila;
    }
    $datos["datos_publicacion"] = $datos_publicacion;

    $consulta_fotos_extra = $con->query("SELECT enlace from foto_publicacion where publicacion = $id");
    $fotos_extra = [];
    if($consulta_fotos_extra->num_rows > 0){
        while($fila = $consulta_fotos_extra->fetch_array(MYSQLI_ASSOC)){
            $fotos_extra[] = $fila;
        }
        $datos["fotos_extra"] = $fotos_extra;
    }
    
    echo json_encode($datos);
