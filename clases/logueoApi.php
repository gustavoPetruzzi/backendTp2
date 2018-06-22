<?php

    require_once 'vendor/autoload.php';
    require_once 'remisero.php';
    require_once 'cliente.php';
    require_once 'usuario.php';
    require_once 'autentificadorJwt.php';
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    class logueoApi{
        public function getToken($request, $response, $args){
            $retorno['token'] = autentificadorJwt::crearToken(array(
                'id'=> '1',
                'usuario'=> 'algo' ,
                'admin' => 'si',
            ));
            return $response->withJson($retorno);
        }

        public function login($request, $response, $args){
            sleep(5);
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];
            $usuarioLogueado = usuario::traerUsuario($usuario, $password);
            if($usuarioLogueado){
                $retorno['token'] = autentificadorJwt::crearToken(array(
                    'id' => $usuarioLogueado->id,
                    'usuario' => $usuarioLogueado->usuario,
                    'tipo' => $usuarioLogueado->tipo,
                ));
                return $response->withJson($retorno);
            }
            return $response->withJson("error logueo",405);
        }

        public function registrar($request, $response, $args){
            $usuario = $_POST['usuario'];
            $password= $_POST['password'];
            $tipo = $_POST['tipo'];
            if($tipo == 'cliente'){
                $cliente = new cliente("N", "N", $usuario, $password);
                if($cliente->guardarCliente()){
                    $clienteGuardado = cliente::buscarCliente($usuario, $password);
                    $usuario = new usuario($clienteGuardado->id, $clienteGuardado->usuario, $clienteGuardado->password, 'cliente');
                    return $response->withJson($usuario->guardarUsuario());
                }

            }
        }
    }