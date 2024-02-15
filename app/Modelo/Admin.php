<?php
define('METHOD','AES-256-CBC');
define('SECRET_KEY','$CARLOS@2016');
define('SECRET_IV','101712');
require_once "../../config/Conexion.php";

class Admin
{

    public $cnx;

    function __construct()
    {
        $this->cnx = Conexion::ConectarDB();
    }

     // Método para comenzar una transacción
    public function beginTransaction()
    {
        $this->cnx->beginTransaction();
    }

     // Método para confirmar la transacción
    public function commit()
    {
        $this->cnx->commit();
    }

     // Método para revertir la transacción
    public function rollBack()
    {
        $this->cnx->rollBack();
    }

    function obtenerUsuarios(){
        $query = "SELECT * FROM usuarios WHERE status_usuario = 1 ORDER BY ID_usuario DESC";
        $result = $this->cnx->query($query);
        if ($result->execute()) {
            if ($result->rowCount() > 0) {
                while ($fila = $result->fetch(PDO::FETCH_ASSOC)) {
                    $datos[] = $fila;
                }
                return $datos;
            } else {
                return [];
            }
        } else {
            return false;
        }
    }

    function registrarUsuario($nombre, $telefono, $tipo, $password){
        $query = "INSERT INTO usuarios (telefono, nombre, password, tipo) VALUES (:telefono, :nombre, :password, :tipo)";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':telefono', $telefono);
        $result->bindParam(':nombre', $nombre);
        $result->bindParam(':password', $password);
        $result->bindParam(':tipo', $tipo);
        return $result->execute();
    }

    function desactivarUsuario($id){
        $query = "UPDATE usuarios SET estatus = 'baja' WHERE id = :id";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':id', $id);
        return $result->execute();
    }

    function existenciaUsuario($telefono){
        $query = "SELECT * FROM usuarios WHERE telefono = :telefono AND estatus = 'activo'";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':telefono', $telefono);
        if ($result->execute()) {
            if ($result->rowCount() > 0) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    function encryption($string){
        $output=FALSE;
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output=base64_encode($output);
        return $output;
    }

    public static function decryption($string){
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }

    function obtenerPassword($idUsuario){
        $query = "SELECT password FROM usuarios WHERE id = :idUsuario";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':idUsuario', $idUsuario);
        $result->execute();
        $fila = $result->fetch();
        return $fila['password'];
    }

    function obtenerInfoUsuario($idUsuario){
        $query = "SELECT * FROM usuarios WHERE id = :idUsuario";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':idUsuario', $idUsuario);
        if ($result->execute()) {
            if ($result->rowCount() > 0) {
                $datos = $result->fetch(PDO::FETCH_ASSOC);
                return $datos;
            } else {
                return [];
            }
        }else {
            return false;
        }
    }

    function actualizarUsuario($idUsuario, $nombre, $telefono, $tipo){
        $query = "UPDATE usuarios SET nombre = :nombre, telefono = :telefono, tipo = :tipo WHERE id = :idUsuario";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':idUsuario', $idUsuario);
        $result->bindParam(':nombre', $nombre);
        $result->bindParam(':telefono', $telefono);
        $result->bindParam(':tipo', $tipo);
        return $result->execute();
    }
}