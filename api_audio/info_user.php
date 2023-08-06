<?php
    session_start();
    $usuario = $_SESSION["user"];
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin:*");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    $perfil_completo = $conexion->prepare("SELECT estilo from usuario where id <> 0 and usuario = ?");
    $perfil_completo->bind_param('s', $usuario);
    $perfil_completo->bind_result($comprobante_perfil);
    $perfil_completo->execute();
    $perfil_completo->fetch();
    $perfil_completo->close();

    $datos["perfil_completado"] = $comprobante_perfil;

    $sentencia = $conexion->prepare("select u.pass contraseña, u.foto_avatar foto_avatar, u.nombre nombre, apellidos, usuario, u.correo correo, e.nombre estilo, g.nombre grupo from usuario u, estilo e, grupo g where u.estilo = e.id and u.grupo = g.id and u.usuario = ?");
    $datos_user = [];
    $sentencia->bind_param('s', $usuario);
    $sentencia->execute();
    $resultado = $sentencia->get_result();
    
    while($fila = $resultado->fetch_assoc()){
        $datos_user[] = $fila;
    }
    $datos['datos'] = $datos_user;
    

    echo json_encode($datos);