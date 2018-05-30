<?php
    
    require_once 'vendor/autoload.php';
    require_once 'remisero.php';
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

        /*
        public $id;
        public $nombre;
        public $tipo;
        public $fechaNacimiento;
        public $rutaDeFoto;
        */
    class remiseroApi extends remisero{
        public function alta($request, $response, $args){        
            
	        $nuevoRemisero = new remisero($_POST['nombre'], $_POST['apellido'], $_POST['usuario'], $_POST['password']);
            if(isset($_POST['vehiculo'])){
                $nuevoRemisero->vehiculo = $_POST['vehiculo'];
            }
            return $response->withJson($nuevoRemisero->guardarRemisero());
            

        }

        public function modificar($request, $response, $args){
            $id = $_POST['id'];
            $remiseroModificado = remisero::traerRemisero($id);
            
            if($remiseroModificado){
                
                $remiseroModificado->nombre = $_POST['nombre'];
                $remiseroModificado->apellido = $_POST['apellido'];
                $remiseroModificado->usuario = $_POST['usuario'];
                $remiseroModificado->password = $_POST['password'];
                if(isset($_POST['vehiculo'])){
                    $remiseroModificado->vehiculo = $_POST['vehiculo'];
                }
                
                return $response->withJson($remiseroModificado->modificarRemisero());    
            }
            else{
                return $response->withJson('No existe ningun remisero con ese id', 20);
            }
        }
        
        public function borrar($request, $response, $args){
            $id = $_POST['id'];
            if($id){
                return $response->withJson(remisero::borrarRemisero($id));
            }
            else{
                return $response->withJson("id invalido", 206);
            }
        }


        public static function listaRemiseroApi($request, $response, $args){
            
            $remiseros = remisero::traerRemiseros();  
            return $response->withJson($remiseros);
        }
    }


?>
