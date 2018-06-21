<?php
    include_once("accesoDatos.php");

    class vehiculo {
    	public $id;
        public $marca;
        public $modelo;
        public $año;
        public $premium;

        function __construct( $marca = NULL, $modelo = NULL, $año = NULL, $premium = NULL ){
            if( $marca != NULL && $modelo != NULL && $año != NULL && $premium != NULL){
                $this->marca = $marca;
                $this->modelo = $modelo;
                $this->año = $año;
                $this->premium = $premium;
            }
        }
        public function guardarVehiculo(){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();

            $consulta = $objetoAccesoDatos->retornarConsulta(
                "INSERT INTO vehiculo (marca, modelo, año, premium)" .
                " VALUES(:marca, :modelo, :año, :premium)"
            );

            $consulta->bindValue(":marca", $this->marca, PDO::PARAM_STR);
            $consulta->bindValue(":modelo", $this->modelo, PDO::PARAM_STR);
            $consulta->bindValue(":año", $this->año, PDO::PARAM_STR);
            $consulta->bindValue(":premium", $this->premium, PDO::PARAM_INT);
            $retorno = $consulta->execute();
            if($retorno && $consulta->rowCount() == 0){
                $retorno = false;
            }
            return $retorno;
        }

        public function noAsignados(){
        	$listaVehiculos = array();
        	$objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
        	$consulta = $objetoAccesoDatos->retornarConsulta(
				"SELECT * FROM vehiculo
				WHERE vehiculo.id NOT IN
				(SELECT vehiculo.id from vehiculo
				WHERE vehiculo.id IN ( SELECT remisero.vehiculo FROM remisero))"
        	);
        	$consulta->execute();
        	$listaVehiculos = $consulta->fetchAll(PDO::FETCH_CLASS, "vehiculo");
        	return $listaVehiculos;
        }

        public function traerVehiculos(){
        	$listaVehiculos = array();
        	$objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
        	$consulta = $objetoAccesoDatos->retornarConsulta(
        		"SELECT * FROM vehiculo"
        	);
        	$consulta->execute();
        	$listaVehiculos = $consulta->fetchAll(PDO::FETCH_CLASS, "vehiculo");
        	return $listaVehiculos;
        }

    }
?>
