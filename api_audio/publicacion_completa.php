<?php
require_once "../php_functions/general.php";
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $con = createConnection();
    $id = $_GET["id"];

    $query_post = $con->query("SELECT title, content, image, p_date, artist from posts where id = $id");
    $post_data = [];
    while($row = $query_post->fetch_array(MYSQLI_ASSOC)){
        $post_data[] = $row;
    }
    $data["post_data"] = $post_data;

    //Revisar foto_publicacion tabla
    $query_extra_photos = $con->query("SELECT link from post_photos where posts = $id");
    $extra_photos = [];
    if($query_extra_photos->num_rows > 0){
        while($row = $query_extra_photos->fetch_array(MYSQLI_ASSOC)){
            $extra_photos[] = $row;
        }
        $data["extra_photos"] = $extra_photos;
    }
    
    echo json_encode($data);
