<?php
    require_once ("../Modelo/Producto.php");
    require_once ("../Modelo/Carrito.php");
    session_start();
    $carrito = $_SESSION['carrito'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="row mt-3">
            <div class="col-10 offset-1">
                <h1 class="text-center">Factura</h1>
            </div>
            <div class="col-1">
                <button class="btn btn-primary" onclick="window.location.href='../Controlador/Init.php';" style="width:100px;">Volver</button>
            </div>
            <div class="col-12 d-flex justify-content-center mt-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio Unidad</th>
                            <th scope="col">Total Producto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                    	foreach ($carrito->getListaProductos() as $producto) {
                            $total += $producto[0]->precioVenta*$producto[1];
                        ?>
                        <tr>
                            <td><?=$producto[0]->codigo?></td>
                            <td><?=$producto[0]->descripcion?></td>
                            <td><?=$producto[1]?></td>
                            <td><?=$producto[0]->precioVenta?></td>
                            <td><?=$producto[0]->precioVenta*$producto[1]?></td>
                        </tr>
                        <?php    
                    	}
                    	?>
                        <tr>
                            <td colspan="3"></td>
                            <td><strong>Total con IVA:</strong></td>
                            <td><strong><?=$total*1.21?>€</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    unset($_SESSION['carrito']);
?>