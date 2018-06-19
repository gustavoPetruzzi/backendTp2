<?php
    require_once 'autentificadorJwt.php';
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;
    require_once 'vendor/autoload.php';

    class verificador{
        public function token($request, $response, $next){
            if($_POST['token']){
                $token = $_POST['token'];
                try{
                    $datos = autentificadorJwt::extraerData($token);
                }
                catch(Exception $e){
                    return $response->withJson($e->getMessage(), 511);
                }
                if($datos){
                    $request = $request->withAttribute('datos', $datos);
                    return $next($request, $response);    
                }
                return $response->withJson("Token vencido",400);
            }
            else{
                $token = $request->getAttribute('route')->getArgument('token');
                if($token){
                    try{
                        $datos = autentificadorJwt::extraerData($token);
                    }
                    catch(Exception $e){
                        return $response->withJson($e->getMessage(), 511);
                    }
                    $request = $request->withAttribute('datos', $datos);
                    return $next($request, $response);
                }
            }
            return $response->withJson("no se ha enviado ningun token", 400);
        }

        public static function remisero($request, $response, $next){
            $datos = $request->getAttribute('datos');
            if($datos->tipo == 'remisero'){
                return $next($request, $response);
            }
            else{
                $retorno['exito'] = false;
                $retorno['mensaje'] = "No tiene los permisos requeridos";
            }
            return $response->withJson($retorno);
        }
        public static function encargado($request, $response, $next){
            $datos = $request->getAttribute('datos');
            if($datos->tipo == 'encargado'){
                return $next($request, $response);
            }
            else{
                $retorno['exito'] = false;
                $retorno['mensaje'] = "No tiene los permisos requeridos";
            }
            return $response->withJson($retorno);
        }
        public static function cliente($request, $response, $next){
            $datos = $request->getAttribute('datos');
            if($datos->tipo == 'cliente'){
                return $next($request, $response);
            }
            else{
                $retorno['exito'] = false;
                $retorno['mensaje'] = "No tiene los permisos requeridos";
            }
            return $response->withJson($retorno);
        }

        public static function verificarCaptcha($request, $response, $next){
            if($_POST['captcha']){
                if($_POST['captcha'] == $_SESSION['codigo_random']){
                    return $next($request, $response);
                }
                else{
                    return $response->withJson("capcha erroneo", 511);
                }
            }
            else{
                return $response->withJson("No se ha enviado captcha", 511);
            }
        }

    }
?>