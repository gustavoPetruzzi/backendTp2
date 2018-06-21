<?php

    require_once 'vendor/autoload.php';
    require_once 'remisero.php';
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
            return $response->withJson("LA CONCHA DE TU MADRE",405);
        }
    }