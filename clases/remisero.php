<?php
    include_once("accesoDatos.php");

    class remisero {
        public $id;
        public $nombre;
        public $apellido;
        public $usuario;
        public $password;
        public $vehiculo;

        function __construct( $nombre = NULL, $apellido = NULL, $usuario = NULL, $password = NULL ){
            if( $nombre != NULL && $apellido != NULL && $usuario != NULL && $password != NULL){
                $this->nombre = $nombre;
                $this->apellido = $apellido;
                $this->usuario = $usuario;
                $this->password = $password;
            }
        }

        public static function traerRemisero($id){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "SELECT id, nombre, apellido, usuario, password, vehiculo
                FROM remisero WHERE id = :id"
            );
            $consulta->bindValue(":id",$id, PDO::PARAM_INT);
            $consulta->setFetchMode(PDO::FETCH_CLASS, "remisero");
            $consulta->execute();
            $remisero = $consulta->fetch();
            return $remisero;            
        }

        public function guardarRemisero(){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            if(isset($this->vehiculo)){
                $consulta = $objetoAccesoDatos->retornarConsulta(
                    "INSERT INTO remisero (nombre, apellido, usuario, password, vehiculo)" .
                    " VALUES(:nombre, :apellido, :usuario, :password, :vehiculo)"
                );
                $consulta->bindValue(":vehiculo", $this->vehiculo, PDO::PARAM_INT);
            }
            else{
                $consulta = $objetoAccesoDatos->retornarConsulta(
                    "INSERT INTO remisero (nombre, apellido, usuario, password)" .
                    " VALUES(:nombre, :apellido, :usuario, :password)"
                );
            }

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

        public static function borrarRemisero($id){
            
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "DELETE FROM remisero WHERE id = :id"
            );
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);
            $retorno = $consulta->execute();
            if($retorno && $consulta->rowCount() == 0){
                $retorno = false;
            }
            return $retorno;
        }

        public function modificarRemisero(){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            if(isset($this->vehiculo)){
                $consulta = $objetoAccesoDatos->retornarConsulta(
                    "UPDATE remisero SET nombre = :nombre, apellido = :apellido, usuario =:usuario, password = :password, vehiculo = :vehiculo
                    WHERE id =:id"
                );
                $consulta->bindValue(":vehiculo", $this->vehiculo, PDO::PARAM_INT);                
            }
            else{
                $consulta = $objetoAccesoDatos->retornarConsulta(
                    "UPDATE remisero SET nombre = :nombre, apellido = :apellido, usuario =:usuario, password = :password
                    WHERE id =:id"
                );                
            }

            $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(":apellido", $this->apellido, PDO::PARAM_STR);
            $consulta->bindValue(":usuario", $this->usuario, PDO::PARAM_STR);
            $consulta->bindValue(":password", $this->password, PDO::PARAM_STR);
            $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
            $retorno = $consulta->execute();
            if($retorno && $consulta->rowCount() == 0){
                $retorno = false;
            }
            return $retorno;
        }

        public static function buscarRemisero($id){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "SELECT id, nombre, apellido, usuario, password
                 FROM remisero
                 WHERE id=:id"
            );
            
        }
        public static function traerRemiseros(){
            $listaRemiseros = array();
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "SELECT id, nombre, apellido, usuario, password 
                 FROM remisero"
            );
            $consulta->execute();
            $listaRemiseros = $consulta->fetchAll(PDO::FETCH_CLASS, "remisero");
            return $listaRemiseros;
        }

        public function asignarVehiculo($idVehiculo){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "UPDATE remisero SET vehiculo = :vehiculo
                 WHERE id = :id"
            );
            $consulta->bindValue(":vehiculo",$idVehiculo, PDO::PARAM_INT);
            $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
            $retorno = $consulta->execute();
            if($retorno && $consulta->rowCount() == 0){
                $retorno = false;
            }
            return $retorno;
        }
    }
?>