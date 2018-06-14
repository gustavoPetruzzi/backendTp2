<?php

    require_once 'vendor/autoload.php';
    require_once 'cliente.php';
    require_once 'usuario.php';
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
            $nuevoCliente->guardarCliente();
            $clienteGuardado = cliente::buscarCliente($nuevoCliente->usuario, $nuevoCliente->password);
            $usuarioGuardado = new usuario($clienteGuardado->id, $clienteGuardado->usuario, $clienteGuardado->password, "cliente");
            return $response->withJson($usuarioGuardado->guardarUsuario());
        }

        public function modificar($request, $response, $args){
            $id = $_POST['id'];
            $clienteModificado = cliente::traerCliente($id);
            if($clienteModificado){
                $usuarioModificado = usuario::traerUsuario($clienteModificado->usuario, $clienteModificado->password);
                $clienteModificado->nombre = $_POST['nombre'];
                $clienteModificado->nombre = $_POST['apellido'];
                $clienteModificado->nombre = $_POST['usuario'];
                $clienteModificado->nombre = $_POST['password'];
                if($clienteModificado->modificarCliente()){
                    return $response->withJson($usuarioModificado->modificarCliente());
                }
            }
            else{
                return $response->withJson('No existe ningun cliente con ese id', 20);
            }
        }

        public function borrar($request, $response, $args){
            $id = $_POST['id'];
            $clienteBorrado = cliente::traerCliente($id);
            if($clienteBorrado){
                $usuarioBorrado = usuario::traerUsuario($clienteBorrado->usuario, $clienteBorrado->password);
                $clienteBorrado->nombre = $_POST['nombre'];
                $clienteBorrado->nombre = $_POST['apellido'];
                $clienteBorrado->nombre = $_POST['usuario'];
                $clienteBorrado->nombre = $_POST['password'];
                if($clienteBorrado->borrarCliente()){
                    return $response->withJson($usuarioModificado->borrarCliente());
                }
            }
            else{
                return $response->withJson('No existe ningun cliente con ese id', 20);
            }            
        }

        public function listaClienteApi($request, $response, $args){
            $clientes = cliente::traerClientes();
            return $response->withJson($clientes);
        }

    }