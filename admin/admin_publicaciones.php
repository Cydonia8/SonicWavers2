<?php
    session_start();
    require_once "../php_functions/admin_functions.php";
    require_once "../php_functions/general.php";
    forbidAccess("admin");
    closeSession($_POST);
    if(isset($_POST["borrar"])){
        deletePost($_POST["id"]);
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
    <script src="../scripts/admin_grupos.js" defer></script>
    <script src="../scripts/jquery-3.2.1.min.js" defer></script>
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <title>Document</title>
</head>
<body id="admin-body">
    <?php
        menuAdminDropdown();
    ?>
    <h1 class="text-center mt-5">Publicaciones de Sonic Waves</h1>
    <?php
        printFilterForm("por autor de publicación");
    ?>
    <section class="container-fluid gap-3 row mx-auto albumes-container">
        <?php
            if(isset($_POST["filtro"])){
                echo "<div class=\"d-flex justify-content-center align-items-center gap-3 mb-4\">
                        <label>Búsqueda dinámica</label>
                        <input type=\"text\" class=\"busqueda-dinamica-admin\">
                    </div>";
                getAllPostsFiltered($_POST["filtro"]);
            }
        ?>
    </section>
</body>
</html>