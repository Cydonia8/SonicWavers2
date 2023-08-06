<?php
    
    header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    // sleep(1);
    
    $contexto = $_GET["contexto"];
    $id = $_GET["id"];
    if($contexto == "album"){
        $sentencia_lista = $conexion->query("select a.id album_id, archivo, g.nombre autor, a.foto caratula, c.titulo titulo, c.id cancion_id from cancion c, incluye i, album a, grupo g where i.cancion = c.id and a.id = i.album and a.grupo = g.id and i.album = $id");
        $datos_lista = [];
        
        while($fila = $sentencia_lista->fetch_array(MYSQLI_ASSOC)){
            $datos_lista[] = $fila;
        }
        $datos['lista_canciones'] = $datos_lista;
    }else{
        $sentencia_lista = $conexion->query("select a.id album_id, archivo, g.nombre autor, a.foto caratula, c.titulo titulo, c.id cancion_id from cancion c, contiene co, album a, grupo g, incluye i where co.cancion = c.id and a.id = i.album and a.grupo = g.id and i.cancion = c.id and co.lista = $id and a.activo = 1 group by c.id order by orden asc");
        $datos_lista = [];

        while($fila = $sentencia_lista->fetch_array(MYSQLI_ASSOC)){
            $datos_lista[] = $fila;
        }
        $datos["lista_canciones"] = $datos_lista;
    }
    

    echo json_encode($datos);
    $conexion->close();