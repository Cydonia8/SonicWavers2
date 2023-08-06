<?php
    session_start();
    require_once "../square_image_creator/create_square_image.php";
    require_once "../php_functions/general.php";
    require_once "../php_functions/group_functions.php";
    forbidAccess("group");
    closeSession($_POST);
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
    <script src="../scripts/jquery-3.2.1.min.js" defer></script>
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <title>Mis reseñas</title>
</head>
<body id="grupo-reseñas-album">
    <?php
        menuGrupoDropdown("position-static");
        echo "<section class='container-xxl d-flex flex-column gap-4'>";
        if(isset($_GET["ver-reseñas"])){
            $titulo_album = getAlbumName($_GET["id"], $_SESSION["user"]);
            echo "<h1 class=\"text-center\">Reseñas de $titulo_album</h1>";
            getAllReviewsOfAlbum($_GET["id"]);
        }elseif(isset($_GET["id"])){
            $titulo_album = getAlbumName($_GET["id"], $_SESSION["user"]);
            if($titulo_album != ""){
                echo "<h1 class=\"text-center\">Reseñas de $titulo_album</h1>";
                getAllReviewsOfAlbum($_GET["id"]);
            }else{
                echo "<h2>Lo sentimos, no encontramos ese álbum para el usuario $_SESSION[user]</h2>";
            }
        }else{
            echo "<div class=\"alert-post-missing-info text-center alert alert-warning position-absolute\" role=\"alert\">
            Falta información para mostrar esta sección. Vuelve al <a href=\"grupo_main.php\" class=\"alert-link\">resumen general</a>.
        </div>";
        }
        echo "</section>";
    ?>
    
</body>
</html>