<?php
    session_start();
    header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    sleep(1.5);
    $id = $_GET["id"];
    $sentencia = $conexion->query("select titulo, a.foto foto, g.nombre autor, lanzamiento, g.foto_avatar avatar, g.id id_grupo, d.nombre discografica, d.foto_avatar foto_discografica from album a, grupo g, discografica d where g.discografica = d.id and a.grupo = g.id and a.id = $id");
    $datos_album = [];
    
    while($fila = $sentencia->fetch_array(MYSQLI_ASSOC)){
        $datos_album[] = $fila;
    }
    $datos['datos_album'] = $datos_album;

    $sentencia_usuario = $conexion->prepare("SELECT id from usuario where usuario = ?");
    $sentencia_usuario->bind_param('s', $_SESSION["user"]);
    $sentencia_usuario->bind_result($id_usuario);
    $sentencia_usuario->execute();
    $sentencia_usuario->fetch();
    $sentencia_usuario->close();

    $sentencia_favorito = $conexion->prepare("select count(*) from favorito where album = ? and usuario = ?");
    $sentencia_favorito->bind_param('ii', $id, $id_usuario);
    $sentencia_favorito->bind_result($favorito);
    $sentencia_favorito->execute();
    $sentencia_favorito->fetch();
    $sentencia_favorito->close();

    $datos["favorito"] = $favorito;

    $consulta_total_canciones = $conexion->prepare("SELECT count(*) from incluye where album = ?");
    $consulta_total_canciones->bind_param('i', $id);
    $consulta_total_canciones->bind_result($total_canciones);
    $consulta_total_canciones->execute();
    $consulta_total_canciones->fetch();
    $consulta_total_canciones->close();

    $datos["canciones_totales"] = $total_canciones;

    $consulta_canciones = $conexion->query("select i.album album, titulo, duracion, archivo, e.nombre estilo, c.id id from cancion c, incluye i, estilo e where c.id = i.cancion and e.id = c.estilo and i.album = $id");
    $datos_canciones = [];
    while($fila = $consulta_canciones->fetch_array(MYSQLI_ASSOC)){
        $datos_canciones[] = $fila;
    }
    $datos["lista_canciones"] = $datos_canciones;

    echo json_encode($datos);
    $conexion->close();