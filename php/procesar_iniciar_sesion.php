<?php

//Archivo: procesar_iniciar_sesion
//Función: Se encarga de leer el archivo de cuentas.xml e identificar si la cuenta existe o no.

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //variables
    $email = $_POST['email'];
    $password = $_POST['password']; 

    $doc = new DOMDocument();
    $doc->load("Datos/cuentas.xml");

    $encontrado = false; 
    foreach ($doc->getElementsByTagName("Cuenta") as $cuenta) {

        //Verifica cada uno de los campos de las distintas cuentas
        //Comprobando que ningun campo sea nulo antes de acceder
        if ($cuenta->getElementsByTagName("email")->length > 0) {
            $emailXML = $cuenta->getElementsByTagName("email")->item(0)->nodeValue;
        } else {
            
            $emailXML = "";
        }
        
        if ($cuenta->getElementsByTagName("password")->length > 0) {
            $passwordXML = $cuenta->getElementsByTagName("password")->item(0)->nodeValue;
        } else {
            $passwordXML = "";
        }
        

        //Comprobar si existe coincidencia. 
        if ($email == $emailXML && $password == $passwordXML) {
            $encontrado = true;
            break;
        }
    }



    //Cuyo caso exista la cuenta
    if ($encontrado) {
        // Autenticación exitosa, generar token de sesión
        session_start();
        $_SESSION['usuario'] = $email;
        $_SESSION['token'] = bin2hex(random_bytes(16)); // Generar un token aleatorio

        // Redirigir al usuario a una página segura
        header('Location: index.html');
        exit;
    } else {
        // Falló la autenticación, redirigir o manejar de otra manera
        echo("ERROR: NO existe la cuenta");
        exit;
    }
}