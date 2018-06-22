<?php
	require_once 'vendor/autoload.php';
	require_once 'mascota.php';
	use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    class mascotaApi extends mascota {
        public function alta($request, $response, $args){        
            
	        $nuevaMascota = new mascota($_POST['raza'], $_POST['color'], $_POST['edad'], $_POST['tipo'], $_POST['idCliente']);
            return $response->withJson($nuevaMascota->guardarMascota());
            

        }    	
    }