<?php
    include_once("accesoDatos.php");

    class Mascota {
        public $id;
        public $nombre;
        public $tipo;
        public $fechaNacimiento;
        public $rutaDeFoto;

        function __construct($id = NULL, $nombre = NULL, $tipo = NULL, $fechaNacimiento = NULL){
            if($id != NULL && $nombre != NULL && $tipo != NULL && $fechaNacimiento != NULL){
                $this->id = $id;
                $this->nombre = $nombre;
                $this->tipo = $tipo;
                $this->fechaNacimiento = $fechaNacimiento;
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
                $consulta = $objetoGuardarDatos->RetornarConsulta("INSERT INTO mascotas (id, nombre, tipo, fechaNacimiento)"
                                                                . " VALUES(:id, :nombre, :tipo, :fechaNacimiento)");
                //$activo = 0;
                $consulta->bindValue(":id", $this->id, PDO::PARAM_STR);                                                             
                $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);                                                             
                $consulta->bindValue(":tipo", $this->tipo, PDO::PARAM_STR);
                $consulta->bindValue(":fechaNacimiento",$this->fechaNacimiento, PDO::PARAM_STR);
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