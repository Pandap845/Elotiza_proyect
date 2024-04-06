<?php

/*  Archivo: Procesar_crear_cuenta.php 
    Función: Se encarga de crear una cuenta para la página Elotiza: generando un XML

*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Variables
    $nombre = $_POST['Nombre'];
    $apellido = $_POST['Apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];
    $rol = 0;

    // Nombre del archivo donde se guardarán todas las cuentas
    $archivo = "Datos/cuentas.xml";

    // Verificar si el archivo existe y no está vacío
    if (file_exists($archivo) && filesize($archivo) > 0) {
        $doc = new DOMDocument("1.0", "UTF-8");
        $doc->load($archivo); // Carga el archivo existente
        $root = $doc->getElementsByTagName("Cuentas")->item(0); // Obtiene el elemento raíz
    } else { //En caso contrario,
        $doc = new DOMDocument("1.0", "UTF-8");
        $doc->formatOutput = true;
        $root = $doc->createElement("Cuentas");
        $doc->appendChild($root);
    }

    //Agregar la nueva cuenta al archivo XML
    $cuenta = $doc->createElement("Cuenta");
    $root->appendChild($cuenta);

    $cuenta->appendChild($doc->createElement("nombre", $nombre));
    $cuenta->appendChild($doc->createElement("apellido", $apellido));
    $cuenta->appendChild($doc->createElement("email", $email));
    $cuenta->appendChild($doc->createElement("telefono", $telefono));
    $cuenta->appendChild($doc->createElement("password", $password));
    $cuenta->appendChild($doc->createElement("rol", $rol));


    //Guardar cambios
    $doc->save($archivo); // Guarda el documento XML actualizado

    header("location: index.php");
}

