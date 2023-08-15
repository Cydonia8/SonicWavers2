<?php
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
     $dotenv = Dotenv\Dotenv::createImmutable('.');
     $dotenv->load();

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

     function decodeToken($token){
        try{
            $jwt_dec = JWT::decode($token, new Key($_ENV["SECRET_KEY"], "HS256")); 
            return $jwt_dec;        
        } catch (UnexpectedValueException $e) {
            echo "No se ha podido validar su sesión";
            unset($_SESSION["token"]);
            return false;
        }catch(ExpiredException $e){
            echo "Su sesión ha expirado";
            unset($_SESSION["token"]);
            return false;
        }
    }

    function printMainMenu($location = "noindex"){

        if($location == "index"){
            if(isset($_SESSION["token"])){
                $token_decoded = decodeToken($_SESSION["token"]);
                $token_decoded = json_decode(json_encode($token_decoded), true);
                if($token_decoded["data"]["admin"]){
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
                }elseif($token_decoded["data"]["role"] == "user"){
                    $foto = imageUser($token_decoded["data"]["user"], "usuario", "usuario");
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
                }elseif($token_decoded["data"]["role"] == "group"){
                    $foto = imageUser($token_decoded["data"]["user"], "grupo", "correo");
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
                    $foto = imageUser($token_decoded["data"]["user"], "patrons", "mail");
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
                                            <li><a class=\"dropdown-item\" href=\"patrons/patrons_main.php\">Perfil</a></li>
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
            if(isset($_SESSION["token"])){
                if($token_decoded["data"]["admin"]){
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
                }elseif($token_decoded["data"]["role"] == "user"){
                    $foto = imageUser($token_decoded["data"]["user"], "usuario", "usuario");
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
                }elseif($token_decoded["data"]["role"] == "group"){
                    $foto = imageUser($token_decoded["data"]["user"], "grupo", "correo");
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
                    $foto = imageUser($token_decoded["data"]["user"], "patrons", "mail");
                    echo "<header class=\"header-index\">
                    <a href='../index.php' class='enlace-index'><img src=\"../media/assets/sonic-waves-high-resolution-logo-color-on-transparent-background (1).png\" alt=\"\"></a>
                        <nav>
                            <ul class=\"links-header\"> 
                                <li><a href=\"../contacto/contacto.php\">Contacto</a></li>
                                <li class=\"li-foto\">
                                    <div class=\"dropdown\">
                                        <img data-bs-toggle=\"dropdown\" aria-expanded=\"false\" class=\"rounded-circle dropdown-toggle\" src=\"$foto\">
                                        <ul class=\"dropdown-menu\">
                                            <li><a class=\"dropdown-item\" href=\"../patrons/patrons_main.php\">Perfil</a></li>
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

    function decodeCookie(){
        if(isset($_COOKIE['sesion'])){
            session_decode($_COOKIE['sesion']);
        }
    }
?>