<?php
    session_start();
    require_once "../php_functions/discografica_functions.php";
    require_once "../php_functions/group_functions.php";
    require_once "../php_functions/general.php";
    forbidAccess("disc");
    closeSession($_POST);
    if(isset($_SESSION["id"])){
        $id_grupo = $_SESSION["id"];
    }
   
    if(isset($_POST["cargar"])){
        
        $nombre_grupo = getGroupName($id_grupo);
        $grupo_carpeta = $nombre_grupo."_".$id_grupo;
        addAlbum($id_grupo, $_SESSION["titulo_album"], $_SESSION["foto_album"], $_SESSION["lanzamiento"], 1);
        for($i = 1; $i <= $_SESSION["num_canciones"]; $i++){
            if($_SESSION["recopilatorio"] == "no" or $_SESSION["recopilatorio"] == NULL){
                $titulo = $_POST["titulo".$i];
                $minutos = getDuration($_FILES["archivo".$i]["tmp_name"]);
                $estilo = $_POST["estilo".$i];
                $ruta = moveUploadedSong("archivo".$i, $grupo_carpeta, $_SESSION["titulo_album"]);
                $filas_afectadas = addSong($titulo, $ruta, $minutos, $estilo);
                $id_cancion = getLastSongID();
                linkSongToAlbum($_SESSION["id_album"], $id_cancion);
            }elseif($_SESSION["recopilatorio"]=="si"){
                $filas_afectadas = linkSongToAlbum($_SESSION["id_album"], $_POST["cancion".$i]);
            }
            
        }
        unsetSessionVariable(array('titulo_album', 'lanzamiento', 'num_canciones', 'recopilatorio', 'foto_album', "id", "id_album"));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../scripts/anadir_cancion.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="../estilos.css">
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32"/>
    <title>Añadir canciones</title>
</head>
<body id="grupo-nuevo-album">
    <?php
        menuDiscograficaDropdown();
    ?>
    <section class="container-añadir-canciones container-xl mt-4">
        <h1 class='text-center mb-4'>Añade las canciones del nuevo álbum</h1>
    <?php
        if(isset($_SESSION["foto_album"])){
            if($_SESSION["recopilatorio"] == NULL){
                echo "<form class='d-flex flex-column align-items-center gap-3' action=\"#\" method=\"post\" enctype=\"multipart/form-data\">";
                generateInputs($_SESSION["num_canciones"]);
            }else{
                if($_SESSION["recopilatorio"] == "no"){
                    echo "<form class='d-flex flex-column align-items-center gap-3' action=\"#\" method=\"post\" enctype=\"multipart/form-data\">";
                    generateInputs($_SESSION["num_canciones"]);
                }else{
                        echo "<script src=\"../scripts/anadir_canciones_recopilatorios.js\" defer></script>";
                        echo "<button style='--clr:#0A90DD' class='btn-danger-own reset-form-recopilatorio'><span>Reiniciar selección</span><i></i></button>";
                        echo "<form class='d-flex flex-column align-items-center gap-3' action=\"#\" method=\"post\">";
                        generateSelects($_SESSION["num_canciones"], $id_grupo);
                        echo "</form>";                  
                }
            }
        }elseif(isset($id_grupo)){
            if($filas_afectadas != 0){
                echo "<h2 class='text-center'>Álbum añadido correctamente, volviendo al resumen general...</h2>";
                echo "<meta http-equiv='refresh' content='2;url=./discografica_main.php'>";
            }
        }else{
            echo "<h2 class='text-center'>Faltan datos para acceder a esta sección. Por favor, vuelva al <a href='discografica_main.php'>resumen general</a></h2>";
        }
    ?>
    </section>
    <div class="alert alert-danger d-none repeated w-50 text-center mt-5 mx-auto" role="alert">
        Has repetido canciones. Vuelve a añadirlas.
    </div>
    
</body>
</html>