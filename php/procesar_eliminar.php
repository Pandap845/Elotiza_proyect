<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Variables
    $id = $_POST['IdElemento'];
    
    $doc = new DOMDocument();
  


    $doc->load("carritoa20300695@ceti.mx");
    $xpath = new DOMXPath($doc);

    //Buscar por ID mediante XPATH
        $elementos = $xpath->query("//carrito/ElementoCarrito[@id='$id']");

    //ELIMINAR
        foreach($elementos as $elemento)
        {
    
        }


    

}