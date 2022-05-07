<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="../Vista/VistaPLicitacion.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center mt-5 mb-5">
            <div class="col-12 d-flex justify-content-center">
                <h1>LICITACIONES</h1>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-11">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Expediente</th>
                            <th scope="col">Organo de Contratacion</th>
                            <th scope="col">Objeto del Contrato</th>
                            <th scope="col">Valor Estimado</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Lugar de Ejecucion</th>
                            <th scope="col">Plazo</th>
                            <th scope="col">Url</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php 
                    	foreach ($listaLicitaciones as $licitacion) {
                        ?>
                        <tr id="<?=$licitacion->id?>">
                            <td><?=$licitacion->id?></td>
                            <td><?=$licitacion->expediente?></td>
                            <td><?=$licitacion->organo_contratacion?></td>
                            <td><?=$licitacion->objeto_contrato?></td>
                            <td><?=$licitacion->valor_estimado?></td>
                            <td><?=$licitacion->tipo?></td>
                            <td><?=$licitacion->lugar_ejecucion?></td>
                            <td><?=$licitacion->plazo?></td>
                            <td><?=$licitacion->url?></td>
                        </tr>	   
                    	<?php    
                    	}
                    	?>
                        <tr>
                            <td colspan="3">Página <?=$numPag?> de <?=$ultPag?></td>
                            <td colspan="3">
                                <button class="btn btn-white" onclick="primeraPag()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-bar-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M11.854 3.646a.5.5 0 0 1 0 .708L8.207 8l3.647 3.646a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708 0zM4.5 1a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 1 0v-13a.5.5 0 0 0-.5-.5z"/>
                                    </svg> Primera
                                </button>
                                <button class="btn btn-white" onclick="anteriorPag(<?=$numPag-1?>)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                                    <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                                    </svg> Anterior
                                </button>
                                <button class="btn btn-white" onclick="siguientePag(<?=$numPag+1?>)">Siguiente 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                                    <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>
                                </button>
                                <button class="btn btn-white" onclick="ultimaPag(<?=$ultPag?>)">Última 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-bar-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4.146 3.646a.5.5 0 0 0 0 .708L7.793 8l-3.647 3.646a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708 0zM11.5 1a.5.5 0 0 1 .5.5v13a.5.5 0 0 1-1 0v-13a.5.5 0 0 1 .5-.5z"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-10 offset-1">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Expediente</th>
                            <th scope="col">Organo de Contratacion</th>
                            <th scope="col">Objeto del Contrato</th>
                            <th scope="col">Valor Estimado</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Lugar de Ejecucion</th>
                            <th scope="col">Plazo</th>
                            <th scope="col">Url</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="insertar">
                            <td><input type="text" name="expediente"></td>
                            <td><input type="text" name="organo_contratacion"></td>
                            <td><input type="text" name="objeto_contrato"></td>
                            <td><input type="number" name="valor_estimado"></td>
                            <td><input type="text" name="tipo"></td>
                            <td><input type="text" name="lugar_ejecucion"></td>
                            <td><input type="date" name="plazo"></td>
                            <td><input type="text" name="url"></td>
                            <td></td>
                            <td>
                                <button class="btn btn-success" onclick="insertar()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                    </svg> Nueva licitacion
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>