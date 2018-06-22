<?php
    include_once("accesoDatos.php");

    class usuarioMascota{
    	public $id;
    	public $email;
    	private $_clave;
    	public $tipo;

    	public function __construct($usuario = NULL, $email = NULL, $clave = NULL, $tipo = NULL){
    		if($email != NULL && $clave != NULL && $tipo != NULL){
    			$this->email = $email;
    			$this->_clave = $clave;
    			$this->tipo = $tipo;
    		}
    	}

    	public function obtenerClave(){
    		return $this->_clave;
    	}

        public function guardarUsuario(){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "INSERT INTO usuario_mascota (email, clave, tipo)" .
                " VALUES(:email, :clave, :tipo)"
            );
            $consulta->bindValue(":email", $this->email, PDO::PARAM_STR);
            $consulta->bindValue(":clave", $this->obtener_clave(), PDO::PARAM_STR);
            $consulta->bindValue(":tipo", $this->tipo, PDO::PARAM_STR);
            $retorno = $consulta->execute();
            if($retorno && $consulta->rowCount() == 0){
                $retorno = false;
            }
            return $retorno;
        }

        public function modificarUsuario(){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "UPDATE usuario_mascota SET  email = :email, clave = :clave, tipo = :tipo
                 WHERE id = :id"
            );
            $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
            $consulta->bindValue(":email", $this->email, PDO::PARAM_STR);
            $consulta->bindValue(":clave", $this->obtenerClave(), PDO::PARAM_STR);
            $consulta->bindValue(":tipo", $this->password, PDO::PARAM_STR);
            $retorno = $consulta->execute();
            if($retorno && $consulta->rowCount() == 0){
                $retorno = false;
            }
            return $retorno;
        }

        public static function traerUsuario($email, $clave){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "SELECT id, email, clave, tipo
                 FROM usuario_mascota
                 WHERE email = :email AND clave = :clave"
            );
            $consulta->bindValue(":email", $email, PDO::PARAM_STR);
            $consulta->bindValue(":clave", $clave, PDO::PARAM_STR);
            $consulta->setFetchMode(PDO::FETCH_CLASS, "usuarioMascota");
            $consulta->execute();
            $usuario = $consulta->fetch();
            return $usuario;
        }
        public function borrarUsuario(){
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "DELETE FROM usuario_mascota
                 WHERE email = :email AND clave = :clave"
            );
            $consulta->bindValue(":email", $this->email, PDO::PARAM_STR);
            $consulta->bindValue(":clave", $this->obtenerClave(), PDO::PARAM_STR);
            $retorno = $consulta->execute();
            if($retorno && $consulta->rowCount() == 0){
                $retorno = false;
            }
            return $retorno;
        }

        public function traerUsuarios(){
        	$listaUsuarios = array();
            $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->retornarConsulta(
                "SELECT id, email, clave, tipo
                 FROM usuario_mascota"
            );
            $consulta->execute();
            $listaUsuarios = $consulta->fetchAll(PDO::FETCH_CLASS, "usuarioMascota");
            return $listaUsuarios;
        }       
    }
?>