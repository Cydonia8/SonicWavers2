<?php
    
    header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
    $con = createConnection();
    sleep(1);
    $query = $con->query("select a.id id, title, a.picture picture, name author from album a, artist g where a.artist = g.id");
    $data = [];
    
    while($row = $query->fetch_array(MYSQLI_ASSOC)){
        $data[] = $row;
    }
    $info['data'] = $data;

    echo json_encode($info);
    $con->close();