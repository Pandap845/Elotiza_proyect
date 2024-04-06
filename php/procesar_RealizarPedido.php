<?php
/*
Archivo: procesar_RealizarPedido.php
Descripción: archivo encargado de concretar la solicitud de los pedidos, junta la informacion de pago del usuario
y los elementos que tenga guardados en su carrito para poder crear un nuevo XML con todos los detalles de su pedido

*/

//En caso de que se quiera procesar el carrito sin haber iniciado sesión

session_start();

if ($_SESSION['usuario'] == null) {
    echo "ERROR: NO ha iniciado sesión";
}


//variables 
$PagoActual;

//Procesamiento del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Control de los archivos XML
   $archivo = "Datos/Pago.xml";


    // Verificar si el archivo existe y no está vacío
 if (file_exists($archivo) && filesize($archivo) > 0) {
    $doc = new DOMDocument("1.0", "UTF-8");
    $doc->load($archivo); // Carga el archivo existente
    $root = $doc->getElementsByTagName("DireccionPago")->item(0); // Obtiene el elemento raíz
} else { //En caso contrario, se supone que no ha ingresado ninguna forma de pago, ya que no hay ninguna
    echo "ERROR: No hay metodos de pago";
    exit();
}

// Verificar si tenemos guardados los datos de pago para este usuario
foreach ($doc->getElementsByTagName("Cuenta") as $pago) {

    //Verifica cada uno de los campos de las distintas cuentas
    //Comprobando que ningun campo sea nulo antes de acceder
    if ($pago->getElementsByTagName("Email")->length > 0) 
    {
        if($pago->getElementsByTagName("Email")->item(0)->nodeValue == $_SESSION['usuario'])
        {
            $PagoActual = $doc->importNode($pago, true);
        }
        else
        {
            echo "ERROR: No has agregado un metodo de pago";
            exit();
        }

    } 
    else
    {
        echo "ERROR: No hay metodos de pago";
        exit();
    }

}

    $archivo = "Datos/carrito".$_SESSION['usuario'].".xml";

    if (file_exists($archivo) && filesize($archivo) > 0) {
        $doc2 = new DOMDocument("1.0", "UTF-8");
        $doc2->load($archivo); // Carga el archivo existente
        $carritoActual = $doc2->getElementsByTagName("Carrito")->item(0); // Obtiene el elemento raíz


        $archivo = "Datos/PedidoPagadoDe".$_SESSION['usuario'].bin2hex(random_bytes(16)).".xml"; // en esta parte creamos un nombre para el archivo de el pedido, se usa el numero aleatorio ya que:
        //Puede funcionar un "Numero de folio" del pedido y a la vez, ya que un usuario puede realizar varios pedidos, y cada pedido pagado debe ser inalterable, pues creamos documentos distintos cada vez
        $doc3 = new DOMDocument("1.0", "UTF-8");
        $doc3->formatOutput = true;
        $root3 = $doc3->createElement("DetallesPedido");
        $doc3->appendChild($root3);

        $carritoSeleccionado = $doc3->importNode($carritoActual, true);
        $pagoSeleccionado = $doc3->importNode($PagoActual, true);


        $root3->appendChild($pagoSeleccionado);
        $root3->appendChild($carritoSeleccionado);

        //Guardar cambios
        $doc3->save($archivo); // Guarda el documento XML actualizado

        header("location: index.php");
        exit();



    } else { //En caso contrario, se supone que no ha ingresado ninguna forma de pago, ya que no hay ninguna
        echo "ERROR: No has guardado nada en tu carrito";
        exit();
    }


}

