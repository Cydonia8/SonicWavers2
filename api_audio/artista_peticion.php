<?php
    
    header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
    $con = new mysqli('localhost', 'root', '', 'sonicwaves');
    // sleep(1);
    $id = $_GET["id"];
    $query_artist = $con->query("select name, image, avatar, bio from grupo where id = $id");
    $artist_data = [];
    
    while($row = $query_artist->fetch_array(MYSQLI_ASSOC)){
        $artist_data[] = $row;
    }
    $data['artist_data'] = $artist_data;

    // $consulta_canciones = $con->query("select titulo, duracion, archivo from cancion c, incluye i where c.id = i.cancion and i.album = $id");
    // $datos_canciones = [];
    // while($row = $consulta_canciones->fetch_array(MYSQLI_ASSOC)){
    //     $datos_canciones[] = $row;
    // }
    // $datos["lista_canciones"] = $datos_canciones;

    $query_artist_albums = $con->query("SELECT title, picture, id from album where active = 1 and artist = $id");
    $album_data = [];

    while($row = $query_artist_albums->fetch_array(MYSQLI_ASSOC)){
        $album_data[] = $row;
    }
    $data["artist_albums"] = $album_data;

        $query_posts = $con->query("SELECT id, content, title, image, p_date from posts where artist = $id");
        $posts_data = [];

        while($row = $query_posts->fetch_array(MYSQLI_ASSOC)){
            $posts_data[] = $row;
        }
        $data["artist_posts"] = $posts_data;


    echo json_encode($data);
    $con->close();