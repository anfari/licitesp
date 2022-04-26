<?php
    namespace Tema05\Ejercicio0304\Modelo;
    //use Tema05\Ejercicio0304\Modelo\Producto;
    use PDO, PDOException;
    require_once ("Producto.php");
    
    class ModeloProducto {
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
        
        public static function insertar(Producto $producto): bool {
            if ($producto->codigo != null) {
                $resultado = self::consulta("SELECT * FROM producto WHERE codigo='".$producto->codigo."'");
                if ($resultado->fetch(PDO::FETCH_ASSOC) != null) {
                    return false;
                }
            }
            [$codigo, $descripcion, $precioCompra, $precioVenta, $stock] = [$producto->codigo, $producto->descripcion, $producto->precioCompra, $producto->precioVenta, $producto->stock];
            $resultado = self::consulta("INSERT INTO producto VALUES('$codigo', '$descripcion', $precioCompra, $precioVenta, $stock);");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        public static function eliminar(string $codigo): bool {
            $resultado = self::consulta("DELETE FROM producto WHERE codigo='".$codigo."'");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        public static function actualizar(Producto $producto): bool {
            [$codigo, $descripcion, $precioCompra, $precioVenta, $stock] = [$producto->codigo, $producto->descripcion, $producto->precioCompra, $producto->precioVenta, $producto->stock];
            $resultado = self::consulta("UPDATE producto SET descripcion='$descripcion', pcompra=$precioCompra, pventa=$precioVenta, stock=$stock WHERE codigo='".$producto->codigo."'");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        public static function listar(int $numPag=1, int $tamPag=10): array {
            $inicio = ($numPag-1)*$tamPag;
            $resultado = self::consulta("SELECT * FROM producto LIMIT $inicio, $tamPag");
            $lista = [];
            while ($producto = $resultado->fetch(PDO::FETCH_ASSOC)) {
                array_push($lista, Producto::getProducto($producto));
            }
            return $lista;
        }
        
        public static function numProductos() {
            $resultado = self::consulta("SELECT count(*) as numProductos FROM producto");
            $count = $resultado->fetch(PDO::FETCH_ASSOC);
            return intval($count['numProductos']);
        }
        
        public static function buscarProducto($codigo) {
            $resultado = self::consulta("SELECT * FROM producto WHERE codigo='".$codigo."'");
            $producto = Producto::getProducto($resultado->fetch(PDO::FETCH_ASSOC));
            return $producto;
        }
    }
    
?>