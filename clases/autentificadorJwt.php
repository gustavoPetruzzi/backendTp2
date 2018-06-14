<?php
    require_once 'vendor/autoload.php';
    use Firebase\JWT\JWT;
    
    class autentificadorJwt{
        private static $claveSecreta = "una-clave-secreta";
        private static $algoritmo = "HS256";
        public static function crearToken($datos){
            $ahora  = time();
            $payload = array(
                'iat' => $ahora,
                'exp' => $ahora + 60 * 60,
                'data' => $datos,
                'app' => 'apiRestJwt'
            );
            return JWT::encode($payload, self::$claveSecreta);
        }

        public static function verificarToken($token){
            $decodificado = JWT::decode($token, self::$claveSecreta, [self::$algoritmo]);
            return true;
        }
            
        public static function extraerData($token){
            return JWT::decode($token, self::$claveSecreta, [self::$algoritmo] )->data;    
        }
    }
?>