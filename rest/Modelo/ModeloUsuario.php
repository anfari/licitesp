<?php
    namespace Tema05\Ejercicio0304\Modelo;
    //use Tema05\Ejercicio0304\Modelo\Producto;
    use PDO, PDOException;
    require_once ("Usuario.php");
    
    class ModeloUsuario {
        public static function consulta(string $sql) {
            [$host,$usuario,$passwd,$bd]=['localhost','gestisimal','gestisimal2021','gestisimal'];
            try {
                $conexion = new PDO("mysql:host=$host;dbname=$bd;charset=utf8", $usuario, $passwd);
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $resultado = $conexion->query($sql);
            } catch (PDOException $e) {
                exit($e);
            }
            return $resultado;
        }
        
        public static function insertar(Usuario $usuario): bool {
            if ($usuario->id != null) {
                $resultado = self::consulta("SELECT * FROM usuario WHERE id=$usuario->id");
                if ($resultado->fetch(PDO::FETCH_ASSOC) != null) {
                    return false;
                }
            }
            [$id, $nombre, $password, $email, $localidad, $localidades_interes, $sectores_interes] = [$usuario->id, $usuario->nombre, $usuario->password, $usuario->email, $usuario->localidad, $usuario->localidades_interes, $usuario->sectores_interes];
            $resultado = self::consulta("INSERT INTO usuario VALUES($id, '$nombre', '$password', '$email', '$localidad', '$localidades_interes', '$sectores_interes');");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        public static function eliminar(string $id): bool {
            $resultado = self::consulta("DELETE FROM usuario WHERE id=$usuario");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        public static function actualizar(Usuario $usuario): bool {
            [$id, $nombre, $password, $email, $localidad, $localidades_interes, $sectores_interes] = [$usuario->id, $usuario->nombre, $usuario->password, $usuario->email, $usuario->localidad, $usuario->localidades_interes, $usuario->sectores_interes];
            $resultado = self::consulta("UPDATE usuario SET nombre='$nombre', password='$password', email='$email', localidad='$localidad', localidades_interes='$localidades_interes', sectores_interes='$sectores_interes' WHERE id=$usuario->id");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        public static function listar(int $numPag=1, int $tamPag=10): array {
            $inicio = ($numPag-1)*$tamPag;
            $resultado = self::consulta("SELECT * FROM usuario LIMIT $inicio, $tamPag");
            $lista = [];
            while ($usuario = $resultado->fetch(PDO::FETCH_ASSOC)) {
                array_push($lista, Usuario::getUsuario($usuario));
            }
            return $lista;
        }
        
        public static function numUsuarios() {
            $resultado = self::consulta("SELECT count(*) as numUsuarios FROM usuario");
            $count = $resultado->fetch(PDO::FETCH_ASSOC);
            return intval($count['numUsuarios']);
        }
        
        public static function buscarUsuario($codigo) {
            $resultado = self::consulta("SELECT * FROM producto WHERE codigo='".$codigo."'");
            $producto = Usuario::getUsuario($resultado->fetch(PDO::FETCH_ASSOC));
            return $producto;
        }
    }
    
?>