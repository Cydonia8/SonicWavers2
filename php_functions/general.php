<?php

function mostStreamedSongs(){
    
}

function createConnection(){
    $con = new mysqli('localhost','root','','sonicwaves');
    $con->set_charset("utf8");
    return $con;
}

function imageIndex($ruta){
    $imagen_rutanueva = preg_replace("`^.{1}`",'',$ruta);
    return $imagen_rutanueva;
}

function imageUser($user, $table, $identificador){
    $con = createConnection();
    $consulta = $con->prepare("SELECT foto_avatar from $table where $identificador = ?");
    $consulta->bind_param('s',$user);
    $consulta->bind_result($foto);
    $consulta->execute();
    $consulta->fetch();
    $consulta->close();
    $con->close();
    return $foto;
}

function forbidAccess($tipo_usuario){
    if(!isset($_SESSION["user"]) or $_SESSION["user-type"] != $tipo_usuario){
        header("Location:../prohibido/forbidden.php");
    }
}

function formatDate($date){
    $marcatiempo = strtotime($date);
    $fecha_formateada = date('d-m-Y', $marcatiempo);
    return $fecha_formateada;
}

function unsetSessionVariable($array){
    foreach($array as $variable){
        unset($_SESSION[$variable]);
    }
}

function getAutoID($tabla){
    $con = createConnection();
    $consulta_id = $con->prepare("select auto_increment cod from information_schema.tables where table_schema = 'sonicwaves' and table_name = ?");
    $consulta_id->bind_param('s', $tabla);
    $consulta_id->bind_result($id);
    $consulta_id->execute();
    $consulta_id->fetch();
    $consulta_id->close();

    return $id;
}

function keepSessionOpen(){
    if(isset($_POST["sesion"]) and $_POST['sesion']==1){
        setcookie('sesion', session_encode(), time()+86400, '/');                  
    }
}

function decodeCookie(){
    if(isset($_COOKIE['sesion'])){
        session_decode($_COOKIE['sesion']);
    }
}

function printMainMenu($location = "noindex"){

    if($location == "index"){
        if(isset($_SESSION["user-type"])){
            if($_SESSION["user-type"] == "admin"){
                $foto = imageUser("admin", "usuario", "usuario");
                $foto = imageIndex($foto);
                echo "<header class=\"header-index\">
                <a href='index.php' class='enlace-index'><img src=\"media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\"></a>
                    <nav>
                        <ul class=\"links-header\"> 
                            <li><a href=\"contacto/contacto.php\">Contacto</a></li>
                            <li class=\"li-foto\">
                                <div class=\"dropdown\">
                                    <img data-bs-toggle=\"dropdown\" aria-expanded=\"false\" class=\"rounded-circle dropdown-toggle\" src=\"$foto\">
                                    <ul class=\"dropdown-menu\">
                                        <li><a class=\"dropdown-item\" href=\"admin/admin_main.php\">Perfil</a></li>
                                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </header>";
            }elseif($_SESSION["user-type"] == "standard"){
                $foto = imageUser($_SESSION["user"], "usuario", "usuario");
                $foto = imageIndex($foto);
                echo "<header class=\"header-index\">
                <a href='index.php' class='enlace-index'><img src=\"media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\"></a>
                    <nav>
                        <ul class=\"links-header\"> 
                            <li><a href=\"reproductor/user_controller.php\">Reproductor</a></li>
                            <li><a href=\"contacto/contacto.php\">Contacto</a></li>
                            <li class=\"li-foto\">
                                <div class=\"dropdown\">
                                    <img data-bs-toggle=\"dropdown\" aria-expanded=\"false\" class=\"rounded-circle dropdown-toggle\" src=\"$foto\">
                                    <ul class=\"dropdown-menu\">
                                        <li><a class=\"dropdown-item\" href=\"reproductor/reproductor.php\">Perfil</a></li>
                                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </header>";
            }elseif($_SESSION["user-type"] == "group"){
                $foto = imageUser($_SESSION["user"], "grupo", "correo");
                $foto = imageIndex($foto);
                echo "<header class=\"header-index\">
                <a href='index.php' class='enlace-index'><img src=\"media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\"></a>
                    <nav>
                        <ul class=\"links-header\"> 
                            <li><a href=\"contacto/contacto.php\">Contacto</a></li>
                            <li class=\"li-foto\">
                                <div class=\"dropdown\">
                                    <img data-bs-toggle=\"dropdown\" aria-expanded=\"false\" class=\"rounded-circle dropdown-toggle\" src=\"$foto\">
                                    <ul class=\"dropdown-menu\">
                                        <li><a class=\"dropdown-item\" href=\"grupo/grupo_main.php\">Perfil</a></li>
                                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </header>";
            }else{
                $foto = imageUser($_SESSION["user"], "discografica", "correo");
                $foto = imageIndex($foto);
                echo "<header class=\"header-index\">
                <a href='index.php' class='enlace-index'><img src=\"media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\"></a>
                    <nav>
                        <ul class=\"links-header\"> 
                            <li><a href=\"contacto/contacto.php\">Contacto</a></li>
                            <li class=\"li-foto\">
                                <div class=\"dropdown\">
                                    <img data-bs-toggle=\"dropdown\" aria-expanded=\"false\" class=\"rounded-circle dropdown-toggle\" src=\"$foto\">
                                    <ul class=\"dropdown-menu\">
                                        <li><a class=\"dropdown-item\" href=\"discografica/discografica_main.php\">Perfil</a></li>
                                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </header>";
            }
            
        }else{
            echo "<header class=\"header-index\">
                    <a href='index.php' class='enlace-index'><img src=\"media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\"></a>
                    <nav>
                        <ul class=\"links-header\"> 
                            <li><a href=\"reproductor/user_controller.php\">Reproductor</a></li>
                            <li><a href=\"contacto/contacto.php\">Contacto</a></li>
                            <li><a href=\"login/login.php\">Iniciar sesión</a></li>
                        </ul>
                    </nav>
                </header>";
        }
        
    }else{
        if(isset($_SESSION["user-type"])){
            if($_SESSION["user-type"] == "admin"){
                $foto = imageUser("admin", "usuario", "usuario");
                echo "<header class=\"header-index\">
                    <a href='../index.php' class='enlace-index'><img src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\"></a>
                    <nav>
                        <ul class=\"links-header\"> 
                            <li class=\"li-foto\">
                                <div class=\"dropdown\">
                                    <img data-bs-toggle=\"dropdown\" aria-expanded=\"false\" class=\"rounded-circle dropdown-toggle\" src=\"$foto\">
                                    <ul class=\"dropdown-menu\">
                                        <li><a class=\"dropdown-item\" href=\"../admin/admin_main.php\">Perfil</a></li>
                                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </header>";
            }elseif($_SESSION["user-type"] == "standard"){
                $foto = imageUser($_SESSION["user"], "usuario", "usuario");
                echo "<header class=\"header-index\">
                <a href='../index.php' class='enlace-index'><img src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\"></a>
                    <nav>
                        <ul class=\"links-header\"> 
                            <li><a href=\"../reproductor/reproductor.php\">Reproductor</a></li>
                            <li><a href=\"../contacto/contacto.php\">Contacto</a></li>
                            <li class=\"li-foto\">
                                <div class=\"dropdown\">
                                    <img data-bs-toggle=\"dropdown\" aria-expanded=\"false\" class=\"rounded-circle dropdown-toggle\" src=\"$foto\">
                                    <ul class=\"dropdown-menu\">
                                        <li><a class=\"dropdown-item\" href=\"\">Perfil</a></li>
                                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </header>";
            }elseif($_SESSION["user-type"] == "group"){
                $foto = imageUser($_SESSION["user"], "grupo", "correo");
                echo "<header class=\"header-index\">
                <a href='../index.php' class='enlace-index'><img src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\"></a>
                    <nav>
                        <ul class=\"links-header\"> 
                            <li><a href=\"../contacto/contacto.php\">Contacto</a></li>
                            <li class=\"li-foto\">
                                <div class=\"dropdown\">
                                    <img data-bs-toggle=\"dropdown\" aria-expanded=\"false\" class=\"rounded-circle dropdown-toggle\" src=\"$foto\">
                                    <ul class=\"dropdown-menu\">
                                        <li><a class=\"dropdown-item\" href=\"../grupo/grupo_main.php\">Perfil</a></li>
                                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </header>";
            }else{
                $foto = imageUser($_SESSION["user"], "discografica", "correo");
                echo "<header class=\"header-index\">
                <a href='../index.php' class='enlace-index'><img src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\"></a>
                    <nav>
                        <ul class=\"links-header\"> 
                            <li><a href=\"../contacto/contacto.php\">Contacto</a></li>
                            <li class=\"li-foto\">
                                <div class=\"dropdown\">
                                    <img data-bs-toggle=\"dropdown\" aria-expanded=\"false\" class=\"rounded-circle dropdown-toggle\" src=\"$foto\">
                                    <ul class=\"dropdown-menu\">
                                        <li><a class=\"dropdown-item\" href=\"../discografica/discografica_main.php\">Perfil</a></li>
                                        <li><form action=\"#\" method=\"post\"><input id=\"cerrar-user\" type=\"submit\" name=\"cerrar-sesion\" value=\"Cerrar sesión\"></form></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </header>";
            }
            
        }else{
            echo "<header class=\"header-index\">
            <a href='../index.php' class='enlace-index'><img src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\"></a>
                    <nav>
                        <ul class=\"links-header\"> 
                            <li><a href=\"\">Reproductor</a></li>
                            <li><a href=\"../contacto/contacto.php\">Contacto</a></li>
                            <li><a href=\"../login/login.php\">Iniciar sesión</a></li>
                        </ul>
                    </nav>
                </header>";
        }
    }
}

function closeSession($POST, $seccion = "noindex"){
    if($seccion == "noindex"){
        if(isset($_POST["cerrar-sesion"])){
            if(isset($_COOKIE['sesion'])){
                setcookie("sesion","", time()-3600, '/');
                unset($_SESSION['user']);
                unset($_SESSION["user-type"]);
                unset($_SESSION["token"]);
                header("location:../index.php");
            }else{
                unset($_SESSION['user']);
                unset($_SESSION["user-type"]);
                unset($_SESSION["token"]);
                header("location:../index.php");
            }
            
        }
    }else{
        if(isset($_POST["cerrar-sesion"])){
            if(isset($_COOKIE['sesion'])){
                unset($_SESSION['user']);
                unset($_SESSION["user-type"]);
                unset($_SESSION["token"]);
                setcookie("sesion","", time()-3600, '/');              
                echo "<meta http-equiv='refresh' content='0;url=index.php'>";
            }else{
                unset($_SESSION['user']);
                unset($_SESSION["user-type"]);
                unset($_SESSION["token"]);
                header("location:index.php");
            }
        }
    }    
}

function printFooter($ruta){
    echo "<footer id=\"footer\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-md-3 d-flex flex-column align-items-center\">
                <a href=\"$ruta/index.php\"><img src=\"$ruta/media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"Logo de Sonic Waves\" class=\"img-fluid logo-footer\"></a>
              <div class=\"footer-about\">
                  <p>All Rights Reserved | 2023</p>
                  <p>Sonic Waves es una filial de Revolver Music</p>
              </div>

            </div>
            <div class=\"col-md-3 d-flex flex-column align-items-center\">
                <div class=\"useful-link\">
                    <h2>Enlaces útiles</h2>
                    <img src=\"$ruta/assets/images/about/home_line.png\" alt=\"\" class=\"img-fluid\">
                    <div class=\"use-links\">
                        <li><a href=\"$ruta/index.php\"><i class=\"fa-solid fa-angles-right\"></i> Home</a></li>
                        <li><a href=\"$ruta/proximamente/proximamente.php\"><i class=\"fa-solid fa-angles-right\"></i>Próximamante: Dolby Atmos</a></li>
                        <li><a href=\"$ruta/reproductor/reproductor.php\"><i class=\"fa-solid fa-angles-right\"></i>Reproductor</a></li>
                        <li><a href=\"$ruta/contacto/contacto.php\"><i class=\"fa-solid fa-angles-right\"></i> Contacto</a></li>
                    </div>
                </div>

            </div>
            <div class=\"col-md-3 d-flex flex-column align-items-center\">
                <div class=\"social-links\">
                    <h2>Síguenos</h2>
                    <img src=\"$ruta/assets/images/about/home_line.png\" alt=\"\">
                    <div class=\"social-icons\">
                        <li><a href=\"\"><i class=\"fa-brands fa-twitter\"></i>Twitter</a></li>
                        <li><a href=\"\"><i class=\"fa-brands fa-instagram\"></i> Instagram</a></li>
                        <li><a href=\"\"><i class=\"fa-brands fa-bandcamp\"></i>Bandcamp</a></li>
                    </div>
                </div>
            

            </div>
            <div class=\"col-md-3 d-flex flex-column align-items-center\">
                <div class=\"address d-flex flex-column align-items-center\">
                    <h2>Nuestras oficinas</h2>
                    <img src=\"$ruta/assets/images/about/home_line.png\" alt=\"\" class=\"img-fluid\">
                    <div class=\"address-links\">
                        <li class=\"address1\"><i class=\"fa-solid fa-location-dot\"></i> 3 Abbey Rd, London
                        NW8 9AY, Reino Unido 
                           </li>
                           <li><a href=\"\"><i class=\"fa-solid fa-phone\"></i> +44 20 7266 7000</a></li>
                           <li><a href=\"\"><i class=\"fa-solid fa-envelope\"></i> sonicwaves@gmail.com</a></li>
                    </div>
                </div>
            </div>
          
        </div>
    </div>

</footer>";
}

