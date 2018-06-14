<?php
    include_once("accesoDatos.php");

    class viaje {
        public $id;
        public $estado;
        public $origen_long;
        public $origen_lat;
        public $destino_long;
        public $destino_lat;
        public $fecha;
        public $hora;
        public $idRemisero;
        public $idCliente;
        public $monto;
        function __construct(
            $origen_lat = NULL,
            $origen_long = NULL, 
            $destino_lat =NULL, 
            $destino_long =NULL,
            $fecha =NULL,
            $hora = NULL,
            $idCliente = NULL){
                if($origen_lat != NULL && $origen_long != NULL && $destino_lat != NULL && $destino_long != NULL && $fecha != NULL && $hora != NULL && $idCliente != NULL){
                    $this->origen_lat = $origen_lat;
                    $this->origen_long = $origen_long;
                    $this->destino_lat = $destino_lat;
                    $this->destino_long = $destino_long;
                    $this->fecha = $fecha;
                    $this->hora = $hora;
                    $this->idCliente = $idCliente;
                    $this->estado = "solicitado";
                }
            }
        
        public function guardarViaje(){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "INSERT INTO viaje (origen_lat, origen_long, destino_lat, destino_long, fecha, hora, idCliente, estado)" .
                " VALUES (:origen_lat, :origen_long, :destino_lat, :destino_long, :fecha, :hora, :idCliente, :estado)"
            );
            $consulta->bindValue(":origen_lat", $this->origen_lat, PDO::PARAM_STR);
            $consulta->bindValue(":origen_long", $this->origen_long, PDO::PARAM_STR);
            $consulta->bindValue(":destino_lat", $this->destino_lat, PDO::PARAM_STR);
            $consulta->bindValue(":destino_long", $this->destino_long, PDO::PARAM_STR);
            $consulta->bindValue(":fecha", $this->fecha, PDO::PARAM_STR);
            $consulta->bindValue(":hora", $this->hora, PDO::PARAM_STR);
            $consulta->bindValue(":idCliente", $this->idCliente, PDO::PARAM_INT);
            $consulta->bindValue(":estado", $this->estado, PDO::PARAM_STR);

            $retorno = $consulta->execute();
            if($retorno && $consulta->rowCount() == 0){
                $retorno = false;
            }
            return $retorno;
        }

        public function modificarViaje(){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "UPDATE viaje SET origen_lat = :origen_lat, origen_long = :origen_long, destino_lat = :destino_lat, destino_long = :destino_long, fecha = :fecha, hora = :hora,
                 idCliente = :idCliente, estado = :estado WHERE id = :id"
            );
            $consulta->bindValue(":origen_lat", $this->origen_lat, PDO::PARAM_STR);
            $consulta->bindValue(":origen_long", $this->origen_long, PDO::PARAM_STR);
            $consulta->bindValue(":destino_lat", $this->destino_lat, PDO::PARAM_STR);
            $consulta->bindValue(":destino_long", $this->destino_long, PDO::PARAM_STR);
            $consulta->bindValue(":fecha", $this->fecha, PDO::PARAM_STR);
            $consulta->bindValue(":hora", $this->hora, PDO::PARAM_STR);
            $consulta->bindValue(":idCliente", $this->idCliente, PDO::PARAM_INT);
            $consulta->bindValue(":estado", $this->estado, PDO::PARAM_STR);
            $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
            $retorno = $consulta->execute();
            if($retorno && $consulta->rowCount() == 0){
                $retorno = false;
            }
            return $retorno;
        }

        public function cancelarViaje(){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $this->estado = "cancelado";
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "UPDATE viaje SET estado = :estado WHERE id = :id"
            );
            $consulta->bindValue(":estado",$this->estado, PDO::PARAM_STR);
            $consulta->bindValue(":id",$this->id, PDO::PARAM_INT);
            $retorno = $consulta->execute();
            if($retorno && $consulta->rowCount() == 0){
                $retorno = false;
            }
            return $retorno;
            
        }

        public function asignarViaje($idRemisero){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $this->estado = "asignado";
            $this->idRemisero = $idRemisero;
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "UPDATE viaje SET estado = :estado, idRemisero = :idRemisero
                 WHERE id = :id"
            );
            $consulta->bindValue(":estado", $this->estado, PDO::PARAM_STR);
            $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
            $consulta->bindValue(":idRemisero", $this->idRemisero, PDO::PARAM_INT);
            $retorno = $consulta->execute();
            if($retorno && $consulta->rowCount() == 0){
                $retorno = false;
            }
            return $retorno;

        }

        public function comenzarViaje(){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $this->estado = "transcurso";
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "UPDATE viaje SET estado = :estado
                 WHERE id = :id"
            );
            $consulta->bindValue(":estado",$this->estado, PDO::PARAM_STR);
            $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
            $retorno = $consulta->execute();
            if($retorno && $consulta->rowCount() == 0){
                $retorno = false;
            }
            return $retorno;
        }

        public function finalizarViaje($monto){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $this->estado = "realizado";
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "UPDATE viaje SET estado = :estado, monto = :monto
                 WHERE id = :id"
            );
            $consulta->bindValue(":estado",$this->estado, PDO::PARAM_STR);
            $consulta->bindValue(":id",$this->id, PDO::PARAM_STR);
            $consulta->bindValue(":monto",$monto,PDO::PARAM_STR);
            $retorno = $consulta->execute();
            if($retorno && $consulta->rowCount() == 0){
                $retorno = false;
            }
            return $retorno;
        }

        public static function traerViajes($estado = false){
            $listaViajes= array();
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "SELECT id, estado, origen_lat, origen_long, destino_lat, 
                        destino_long, fecha, hora, idRemisero, idCliente,
                        monto
                 FROM viaje
                 WHERE estado = :estado"
            );
            if($estado){
                $consulta = $objetoAccesoDatos->retornarConsulta(
                    "SELECT id, estado, origen_lat, origen_long, destino_lat, 
                            destino_long, fecha, hora, idRemisero, idCliente,
                            monto
                    FROM viaje
                    WHERE estado = :estado"
                );
                $consulta->bindValue(":estado", $estado, PDO::PARAM_STR);                
            }
            else{
                $consulta = $objetoAccesoDatos->retornarConsulta(
                    "SELECT id, estado, origen_lat, origen_long, destino_lat,
                            destino_long, fecha, hora, idRemisero, idCliente,
                            monto
                    FROM viaje"
                );
            }

            $consulta->execute();
            $listaViajes = $consulta->fetchAll(PDO::FETCH_CLASS, "viaje");
            return $listaViajes;
        }


        public static function traerViaje($id){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "SELECT id, estado, origen_lat, origen_long, destino_lat, 
                        destino_long, fecha, hora, idRemisero, idCliente,
                        monto
                 FROM viaje
                 WHERE id = :id"
            );
            $consulta->bindValue(":id",$id, PDO::PARAM_INT);
            $consulta->setFetchMode(PDO::FETCH_CLASS, "viaje");
            $consulta->execute();
            $viaje = $consulta->fetch();
            return $viaje;            
        }
        
    }
?>