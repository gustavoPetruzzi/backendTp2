<?php

	require_once 'vendor/autoload.php';
    require_once 'viaje.php';
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    class viajeApi extends viaje{
    	public function alta($request, $response,$args){

    		$nuevoViaje = new viaje(
    			$_POST['origen_lat'], 
    			$_POST['origen_long'],
    			$_POST['destino_lat'],
    			$_POST['destino_long'],
    			$_POST['fecha'],
    			$_POST['hora'],
    			$_POST['idCliente'] );
    		return $response->withJson($nuevoViaje->guardarViaje());
    	}

    	public function modificar($request, $response, $args){
            $id = $_POST['id'];
            $viajeModificado = viaje::traerViaje($id);
            
            if($viajeModificado){
                $viajeModificado->origen_lat = $_POST['origen_lat'];
                $viajeModificado->origen_long = $_POST['origen_long'];                
                $viajeModificado->destino_lat = $_POST['destino_lat'];
                $viajeModificado->destino_long = $_POST['destino_long'];
                $viajeModificado->fecha = $_POST['fecha'];
                $viajeModificado->hora = $_POST['hora'];
                $viajeModificado->idCliente = $_POST['idCliente'];
                $viajeModificado->estado = $_POST['estado'];
                return $response->withJson($viajeModificado->modificarViaje());    
            }
            else{
                return $response->withJson('No existe ningun viaje con ese id', 20);
            }
    	}
    	public function cancelar($request, $response, $args){
    		$id = $_POST['idViaje'];
    		$viajeCancelado = viaje::traerViaje($idViaje);
    		if($viajeCancelado){
    			return $response->withJson($viajeCancelado->cancelarViaje());
    		}
    		else{
    			return $response->withJson('No existe ningun viaje con ese id', 20);
    		}
    	}

    	public function asignar($request, $response, $args){
    		$idViaje = $_POST['idViaje'];
    		$idRemisero = $_POST['idRemisero'];
    		$viajeAsignado = viaje::traerViaje($idViaje);
    		if($viajeAsignado){
    			return $response->withJson($viajeAsignado->asignarViaje($idRemisero));
    		}
    		else{
    			return $response->withJson('No existe ningun viaje con ese id', 20);
    		}
    	}

    	public function comenzar($request, $response, $args){
    		$idViaje = $_POST['idViaje'];
    		$viajeComenzado = viaje::traerViaje($idViaje);
    		if($viajeComenzado){
    			return $response->withJson($viajeComenzado->comenzarViaje());
			}
			else{
				return $response->withJson('No existe ningun viaje con ese id', 20);
			}
		}
		
		public function finalizar($request, $response, $args){
			$idViaje = $_POST['idViaje'];
			$monto = $_POST['monto'];
			$viajeFinalizado = viaje::traerViaje($idViaje);
			if($viajeFinalizado){
				return $response->withJson($viajeFinalizado->finalizarViaje($monto));
			}
			else{
				return $response->withJson('No existe ningun viaje con ese id', 20);
			}
		}
		public function listaViajeApi($request, $response, $args){
			if(isset($_GET['estado'])){
				$viajes = viaje::traerViajes($_GET['estado']);
			}
			else{
				$viajes = viaje::traerViajes("todos");
			}
			return $response->withJson($viajes);
		}
    }