<?php
/*
Archivo: procesar_pago.php
Descripción: archivo encargado de procesar las solicitudes del carrito de compras

*/

//En caso de que se quiera procesar el carrito sin haber iniciado sesión

session_start();
if ($_SESSION['usuario'] == null) {
    echo "ERROR: NO ha iniciado sesión";
}




//Procesamiento del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Variables
    $ciudad = $_POST['D_Ciudad'];
    $colonia = $_POST['D_Colonia'];
    $calle = $_POST['D_Calle'];
    $numExterior = $_POST['D_Num_Ex'];
    $numInterior = $_POST['D_Num_In'] ?? ''; // Opcional
    $numTarjeta = $_POST['Num_Tarjeta'];
    $nombreTarjeta = $_POST['Nom_Tarjeta'];
    $vencimientoTarjeta = $_POST['Ven_Tarjeta'];
    $ccvTarjeta = $_POST['CCV_Tarjeta'];

    //Control de los archivos XML
   $archivo = "Datos/Pago.xml";


    // Verificar si el archivo existe y no está vacío
 if (file_exists($archivo) && filesize($archivo) > 0) {
    $doc = new DOMDocument("1.0", "UTF-8");
    $doc->load($archivo); // Carga el archivo existente
    $root = $doc->getElementsByTagName("Suministros")->item(0); // Obtiene el elemento raíz
} else { //En caso contrario,
    $doc = new DOMDocument("1.0", "UTF-8");
    $doc->formatOutput = true;
    $root = $doc->createElement("Suministros");
    $doc->appendChild($root);
}


    //Raíz del archivo XML
    $root = $doc->createElement("DireccionPago");
    $doc->appendChild($root);


    //Se almacena una dirección para cada Cuenta
    $cuentaElement = $doc->createElement("Cuenta");
    $root->appendChild($cuentaElement);

    $cuentaElement->appendChild($doc->createElement("Email", $_SESSION['usuario']));

    //Direccion
    $direccionElement = $doc->createElement("Direccion");
    $direccionElement->appendChild($doc->createElement("Ciudad", $ciudad));
    $direccionElement->appendChild($doc->createElement("Colonia", $colonia));
    $direccionElement->appendChild($doc->createElement("Calle", $calle));
    $direccionElement->appendChild($doc->createElement("NumeroExterior", $numExterior));
    $direccionElement->appendChild($doc->createElement("NumeroInterior", $numInterior));

    $cuentaElement->appendChild($direccionElement);

    $pagoElement = $doc->createElement("Pago");
    $pagoElement->appendChild($doc->createElement("NumeroTarjeta", $numTarjeta));
    $pagoElement->appendChild($doc->createElement("NombreTarjeta", $nombreTarjeta));
    $pagoElement->appendChild($doc->createElement("Vencimiento", $vencimientoTarjeta));
    $pagoElement->appendChild($doc->createElement("CCV", $ccvTarjeta));
    $cuentaElement->appendChild($pagoElement);

    echo $doc->saveXML();
    $doc->save("Datos/Pago.xml");

    header("location: index.html");
    exit();
}

