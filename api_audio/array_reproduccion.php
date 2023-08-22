<?php
    
    header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
    $con = createConnection();
    // sleep(1);
    
    $context = $_GET["contexto"];
    $id = $_GET["id"];
    if($context == "album"){
        $query_playlist = $con->query("select a.id album_id, file, g.name author, a.picture picture, c.title title, c.id song_id from songs c, album_contains i, album a, artist g where i.song = c.id and a.id = i.album and a.artist = g.id and i.album = $id");
        $playlist_data = [];
        
        while($row = $query_playlist->fetch_array(MYSQLI_ASSOC)){
            $playlist_data[] = $row;
        }
        $data['songlist'] = $playlist_data;
    }else{
        $query_playlist = $con->query("select a.id album_id, file, g.name author, a.picture picture, c.title title, c.id song_id from songs c, playlist_includes co, album a, artist g, album_contains i where co.song = c.id and a.id = i.album and a.artist = g.id and i.song = c.id and co.playlist = $id and a.active = 1 group by c.id order by order asc");
        $playlist_data = [];

        while($row = $query_playlist->fetch_array(MYSQLI_ASSOC)){
            $playlist_data[] = $row;
        }
        $data["songlist"] = $playlist_data;
    }
    

    echo json_encode($data);
    $con->close();