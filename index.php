<?php
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;
    require 'clases/vendor/autoload.php';
    require_once 'clases/remiseroApi.php';
    
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
    

    $app->group('/remiseros', function(){
        $this->get('/lista', \remiseroApi::class . ':listaRemiseroApi');
        $this->post('/alta', \remiseroApi::class . ':alta');
        $this->post('/modificar', \remiseroApi::class . ':modificar');
        $this->post('/borrar', \remiseroApi::class . ':borrar');
    });
    $app->run();
