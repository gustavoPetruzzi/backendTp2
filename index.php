<?php
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;
    require 'clases/vendor/autoload.php';
    require_once 'clases/remiseroApi.php';
    require_once 'clases/viajeApi.php';
    require_once 'clases/logueoApi.php';
    require_once 'clases/verificador.php';
    $config['displayErrorDetails'] = true;
    $app = new \Slim\App(["settings" => $config]);
    
    $app->add(function($request, $response, $next){
       $response = $next($request, $response);
       return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-API-KEY,Access-Control-Request-Method,X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    });
    
    $app->get('/', function (Request $req,  Response $res, $args = []) {
        return $res->withJson($req);
    });
    $app->post('/angularFoto', function(Request $req, Response $res, $args = []) {
        
        $foto = $_FILES['demo']['tmp_name'];
        $fotoNombre = $_FILES['demo']['name'];
        $nuevoNombre = './fotos/algo.jpg';
        rename($foto, $nuevoNombre);

        //$foto = $archivos['demo'];
        //$nombreArchivo = moveUploadedFile("./", $foto);
        return $res->write($nuevoNombre);
    });
    $app->post('/alta', function (Request $req,  Response $res, $args = []) {
        return $res->withJson($req);
    });
    
    $app->group('/cliente', function(){
        $this->post('/viajeNuevo', \viajeApi::class . ':alta');
        $this->post('/modificar', \clienteApi::class . ':modificar');
    })->add(\verificador::class . ':cliente')->add(\verificador::class . ':token');

    $app->group('/remisero', function(){
        $this->post('/viajes', \remiseroApi::class . ':viajes');
        $this->post('/finalizar', \viajeApi::class . ':finalizar');
    })->add(\verificador::class . ':remisero')->add(\verificador::class . ':token');

    $app->group('/remiseros', function(){
        $this->get('/lista', \remiseroApi::class . ':listaRemiseroApi');
        $this->post('/alta', \remiseroApi::class . ':alta');
        $this->post('/modificar', \remiseroApi::class . ':modificar');
        $this->post('/borrar', \remiseroApi::class . ':borrar');
    });
    $app->group('/ingreso', function(){
        $this->get('/token', \logueoApi::class . ':getToken');
        $this->post('/in', \logueoApi::class . ':login');
        $this->get('/captcha', \viajeApi::class . ':captcha');
    });
    $app->group('/viajes', function(){
        $this->get('/lista', \viajeApi::class . ':listaViajeApi');
        $this->post('/alta', \viajeApi::class . ':alta');
        $this->post('/modificar', \viajeApi::class . ':modificar');
        $this->post('/cancelar', \viajeApi::class . ':cancelar');
        $this->post('/asignar', \viajeApi::class . ':asignar');
        $this->post('/comenzar',\viajeApi::class . ':comenzar');
        $this->post('/finalizar', \viajeApi::class . ':finalizar');
    });
    $app->run();
