<?php
    session_start();
    require_once "../php_functions/general.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../estilos.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32" />
    <title>Sonic Waves</title>
</head>
<body id="dolby">
    <header id="dolby-header" class="d-flex justify-content-center p-3 mb-5 border-bottom">
        <a class="w-25" href="../index.php"><img src="../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png" alt="Logo de Sonic Waves"></a>
    </header>
    <h1 class="text-center w-75 mx-auto">Próximamente llegará a Sonic Waves el sonido más envolvente y avanzado del mundo: Dolby Atmos.</h1>
    <img src="../media/assets/atmos.webp" alt="Logo de Dolby Atmos" class="img-fluid mb-5">
    <h2 class="text-center w-50 mx-auto">Mientras tanto, disfruten de las numerosas funcionalidades que les ofrece nuestro sitio. Nosotros ya no podemos más, estamos así.</h2>
    <div class="d-flex justify-content-center">
        <img src="../media/assets/coraline-dad.gif" alt="" class="mb-4 img-fluid">
    </div>
    <?php
        printFooter("..");
    ?>
</body>
</html>