<?php
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    $con = createConnection();

    $query = $con->query("select c.title title, file, g.name artist, a.picture picture, c.id song_id from songs c, album a, artist g, album_contains i where c.id = i.song and a.id = i.album and g.id = a.artist order by rand() limit 1");
    $data = [];
    
    while($row = $query->fetch_array(MYSQLI_ASSOC)){
        $data[] = $row;
    }
    $info['data'] = $data;
    

    echo json_encode($info);
    $con->close();