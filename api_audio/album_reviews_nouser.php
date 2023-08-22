<?php
    require_once "../php_functions/general.php";
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $con = createConnection();
    // sleep(1.5);
    $id = $_GET["id"];
    $album_data_query = $con->query("select title, a.picture picture, name author, release_date, g.avatar avatar, g.id artist_id from album a, artist g where a.artist = g.id and a.id = $id");
    $album_data = [];
    
    while($row = $album_data_query->fetch_array(MYSQLI_ASSOC)){
        $album_data[] = $row;
    }
    $data['album_data'] = $album_data;

    $reviews_query = $con->query("select title, content, r_date, u.username author, u.avatar avatar from review r, user u where r.user = u.id and r.album = $id order by r_date desc");
    $reviews_data = [];
    
    while($row = $reviews_query->fetch_array(MYSQLI_ASSOC)){
        $reviews_data[] = $row;
    }
    $data['reviews'] = $reviews_data;


    echo json_encode($data);
    $con->close();