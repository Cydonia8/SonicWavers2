<?php
    session_start();
    require_once "../php_functions/general.php";
    // echo $_SESSION["user"];
    if(!isset($_SESSION["user-type"])){
        header("location:../login/login.php");
    }else{
        forbidAccess("standard");
    }
    $user = $_SESSION["user"];
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../scripts/jquery-3.2.1.min.js" defer></script>
    <script src="../scripts/reproductor.js" defer></script>
    <link rel="stylesheet" href="../estilos.css">
    <link rel="icon" type="image/png" href="../media/assets/favicon-32x32-modified.png" sizes="32x32"/>
    <title>Sonic Waves | Reproductor Web</title>
</head>
<body id="reproductor">
    <div class="alert alert-success position-fixed d-none" id="alert-song-added" role="alert">
        Canción añadida
    </div>
    <div class="alert alert-danger position-fixed d-none" id="alert-song-repeated" role="alert">
        Esta canción ya está en la lista
    </div>
    <div class="alert alert-success position-fixed d-none" id="alert-data-modified" role="alert">
        Datos modificados correctamente
    </div>
    <div class="alert alert-danger position-fixed d-none" id="alert-mail-repeated" role="alert">
        Este correo ya existe en Sonic Waves
    </div>
    <div class="alert alert-danger position-fixed d-none" id="alert-review-missing-data" role="alert">
        Faltan datos
    </div>
    <audio src=""></audio>
    <ion-icon id="arrow-show-aside" name="chevron-forward-outline"></ion-icon>
    <header id="side-menu" class="p-3 gap-3">
        <div class="p-2 modal-new-playlist d-flex flex-column">
            <ion-icon id="close-modal-new-list" name="close-outline"></ion-icon>
            <h5 class="text-center">Nueva playlist</h5>
            <form id="form-new-list" method="post" enctype="multipart/form-data" class="d-flex flex-column align-items-start gap-2">
                <div class="input-field d-flex flex-column mb-3">
                    <div class="input-visuals d-flex justify-content-between">
                        <label for="usuario">Nombre</label>
                        <ion-icon name="at-outline"></ion-icon>
                    </div>
                    <input id="nombre-nueva-lista" type="text" placeholder="Nombre">                      
                </div>
                
                <input id="foto-nueva-lista" type="file" class="custom-file-input" accept=".png,.webp,.jpg,.jpeg">
                <button type="button" style='--clr:#0ce8e8' class='btn-danger-own' id='crear-lista'><span>Añadir lista</span><i></i></button>
            </form>
        </div>
        <a class="w-75" href="../index.php">
            <img class="img-fluid" src="../media/assets/sonic-waves-logo-simple.png" alt="">
        </a>
        <ul class="d-flex flex-column gap-3 header-main-menu">
            <li>
                <a class="d-flex align-items-center gap-2" id="home-link" href="">
                    <ion-icon class="side-header-icons" name="home-outline"></ion-icon>
                    <span>Inicio</span>
                </a>
            </li>
            <li>
                <a class="d-flex align-items-center gap-2" id="albums-esenciales" href="">
                    <ion-icon class="side-header-icons" name="disc-outline"></ion-icon>
                    <span>Álbumes favoritos</span>
                </a>
            </li>
            <li>
                <a class ="d-flex align-items-center gap-2" id="lista-recomendada" href="">
                    <ion-icon class="side-header-icons" name="color-filter-outline"></ion-icon>
                    <span>Lista recomendada</span>
                </a>
            </li>
        </ul>
        <span class="d-flex playlists-title gap-2 align-items-center w-100 justify-content-between">
            <span class="d-flex align-items-center gap-2"><ion-icon name="library-outline"></ion-icon>Mis listas</span>
            <ion-icon id="add-new-playlist" name="add-outline"></ion-icon>
        </span>
        <div class="d-flex flex-column gap-3" id="playlists-container">

        </div>
    </header>
    <main id="main-content">
        <div class="d-none actualizar-avatar-usuario">
            <ion-icon class="position-absolute top-0 end-0 p-5" id="close-update-avatar-user" name="close-outline"></ion-icon>
            <form method="post" enctype="multipart/form-data" class="d-flex flex-column gap-5" id="form-new-user-avatar">
                <input type="file" accept=".png,.webp,.jpg,.jpeg" id="input-new-avatar">
                <button style='--clr:#0ce8e8' class='btn-danger-own' id='actualizar-avatar'><span>Actualizar avatar</span><i></i></button>
            </form>
        </div>
        <header class="profile-menu d-flex justify-content-between align-items-center">
            <input type="text" placeholder="Búsqueda..." id="search-bar">
            <div class="dropdown">
                <img data-bs-toggle="dropdown" aria-expanded="false" class=" profile-menu-avatar rounded-circle dropdown-toggle" src="">
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" id="link-profile" href="">Perfil</a></li>
                    <li><a class="dropdown-item" id="link-eq" href="">Ecualizador</a></li>
                    <li><a class="dropdown-item" id="link-close-session" href="">Cerrar sesión</a></li>
                </ul>
            </div>
            <!-- <img class="profile-menu-avatar rounded-circle" src="" alt=""> -->
        </header>
        <section id="main-content-dynamic-container">

        </section>
        <section id="loader" class="">
            <!-- <span class="loader"></span> -->
            <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </section>
    </main>
    <footer class="master-play d-flex justify-content-between align-items-center" id="player">
        <div class="track-info d-flex gap-2 align-items-start align-items-sm-center">
            <img src="../media/assets/no_cover.jpg" class="rounded">
        </div>  
         
        <div class="time-bar position-relative">
            <div class="bar-control-icons d-flex gap-3 align-items-center">
                <ion-icon id="shuffle" name="shuffle-outline"></ion-icon>
                <ion-icon class="control-icons" name="play-skip-back-outline" id="previous"></ion-icon>
                <ion-icon class="control-icons" id="play-pause" name="play-outline"></ion-icon>
                <ion-icon class="control-icons" name="play-skip-forward-outline" id="next"></ion-icon>
                <i id="letra" class="fa-solid fa-microphone-lines"></i>
            </div>
            <img src="../media/assets/sonic-waves-logo-simple.png" class="position-absolute player-logo-color-changer" alt="">
            <span class="me-2" id="current-time">0:00</span>
            <input class="position-absolute w-100" type="range" id="seek" min="0" max="100">
            <div class="bar2" id="bar2"></div>
            <div class="dot"></div>
            <span id="end-time">0:00</span>
        </div>
        
        <div class="volume-control position-relative">
            <ion-icon class="volume-icon" name="volume-medium-outline"></ion-icon>
            <input type="range" id="volume-slider" min="0" max="1" step="0.05" value="0.5">
            <div class="vol-bar position-absolute"></div>
            <div class="vol-dot position-absolute"></div>
        </div>
    </footer>
</body>
</html>