<?php

session_start();

/*
    ARCHIVO: procesar_suministro.php
    Función: encargado de administrar la cantidad de ltoes de suministros que se poseen para realizar los elotes
*/

if($_SERVER['REQUEST_METHOD'] == "POST")
{

//Variables
 $lote = $_POST['IdElemento'];


 $archivo = "Datos/Suministros.xml";

 //Control del XML
 $doc = new DOMDocument();
 $doc->formatOutput = true;

 //Verificar la existencia de un archivo de suministros


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

 $Suministro = $doc->createElement("Suministro");
//Agregar los elementos del lote
$loteElement = $doc->createElement("Lote", $lote);
$Suministro->appendChild($loteElement);

// Repetir el proceso para los demás elementos
$descripcionElement = $doc->createElement("Descripcion", $descripcionLote);
$Suministro->appendChild($descripcionElement);

$cantidadElement = $doc->createElement("Cantidad", $cantidadElementos);
$Suministro->appendChild($cantidadElement);

$costoElement = $doc->createElement("Costo", $costoLote);
$Suministro->appendChild($costoElement);

$ubicacionElement = $doc->createElement("Ubicacion", $ubicacionLote);
$Suministro->appendChild($ubicacionElement);

$caducidadElement = $doc->createElement("Caducidad", $caducidadLote);
$Suministro->appendChild($caducidadElement);

// Finalmente, añadir <Suministro> al elemento raíz <Suministros>
$root->appendChild($Suministro);

// Guardar el archivo XML
$doc->save($archivo);

//Guardar el archivo XML
$doc->save($archivo);

//Regresar a la pagina principal
 header("location: index.php");
 exit();

}