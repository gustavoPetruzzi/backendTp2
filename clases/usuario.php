<?php
    include_once("accesoDatos.php");

    class usuario{
        public $id;
        public $usuario;
        public $password;
        public $tipo;

        public function __construct($id = NULL, $usuario = NULL, $password = NULL, $tipo = NULL){
            if($id != NULL && $usuario != NULL && $password != NULL && $tipo != NULL){
                $this->id = $id;
                $this->usuario = $usuario;
                $this->password = $password;
                $this->tipo = $tipo;
            }
        }

        public function guardarUsuario(){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "INSERT INTO usuario (id, usuario, password, tipo)" .
                " VALUES(:id, :usuario, :password, :tipo)"
            );
            $consulta->bindValue(":id",$this->id, PDO::PARAM_INT);
            $consulta->bindValue(":usuario", $this->usuario, PDO::PARAM_STR);
            $consulta->bindValue(":password", $this->password, PDO::PARAM_STR);
            $consulta->bindValue(":tipo", $this->tipo, PDO::PARAM_STR);
            $retorno = $consulta->execute();
            if($retorno && $consulta->rowCount() == 0){
                $retorno = false;
            }
            return $retorno;
        }

        public function modificarUsuario(){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "UPDATE usuario SET id= :id, usuario = :usuario, password = :password, tipo = :tipo
                 WHERE id = :id"
            );
            $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
            $consulta->bindValue(":usuario", $this->usuario, PDO::PARAM_STR);
            $consulta->bindValue(":password", $this->password, PDO::PARAM_STR);
            $consulta->bindValue(":tipo", $this->password, PDO::PARAM_STR);
            $retorno = $consulta->execute();
            if($retorno && $consulta->rowCount() == 0){
                $retorno = false;
            }
            return $retorno;
        }

        public static function traerUsuario($usuario, $password){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "SELECT id, usuario, password, tipo
                 FROM usuario
                 WHERE usuario = :usuario AND password = :password"
            );
            $consulta->bindValue(":usuario", $usuario, PDO::PARAM_STR);
            $consulta->bindValue(":password", $password, PDO::PARAM_STR);
            $consulta->setFetchMode(PDO::FETCH_CLASS, "usuario");
            $consulta->execute();
            $usuario = $consulta->fetch();
            return $usuario;
        }

        public function borrarUsuario(){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "DELETE FROM usuario
                 WHERE usuario = :usuario AND password = :password"
            );
            $consulta->bindValue(":usuario", $this->usuario, PDO::PARAM_STR);
            $consulta->bindValue(":password", $this->password, PDO::PARAM_STR);
            $retorno = $consulta->execute();
            if($retorno && $consulta->rowCount() == 0){
                $retorno = false;
            }
            return $retorno;
        }
    }
?>