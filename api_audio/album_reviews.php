<?php
    require_once "../php_functions/login_register_functions.php";
    session_start();
    
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $con = createConnection();

    $decoded = decodeToken($_SESSION["token"]);
    $decoded = json_decode(json_encode($decoded), true);
    $user = $decoded["data"]["user"];
    
    $id = $_GET["id"];
    $query_album_data = $con->query("select title, a.picture picture, name author, release_date, g.avatar avatar, g.id artist_d from album a, artist g where a.artist = g.id and a.id = $id");
    $album_data = [];
    
    while($row = $query_album_data->fetch_array(MYSQLI_ASSOC)){
        $album_data[] = $row;
    }
    $data['album_data'] = $album_data;

    $query_user_wrote_review = $con->query("SELECT count(*) checker from review r, user u where r.user = u.id and u.username = '$user' and r.album = $id");
    $row = $query_user_wrote_review->fetch_array(MYSQLI_ASSOC);
    $user_review[] = $row;
    $data["has_wrote_review"] = $user_review;

    $query_reviews = $con->query("select title, content, r_date, u.username author, u.avatar avatar from review r, user u where r.user = u.id and r.album = $id order by r_date desc");
    $review_data = [];
    
    while($row = $query_reviews->fetch_array(MYSQLI_ASSOC)){
        $review_data[] = $row;
    }
    $data['reviews'] = $review_data;


    echo json_encode($data);
    $con->close();