<?php

function menuDiscograficaDropdown(){
    echo "<header class=\"dropdown-header d-flex justify-content-between align-items-center pt-3 pe-3 pb-2 ps-3 border-bottom\">
            <a class=\"dropdown-link-responsive\" href=\"../index.php\"><img src=\"../media/assets/sonic-waves-logo-simple.png\"></a>
            <a href=\"../index.php\"><img class=\"w-25\" src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\"></a>
            <div class=\"dropdown-admin-disc-group\">
                <button class=\"btn btn-secondary btn-lg dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                Menú de discográfica
                </button>
                <ul class=\"dropdown-menu\">
                    <li><a class=\"dropdown-item\" href=\"discografica_main.php\">Resumen de discográfica</a></li>
                    <li><a class=\"dropdown-item\" href=\"discografica_grupos.php\">Grupos gestionados</a></li>
                    <li><a class=\"dropdown-item\" href=\"discografica_anadir_grupo.php\">Añadir nuevo grupo</a></li>
                    <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                </ul>
            </div>
          </header>";
}

function getDiscographicName($correo){
    $con = createConnection();
    $consulta = $con->prepare("SELECT nombre FROM discografica where correo = ?");
    $consulta->bind_param('s',$correo);
    $consulta->bind_result($nombre);
    $consulta->execute();
    $consulta->fetch();
    $consulta->close();
    $con->close();
    return $nombre;
}

function getDiscographicInformation($correo){
    $con = createConnection();
    $consulta = $con->prepare("SELECT nombre, correo, pass, foto_avatar from discografica where correo = ?");
    $consulta->bind_param('s', $correo);
    $consulta->bind_result($nombre, $correo, $pass, $foto);
    $consulta->execute();
    $consulta->fetch();
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
                    <input readonly disabled value='$nombre' name=\"nombre\" type=\"text\">                        
                </div>
                <div class=\"input-field d-flex flex-column gap-3 mb-3\">
                    <div class=\"input-visuals d-flex justify-content-between\">
                        <label for=\"usuario\">Correo</label>
                        <ion-icon name=\"person-outline\"></ion-icon>
                    </div>
                    <input value='$correo' name=\"mail\" type=\"email\">                        
                </div>
                <div class=\"input-field d-flex flex-column gap-3 mb-3\">
                    <div class=\"input-visuals d-flex justify-content-between\">
                        <label for=\"usuario\">Contraseña</label>
                        <ion-icon name=\"person-outline\"></ion-icon>
                    </div>
                    <input name=\"pass\" type=\"password\">
                    <input class='pass-original' hidden value='$pass' name='pass-original'>                        
                </div>
                <button style='--clr:#0A90DD' class='btn-danger-own' name='modificar-datos'><span>Modificar</span><i></i></button>
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
                    <button style='--clr:#0A90DD' class='btn-danger-own' name='actualizar-avatar'><span>Actualizar foto de avatar</span><i></i></button>
                </form>
            </section>";
    $consulta->close();
    $con->close();
}

function getDiscographicID($mail){
    $con = createConnection();
    $consulta = $con->prepare("SELECT id FROM discografica where correo = ?");
    $consulta->bind_param('s', $mail);
    $consulta->bind_result($id);
    $consulta->execute();
    $consulta->fetch();
    $consulta->close();
    $con->close();
    return $id;
}

function getDiscographicGroupsFiltered($id_disc, $filter){
    $con = createConnection();
    $filtro = $filter."%";
    $consulta = $con->prepare("SELECT id, nombre, activo, foto_avatar, pendiente_aprobacion aprob from grupo where discografica = ? and nombre like ? order by nombre asc");
    $consulta->bind_param('is', $id_disc, $filtro);
    $consulta->bind_result($id, $nombre, $activo, $foto_avatar, $aprob);
    $consulta->execute();
    $consulta->store_result();
    if($consulta->num_rows > 0){
        while($consulta->fetch()){
            echo "<div data-name=\"$nombre\" class=\"disc-grupo-detalle border rounded d-flex justify-content-around p-3 gap-3 col-12 col-lg-3\">
                    <div class='w-50'>
                        <img class=\"img-fluid rounded-circle mb-2\" src=\"$foto_avatar\" alt=\"\">
                        <p class=\"text-center font-weight-bold\">$nombre</p>
                    </div>";
                    if($activo == 0 and $aprob == 1){
                        echo "<div class=\"w-50 d-flex flex-column justify-content-center\"><div class=\"alert alert-info\" role=\"alert\">
                        Pendiente de aprobación
                      </div></div>";
                    }elseif($activo == 0 and $aprob == 0){
                        echo "<div class=\"w-50 d-flex flex-column justify-content-center\"><div class=\"alert alert-danger\" role=\"alert\">
                        Grupo actualmente desactivado. Póngase en <a href='../contacto/contacto.php'>contacto con el administrador</a> del sitio para más información.
                      </div></div>";     
                    }elseif($activo == 1){
                        echo "<div class=\"w-50 d-flex flex-column justify-content-center gap-5\">
                        <form method=\"post\" action=\"discografica_editar_grupo.php\">
                            <input hidden value=\"$id\" name=\"id\">
                            <button style='--clr:#3232e3' class='btn-danger-own btn' name='editar-group'><span>Editar datos de grupo</span><i></i></button>
                        </form>
                        <form method=\"post\" action=\"../discografica/discografica_anadir_album.php\">
                            <input hidden value=\"$id\" name=\"id\">
                            <button style='--clr:#0ce8e8' class='btn-danger-own' name='anadir'><span>Añadir nuevo álbum</span><i></i></button>
                        </form>
                    </div>";
                    }else{
                        echo "<div class=\"w-50 d-flex flex-column justify-content-center\"><div class=\"alert alert-danger\" role=\"alert\">
                        Creación de grupo denegada. Póngase en <a href='../contacto/contacto.php'>contacto con el administrador</a> del sitio para más información.
                      </div></div>";
                    }
                    
                  echo "</div>";
        }
    }else{
        echo "<h2 class='text-center'>No hay coincidencias</h2>";
    }
    
    $consulta->close();
    $con->close();
}

function addGroup($nombre, $biografia, $foto, $foto_avatar, $activo, $id_disco){
    $con = createConnection();
    $insercion = $con->prepare("INSERT INTO grupo (nombre,biografia, foto, foto_avatar, activo, discografica) VALUES (?,?,?,?,?,?)");
    $insercion->bind_param('ssssii', $nombre, $biografia, $foto, $foto_avatar, $activo, $id_disco);
    $insercion->execute();
    $insercion->close();
    $con->close();
}

function newPhotoPathAvatarDiscographic($nombre, $tipo, $discografica){
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
    if(!file_exists("../media/img_discografica/".$discografica)){
        mkdir("../media/img_discografica/".$discografica, 0777, true);
    }
    $nueva_ruta = "../media/img_discografica/".$discografica.'/'.$nuevo_nombre;
    move_uploaded_file($_FILES[$nombre]["tmp_name"], $nueva_ruta);
    return $nueva_ruta;
}

function newPhotoPathDisc($nombre, $tipo, $grupo, $id){
    $nuevo_nombre;
    $quitar = ["'", "\""];
    $grupo = str_replace($quitar, "", $grupo);
    switch($_FILES[$nombre]["type"]){
        case "image/jpeg":
            $nuevo_nombre = $grupo."_".$id."_".$tipo.".jpg";
            break;
        case "image/png":
            $nuevo_nombre = $grupo."_".$id."_".$tipo.".png";
            break;
        case "image/gif":
            $nuevo_nombre = $grupo."_".$id."_".$tipo.".gif";
            break;
        case "image/webp":
            $nuevo_nombre = $grupo."_".$id."_".$tipo.".webp";
            break;
    }
    if(!file_exists("../media/img_grupos/".$grupo."_".$id)){
        mkdir("../media/img_grupos/".$grupo."_".$id, 0777, true);
    }
    $nueva_ruta = "../media/img_grupos/".$grupo."_".$id."/".$nuevo_nombre;
    move_uploaded_file($_FILES[$nombre]["tmp_name"], $nueva_ruta);
    return $nueva_ruta;
}

function newPhotoPathAlbumDisc($nombre, $album, $grupo, $id){
    $nuevo_nombre;
    $quitar = ["/", ".", "*","'"];
    $album = strtolower(str_replace($quitar, "", $album));
    $grupo = str_replace($quitar, "", $grupo);
    switch($_FILES[$nombre]["type"]){
        case "image/jpeg":
            $nuevo_nombre = $album.".jpg";
            break;
        case "image/png":
            $nuevo_nombre = $album.".png";
            break;
        case "image/gif":
            $nuevo_nombre = $album.".gif";
            break;
        case "image/webp":
            $nuevo_nombre = $album.".webp";
            break;
    }
    if(!file_exists("../media/img_grupos/".$grupo."_".$id)){
        mkdir("../media/img_grupos/".$grupo."_".$id, 0777, true);
    }
    $nueva_ruta = "../media/img_grupos/".$grupo."_".$id."/".$nuevo_nombre;
    move_uploaded_file($_FILES[$nombre]["tmp_name"], $nueva_ruta);
    return $nueva_ruta;
}

function getGroupDataEdit($id){
    $con = createConnection();
    $consulta = $con->prepare("SELECT nombre, biografia, foto, foto_avatar from grupo where id = ?");
    $consulta->bind_param('i', $id);
    $consulta->bind_result($nombre, $bio, $foto, $foto_av);
    $consulta->execute();
    $consulta->fetch();
    $consulta->close();
    $con->close();
    $datos["nombre"] = $nombre;
    $datos["bio"] = $bio;
    $datos["foto"] = $foto;
    $datos["foto_avatar"] = $foto_av;
    return $datos;
}

function editGroup($id, $bio, $foto, $foto_avatar){
    $con = createConnection();
    $update = $con->prepare("UPDATE grupo set biografia = ?, foto = ?, foto_avatar = ? where id = ?");
    $update->bind_param('sssi', $bio, $foto, $foto_avatar, $id);
    $update->execute();
    $update->close();
    $con->close();
}

function checkEnoughAlbums($id_grupo){
    $con = createConnection();
    $consulta = $con->query("SELECT count(*) total from album a, grupo g where a.grupo = g.id and g.id = $id_grupo");
    $fila = $consulta->fetch_array(MYSQLI_ASSOC);
    $total = $fila["total"];
    $con->close();
    return $total;
}

function updateDiscographicAvatarPhoto($mail, $foto_avatar){
    $con = createConnection();
    $update = $con->prepare("UPDATE discografica set foto_avatar = ? where correo = ?");
    $update->bind_param('ss', $foto_avatar, $mail);
    $update->execute();
    $update->close();
    $con->close();
}

function discographicEmailRepeatedAtUpdate($mail, $mail_act){
    $con = createConnection();
    $consulta = $con->prepare("SELECT count(*) from discografica where correo = ? and ?<>?");
    $consulta->bind_param('sss', $mail, $mail_act, $mail);
    $consulta->bind_result($count);
    $consulta->execute();
    $consulta->fetch();
    $consulta->close();
    $con->close();
    return $count;
}

function updateDiscographicData($user, $mail, $pass){
    $con = createConnection();
    $update = $con->prepare("UPDATE discografica set correo = ?, pass = ? where correo = ?");
    $update->bind_param('sss', $mail, $pass, $user);
    $update->execute();
    $update->close();
    $con->close();
}

?>