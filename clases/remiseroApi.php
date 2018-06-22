<?php
    
    require_once 'vendor/autoload.php';
    require_once 'remisero.php';
    require_once 'usuario.php';
    require_once 'viaje.php';
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
            
            $nuevoRemisero->guardarRemisero();
            $remiseroGuardado = remisero::buscarRemisero($remiseroGuardado->usuario, $remiseroGuardado->password);
            $nuevoUsuario = new usuario($remiseroGuardado->id, $remiseroGuardado->usuario, $remiseroGuardado->password, "remisero");
            return $response->withJson($nuevoUsuario->guardarUsuario());
            

        }

        public function modificar($request, $response, $args){
            $id = $_POST['id'];
            $remiseroModificado = remisero::traerRemisero($id);
            
            if($remiseroModificado){
                $usuarioModificado = usuario::traerUsuario($remiseroModificado->usuario, $remiseroModificado->password);
                $remiseroModificado->nombre = $_POST['nombre'];
                $remiseroModificado->apellido = $_POST['apellido'];
                $remiseroModificado->usuario = $_POST['usuario'];
                $remiseroModificado->password = $_POST['password'];
                if(isset($_POST['vehiculo'])){
                    $remiseroModificado->vehiculo = $_POST['vehiculo'];
                }
                if($remiseroModificado->modificarRemisero()){
                    return $response->withJson($usuarioModificado->modificarUsuario());                    
                }
                else{
                    return $response->withJson('error', 20);
                }

            }
            else{
                return $response->withJson('No existe ningun remisero con ese id', 20);
            }
        }
        
        public function borrar($request, $response, $args){
            $id = $_POST['id'];
            $remiseroBorrado = remisero::traerRemisero($id);
            if($remiseroBorrado){
                $usuarioBorrado = usuario::traerUsuario($remiseroBorrado->usuario, $remiseroBorrado->password);
                if($remiseroBorrado->borrar()){
                    return $response->withJson($usuarioBorrado->borrarUsuario());
                }
            }
            else{
                return $response->withJson("id invalido", 206);
            }
        }


        public static function listaRemiseroApi($request, $response, $args){
            
            $remiseros = remisero::traerRemiseros();  
            return $response->withJson($remiseros);
        }

        public function viajes($request, $response, $args){
            $id = $_POST['id'];
            $viajes = viaje::traerViajes();
            if($viajes){
                $viajesFiltrados = array();
                foreach ($viajes as $key => $value) {
                    if(isset($_POST['estado'])){
                        $estado = $_POST['estado'];
                        if($value->idRemisero == $id && $value->estado == $estado){
                            array_push($viajesFiltrados, $value);
                        }
                    }
                    else{
                        if($value->idRemisero == $id){
                            array_push($viajesFiltrados, $value);
                        }                        
                    }
                }
                return $response->withJson($viajesFiltrados);
            }
            else{
                return $response->withJson("viaje error", 206);
            }

        }

        public function asignar($request, $response, $args){
            $idVehiculo = $_POST['idVehiculo'];
            //$idRemisero = $_POST['idRemisero'];

            //$remisero = remisero::traerRemisero($idRemisero);
            //if($remisero){
                //return $response->withJson($remisero->asignarVehiculo($idVehiculo));

            //}
            //return $response->withJson("asignar vehiculo error", 405);
            return $response->withJson($_POST);
        }
    }


?>
