<?php
    session_start();
    require_once "../php_functions/discografica_functions.php";
    require_once "../php_functions/group_functions.php";
    require_once "../php_functions/general.php";
    forbidAccess("disc");
    closeSession($_POST);

    if(isset($_POST["anadir"]) or isset($_POST["crear"])){
        $id = $_POST["id"];
        $total = checkEnoughAlbums($id);
    }else{
        header("location:discografica_grupos.php");
    }
    $nuevo_id = getAutoID("album");
    $_SESSION["id_album"] = $nuevo_id;
    
    
    if(isset($_POST["crear"])){
        $_SESSION["titulo_album"] = $_POST["nombre"];
        $_SESSION["lanzamiento"] = $_POST["fecha"];
        $_SESSION["num_canciones"] = $_POST["num-canciones"];
        $_SESSION["recopilatorio"] = isset($_POST["recopilatorio"]) ? $_POST["recopilatorio"] : NULL;
        $_SESSION["id"] = $_POST["id"];
        $foto_correcta = checkPhoto("foto");
        $nombre_grupo = getGroupName($_SESSION["id"]);
        if($foto_correcta){
            $foto = newPhotoPathAlbumDisc("foto", $_POST["nombre"], $nombre_grupo, $_SESSION["id"]);
            $_SESSION["foto_album"] = $foto;
            // addAlbum($id_grupo, $_POST["nombre"], $foto, $_POST["fecha"], 1);
            echo "<meta http-equiv='refresh' content='0;url=discografica_anadir_canciones.php'>";
        }else{
            echo "datos mal";
        }
        
    }
    
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="../estilos.css">
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <title>Añadir álbum</title>
</head>
<body id="grupo-nuevo-album">
    <?php
        menuDiscograficaDropdown();
    ?>
    <section class="container-xl mt-3">
        <h1 class='text-center mb-4'>Nuevo álbum</h1>
        <form class="d-flex flex-column gap-3 w-50 mx-auto" action="#" method="post" enctype="multipart/form-data">
            <div class="input-field d-flex flex-column mb-3">
                <div class="input-visuals d-flex justify-content-between">
                    <label for="usuario">Título del álbum</label>
                    <ion-icon name="radio-outline"></ion-icon>
                </div>
                <input type="text" placeholder="Título..." name="nombre" required>                      
            </div>
            <div class="input-field d-flex flex-column mb-3">
                <div class="input-visuals d-flex justify-content-between">
                    <label for="usuario">Carátula del álbum</label>
                    <ion-icon name="image-outline"></ion-icon>
                </div>
                <input required type="file" name="foto">                   
            </div>
            <div class="input-field d-flex flex-column mb-3">
                <div class="input-visuals d-flex justify-content-between">
                    <label for="usuario">Fecha de publicación</label>
                    <ion-icon name="calendar-outline"></ion-icon>
                </div>
                <input class='d-block' required type="date" name="fecha">                    
            </div>
            <label for="">Numero de canciones</label><input type="number" required value="1" name="num-canciones" min="1" id="">
            <br>
            <?php
                if($total >= 2){
                    echo "<fieldset>
                            <legend>¿Es un álbum recopilatorio?</legend>
                            <input type=\"radio\" id=\"si\" name=\"recopilatorio\" value=\"si\" required>
                            <label for=\"si\">Sí</label>
                            <input type=\"radio\" id=\"no\" name=\"recopilatorio\" value=\"no\" required>
                            <label for=\"si\">No</label>
                        </fieldset>";
                }
            ?>
            <?php
                echo "<input hidden value=\"$id\" name=\"id\">";
            ?>
            <!-- <input type="submit" value="Pasar a añadir canciones" name="crear"> -->
            <button style='--clr:#0A90DD' class='btn-danger-own' name='crear'><span>Pasar a añadir canciones</span><i></i></button>
        </form>
    </section>
</body>
</html>
