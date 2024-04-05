<?php
session_start();

// Verificamos si se ha enviado el formulario y si existe un usuario en sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['usuario'])) {
    // Ruta del archivo donde se guardará el carrito del usuario
    $usuario = $_SESSION['usuario']; // Sanitización básica
    $archivo = "Datos/carrito" . $usuario . ".xml"; // Nombre de archivo único por usuario

    // Cargar o inicializar el documento XML
    $doc = new DOMDocument("1.0", "UTF-8");
    if (file_exists($archivo) && filesize($archivo) > 0) {
        $doc->load($archivo); // Carga el archivo existente
        $root = $doc->getElementsByTagName("Carrito")->item(0); // Obtiene el elemento raíz
    } else {
        $doc->formatOutput = true;
        $root = $doc->createElement("Carrito");
        $doc->appendChild($root);
    }

    // Asignar variables para los datos recibidos por POST
    $cantidad = isset($_POST["cantidad"]) ? $_POST["cantidad"] : "0";
    $elote = isset($_POST["Telote"]) ? $_POST["Telote"] : "no especificado";

    // Crear elementos para el carrito
    $elementoCarrito = $doc->createElement("ElementoCarrito");
    $root->appendChild($elementoCarrito);

    $elementoCarrito->appendChild($doc->createElement("Cantidad", $cantidad));
    $elementoCarrito->appendChild($doc->createElement("Elote", $elote));

    // Manejar toppings si existen
    if (isset($_POST["top"]) && is_array($_POST["top"])) {
        $toppings = $doc->createElement("Toppings");
        $elementoCarrito->appendChild($toppings);

        foreach ($_POST["top"] as $topping) {
            $toppingElement = $doc->createElement("Topping", htmlspecialchars($topping));
            $toppings->appendChild($toppingElement);
        }
    }

    // Guardar el XML
    $doc->formatOutput = true; // Mejora la legibilidad del archivo resultante
    $doc->save($archivo);

    // Redireccionar al usuario a una página de confirmación o al carrito
    header("Location: index.html");
    exit();
} else {
    // Mensaje de error si no se ha iniciado sesión o el formulario no se ha enviado
    echo "Error: Debes iniciar sesión para agregar al carrito o no se ha enviado el formulario correctamente.";
}

