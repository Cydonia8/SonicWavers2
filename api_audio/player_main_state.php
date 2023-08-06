<?php
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    sleep(1.5);

    $id_grupo_recomendado = $conexion->query("SELECT id from grupo where id <> 0 and foto is not null and activo = 1 order by rand() limit 1");
    $fila = $id_grupo_recomendado->fetch_array(MYSQLI_ASSOC);
    $id = $fila["id"];
    $sentencia_grupo_recomendado = $conexion->prepare("SELECT enlace, grupo, nombre, discografica from foto_grupo f, grupo g where f.grupo = g.id and grupo = ? order by rand() limit 1");
    $sentencia_grupo_recomendado->bind_param('i', $id);
    $sentencia_grupo_recomendado->bind_result($recomendado, $grupo, $nombre, $disc);
    $sentencia_grupo_recomendado->execute();
    $sentencia_grupo_recomendado->store_result();
    $sentencia_grupo_recomendado->fetch();
    
    
    if($sentencia_grupo_recomendado->num_rows != 0){
        $sentencia_grupo_recomendado->close();
        $datos["grupo_recomendado"] = $recomendado;
        $datos["id_grupo_recomendado"] = $grupo;
        $datos["nombre_grupo_recomendado"] = $nombre;
        $datos["discografica"] = $disc;
    }else{
        $sentencia_grupo_recomendado->close();
        $sentencia_grupo_recomendado_v2 = $conexion->prepare("SELECT nombre, foto, id, discografica from grupo where id = ? and foto is not null");
        $sentencia_grupo_recomendado_v2->bind_param('i', $id);
        $sentencia_grupo_recomendado_v2->bind_result($nombre, $recomendado, $grupo, $disc);
        $sentencia_grupo_recomendado_v2->execute();
        $sentencia_grupo_recomendado_v2->fetch();
        $sentencia_grupo_recomendado_v2->close();
        $datos["grupo_recomendado"] = $recomendado;
        $datos["id_grupo_recomendado"] = $grupo;
        $datos["nombre_grupo_recomendado"] = $nombre;
        $datos["discografica"] = $disc;
    }
    

    // $recomendado=$sentencia_grupo_recomendado->get_result()->fetch_row()[0];
    

    // $sentencia_grupo_recomendado_v2 = $conexion->prepare("SELECT foto from grupo where id = '19' and foto <> null");
    // // $sentencia_grupo_recomendado_v2->bind_param('i', $id);
    // $sentencia_grupo_recomendado_v2->execute();
    // $recomendado = $sentencia_grupo_recomendado_v2->get_result()->fetch_row()[0];
    // $sentencia_grupo_recomendado_v2->close();
    
    // $datos["grupo_recomendado"] = $recomendado;
    
    $datos_recogidos = [];
    $sentencia_albumes = $conexion->query("select a.id id, titulo, a.foto foto, nombre autor, g.id grupo_id from album a, grupo g where a.grupo = g.id and a.activo = 1 order by rand() limit 8");
    while($fila = $sentencia_albumes->fetch_array(MYSQLI_ASSOC)){
        $datos_recogidos[] = $fila;
    }
    $datos['datos'] = $datos_recogidos;

    $artistas_recogidos = [];
    $sentencia_artistas = $conexion->query("SELECT nombre, foto_avatar, id from grupo where activo = 1 and id <> 0 order by rand() limit 8");
    while($fila = $sentencia_artistas->fetch_array(MYSQLI_ASSOC)){
        $artistas_recogidos[] = $fila;
    }

    $datos["artistas"] = $artistas_recogidos;

    $select_estilo = $conexion->query("SELECT nombre from estilo where id <> 0 order by rand() limit 1");
    $fila = $select_estilo->fetch_array(MYSQLI_ASSOC);
    $estilo_rand1 = $fila["nombre"];

    $datos["estilo_random1"] = $estilo_rand1;

    $consulta_albums_estilo_r1 = $conexion->prepare("SELECT a.id id, a.titulo titulo, a.foto foto, g.nombre autor, g.id grupo_id FROM album a, cancion c, estilo e, incluye i, grupo g where a.id = i.album and c.id = i.cancion and e.id = c.estilo and a.grupo = g.id and e.nombre = ? and a.activo = 1 GROUP BY a.id, a.titulo HAVING COUNT(*) >= 4 limit 8");
    $consulta_albums_estilo_r1->bind_param('s', $estilo_rand1);

    $consulta_albums_estilo_r1->execute();
    $resultado = $consulta_albums_estilo_r1->get_result();
    $albums_estilo_r1 = [];

    while($fila = $resultado->fetch_assoc()){
        $albums_estilo_r1[] = $fila;
    }   

    $datos["albums_estilo_r1"] = $albums_estilo_r1;
    $consulta_albums_estilo_r1->close();

    $fecha_actual = date('Y-m-d');
    $pubs_random = [];
    $consulta_publicaciones_random = $conexion->query("SELECT p.id , contenido, titulo, p.foto foto, fecha, g.nombre grupo from publicacion p, grupo g where g.id = p.grupo and g.activo = 1 and p.fecha <= '$fecha_actual' order by rand () limit 4");
    while($fila = $consulta_publicaciones_random->fetch_array(MYSQLI_ASSOC)){
        $pubs_random[] = $fila;
    }
    $datos["publicaciones_random"] = $pubs_random;

    echo json_encode($datos);
    $conexion->close();