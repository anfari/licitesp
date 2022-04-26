<?php
    namespace Tema05\Ejercicio0304\Controlador;
    require_once ("../Modelo/Producto.php");
    require_once ("../Modelo/Carrito.php");
    session_start();
    use Tema05\Ejercicio0304\Modelo\ModeloProducto;
    use Tema05\Ejercicio0304\Modelo\Producto;
    use Tema05\Ejercicio0304\Modelo\ModeloCarrito;
    use Carrito;
    //use Tema05\Ejercicio0304\Modelo\Carrito;
    require_once ("../Modelo/ModeloProducto.php");
    require_once ("../Modelo/ModeloCarrito.php");
                
    class ControladorProducto {
        
        public function listar(int $numPag=1, int $tamPag=10):array {
            return ModeloProducto::listar($numPag, $tamPag);
        }
        
        public function numProductos() {
            return ModeloProducto::numProductos();
        }
    }
    
    if (isset($_SESSION['carrito'])) {
        $carrito = $_SESSION['carrito'];
    } else {
        $carrito = new Carrito([]);
        $_SESSION['carrito'] = $carrito;
    }
    
    if (isset($_POST['operacion']) && $_POST['operacion'] == "insertar") {
        $atributos = [
            "codigo" => $_POST['codigo'],
            "descripcion" => $_POST['descripcion'],
            "pcompra" => floatval($_POST['precioCompra']),
            "pventa" => floatval($_POST['precioVenta']),
            "stock" => intval($_POST['stock'])
        ];
        $producto = Producto::getProducto($atributos);
        $resultado = ModeloProducto::insertar($producto);
        if ($resultado) {
            echo '{"respuesta": true}';
        } else {
            echo '{"respuesta": false}';
        }
    }
    
    if (isset($_POST['operacion']) && $_POST['operacion'] == "eliminar") {
        $codigo = $_POST['codigo'];
        $resultado = ModeloProducto::eliminar($codigo);
        if ($resultado) {
            echo '{"respuesta": true}';
        } else {
            echo '{"respuesta": false}';
        }
    }
    
    if (isset($_POST['operacion']) && $_POST['operacion'] == "actualizar") {
        $atributos = [
            "codigo" => $_POST['codigo'],
            "descripcion" => $_POST['descripcion'],
            "pcompra" => floatval($_POST['precioCompra']),
            "pventa" => floatval($_POST['precioVenta']),
            "stock" => intval($_POST['stock'])
        ];
        $producto = Producto::getProducto($atributos);
        $resultado = ModeloProducto::actualizar($producto);
        if ($resultado) {
            echo '{"respuesta": true}';
        } else {
            echo '{"respuesta": false}';
        }
    }
    
    if (isset($_POST['operacion']) && $_POST['operacion'] == "entrada") {
        $atributos = [
            "codigo" => $_POST['codigo'],
            "descripcion" => $_POST['descripcion'],
            "pcompra" => floatval($_POST['precioCompra']),
            "pventa" => floatval($_POST['precioVenta']),
            "stock" => intval($_POST['stock'])
        ];
        $cantidad = intval($_POST['cantidad']);
        $atributos['stock'] += $cantidad;
        $producto = Producto::getProducto($atributos);
        $resultado = ModeloProducto::actualizar($producto);
        if ($resultado) {
            echo '{"respuesta": true}';
        } else {
            echo '{"respuesta": false}';
        }
        //echo '{"respuesta": '.$resultado.'}';
    }
    
    if (isset($_POST['operacion']) && $_POST['operacion'] == "salida") {
        $atributos = [
            "codigo" => $_POST['codigo'],
            "descripcion" => $_POST['descripcion'],
            "pcompra" => floatval($_POST['precioCompra']),
            "pventa" => floatval($_POST['precioVenta']),
            "stock" => intval($_POST['stock'])
        ];
        $cantidad = intval($_POST['cantidad']);
        
        if ($atributos['stock'] >= $cantidad) {
            $atributos['stock'] -= $cantidad;
            $producto = Producto::getProducto($atributos);
            $resultado = ModeloProducto::actualizar($producto);
        } else {
            echo '{"respuesta": "Stock excedido"}';
        }
        
        if (isset($resultado) && $resultado) {
            echo '{"respuesta": true}';
        }
    }
    
    if (isset($_POST['operacion']) && $_POST['operacion'] == "comprar") {
        $atributos = [
            "codigo" => $_POST['codigo'],
            "descripcion" => $_POST['descripcion'],
            "pcompra" => floatval($_POST['precioCompra']),
            "pventa" => floatval($_POST['precioVenta']),
            "stock" => intval($_POST['stock'])
        ];
        $cantidad = intval($_POST['cantidad']);
        
        if ($atributos['stock'] >= $cantidad) {
            $atributos['stock'] -= $cantidad;
            $producto = Producto::getProducto($atributos);
            $resultado = ModeloProducto::actualizar($producto);
        } else {
            echo '{"respuesta": "Stock excedido"}';
        }
        
        if (isset($resultado) && $resultado) {
            $carrito->agregarProducto($producto);
            $_SESSION['carrito'] = $carrito;
            echo '{"respuesta": true}';
        }
    }
    
    if (isset($_POST['operacion']) && $_POST['operacion'] == "borrarProducto") {
        $codigo = $_POST['codigo'];
        //echo "Codigoooooo ".$codigo;
        $cantidad = intval($_POST['cantidad']);
        $producto = ModeloProducto::buscarProducto($codigo);
        $producto->stock = $producto->stock + $cantidad;
        //$atributos['stock'] += $cantidad;
        //$producto = Producto::getProducto($atributos);
        $resultado = ModeloProducto::actualizar($producto);
        if ($resultado) {
            $carrito->borrarProducto($producto->codigo);
            $_SESSION['carrito'] = $carrito;
            echo '{"respuesta": true}';
        } else {
            echo '{"respuesta": false}';
        }
    }
?>