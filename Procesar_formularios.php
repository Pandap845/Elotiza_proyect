<?php

//Archivo: Procesar_formularios
//Función: Enrutar los diversos formularios a su respectivo archivo php para procesar su solicitud
function redireccionarSegunFormulario($idFormulario, $datos) {
    switch ($idFormulario) {
        case 'crearCuenta':
            
            require 'php/procesar_crear_cuenta.php';
            break;
        case 'inicioSesion':
            require 'php/procesar_iniciar_sesion.php';
            break;
        case 'carrito':
            require 'php/procesar_carrito.php';
            break;
        case 'pago':
            require 'php/procesar_pago.php';
            break;
        case 'lote':
            require 'php/procesar_suministro.php';
            break;
        default:
            echo "Identificador de formulario no reconocido.";
            break;
    }
}

// Verificar si se recibió una petición POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Redirecciona con base en el ID de cada formulario
    if (isset($_POST['formularioId'])) {
        redireccionarSegunFormulario($_POST['formularioId'], $_POST);
    } else {
        echo "No se proporcionó identificador de formulario.";
    }
}


