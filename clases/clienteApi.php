<?php

    require_once 'vendor/autoload.php';
    require_once 'cliente.php';
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;
    
    class clienteApi extends cliente{
        public function alta($request, $response, $args){
            $nuevoCliente = new cliente(
                $_POST['nombre'],
                $_POST['apellido'],
                $_POST['usuario'],
                $_POST['password']
            );
            return $response->withJson($nuevoCliente->guardarCliente());
        }

        public function modificar($request, $response, $args){
            $id = $_POST['id'];
            $clienteModificadado = cliente::traerCliente($id);
            if($clienteModificadado){
                $clienteModificadado->nombre = $_POST['nombre'];
                $clienteModificadado->nombre = $_POST['apellido'];
                $clienteModificadado->nombre = $_POST['usuario'];
                $clienteModificadado->nombre = $_POST['password'];
                return $response->withJson($clienteModificadado->modificarCliente());
            }
            else{
                return $response->withJson('No existe ningun cliente con ese id', 20);
            }
        }
    }