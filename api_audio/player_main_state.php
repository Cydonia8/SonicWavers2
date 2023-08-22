<?php
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $con = createConnection();
    sleep(1.5);

    $id_recommended_artist = $con->query("SELECT id from artist where id <> 0 and image is not null and active = 1 order by rand() limit 1");
    $row = $id_recommended_artist->fetch_array(MYSQLI_ASSOC);
    $id = $row["id"];
    $query_recommended_group = $con->prepare("SELECT enlace, grupo, nombre from foto_grupo f, grupo g where f.grupo = g.id and grupo = ? order by rand() limit 1");
    $query_recommended_group->bind_param('i', $id);
    $query_recommended_group->bind_result($recomendado, $grupo, $nombre);
    $query_recommended_group->execute();
    $query_recommended_group->store_result();
    $query_recommended_group->fetch();
    
    
    if($query_recommended_group->num_rows != 0){
        $query_recommended_group->close();
        $datos["grupo_recomendado"] = $recomendado;
        $datos["id_recommended_artist"] = $grupo;
        $datos["nombre_grupo_recomendado"] = $nombre;
    }else{
        $query_recommended_group->close();
        $query_recommended_group_v2 = $con->prepare("SELECT nombre, foto, id from grupo where id = ? and foto is not null");
        $query_recommended_group_v2->bind_param('i', $id);
        $query_recommended_group_v2->bind_result($nombre, $recomendado, $grupo);
        $query_recommended_group_v2->execute();
        $query_recommended_group_v2->fetch();
        $query_recommended_group_v2->close();
        $datos["grupo_recomendado"] = $recomendado;
        $datos["id_recommended_artist"] = $grupo;
        $datos["nombre_grupo_recomendado"] = $nombre;
    }
    

    // $recomendado=$sentencia_grupo_recomendado->get_result()->fetch_row()[0];
    

    // $query_recommended_group_v2 = $con->prepare("SELECT foto from grupo where id = '19' and foto <> null");
    // // $query_recommended_group_v2->bind_param('i', $id);
    // $query_recommended_group_v2->execute();
    // $recomendado = $query_recommended_group_v2->get_result()->fetch_row()[0];
    // $query_recommended_group_v2->close();
    
    // $datos["grupo_recomendado"] = $recomendado;
    
    $datos_recogidos = [];
    $sentencia_albumes = $con->query("select a.id id, titulo, a.foto foto, nombre autor, g.id grupo_id from album a, grupo g where a.grupo = g.id and a.activo = 1 order by rand() limit 8");
    while($row = $sentencia_albumes->fetch_array(MYSQLI_ASSOC)){
        $datos_recogidos[] = $row;
    }
    $datos['datos'] = $datos_recogidos;

    $artistas_recogidos = [];
    $sentencia_artistas = $con->query("SELECT nombre, foto_avatar, id from grupo where activo = 1 and id <> 0 order by rand() limit 8");
    while($row = $sentencia_artistas->fetch_array(MYSQLI_ASSOC)){
        $artistas_recogidos[] = $row;
    }

    $datos["artistas"] = $artistas_recogidos;

    $select_estilo = $con->query("SELECT nombre from estilo where id <> 0 order by rand() limit 1");
    $row = $select_estilo->fetch_array(MYSQLI_ASSOC);
    $estilo_rand1 = $row["nombre"];

    $datos["estilo_random1"] = $estilo_rand1;

    $consulta_albums_estilo_r1 = $con->prepare("SELECT a.id id, a.titulo titulo, a.foto foto, g.nombre autor, g.id grupo_id FROM album a, cancion c, estilo e, incluye i, grupo g where a.id = i.album and c.id = i.cancion and e.id = c.estilo and a.grupo = g.id and e.nombre = ? and a.activo = 1 GROUP BY a.id, a.titulo HAVING COUNT(*) >= 4 limit 8");
    $consulta_albums_estilo_r1->bind_param('s', $estilo_rand1);

    $consulta_albums_estilo_r1->execute();
    $resultado = $consulta_albums_estilo_r1->get_result();
    $albums_estilo_r1 = [];

    while($row = $resultado->fetch_assoc()){
        $albums_estilo_r1[] = $row;
    }   

    $datos["albums_estilo_r1"] = $albums_estilo_r1;
    $consulta_albums_estilo_r1->close();

    $fecha_actual = date('Y-m-d');
    $pubs_random = [];
    $consulta_publicaciones_random = $con->query("SELECT p.id , contenido, titulo, p.foto foto, fecha, g.nombre grupo from publicacion p, grupo g where g.id = p.grupo and g.activo = 1 and p.fecha <= '$fecha_actual' order by rand () limit 4");
    while($row = $consulta_publicaciones_random->fetch_array(MYSQLI_ASSOC)){
        $pubs_random[] = $row;
    }
    $datos["publicaciones_random"] = $pubs_random;

    echo json_encode($datos);
    $con->close();