<?php
require_once "../php_functions/general.php";
    session_start();
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $con = createConnection();

    $query_random = $con->query("select a.id album_id, file, g.name author, a.picture picture, c.title title, c.id song_id from songs c, album_contains i, album a, artist g where i.song = c.id and a.id = i.album and a.artist = g.id and a.active = 1 order by c.times_played desc");
    $list_data = [];

    while($row = $query_random->fetch_array(MYSQLI_ASSOC)){
        $list_data[] = $row;
    }
    $data["random_list"] = $list_data;

    $con->close();
    echo json_encode($data);