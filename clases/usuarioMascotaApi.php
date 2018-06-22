<?php
    
    require_once 'vendor/autoload.php';
    require_once 'usuarioMascota.php';
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    class usuarioMascotaApi extends usuarioMascota{
        public function alta($request, $response, $args){        
            
	        $nuevoUsuarioMascota = new usuarioMascota($_POST['email'], $_POST['clave'], $_POST['tipo']);
			return $response->withJson($nuevoUsuarioMascota->guardarUsuario());
        }

        public function modificar($request, $response, $args){
        	//$id= $_POST['id'];

        }
