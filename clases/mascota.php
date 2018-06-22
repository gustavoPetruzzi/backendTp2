<?php
    include_once("accesoDatos.php");

    class Mascota {
        public $nroFicha;
        public $raza;
        public $color;
        public $edad;
        public $tipo;
        public $idCliente;

        function __construct($raza = NULL, $color = NULL, $edad = NULL, $tipo = NULL, $idCliente = NULL){
            if($raza != NULL && $color != NULL && $edad != NULL && $tipo != NULL && $idCliente != NULL) {
                $this->raza = $raza;
                $this->color = $color;
                $this->edad = $edad;
                $this->tipo = $tipo;
                $this->idCliente = $idCliente;
            }
        }

            public static function TraerMascota($id){
                $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
                $consulta = $objetoAccesoDatos->retornarConsulta("SELECT id, nombre, tipo fechaNacimiento, rutaDeFoto FROM mascotas WHERE id = :id");
                $consulta->bindValue(":id",$mail,PDO::PARAM_STR);
                $consulta->setFetchMode(PDO::FETCH_CLASS, "mascota");
                $consulta->execute();
                $mascota = $consulta->fetch();
                return $mascota;
            }



            public static function TraerMascotas(){
                $listaMascotas = array();
                $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
                $consulta = $objetoAccesoDatos->retornarConsulta("SELECT id, nombre, tipo, fechaNacimiento, rutaDeFoto FROM mascotas");
                $consulta->execute();
                $listaMascotas= $consulta->fetchAll(PDO::FETCH_CLASS, "mascota");
                return $listaMascotas;
            }
            public  function modificarMascota(){
                $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
                $consulta = $objetoAccesoDatos->RetornarConsulta("UPDATE mascotas SET nombre = :nombre, tipo = :tipo, fechaNacimiento = :fechaNacimiento, rutaDeFoto = :rutaDeFoto  ,  WHERE id =:id");
                $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
                $consulta->bindValue(":tipo", $this->tipo, PDO::PARAM_STR);
                $consulta->bindValue(":fechaNacimiento", $this->fechaNacimiento, PDO::PARAM_STR);
                $consulta->bindValue(":rutaDeFoto", $this->rutaDeFoto, PDO::PARAM_STR);                
                $retorno = $consulta->execute();
                if($retorno && $consulta->rowCount() == 0){
                    $retorno = false;
                }
                return $retorno;
            }
            
            public  function guardarMascota(){
                $objetoGuardarDatos = accesoDatos::DameUnObjetoAcceso();
                $consulta = $objetoGuardarDatos->RetornarConsulta("INSERT INTO mascotas (raza, color, edad, tipo, idCliente)"
                                                                . " VALUES(:raza, :color, :edad, :tipo, :idCliente)");
                //$activo = 0;                                                         
                $consulta->bindValue(":raza", $this->raza, PDO::PARAM_STR);
                $consulta->bindValue(":color", $this->color, PDO::PARAM_STR);
                $consulta->bindValue(":edad", $this->edad, PDO::PARAM_INT);
                $consulta->bindValue(":tipo", $this->tipo, PDO::PARAM_STR);
                $consulta->bindValue(":idCliente", $this->idCliente, PDO::PARAM_INT);
                $retorno = $consulta->execute();
                if($retorno && $consulta->rowCount() == 0){
                    $retorno = false;
                }
                return $retorno;
            }

            public static function borrarMascota($id){
                $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
                $consulta = $objetoAccesoDatos->retornarConsulta("DELETE FROM mascotas WHERE id= :id");
                $consulta->bindValue(":id", $id, PDO::PARAM_STR);
                
                $retorno = $consulta->execute();
                if($retorno && $consulta->rowCount() == 0 ){
                    
                    $retorno = false;
                }
                            
                return $retorno;
            }







                /*
                        public static function buscarEmpleado($id){
                $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
                $consulta = $objetoAccesoDatos->retornarConsulta("SELECT id , nombre, apellido, usuario, pass as _pass, activo, admin FROM empleados
                                                                WHERE id = :id");
                $consulta->bindValue(":id", $id, PDO::PARAM_INT);
                $consulta->setFetchMode(PDO::FETCH_CLASS, "empleado");
                $consulta->execute();
                if($consulta->rowCount() == 0){
                    return false;
                }
                $empleado = $consulta->fetch();
                return $empleado;
            }
            */
        
    }
?>