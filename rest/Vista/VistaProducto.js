function peticion(form) {
    let url = form.getAttribute("action");
    
    fetch(url, {
        body: new FormData(form),
        method: "post"
    })
    .then(respuesta => respuesta.text())
    .then(datos => {
        try {
            var respuesta = JSON.parse(datos);
        } catch (e) {
            console.log("Error al parsear: " + datos);
        }
        let operacion = form.elements['operacion'].value;
        if (respuesta["respuesta"] === true) {
            switch (operacion) {
                case "insertar":
                    mensaje = "insertado";
                    break;
                case "actualizar":
                    mensaje = "actualizar";
                    break;
                case "eliminar":
                    mensaje = "eliminado";
                    break;
                case "entrada":
                    mensaje = "agregado";
                    break;
                case "salida":
                    mensaje = "retirado";
                    break;
                case "comprar":
                    mensaje = "añadido";
                    break;
                case "borrarProducto":
                    mensaje = "borrado";
                    break;
            }
            alert("Producto " + mensaje + " correctamente");
            location.reload(true);
        } else {
            alert("Error en " + operacion + ": " + respuesta['respuesta']);
        }
    });
}

function crearFormulario(inputs, operacion, cantidad = null) {
    let form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "../Controlador/ControladorProducto.php")
    let op = document.createElement("input");
    op.setAttribute("name", "operacion");
    op.setAttribute("value", operacion);
    form.appendChild(op);

    if (operacion == "eliminar") {
        let tmpInput = document.createElement("input");
        tmpInput.setAttribute("name", inputs[0].name);
        tmpInput.setAttribute("value", inputs[0].value);
        form.appendChild(tmpInput);
    } else {
        for (let input of inputs) {
            if (input.name != "margen") {
                let tmpInput = document.createElement("input");
                tmpInput.setAttribute("name", input.name);
                tmpInput.setAttribute("value", input.value);
                form.appendChild(tmpInput);
            }
        };
    }
    if (cantidad != null) {
        form.appendChild(cantidad);
    }
    peticion(form);
}

function insertar() {
    let inputs = document.getElementById("insertar").getElementsByTagName("input");
    crearFormulario(inputs, "insertar");
}

function eliminar(codigo) {
    let inputs = codigo.getElementsByTagName("input");
    crearFormulario(inputs, "eliminar");
}

function actualizar(codigo) {
    let inputs = codigo.getElementsByTagName("input");
    console.log(inputs);
    crearFormulario(inputs, "actualizar");
}

function entrada(codigo) {
    let inputs = codigo.getElementsByTagName("input");
    let cantidad = prompt("Cantidad:");
    let inputCantidad = document.createElement("input");
    inputCantidad.setAttribute("name", "cantidad");
    inputCantidad.setAttribute("value", cantidad);
    //inputs.appendChild(inputCantidad);
    
    crearFormulario(inputs, "entrada", inputCantidad);
}

function salida(codigo) {
    let inputs = codigo.getElementsByTagName("input");
    let cantidad = prompt("Cantidad:");
    let inputCantidad = document.createElement("input");
    inputCantidad.setAttribute("name", "cantidad");
    inputCantidad.setAttribute("value", cantidad);
    //inputs.appendChild(inputCantidad);

    crearFormulario(inputs, "salida", inputCantidad);
}

function primeraPag() {
    window.location.href = ("../Controlador/Init.php?pag=1");
}

function anteriorPag(pag) {
    window.location.href = "../Controlador/Init.php?pag=" + pag;
}

function siguientePag(pag) {
    window.location.href = "../Controlador/Init.php?pag=" + pag;
}

function ultimaPag(pag) {
    window.location.href = "../Controlador/Init.php?pag=" + pag;
}

function comprar(codigo) {
    let inputs = codigo.getElementsByTagName("input");
    let inputCantidad = document.createElement("input");
    inputCantidad.setAttribute("name", "cantidad");
    inputCantidad.setAttribute("value", 1);
    crearFormulario(inputs, "comprar", inputCantidad);
}

function borrarProducto(codigo) {
    let inputs = codigo.getElementsByTagName("input");
    let inputCodigo = document.createElement("input");
    inputCodigo.setAttribute("name", "codigo");
    inputCodigo.setAttribute("value", codigo.id);
    let inputCantidad = document.createElement("input");
    inputCantidad.setAttribute("name", "cantidad");
    inputCantidad.setAttribute("value", 1);
    console.log(codigo.id);
    crearFormulario(inputs, "borrarProducto", inputCantidad);
}

function factura() {
    window.location.href = "../Vista/Factura.php";
}