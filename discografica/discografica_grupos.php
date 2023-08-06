<?php
    session_start();
    require_once "../square_image_creator/create_square_image.php";
    require_once "../php_functions/general.php";
    require_once "../php_functions/discografica_functions.php";
    require_once "../php_functions/admin_functions.php";
    forbidAccess("disc");
    closeSession($_POST);
    $nombre = getDiscographicName($_SESSION["user"]);
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
    <link rel="stylesheet" href="../estilos.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
    <script src="../scripts/discografica_grupos.js" defer></script>
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <title><?php echo $nombre;?> | Grupos gestionados</title>
</head>
<body id="discografica-main">
    <?php
        menuDiscograficaDropdown();
        
        $id = getDiscographicID($_SESSION["user"]);
    ?>
    <h1 class="text-center mt-4 mb-4">Grupos gestionados por <?php echo $nombre;?></h1>
    <!-- <input type="text" class="busqueda-dinamica-disc"> -->
    <section class="filter-abc-admin">
        <?php
            printFilterForm("por nombre de grupo")
        ?>
        <!-- <h3 class="text-center mt-4">Filtro alfabético</h3>
        <form action="#" method="post">
            <ul class="d-flex list-style-none justify-content-center gap-3 flex-wrap mb-3 pe-2 ps-2">
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="a"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="b"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="c"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="d"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="e"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="f"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="g"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="h"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="i"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="j"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="k"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="l"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="m"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="n"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="ñ"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="o"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="p"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="q"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="r"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="s"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="t"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="u"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="v"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="w"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="x"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="y"></li>
                <li><input class="btn btn-outline-light" name="filtro" type="submit" value="z"></li>
                <li class='position-relative'><input class="btn btn-outline-light" name="filtro" type="submit" value=""><ion-icon class="position-absolute top-50 start-50 translate-middle" name="refresh-outline"></ion-icon></li>
            </ul>
        </form> -->
    </section>
    <section class="container-fluid container-grupos-discografica row mx-auto gap-3 p-2">
        <?php
            if(isset($_POST["filtro"])){
                echo "<div class=\"d-flex justify-content-center align-items-center gap-3 mb-4\">
                        <label>Búsqueda dinámica</label>
                        <input type=\"text\" class=\"busqueda-dinamica-disc\">
                    </div>";
                getDiscographicGroupsFiltered($id, $_POST["filtro"]);
            }         
        ?>
    
    </section>
</body>
</html>
