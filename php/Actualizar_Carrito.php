<?php

session_start();

/*
    ARCHIVO: procesar_suministro.php
    Función: encargado de administrar la cantidad de lotes de suministros que se poseen para realizar los elotes
*/

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Variables
    $idElemento = $_POST['IdElemento'];  // Asegúrate de que este es el nombre correcto del campo en el formulario
    $usuario = $_SESSION['usuario'];

    $archivo = "Datos/carrito" . $usuario . ".xml";

    // Control del XML
    $doc = new DOMDocument();
    $doc->formatOutput = true;

    // Verificar si el archivo existe y no está vacío
    if (file_exists($archivo) && filesize($archivo) > 0) {
        $doc->load($archivo); // Carga el archivo existente
        $carrito = $doc->getElementsByTagName("Carrito")->item(0); // Obtiene el elemento raíz

        $elementoEncontrado = false;
        $elementos = $doc->getElementsByTagName("ElementoCarrito");
        foreach ($elementos as $elemento) {
            if ($elemento->getAttribute("id") == $idElemento) {
                $carrito->removeChild($elemento);  // Elimina el elemento del documento
                $elementoEncontrado = true;
                break;
            }
        }

        if ($elementoEncontrado) {
            // Guardar los cambios en el archivo XML
            $doc->save($archivo);
            // Redirigir al usuario a la página principal
            header("Location: index.php");
            exit();
        } else {
            echo "Error: Elemento no encontrado.";
        }
    } else {
        echo "Error: El archivo no existe o está vacío.";
    }
} else {
    echo "Error: Método de solicitud incorrecto.";
}
?>
