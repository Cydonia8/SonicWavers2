<?php
    require_once "general.php";

    function menuAdmin(){
        echo "<header class=\"menu-admin border-bottom\">
                <nav class=\"pt-3\">
                    <ul class=\"p-0\">
                        <li><a href=>Usuarios</a></li>
                        <li><a href=>Grupos</a></li>
                        <li><a href=>Mecenas</a></li>
                        <li class=\"li-foto\"><a href=\"../index.php\"><img src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\"></a></li>
                        <li><a href=>Álbumes</a></li>
                        <li><a href=>Reseñas</a></li>
                        <li><a href=\"admin_estilos.php\">Estilos</a></li>
                    </ul>
                </nav>
              </header>";
    }
    function menuAdminDropdown(){
        echo "<header class=\"dropdown-header d-flex justify-content-between align-items-center pt-3 pe-3 pb-2 ps-3 border-bottom\">
                <a class=\"dropdown-link-responsive\" href=\"../index.php\"><img src=\"../media/assets/sonic-waves-logo-simple.png\"></a>
                <a href=\"../index.php\"><img class=\"w-25\" src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\"></a>
                <div class=\"dropdown-admin-disc-group\">
                    <button class=\"btn btn-secondary btn-lg dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                    Menú de administración
                    </button>
                    <ul class=\"dropdown-menu\">
                        <li><a class=\"dropdown-item\" href=\"admin_main.php\">Resumen general</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_users.php\">Usuarios</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_artists.php\">Grupos</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_patrons.php\">Mecenas</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_albums.php\">Álbumes</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_reviews.php\">Reseñas</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_styles.php\">Estilos</a></li>
                        <li><a class=\"dropdown-item\" href=\"admin_posts.php\">Publicaciones</a></li>
                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                    </ul>
                </div>
              </header>";
    }
    
    function adminOverview(){
        $con = createConnection();
        $query_u = $con->query("SELECT count(*) total_u from user where id <> 0");
        $row = $query_u->fetch_array(MYSQLI_ASSOC);
        $total_users = $row["total_u"];

        $query_artists = $con->query("SELECT count(*) total_g from artist where id <> 0");
        $row = $query_artists->fetch_array(MYSQLI_ASSOC);
        $total_artists = $row["total_g"];

        $query_artists_inactive = $con->query("SELECT count(*) total_g_inactive from artist where active <> 1 and id <> 0");
        $row = $query_artists_inactive->fetch_array(MYSQLI_ASSOC);
        $total_artists_inactives = $row["total_g_inactive"];

        $query_albums = $con->query("SELECT count(*) albums from album");
        $row = $query_albums->fetch_array(MYSQLI_ASSOC);
        $total_albumes = $row["albums"];

        $query_albums_inactives = $con->query("SELECT count(*) albums_inactive from album where active = 0");
        $row = $query_albums_inactives->fetch_array(MYSQLI_ASSOC);
        $total_albums_inactives = $row["albums_inactive"];

        $query_patrons = $con->query("SELECT count(*) patrons from patrons where id <> 0");
        $row = $query_patrons->fetch_array(MYSQLI_ASSOC);
        $total_patrons = $row["patrons"];

        $query_patrons_inactives = $con->query("SELECT count(*) patrons_inactive from patrons where id <> 0 and active <> 1");
        $row = $query_patrons_inactives->fetch_array(MYSQLI_ASSOC);
        $total_patrons_inactive = $row["patrons_inactive"];

        $query_reviews = $con->query("SELECT count(*) reviews from review");
        $row = $query_reviews->fetch_array(MYSQLI_ASSOC);
        $total_reviews = $row["reviews"];

        $query_styles = $con->query("SELECT count(*) styles from styles where id <> 0");
        $row = $query_styles->fetch_array(MYSQLI_ASSOC);
        $total_styles = $row["styles"];

        $query_posts = $con->query("SELECT count(*) posts from posts");
        $row = $query_posts->fetch_array(MYSQLI_ASSOC);
        $total_posts = $row["posts"];

        echo "
                <h3>Usuarios registrados: $total_users</h3>
                <h3>Grupos autogestionados: $total_artists</h3>
                <h3>Grupos inactivos: $total_artists_inactives</h3>
                <h3>Álbumes almacenados: $total_albumes</h3>
                <h3>Álbumes inactivos: $total_albums_inactives</h3>
                <h3>Mecenas registrados: $total_patrons</h3>
                <h3>Mecenas inactivos: $total_patrons_inactive</h3>
                <h3>Reseñas totales: $total_reviews</h3>
                <h3>Estilos totales: $total_styles</h3>
                <h3>Publicaciones totales: $total_posts</h3>";
        $con->close();
    }

    function songsPerStyle($id){
        $total = 0;
        $con = createConnection();
        $query = $con->query("SELECT COUNT(*) total_songs
        FROM songs, styles where songs.style = styles.id and styles.id = '$id'
        GROUP BY styles.id");
        $row = $query->fetch_array(MYSQLI_ASSOC);
        if($query->num_rows > 0){
            $total = $row["total_songs"];
        }
        return $total;
    }

    function albumsPerGroup($id){
        $total = 0;
        $con = createConnection();
        $query = $con->query("SELECT COUNT(*) number_albums
        FROM album a, artist g where a.artist = g.id and g.id = '$id'
        GROUP BY g.id");
        $row = $query->fetch_array(MYSQLI_ASSOC);
        if($query->num_rows > 0){
            $total = $row["number_albums"];
        }
        return $total;
    }

    function getAllStyles(){
        $con = createConnection();
        $query = $con->query("SELECT * FROM styles where id <> 0");
        echo "<table id='tabla-estilos-admin' class='w-50 mx-auto'>
                <thead>
                    <th>Nombre</th>
                    <th>Canciones con este estilo</th>
                </thead>
                <tbody>";
        while($row = $query->fetch_array(MYSQLI_ASSOC)){
            $songs_style = songsPerStyle($row["id"]);
            echo "<tr>
                    <td>$row[name]</td>";
                    if($songs_style != ""){
                        echo "<td>$songs_style</td>";
                    }else{
                        echo "<td></td>";
                    }
                echo "</tr>";
        }
        echo "</tbody></table>";
        $con->close();
    }

    function newStyle($name){
        $success = false;
        $con = createConnection();
        $insert = $con->prepare("INSERT INTO styles (name) VALUES (?)");
        $insert->bind_param("s", $name);
        $insert->execute();
        $insert->close();
        $con->close();
    }

    function getAllGroups(){
        $con = createConnection();
        $query = $con->query("SELECT g.id artist_id, g.name artist_name, g.active active_artist, image, g.avatar avatar, g.awaiting_approval approval from artist g, where g.id <> 0 order by g.name asc");
        $rows = $query->num_rows;

        if($rows > 0){
            while($row = $query->fetch_array(MYSQLI_ASSOC)){
                $artist_albums = albumsPerGroup($row["artist_id"]);
                echo "<div data-name=\"$row[artist_name]\" class=\"rounded border grupo-detalle p-3 gap-2 col-12 col-md-3\">
                    <div class=\"w-50\">
                        <img class=\"rounded-circle img-fluid\" src=\"$row[avatar]\">
                    </div>
                    <div class=\"d-flex flex-column justify-content-between\">
                        <p>Nombre: $row[artist_name]</p>";
                        if($artist_albums != ""){
                            echo "<p>Álbumes publicados: $artist_albums</p>";
                        }
                        echo "<p>Gestión: $row[disco]</p>";
                    if($row["approval"] == 1){
                        echo "<div class=\"d-flex gap-3\"><form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$row[artist_id]\">
                                <button style='--clr:#09eb3a' class='btn-danger-own' name='aprobar'><span>Aprobar</span><i></i></button>
                                </form>
                                <form method=\"post\" action=\"#\">
                                    <input hidden name=\"id\" value=\"$row[artist_id]\">
                                    <button style='--clr:#e80c0c' class='btn-danger-own' name='denegar'><span>Denegar</span><i></i></button>
                                </form></div>";
                    }else{
                        if($row["active_artist"] == 0){
                            echo "<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$row[artist_id]\">
                            <button style='--clr:#09eb3a' class='btn-danger-own' name='activar'><span>Activar</span><i></i></button>
                            </form>";
                        }elseif($row["active_artist"] == 1){
                            echo "<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$row[artist_id]\">
                            <button style='--clr:#e80c0c' class='btn-danger-own' name='desactivar'><span>Desactivar</span><i></i></button>
                            </form>";
                        }else{
                            echo "<div class=\"alert alert-danger\" role=\"alert\">
                            Petición denegada<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$row[artist_id]\">
                            <button style='--clr:#09eb3a' class='btn-danger-own' name='activar'><span>Pulsa para aprobar</span><i></i></button>
                            </form>
                          </div>";
                        }
                    }
                    
                    echo "</div>
                </div>";
            }
        }else{
            echo "<h2 class=\"text-center\">No hay coincidencias</h2>";
        } 
        
    }

    function getGroupsFiltered($filter){
        $con = createConnection();
        $filter = $filter.'%';
        $query = $con->prepare("SELECT g.id artist_id, g.name artist_name, g.active active_artist, g.avatar avatar, g.awaiting_approval approval from artist g where g.id <> 0 and g.name like ? order by g.name asc");
        $query->bind_param('s', $filter);
        $query->bind_result($artist_id, $artist_name, $active_group, $avatar, $approval);
        $query->execute();
        $query->store_result();
        if($query->num_rows>0){
            while($query->fetch()){
                $artist_albums = albumsPerGroup($artist_id);
                echo "<div data-name=\"$artist_name\" class=\"rounded border grupo-detalle p-3 gap-2 col-12 col-md-3 d-flex flex-column flex-xl-row align-items-center\">
                    <div class=\"w-50\">
                        <img class=\"rounded-circle img-fluid\" src=\"$avatar\">
                    </div>
                    <div class=\"d-flex flex-column justify-content-between\">
                        <p>Nombre: <span class='admin-emphasis-span'>$artist_name</span></p>";
                        if($artist_albums != ""){
                            echo "<p>Álbumes publicados: <span class='admin-emphasis-span'>
                            $artist_albums</span></p>";
                        }

                    if($approval == 1){
                        echo "<div class=\"d-flex gap-3\"><form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$artist_id\">
                                <button style='--clr:#09eb3a' class='btn-danger-own' name='aprobar'><span>Aprobar</span><i></i></button>
                                </form>
                                <form method=\"post\" action=\"#\">
                                    <input hidden name=\"id\" value=\"$artist_id\">
                                    
                                    <button style='--clr:#e80c0c' class='btn-danger-own' name='denegar'><span>Denegar</span><i></i></button>
                                </form></div>";
                    }else{
                        if($active_group == 0){
                            echo "<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$artist_id\">
                            <button style='--clr:#09eb3a' class='btn-danger-own' name='activar'><span>Activar</span><i></i></button>
                            </form>";
                        }elseif($active_group == 1){
                            echo "<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$artist_id\">
                            <button style='--clr:#e80c0c' class='btn-danger-own' name='desactivar'><span>Desactivar</span><i></i></button>
                            </form>";
                        }else{
                            echo "<div class=\"alert alert-danger\" role=\"alert\">
                            Petición denegada<form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$artist_id\">
                            <button style='--clr:#09eb3a' class='btn-danger-own' name='activar'><span>Pulsa para aprobar</span><i></i></button>
                            </form>
                          </div>";
                        }
                    }
                    
                    echo "</div>
                </div>";
            }
        }else{
            echo "<h2 class=\"text-center\">No hay coincidencias</h2>";
        }
        $query->close();
        $con->close();
        
    }

    function activatePatron($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE patrons SET active = 1 WHERE id = ?");
        $update->bind_param("i", $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function deactivatePatron($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE patrons SET active = 0 WHERE id = ?");
        $update->bind_param("i", $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function deactivateAlbum($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE album SET active = 0 WHERE id = ?");
        $update->bind_param("i", $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function activateAlbum($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE album SET active = 1 WHERE id = ?");
        $update->bind_param("i", $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function activateGroup($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE artist SET active = 1 WHERE id = ?");
        $update->bind_param("i", $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function deactivateGroup($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE artist SET active = 0 WHERE id = ?");
        $update->bind_param("i", $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function getPatrons($filter){
        $con = createConnection();
        $filter = $filter.'%';
        $query = $con->prepare("SELECT id, name, mail, avatar, active, awaiting_activation await FROM patrons where id <> 0 and name like ? order by name asc");
        $query->bind_param('s', $filter);
        $query->bind_result($id, $name, $mail, $avatar, $active, $await);
        $query->execute();
        $query->store_result();
        if($query->num_rows() > 0){
            while($query->fetch()){
                // $total_grupos = groupsPerRecordLabel($id);
                echo "<div data-name=\"$name\" class=\"rounded border grupo-detalle p-3 gap-2 col-12 col-md-3 d-flex flex-column flex-xl-row align-items-center\">
                        <div class=\"w-50\">
                            <img class=\"img-fluid rounded-circle\" src=\"$avatar\">
                        </div>
                        <div class=\"d-flex flex-column justify-content-between\">
                            <p>Nombre: <span class='admin-emphasis-span'>$name</span></p>
                            <p>Correo: <span class='admin-emphasis-span'>$mail</span></p>
                            <p>Número de grupos gestionados: <span class='admin-emphasis-span'></span></p>";
                        if($await == 1){
                            echo "<div class=\"d-flex gap-3\"><form method=\"post\" action=\"#\">
                            <input hidden name=\"id\" value=\"$id\">
                            <button style='--clr:#09eb3a' class='btn-danger-own' name='approve'><span>Aprobar</span><i></i></button>
                            </form>
                            <form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$id\">
                                <button style='--clr:#e80c0c' class='btn-danger-own' name='deny'><span>Denegar</span><i></i></button>
                            </form></div>";
                        }else{
                            if($active == 0){
                                echo "<form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$id\">
                                <button style='--clr:#09eb3a' class='btn-danger-own' name='activate'><span>Activar</span><i></i></button>
                                </form>";
                            }elseif($active == 1){
                                echo "<form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$id\">
                                <button style='--clr:#e80c0c' class='btn-danger-own' name='deactivate'><span>Desactivar</span><i></i></button>
                                </form>";
                            }else{
                                echo "<div class=\"alert alert-danger\" role=\"alert\">
                                Petición denegada<form method=\"post\" action=\"#\">
                                <input hidden name=\"id\" value=\"$id\">
                                <button style='--clr:#09eb3a' class='btn-danger-own' name='activar'><span>Pulsa para aprobar</span><i></i></button>
                                </form>
                              </div>";
                            }
                        }
                        
                        echo "</div>
                </div>";
            }
        }else{
            echo "<h2 class=\"text-center\">No hay coincidencias</h2>";
        }
        $query->close();
        $con->close();
    }

    function getAllAlbums(){
        $con = createConnection();
        $query = $con->query("SELECT a.id id_album, titulo, a.foto foto_album, a.activo album_activo, lanzamiento, g.nombre nom_grupo from album a, grupo g where g.id = a.grupo order by titulo asc");
        while($row = $query->fetch_array(MYSQLI_ASSOC)){
            $fecha_format = formatDate($row["lanzamiento"]);
            echo "<div data-name=\"$row[titulo]\" class=\"rounded border grupo-detalle p-3 gap-3 col-12 col-xl-3 col-md-4 \">
                <div class=\"w-50\">
                    <img class=\"img-fluid rounded\" src=\"$row[foto_album]\">
                </div>
                <div class=\"d-flex flex-column justify-content-between gap-1\">
                    <p>Título: $row[titulo]</p>
                    <p>Autor: $row[nom_grupo]</p>
                    <p>Lanzado el: $fecha_format</p>";
                if($row["album_activo"] == 0){
                    echo "<form method=\"post\" action=\"#\">
                    <input hidden name=\"id\" value=\"$row[id_album]\">
                    <button style='--clr:#09eb3a' class='btn-danger-own' name='activar'><span>Activar</span><i></i></button>
                    </form>";
                }else{
                    echo "<form method=\"post\" action=\"#\">
                    <input hidden name=\"id\" value=\"$row[id_album]\">
                    <button style='--clr:#e80c0c' class='btn-danger-own' name='desactivar'><span>Desactivar</span><i></i></button>
                    </form>";
                }
                echo "<form method=\"post\" action=\"admin_song_list.php\">
                        <input hidden name=\"id\" value=\"$row[id_album]\">
                        <button style='--clr:#0ce8e8' class='btn-danger-own' name='ver'><span>Ver canciones</span><i></i></button>
                      </form>
                </div>
                </div>";
        }
        $con->close();
    }

    function getAlbumsFiltered($filter){
        $con = createConnection();
        $filter = $filter.'%';
        $query = $con->prepare("SELECT a.id id_album, title, a.picture picture, a.active active, release_date, g.name artist_name from album a, artist g where g.id = a.artist and title like ? order by title asc");
        $query->bind_param('s', $filter);
        $query->bind_result($id_album, $title, $picture, $active, $release_date, $artist_name);
        $query->execute();
        $query->store_result();
        if($query->num_rows() > 0){
            while($query->fetch()){
                $date_format = formatDate($release_date);
                echo "<div data-name=\"$title\" class=\"rounded border grupo-detalle d-flex justify-content-around p-3 gap-3 col-12 col-xl-3 col-md-4 flex-column flex-xl-row align-items-center\">
                    <div class=\"w-50\">
                        <img class=\"img-fluid rounded\" src=\"$picture\">
                    </div>
                    <div class=\"d-flex flex-column justify-content-between gap-1\">
                        <p>Título: <span class='admin-emphasis-span'>$title</span></p>
                        <p>Autor: <span class='admin-emphasis-span'>$artist_name</span></p>
                        <p>Lanzado el: <span class='admin-emphasis-span'>$date_format</span></p>";
                    if($active == 0){
                        echo "<form method=\"post\" action=\"#\">
                        <input hidden name=\"id\" value=\"$id_album\">
                        <button style='--clr:#09eb3a' class='btn-danger-own' name='activar'><span>Activar</span><i></i></button>
                        </form>";
                    }else{
                        echo "<form method=\"post\" action=\"#\">
                        <input hidden name=\"id\" value=\"$id_album\">
                        <button style='--clr:#e80c0c' class='btn-danger-own' name='desactivar'><span>Desactivar</span><i></i></button>
                        </form>";
                    }
                    echo "<form method=\"post\" action=\"admin_song_list.php\">
                            <input hidden name=\"id\" value=\"$id_album\">
                            <button style='--clr:#0ce8e8' class='btn-danger-own' name='ver'><span>Ver canciones</span><i></i></button>
                        </form>
                    </div>
                    </div>";
            }
        }else{
            echo "<h2 class=\"text-center\">No hay coincidencias</h2>";
        }
        $query->close();
        $con->close();
    }

    function getAlbumSongs($id){
        $con = createConnection();
        $query1 = $con->prepare("SELECT a.title album, a.picture picture, g.name artist from album a, artist g where g.id = a.artist and a.id = ?");
        $query1->bind_param('i', $id);
        $query1->bind_result($album, $picture, $artist);
        $query1->execute();
        $query1->fetch();
        echo "<h2 class='text-center'>$artist</h2>
        <div class=\"d-flex gap-5 mt-4\">
                <div class='w-50'>
                <img class=\"img-fluid rounded\" src=\"$picture\">
                </div>";
        $query1->close();
        
        $query2 = $con->prepare("SELECT c.title song, length from album a, album_contains i, songs c where a.id = i.album and c.id = i.song and a.id = ?");
        $query2->bind_param('i', $id);
        $query2->bind_result($song, $length);
        $query2->execute();
        echo "<ul class=\"w-50 admin-album-song-list d-flex flex-column gap-4\">";
        while($query2->fetch()) {
            echo "<li>$song ($length)</li>";
        }
        echo "</ul></div>";
        $query2->close();
        $con->close();
    }

    function getAlbumName($id){
        $con = createConnection();
        $query = $con->prepare("SELECT a.title from album a, artist g where g.id = a.artist and a.id = ?");
        $query->bind_param('i', $id);
        $query->bind_result($name);
        $query->execute();
        $query->fetch();
        $query->close();
        $con->close();
        return $name;
    }


    function getAllUsers($filter){
        $con = createConnection();
        $filter = $filter."%";
        $query = $con->prepare("SELECT u.name name, surname, username, u.avatar avatar, u.mail mail, e.name style, g.name artist FROM user u, artist g, styles e where u.style = e.id and u.artist = g.id and u.id <> 0 and u.username like ?");
        $query->bind_param('s', $filter);
        $query->bind_result($name, $surname, $username, $avatar, $mail, $style, $artist);
        $query->execute();
        $query->store_result();

        if($query->num_rows > 0){
            while($query->fetch()){
                echo "<div data-name=\"$username\" class=\"rounded border grupo-detalle d-flex justify-content-around flex-column flex-xl-row align-items-center p-3 gap-2 col-12 col-md-3\">
                            <div class=\"w-50\">
                                <img class=\"img-fluid rounded-circle\" src=\"$avatar\">
                            </div>
                            <div class=\"d-flex flex-column justify-content-between\">
                                <p>Usuario: <span class='admin-emphasis-span'>$username</span></p>
                                
                                <p>mail: <span class='admin-emphasis-span'>$mail</span></p>";
                            if($style != null){
                                echo "<p>style favorito: <span class='admin-emphasis-span'>$style</span></p>";
                            }else{
                                echo "<p>Sin style favorito</p>";
                            }
                            if($artist != "sin grupo"){
                                echo "<p>Miembro de <span class='admin-emphasis-span'>$artist</span></p>";
                            }else{
                                echo "<p>No es miembro de ningún grupo</p>";
                            }
                            
                            echo "</div>
                    </div>";
            }
        }else{
            echo "<h2 class='text-center'>No hay coincidencias</h2>";
        }
        
        $query->close();
        $con->close();
    }

    function getAllPosts(){
        $con = createConnection();
        $query = $con->query("SELECT p.id id, titulo, contenido, fecha, p.foto foto, g.nombre grupo from publicacion p, grupo g where p.grupo = g.id order by g.nombre asc");
        while($row = $query->fetch_array(MYSQLI_ASSOC)){
            $fecha = formatDate($row["fecha"]);
            echo "<div class='grupo-detalle border rounded p-2 post-container-admin d-flex align-items-center align-items-lg-start justify-content-around gap-3'>
                    <img src='$row[foto]' class='w-50 rounded object-fit-cover'>
                    <div class='d-flex flex-column gap-2'>
                        <p>Título: $row[titulo]</p>
                        <p>Fecha de publicación: $fecha</p>
                        <p>Autor: $row[grupo]</p>
                        <div class='d-flex gap-2 flex-column flex-lg-row'>
                            <form action='admin_full_post.php' method='get'>
                                <input hidden value='$row[id]' name='id'>
                                <button style='--clr:#0ce8e8' class='btn-danger-own' name='ver-mas'><span>Ver más</span><i></i></button>
                            </form>
                            <form action='#' method='post'>
                                <input hidden value='$row[id]' name='id'>
                                <button style='--clr:#e80c0c' class='btn-danger-own' name='borrar'><span>Eliminar</span><i></i></button>
                            </form>
                        </div>
                    </div>
                </div>";
        }
        $con->close();
    }

    function getAllPostsFiltered($filter){
        $con = createConnection();
        $filter = $filter."%";
        $query = $con->prepare("SELECT p.id id, title, content, p_date, p.image image, g.name artist from posts p, artist g where p.artist = g.id and g.name like ?");
        $query->bind_param('s', $filter);
        $query->bind_result($id, $title, $content, $p_date, $image, $artist);
        $query->execute();
        $query->store_result();
        if($query->num_rows>0){
            while($query->fetch()){
                $p_date = formatDate($p_date);
                echo "<div data-name='$artist' class='grupo-detalle border rounded p-3 post-container-admin d-flex align-items-center align-items-lg-start justify-content-around gap-3 flex-column flex-xxl-row'>
                        <img src='$image' class='w-50 rounded'>
                        <div class='d-flex flex-column'>
                            <p>Título: <span class='admin-emphasis-span'>$title</span></p>
                            <p>Fecha de publicación: <span class='admin-emphasis-span'>$p_date</span></p>
                            <p>Autor: <span class='admin-emphasis-span'>$artist</span></p>
                            <div class='d-flex gap-2 flex-column flex-lg-row'>
                            <form action='admin_full_post.php' method='get'>
                                <input hidden value='$id' name='id'>
                                <button style='--clr:#0ce8e8' class='btn-danger-own' name='ver-mas'><span>Ver más</span><i></i></button>
                            </form>
                            <form action='#' method='post'>
                                <input hidden value='$id' name='id'>
                                <button style='--clr:#e80c0c' class='btn-danger-own' name='borrar'><span>Eliminar</span><i></i></button>
                            </form>
                        </div>
                        </div>
                    </div>";
            }
        }else{
            echo "<h2 class=\"text-center\">No hay coincidencias</h2>";
        }
        
        $query->close();
        $con->close();
    }
    function getPostMainPhotoLink($id, $con){
        $query = $con->prepare("SELECT image from posts where id = ?");
        $query->bind_param('i', $id);
        $query->bind_result($image);
        $query->execute();
        $query->fetch();
        $query->close();
        return $image;
    }

    function deletePostExtraPhotosLinks($id, $con){
        $query = $con->prepare("SELECT link from post_photoss where post = ?");
        $query->bind_param('i', $id);
        $query->bind_result($link);
        $query->execute();
        $query->store_result();
        if($query->num_rows > 0){
            while($query->fetch()){
                unlink($link);
            }
        }
        $query->close();
    }

    function deletePost($id){
        $con = createConnection();
        deletePostExtraPhotosLinks($id, $con);
        $delete1 = $con->prepare("DELETE FROM post_photos where post = ?");
        $delete1->bind_param('i', $id);
        $delete1->execute();
        $delete1->close();
        $picture = getPostMainPhotoLink($id, $con);
        $delete2 = $con->prepare("DELETE FROM posts where id = ?");
        $delete2->bind_param('i', $id);
        $delete2->execute();
        $delete2->close();
        $con->close();
        unlink($picture);
    }

    function approveGroupCreation($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE artist set active = 1, awaiting_approval = 0 where id = ?");
        $update->bind_param('i', $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function denyGroupCreation($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE artist set active = 2, awaitin_approval = 0 where id = ?");
        $update->bind_param('i', $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function approvePatronCreation($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE patrons set active = 1, awaiting_activation = 0 where id = ?");
        $update->bind_param('i', $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function denyPatronCreation($id){
        $con = createConnection();
        $update = $con->prepare("UPDATE patrons set active = 2, awaiting_activation = 0 where id = ?");
        $update->bind_param('i', $id);
        $update->execute();
        $update->close();
        $con->close();
    }

    function printFilterForm($filter_type = ""){
        echo "<h3 class=\"text-center mt-4\">Filtro alfabético $filter_type</h3>
        <form action=\"#\" method=\"post\">
            <ul class=\"filter-alphabetic d-flex list-style-none justify-content-center gap-3 flex-wrap mb-3 pe-2 ps-2\">
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"a\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"b\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"c\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"d\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"e\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"f\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"g\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"h\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"i\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"j\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"k\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"l\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"m\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"n\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"ñ\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"o\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"p\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"q\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"r\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"s\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"t\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"u\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"v\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"w\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"x\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"y\"></li>
                <li><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"z\"></li>
                <li class='position-relative'><input class=\"btn btn-outline-light\" name=\"filter\" type=\"submit\" value=\"\"><ion-icon class=\"position-absolute top-50 start-50 translate-middle\" name=\"refresh-outline\"></ion-icon></li>
            </ul>
        </form>";
    }

    function getPostPhotos($id){
        $con = createConnection();
        $query = $con->prepare("SELECT f.id id, link from post_photos f, posts p where f.post = p.id and p.id = ?");
        $query->bind_param('i', $id);
        $query->bind_result($id_f, $picture);
        $query->execute();
        $query->store_result();
        if($query->num_rows > 0){

            echo "<h3>Fotografías adicionales</h3><div class='row gap-2'><div class='row gap-2'>";
            while($query->fetch()){
                echo "<form class='col-5 col-xl-3 position-relative' action='#' method='post'>
                        <img src='$picture' class='img-fluid rounded object-fit-cover post-admin-extra-photos'>
                        <input hidden value='$id_f' name='id-foto'>
                        <button style='--clr:#e80c0c' name='eliminar' class='btn-eliminar-foto-publicacion position-absolute btn-danger-own'><span>Eliminar</span><i></i></button>
                    </form>";
            }
            echo "</div></div>";
        }
        $query->close();
        $con->close();
    }
    
    function getPostPhotoLink($id){
        $con = createConnection();
        $query = $con->prepare("SELECT link from post_photos where id = ?");
        $query->bind_param('i', $id);
        $query->bind_result($link);
        $query->execute();
        $query->fetch();
        $query->close();
        $con->close();
        return $link;
    }

    function deletePostPhoto($id){
        $link = getPostPhotoLink($id);
        $con = createConnection();
        $delete = $con->prepare("DELETE FROM post_photos where id = ?");
        $delete->bind_param('i', $id);
        $delete->execute();
        $delete->close();
        $con->close();
        unlink($link);
    }

    function getPost($id){
        $con = createConnection();
        $query = $con->prepare("SELECT title, content, p.image image, p_date, g.name artist from posts p, artist g where p.artist = g.id and p.id = ?");
        $query->bind_param('i', $id);
        $query->bind_result($title, $content, $image, $p_date, $artist);
        $query->execute();
        $query->store_result();
        if($query->num_rows != 0){
            $query->fetch();
            $query->close();
            $p_date = formatDate($p_date);
                echo "<section class='container-fluid mt-4'>
                            <div class='d-flex flex-column flex-xl-row gap-3'>
                                
                                <img src='$image' class='w-50 rounded object-fit-cover ratio ratio-1x1'>
                                <div class='d-flex flex-column gap-3'>
                                    <h1>$title</h1>
                                    <pre class='pre-admin-full-post'>$content</pre>
                                    <i>$p_date</i>
                                    <strong>Publicado por: $artist</strong>"; 
                                getPostPhotos($id);  
                                echo "</div>
                            </div>
                    </section>";
            
        }else{
            echo "<div class=\"alert-post-missing-info text-center alert alert-warning position-absolute\" role=\"alert\">
            No se ha encontrado ningun publicación.
          </div>";
        }
        
        $con->close();
    }

    function getAllReviews($filter){
        $con = createConnection();
        $fitler = $filter."%";
        $query = $con->prepare("SELECT r.id id, u.username author, r.title title, content, r.r_date r_date, a.title album from review r, user u, album a where r.user = u.id and r.album = a.id and u.username like ?");
        $query->bind_param('s', $fitler);
        $query->bind_result($id, $autor, $title, $content, $r_date, $album);
        $query->execute();
        $query->store_result();
        if($query->num_rows>0){
            while($query->fetch()){
                $r_date = formatDate($r_date);
                echo "<div class='grupo-detalle border rounded p-3 post-container-admin d-flex align-items-center align-items-lg-start justify-content-between gap-3'>
                        <div class='d-flex flex-column'>
                            <p>Título: <span class='admin-emphasis-span'>$title</span></p>
                            <p>Fecha de publicación: <span class='admin-emphasis-span'>$r_date</span></p>
                            <p>Autor: <span class='admin-emphasis-span'>$autor</span></p>
                            <p>Álbum: <span class='admin-emphasis-span'>$album</span></p>
                            <div class='d-flex gap-2 flex-column flex-lg-row'>
                            <form action='admin_full_review.php' method='get'>
                                <input hidden value='$id' name='id'>
                                <button style='--clr:#0ce8e8' class='btn-danger-own' name='ver-mas'><span>Ver más</span><i></i></button>
                            </form>
                            <form action='#' method='post'>
                                <input hidden value='$id' name='id'>
                                <button style='--clr:#e80c0c' class='btn-danger-own' name='borrar'><span>Eliminar</span><i></i></button>
                            </form>
                        </div>
                        </div>
                    </div>";
            }
        }else{
            echo "<h2 class=\"text-center\">No hay coincidencias</h2>";
        }
        
        $query->close();
        $con->close();
    }
    
    function getReview($id){
        $con = createConnection();
        $query = $con->prepare("SELECT r.title title, content, u.username author, r_date, a.title album, u.avatar avatar from review r, user u, album a where r.album = a.id and r.user = u.id and r.id = ?");
        $query->bind_param('i', $id);
        $query->bind_result($title, $content, $autor, $r_date, $album, $avatar);
        $query->execute();
        $query->store_result();
        if($query->num_rows != 0){
            $query->fetch();
            $query->close();
            $r_date = formatDate($r_date);
            echo "<div class='d-flex flex-column gap-3 review-individual-container-group-section mt-5 text-center'>
                        <div class='d-flex align-items-center gap-3 justify-content-center'>
                            <img src='$avatar' class='rounded-circle admin-full-review-img'>
                            <h2 class='m-0 text-decoration-underline'>$title</h2>
                        </div>
                        <pre class='admin-full-review-content'>$content</pre>
                        <i>Reseña escrita el $r_date por $autor sobre el álbum $album</i>
                    </div>";
            
        }else{
            echo "<div class=\"alert-post-missing-info text-center alert alert-warning position-absolute\" role=\"alert\">
            No se ha encontrado ningun publicación.
          </div>";
        }
        
        $con->close();
    }

    function deleteReview($id){
        $con = createConnection();
        $delete = $con->prepare("DELETE FROM review where id = ?");
        $delete->bind_param('i', $id);
        $delete->execute();
        $delete->close();
        $con->close();
    }
    
    
?>