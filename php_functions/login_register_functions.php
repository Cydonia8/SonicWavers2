<?php
    require_once "general.php";
    require_once "../vendor/autoload.php";

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    $dotenv = Dotenv\Dotenv::createImmutable('../');
    $dotenv->load();
    
    // function printKey(){
    //     echo $_ENV["SECRET_KEY"];
    // }
    // printKey();


    function userNameRepeated($user){
        $exists = true;
        $con = createConnection();
        $consulta = $con->prepare("SELECT COUNT(*) from USUARIO where usuario = ?");
        $consulta->bind_param("s", $user);
        $consulta->bind_result($count);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();

        if($count == 0){
            $exists = false;
        }
        return $exists;
    }

    function mailRepeated($mail, $table){
        $exists = true;
        $con = createConnection();
        $query = $con->prepare("SELECT COUNT(*) from $table where mail = ?");
        $query->bind_param("s", $mail);
        $query->bind_result($count);
        $query->execute();
        $query->fetch();
        $query->close();
        $con->close();

        if($count == 0){
            $exists = false;
        }
        return $exists;
    }

    function insertNewUser($user, $name, $surname, $pass, $mail, $style, $group){
        $con = createConnection();
        $pass = md5(md5($pass));
        $consulta = $con->prepare("INSERT INTO USUARIO (usuario, nombre, apellidos, pass, correo, estilo, grupo) VALUES (?,?,?,?,?,?,?)");
        $consulta->bind_param("sssssii", $user, $name, $surname, $pass, $mail, $style, $group);
        $consulta->execute();
        $consulta->close();
        $con->close();
    }

    function insertNewGroup($name, $pass, $mail, $discografica){
        $con = createConnection();
        $pass = md5(md5($pass));
        $consulta = $con->prepare("INSERT INTO grupo (nombre, pass, correo, discografica) VALUES (?,?,?,?)");
        $consulta->bind_param("sssi", $name, $pass, $mail, $discografica);
        $consulta->execute();
        $consulta->close();
        $con->close();
    }

    function insertNewDiscographic($nombre, $pass, $mail){
        $con = createConnection();
        $consulta = $con->prepare("INSERT INTO discografica (nombre, pass, correo) VALUES (?,?,?)");
        $consulta->bind_param("sss", $nombre, $pass, $mail);
        $consulta->execute();
        $consulta->close();
        $con->close();
    }

    function insertNewPatron($name, $pass, $mail){
        $con = createConnection();
        $pass = md5(md5($pass));
        $query = $con->prepare("INSERT INTO patrons (name, pass, mail) VALUES (?,?,?)");
        $query->bind_param("sss", $name, $pass, $mail);
        $query->execute();
        $query->close();
        $con->close();
    }
    

    function loginUser($user, $pass){
        $accede = false;
        $con = createConnection();
        $pass = md5(md5($pass));
        $consulta = $con->prepare("SELECT count(*) FROM USUARIO WHERE usuario = ? and pass = ?");
        $consulta->bind_param("ss", $user, $pass);
        $consulta->bind_result($count);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        if($count == 1){
            $accede = true;
        }

        return $accede;
    }

    function generateToken($mail, $is_admin, $role){

        $time = time();
        $token = array(
            "iat" => $time, //Moment when token is created
            "exp" => $time + 3600, //Expiration date of the token
            "data" => [
                "user" => $mail,
                "admin" => $is_admin, 
                "role" => $role
            ]
        );
    
        $jwt = JWT::encode($token, $_ENV["SECRET_KEY"], "HS256");
        // echo print_r($jwt);
        // $jwt_dec = JWT::decode($jwt, new Key("secretkey", "HS256"));
        // $decoded_array = (array) $jwt_dec;
        // echo $jwt;
        return $jwt;
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

    function forbidAccess($user_type){
        if(isset($_SESSION["token"])){
            $token_decoded = decodeToken($_SESSION["token"]);
            $token_decoded = json_decode(json_encode($token_decoded), true);
            if($token_decoded["data"]["role"] != $user_type){
                header("Location:../prohibido/forbidden.php");
            }
        }else{
            header("Location:../prohibido/forbidden.php");
        }
        // if(!isset($_SESSION["user"]) or $_SESSION["user-type"] != $tipo_usuario){
        //     header("Location:../prohibido/forbidden.php");
        // }
    }

    function loginGroupDisc($mail, $pass, $tabla){
        $accede = false;
        $con = createConnection();
        $pass = md5(md5($pass));
        $consulta = $con->prepare("SELECT count(*) FROM $tabla WHERE correo = ? and pass = ? and activo = 1");
        $consulta->bind_param("ss", $mail, $pass);
        $consulta->bind_result($count);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        if($count == 1){
            $accede = true;
        }

        return $accede;
    }

    function loginPatrons($mail, $pass, $table){
        $access = false;
        $con = createConnection();
        $pass = md5(md5($pass));
        $query = $con->prepare("SELECT count(*) FROM $table WHERE mail = ? and pass = ? and active = 1");
        $query->bind_param("ss", $mail, $pass);
        $query->bind_result($count);
        $query->execute();
        $query->fetch();
        $query->close();
        $con->close();
        if($count == 1){
            $access = true;
        }

        return $access;
    }

    function petitionStatus($mail, $table){
        $con = createConnection();
        $query = $con->prepare("SELECT active from $table where mail = ?");
        $query->bind_param('s', $mail);
        $query->bind_result($state);
        $query->execute();
        $query->fetch();
        $query->close();
        $con->close();
        return $state;
    }