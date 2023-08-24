<?php
    require_once "../php_functions/general.php";
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $con = createConnection();
    sleep(1.5);

    $id_recommended_artist = $con->query("SELECT id from artist where id <> 0 and image is not null and active = 1 order by rand() limit 1");
    $row = $id_recommended_artist->fetch_array(MYSQLI_ASSOC);
    $id = $row["id"];
    $query_recommended_group = $con->prepare("SELECT link, name, g.id from artist_photos f, artist g where f.artist = g.id and artist = ? order by rand() limit 1");
    $query_recommended_group->bind_param('i', $id);
    $query_recommended_group->bind_result($image, $name, $id);
    $query_recommended_group->execute();
    $query_recommended_group->store_result();
    $query_recommended_group->fetch();
    
    
    if($query_recommended_group->num_rows != 0){
        $query_recommended_group->close();
        $data["artist"] = $image;
        $data["id_recommended_artist"] = $id;
        $data["name"] = $name;
    }else{
        $query_recommended_group->close();
        $query_recommended_group_v2 = $con->prepare("SELECT name, image, id from artist where id = ? and image is not null");
        $query_recommended_group_v2->bind_param('i', $id);
        $query_recommended_group_v2->bind_result($name, $recommended, $artist);
        $query_recommended_group_v2->execute();
        $query_recommended_group_v2->fetch();
        $query_recommended_group_v2->close();
        $data["artist"] = $recommended;
        $data["id_recommended_artist"] = $artist;
        $data["name"] = $name;
    }
    

    // $recomendado=$sentencia_grupo_recomendado->get_result()->fetch_row()[0];
    

    // $query_recommended_group_v2 = $con->prepare("SELECT foto from grupo where id = '19' and foto <> null");
    // // $query_recommended_group_v2->bind_param('i', $id);
    // $query_recommended_group_v2->execute();
    // $recomendado = $query_recommended_group_v2->get_result()->fetch_row()[0];
    // $query_recommended_group_v2->close();
    
    // $datos["grupo_recomendado"] = $recomendado;
    
    $retrieved_data = [];
    $query_albums = $con->query("select a.id id, title, a.picture picture, name author, g.id artist_id from album a, artist g where a.artist = g.id and a.active = 1 order by rand() limit 8");
    while($row = $query_albums->fetch_array(MYSQLI_ASSOC)){
        $retrieved_data[] = $row;
    }
    $data['data'] = $retrieved_data;

    $retrieved_artists = [];
    $query_artists = $con->query("SELECT name, avatar, id from artist where active = 1 and id <> 0 order by rand() limit 8");
    while($row = $query_artists->fetch_array(MYSQLI_ASSOC)){
        $retrieved_artists[] = $row;
    }

    $data["artists"] = $retrieved_artists;

    $query_style = $con->query("SELECT name from styles where id <> 0 order by rand() limit 1");
    $row = $query_style->fetch_array(MYSQLI_ASSOC);
    $random_style1 = $row["name"];

    $data["random_style1"] = $random_style1;

    $query_albums_style_r1 = $con->prepare("SELECT a.id id, a.title title, a.picture picture, g.name author, g.id artist_id FROM album a, songs c, styles e, album_contains i, artist g where a.id = i.album and c.id = i.song and e.id = c.style and a.artist = g.id and e.name = ? and a.active = 1 GROUP BY a.id, a.title HAVING COUNT(*) >= 4 limit 8");
    $query_albums_style_r1->bind_param('s', $random_style1);

    $query_albums_style_r1->execute();
    $result = $query_albums_style_r1->get_result();
    $albums_style_r1 = [];

    while($row = $result->fetch_assoc()){
        $albums_style_r1[] = $row;
    }   

    $data["albums_style_r1"] = $albums_style_r1;
    $query_albums_style_r1->close();

    $current_date = date('Y-m-d');
    $pubs_random = [];
    $query_random_posts = $con->query("SELECT p.id , content, title, p.image image, p_date, g.name artist from posts p, artist g where g.id = p.artist and g.active = 1 and p.p_date <= '$current_date' order by rand () limit 4");
    while($row = $query_random_posts->fetch_array(MYSQLI_ASSOC)){
        $pubs_random[] = $row;
    }
    $data["random_posts"] = $pubs_random;

    echo json_encode($data);
    $con->close();