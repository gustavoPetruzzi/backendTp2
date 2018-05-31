<?php
    include_once("accesoDatos.php");

    class cliente {
        public $id;
        public $nombre;
        public $apellido;
        public $usuario;
        public $password;

        function __construct($nombre = NULL, $apellido = NULL, $usuario = NULL, $password = NULL){
            if($nombre != NULL && $apellido != NULL && $usuario != NULL && $password != NULL){
                $this->nombre = $nombre;
                $this->apellido = $apellido;
                $this->usuario = $usuario;
                $this->password = $password;
            }
        }
        public static function traerCliente($id){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "SELECT id, nombre, apellido, usuario, password
                 FROM cliente WHERE id = :id"
            );
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);
            $consulta->setFetchMode(PDO::FETCH_CLASS, "cliente");
            $consulta->execute();
            $cliente = $consulta->fetch();
            return $cliente;   
        }
        
        public function guardarCliente(){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "INSERT INTO cliente (nombre, apellido, usuario, password)" .
                " VALUES(:nombre, :apellido, :usuario, :password)"
            );
            $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(":apellido", $this->apellido, PDO::PARAM_STR);
            $consulta->bindValue(":usuario", $this->usuario, PDO::PARAM_STR);
            $consulta->bindValue(":password", $this->password, PDO::PARAM_STR);
            $retorno = $consulta->execute();
            if($retorno && $consulta->rowCount() == 0){
                $retorno = false;
            }
            return $retorno;
        }

        public static function borrarCliente($id){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "DELETE FROM cliente WHERE id = :id"
            );
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);
            $retorno = $consulta->execute();
            if($retorno && $consulta->rowCount() == 0){
                $retorno = false;
            }
            return $retorno;
        }

        public function modificarCliente(){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "UPDATE cliente SET nombre = :nombre, apellido = :apellido, usuario = :usuario, password = :password
                 WHERE id = :id"
            );
            $consulta->bindValue(":nombre",$this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(":apellido", $this->apellido, PDO::PARAM_STR);
            $consulta->bindValue(":usuario", $this->usuario, PDO::PARAM_STR);
            $consulta->bindValue(":password",$this->password, PDO::PARAM_STR);
            $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
            $retorno = $consulta->execute();
            if($retorno && $consulta->rowCount() == 0){
                $retorno = false;
            }
            return $retorno;
        }

        public static function traerClientes(){
            $listaClientes = array();
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "SELECT id, nombre, apellido, usuario, password
                 FROM cliente"
            );
            $consulta->execute();
            $listaClientes = $consulta->fetchAll(PDO::FETCH_CLASS, "cliente");
            return $listaClientes;
        }

        
    }
?>