<?php
    
    require_once 'vendor/autoload.php';
    require_once 'vehiculo.php';
    require_once 'usuario.php';
    require_once 'viaje.php';
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    class vehiculoApi extends vehiculo{
        public static function libres($request, $response, $args){
            
            $vehiculos = vehiculo::noAsignados();  
            return $response->withJson($vehiculos);
        }

        public static function todos($request, $response, $args){
            
            $vehiculos = vehiculo::traerVehiculos();  
            return $response->withJson($vehiculos);
        }               	
    }    
 ?>