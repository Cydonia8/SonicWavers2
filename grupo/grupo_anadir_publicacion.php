<?php
    session_start();
    require_once "../php_functions/general.php";
    require_once "../php_functions/group_functions.php";
    forbidAccess("group");
    closeSession($_POST);
    $nombre_grupo = getGroupNameByMail($_SESSION["user"]);
    if(isset($_POST["subir"])){
      $titulo = strip_tags($_POST["titulo"]);  
      $contenido = strip_tags($_POST["contenido"]);
      $foto_correcta = checkPhoto("foto");
      $fecha = $_POST["fecha"];
      $nuevo_id = getAutoID("publicacion");
    
      if($foto_correcta){
        $ruta_princ = newMainPhotoPathPost($nuevo_id);
        addPost($_SESSION["user"], $titulo, $contenido, $ruta_princ, $fecha);
        if(is_array($_FILES["fotos"])){
            $total = 0;       
            $cont = 0;
            foreach($_FILES["fotos"]["tmp_name"] as $key => $tmp_name){
                // var_dump($foto_op);
                $file_name = $_FILES['fotos']['name'][$key];
                $file_size =$_FILES['fotos']['size'][$key];
                $file_tmp =$_FILES['fotos']['tmp_name'][$key];
                $file_type=$_FILES['fotos']['type'][$key];
                if($file_name != ''){
                    $correct = checkPhotosArray("fotos", $key);
                    $total++;
                    // var_dump($correct);
                    if($correct){
                        $cont++;
                        $ruta = newPhotoPathPost($file_type, $cont, $nuevo_id, $file_tmp);
                        addPostPhotos($ruta, $nuevo_id);                    
                    }
                }
                
            }
        }
      }

      
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
    <link rel="stylesheet" href="../estilos.css">
    <script src="../scripts/grupo_add_post.js" defer></script>
    <script src="../scripts/jquery-3.2.1.min.js" defer></script>
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <title><?php echo $nombre_grupo; ?> | Añadir publicación</title>
</head>
<body id="grupo-añadir-publi">
    <?php
        menuGrupoDropdown("position-static");
    ?>
    <section class="container-xl mb-4">
        <h1 class="text-center mb-4">Añadir nueva publicación</h1>
        <form class="w-50 mx-auto d-flex flex-column gap-3" action="#" method="post" enctype="multipart/form-data">
            <div class="input-field d-flex flex-column mb-3 gap-2">
                <div class="d-flex input-visuals justify-content-between">
                    <label class="file">Título de la publicación</label>
                    <ion-icon name="image-outline"></ion-icon>
                </div>
                <input type="text" name="titulo" required placeholder="Título...">
                
            </div>
            <div class="input-field  d-flex flex-column mb-3 gap-2">
                <div class="d-flex input-visuals justify-content-between">
                    <label class="file">Contenido de la publicación</label>
                    <ion-icon name="image-outline"></ion-icon>
                </div>
                <textarea placeholder="Contenido..." name="contenido" id="contenido-publicacion-insertar" cols="30" rows="10" required></textarea>
            </div>
            <div class="input-field d-flex flex-column mb-3 gap-2">
                <div class="d-flex justify-content-between"><label class="file">Foto principal de la publicación</label><ion-icon name="image-outline"></ion-icon></div>
                    <input type="file" class="custom-file-input" name="foto" required accept=".jpeg,.webp,.png,.gif,.jpg">             
            </div>
            
            <button type="button" id="btn-add-photos" style='--clr:#c49c23' class='btn-danger-own'><span>Añadir fotos extra (máximo ocho)</span><i></i></button>
            <div class="modal-añadir-fotos-publi d-none">
                <div class="modal-añadir-fotos-container position-relative d-flex align-items-center">
                    <input type="file" name="fotos[]" accept=".jpeg,.webp,.png,.gif,.jpg" multiple>
                    <ion-icon class='close-modal-photos-post position-absolute end-0' name="close-outline"></ion-icon>
                </div>
            </div>
            <div class="input-field d-flex flex-column mb-3 gap-2">
                <div class="justify-content-between">
                    <label class="file">Fecha de la publicación</label>
                    <ion-icon name="image-outline"></ion-icon>
                </div>
                <input type="date" name="fecha" required>
            </div>
            <button name='subir' style='--clr:#c49c23' class='btn-danger-own'><span>Crear publicación</span><i></i></button>
        </form>
    </section>
    <?php
        if(isset($foto_correcta)){
            if(!$foto_correcta){
                echo "<div class=\"text-center alert alert-danger\" role=\"alert\">Publicación no creada. Fallo con la foto principal.</div>";
            }else{
                echo "<div class=\"text-center alert alert-success\" role=\"alert\">Publicación creada.</div>";
                echo "<div class=\"text-center alert alert-info\" role=\"alert\">Subidas $cont de $total fotos extra.</div>";
            }
            
        }
    ?>
</body>
</html>