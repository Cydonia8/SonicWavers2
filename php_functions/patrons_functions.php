<?php
    function menuPatronDropdown(){
        echo "<header class=\"dropdown-header d-flex justify-content-between align-items-center pt-3 pe-3 pb-2 ps-3 border-bottom\">
                <a class=\"dropdown-link-responsive\" href=\"../index.php\"><img src=\"../media/assets/sonic-waves-logo-simple.png\"></a>
                <a href=\"../index.php\"><img class=\"w-25\" src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\"></a>
                <div class=\"dropdown-admin-disc-group\">
                    <button class=\"btn btn-secondary btn-lg dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                    Menú de mecenas
                    </button>
                    <ul class=\"dropdown-menu\">
                        <li><a class=\"dropdown-item\" href=\"patrons_main.php\">Resumen de mecenas</a></li>
                        <li><a class=\"dropdown-item\" href=\"patrons_new_message.php\">Enviar mensaje a grupo</a></li>
                        <li><a class=\"dropdown-item\" href=\"patrons_my_messages.php\">Mis mensajes</a></li>
                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                    </ul>
                </div>
              </header>";
    }

    function getPatronInformation($mail){
        $con = createConnection();
        $query = $con->prepare("SELECT name, mail, pass, foto_avatar from patrons where mail = ?");
        $query->bind_param('s', $mail);
        $query->bind_result($name, $mail, $pass, $foto);
        $query->execute();
        $query->fetch();
        echo "<div class='d-flex flex-column flex-md-row justify-content-evenly gap-5 align-items-center'>
                <a class='avatar-discografica-editable position-relative w-25' href=''>
                    <img src='$foto' class='rounded-circle img-fluid avatar-discografica-editable'>
                    <ion-icon class='icon-edit-avatar-discografica d-none' name=\"pencil-outline\"></ion-icon>
                </a>
                <form class='d-flex flex-column gap-3 form-editar-datos-discografica' action='#' method='post'>
                    <legend class='text-center'>Datos</legend>
                    <div class=\"input-field d-flex flex-column gap-3 mb-3\">
                        <div class=\"input-visuals d-flex justify-content-between\">
                            <label for=\"usuario\">Nombre (no editable)</label>
                            <ion-icon name=\"person-outline\"></ion-icon>
                        </div>
                        <input readonly disabled value='$name' name=\"nombre\" type=\"text\">                        
                    </div>
                    <div class=\"input-field d-flex flex-column gap-3 mb-3\">
                        <div class=\"input-visuals d-flex justify-content-between\">
                            <label for=\"usuario\">Correo (para modificarlo contacte con los administradores)</label>
                            <ion-icon name=\"person-outline\"></ion-icon>
                        </div>
                        <input readonly disabled value='$mail' name=\"mail\" type=\"email\">                        
                    </div>
                    <div class=\"input-field d-flex flex-column gap-3 mb-3\">
                        <div class=\"input-visuals d-flex justify-content-between\">
                            <label for=\"usuario\">Contraseña</label>
                            <ion-icon name=\"person-outline\"></ion-icon>
                        </div>
                        <input name=\"pass\" type=\"password\">
                        <input class='pass-original' hidden value='$pass' name='pass-original'>                        
                    </div>
                    <button style='--clr:#0A90DD' class='btn-danger-own' name='update-data'><span>Modificar</span><i></i></button>
                </form>
              </div>
              <section class=\"update-avatar-photo d-none flex-column justify-content-center align-items-center\">
                    <ion-icon class='close-modal-update-avatar position-absolute' name=\"close-outline\"></ion-icon>
                    <img class='rounded-circle w-25' src=\"$foto\" alt=\"\">
                    <form class='text-center' action=\"#\" method=\"post\" enctype=\"multipart/form-data\">
                        <div class=\"input-field  mb-3 gap-2\">
                            <div class=\" justify-content-between\">
                                <label class=\"file\">Foto de avatar</label>
                                <ion-icon name=\"image-outline\"></ion-icon>
                                <input type=\"file\" class=\"custom-file-input\" name=\"foto-avatar-nueva\">
                            </div>
                        </div>
                        <button style='--clr:#0A90DD' class='btn-danger-own' name='update-avatar'><span>Actualizar foto de avatar</span><i></i></button>
                    </form>
                </section>";
        $query->close();
        $con->close();
    }

    function newPhotoPathAvatarPatron($nombre, $tipo, $discografica){
        $nuevo_nombre;
        switch($_FILES[$nombre]["type"]){
            case "image/jpeg":
                $nuevo_nombre = $discografica.'_'.$tipo.'.jpg';
                break;
            case "image/png":
                $nuevo_nombre = $discografica.'_'.$tipo.'.png';
                break;
            case "image/gif":
                $nuevo_nombre = $discografica.'_'.$tipo.'.gif';
                break;
            case "image/webp":
                $nuevo_nombre = $discografica.'_'.$tipo.'.webp';
                break;
        }
        if(!file_exists("../media/image_patrons/".$discografica)){
            mkdir("../media/image_patrons/".$discografica, 0777, true);
        }
        $nueva_ruta = "../media/image_patrons/".$discografica.'/'.$nuevo_nombre;
        move_uploaded_file($_FILES[$nombre]["tmp_name"], $nueva_ruta);
        return $nueva_ruta;
    }

    function updatePatronAvatarPhoto($mail, $foto_avatar){
        $con = createConnection();
        $update = $con->prepare("UPDATE patrons set foto_avatar = ? where mail = ?");
        $update->bind_param('ss', $foto_avatar, $mail);
        $update->execute();
        $update->close();
        $con->close();
    }

    function updatePatronData($user, $pass){
        $updated = false;
        $con = createConnection();
        $update = $con->prepare("UPDATE patrons set pass = ? where mail = ?");
        $pass = md5(md5($pass));
        $update->bind_param('ss', $pass, $user);
        if($update->execute()){
            $updated = true;
        }
        $update->close();
        $con->close();
        return $updated;
    }

    function checkPreviousMessages($user, $artist_id){
        $con = createConnection();
        $query = $con->prepare("SELECT COUNT(*) FROM artist_receives_message a, patrons_messages pm, patrons p WHERE a.message = pm.id and p.id = pm.patron and p.mail = ? and a.artist = ?");
        $query->bind_param('si', $user, $artist_id);
        $query->bind_result($check);
        $query->execute();
        $query->fetch();
        $query->close();
        $con->close();
        return $check;
    }

    function getPatronsGroupsFiltered($filter, $user){
        $con = createConnection();
        $filtro = $filter."%";
        $query = $con->prepare("SELECT id, nombre, foto_avatar from grupo where activo = 1 and nombre like ? order by nombre asc");
        $query->bind_param('s', $filtro);
        $query->bind_result($id, $nombre, $foto_avatar);
        $query->execute();
        $query->store_result();
        if($query->num_rows > 0){
            while($query->fetch()){
                $previous_messages = checkPreviousMessages($user, $id);
                echo "<div data-name=\"$nombre\" class=\"disc-grupo-detalle border rounded d-flex justify-content-around p-3 gap-3 col-12 col-lg-3\">
                        <div class='w-50 justify-content-center d-flex flex-column'>
                            <img class=\"img-fluid rounded-circle mb-2\" src=\"$foto_avatar\" alt=\"\">
                            <p class=\"text-center font-weight-bold\">$nombre</p>";
                            if($previous_messages == 0){
                                echo "<button data-id-group='$id' style='--clr:#2ce329' class='btn-danger-own open-message-modal'><span>Enviar mensaje</span><i></i></button>";
                            }else{
                                echo "<a href='patrons_message.php?artist=$id'><button style='--clr:#0A90DD' class='btn-danger-own w-100'><span>Ver mensajes</span><i></i></button></a>";
                            }
                            
                       echo "</div>";
                        
                      echo "</div>";
            }
        }else{
            echo "<h2 class='text-center'>No hay coincidencias</h2>";
        }   
        $query->close();
        $con->close();
    }

    function getPatronID($mail){
        $con = createConnection();
        $query = $con->prepare("SELECT id from patrons where mail = ?");
        $query->bind_param('s', $mail);
        $query->bind_result($id);
        $query->execute();
        $query->fetch();
        $query->close();
        $con->close();
        return $id;
    }
    

    function sendPatronMessage($msg, $mail, $group_id){
        $message_sent = false;
        $msg = strip_tags($msg);
        $id_patron = getPatronID($mail);
        $date = date('Y-m-d');
        $con = createConnection();
        $query = $con->prepare("INSERT INTO patrons_messages values ('', ?,?,?)");
        $query->bind_param('ssi', $msg, $date, $id_patron);
        if($query->execute()){
            $queryid = $con->query("SELECT id from patrons_messages order by id desc");
            $row = $queryid->fetch_array(MYSQLI_ASSOC);
            $id = $row["id"];
            $query->close();
            $link_message = $con->query("INSERT INTO artist_receives_message (artist, message) values ($group_id, $id)");
            $message_sent = true;
        }
        $con->close();    
        return $message_sent;
    }

    function getMessagesWithArtists($mail){
        $con = createConnection();
        $query = $con->prepare("SELECT g.foto_avatar foto, g.nombre nombre, g.id id from grupo g, patrons_messages pm, patrons p, artist_receives_message arm where g.id = arm.artist and 
        p.mail = ? and pm.patron = p.id and pm.id = arm.message");
        $query->bind_param('s', $mail);
        $query->bind_result($foto, $nombre, $id);
        $query->execute();
        while($query->fetch()){
            echo "<div class='d-flex gap-3 align-items-center rounded album-review-group-container'>
                    <div class='album-review-container-img'>
                        <img src='$foto' class='img-fluid'>
                        <canvas></canvas>
                    </div>
                    <div class='d-flex flex-column gap-1'>
                        <h4 class='mt-0'>$nombre</h4>
                    ";
                echo "<form action='patrons_message.php' method='get'>
                        <input hidden name='artist' value='$id'>
                        <button style='--clr:#e80c0c' class='btn-danger-own' name='ver-reseñas'><span>Abrir mensajes</span><i></i></button></div></div>
                    </form>";          
        }
        $query->close();
        $con->close();
    }
?>