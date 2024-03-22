<?php
// Verificamos si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Creamos un nuevo documento XML
$xml = new DOMDocument("1.0", "UTF-8");
// Creamos el elemento raíz
$root = $xml->createElement("Solicitud");
$xml->appendChild($root);
// Creamos elementos para cada campo del formulario
$cantidad = $xml->createElement("cantidad", $_POST["cantidad"]);
$root->appendChild($cantidad);
$elote = $xml->createElement("elote", $_POST["Telote"]);
$root->appendChild($elote);

if (isset($_POST["top"]) && is_array($_POST["top"])) {
    // Creamos un elemento contenedor para los toppings
    $toppings = $xml->createElement("toppings");
    $root->appendChild($toppings);

    foreach($_POST["top"] as $topping) {
        // Para cada topping, creamos un elemento
        // Es importante validar y limpiar $topping antes de usarlo
        $toppingElement = $xml->createElement("topping", htmlspecialchars($topping));
        $toppings->appendChild($toppingElement);
    }
}

// Guardamos el XML en un archivo
$xml->formatOutput = true; // Formateamos la salida para que sea legible
$xml->save("datos_formulario.xml");
// Mostramos un mensaje de éxito
echo "Los datos del formulario se han enviado correctamente.";
} else {
// Si no se ha enviado el formulario, redireccionamos al formulario HTML
header("Location: formulario.html");
exit();
}
?>