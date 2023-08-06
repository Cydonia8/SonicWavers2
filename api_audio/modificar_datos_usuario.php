<?php
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin:*");
    $con = new mysqli('localhost', 'root', '', 'sonicwaves');
    $consulta_correo_actual = $con->prepare("SELECT correo from usuario where usuario = ?");
    $consulta_correo_actual->bind_param('s', $_SESSION["user"]);
    $consulta_correo_actual->bind_result($correo_actual);
    $consulta_correo_actual->execute();
    $consulta_correo_actual->fetch();
    $consulta_correo_actual->close();

    if(isset($_REQUEST["nombre"]) and isset($_REQUEST["apellidos"]) and isset($_REQUEST["correo"]) and isset($_REQUEST["pass"]) and isset($_REQUEST["estilo"])){
        $nombre = $_REQUEST["nombre"];
        $apellidos = $_REQUEST["apellidos"];
        $correo = $_REQUEST["correo"];
        $pass = $_REQUEST["pass"];
        $estilo = $_REQUEST["estilo"];

        $correo_repetido = $con->prepare("SELECT count(*) from usuario where correo = ? and ?<>?");
        $correo_repetido->bind_param('sss', $correo, $correo_actual, $correo);
        $correo_repetido->bind_result($repetido);
        $correo_repetido->execute();
        $correo_repetido->fetch();
        $correo_repetido->close();

        if($repetido == 0){
            $update = $con->prepare("UPDATE usuario set nombre = ?, apellidos = ?, correo = ?, pass = ?, estilo = ? where usuario = ?");
            $update->bind_param('ssssis', $nombre, $apellidos, $correo, $pass, $estilo, $_SESSION["user"]);
            $update->execute();
            $update->close();
        }else{
            http_response_code(409);
        }
        $con->close();
        
    }