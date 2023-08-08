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

    function getStyles(){
        $con = createConnection();
        $consulta = $con->prepare("SELECT nombre, id FROM estilo");
        $consulta->bind_result($nombre, $id);
        $consulta->execute();
        while($consulta->fetch()) {
            echo "<option class=\"p-2\" value=\"$id\">$nombre</option>";
        }
        $consulta->close();
        $con->close();
    }

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

    function mailRepeated($mail, $tabla){
        $exists = true;
        $con = createConnection();
        $consulta = $con->prepare("SELECT COUNT(*) from $tabla where correo = ?");
        $consulta->bind_param("s", $mail);
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

    function generateToken($mail, $is_admin){

        $time = time();
        $token = array(
            "iat" => $time, //Moment when token is created
            "exp" => $time + 3600, //Expiration date of the token
            "data" => [
                "user" => $mail,
                "admin" => $is_admin
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
            $jwt_dec = JWT::decode($token, new Key("aa", "HS256")); 
            return $jwt_dec;        
        } catch (UnexpectedValueException $e) {
            echo "No se ha podido validar su sesión";
            return false;
        }catch(ExpiredException $e){
            echo "Su sesión ha expirado";
            return false;
        }
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

    function petitionStatus($mail, $tabla){
        $con = createConnection();
        $consulta = $con->prepare("SELECT activo from $tabla where correo = ?");
        $consulta->bind_param('s', $mail);
        $consulta->bind_result($estado);
        $consulta->execute();
        $consulta->fetch();
        $consulta->close();
        $con->close();
        return $estado;
    }