<!DOCTYPE html>
<html lang="es" id="htmlLang">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miku-Elotes</title>
    <link rel="icon" href="img/logo1.jpg">
    <link rel="stylesheet" href="css/styles.css">
    <!--<script src="language.js" defer></script> -->
</head>
<body>
    <header>
        <div class="container">
            <img src="img/logo1.jpg" alt="Logo de Elotes">
            <div class="texto">
                <h1 id="titulo" data-translate="titulo">Miku-Elotes</h1>
                <p id="descripcion" data-translate="descripcion">"Los elotes son mejores que el jugo de vegetales, pruebalos!!!".</p>
            </div>
        </div>
    </header>

    <nav>
            <?php


            session_start();
            
            if($_SESSION['usuario'] == null)
            {
                echo '
                
                        <div class="container">
                        <ul>
                            <li><a  data-translate="CrearCuenta" href="#CrearCuenta">Crear una Cuenta</a></li>
                            <li><a  data-translate="Iniciarsesio" href="#IniciarSesion">Inicio de Sesion</a></li>
                        </ul>
                        </div>

                ';
                
            }
            else
            {
                echo '
                        <div class="container">
                        <ul>
                            <li><a  data-translate="inicio" href="#inicio">Inicio</a></li>
                            <li><a  data-translate="productos"  href="#productos">Personaliza tu elote</a></li>
                            <li><a  data-translate="carrito" href="#Carrito">Ir al carrito</a></li>
                            <li><a  data-translate="contacto" href="#contacto">Contacto</a></li>
                            <li><a  data-translate="Iniciarsesio" href="php/procesar_cerrar_sesion.php">Cerrar Sesion</a></li>
                            
                        </ul>
                        </div>
                ';
            }

            ?>


    </nav>

    <h1>
        <?php
        
        if($_SESSION['rol'] == '0')
        {
            $bienvenida = "Bienvenido Usuario, " . $_SESSION['usuario'];
            echo $bienvenida;
            
        }
        else if ($_SESSION['rol'] == '1')
        {
            $bienvenida = "Bienvenido Administrador, " . $_SESSION['usuario'];
            echo $bienvenida;
            
        }
        else
        {
            echo 'Por Favor, Inicia Sesion o Crea una cuenta!';
        }

        ?>
    </h1>

    <?php
    if ($_SESSION['usuario'] == null) 
    {
        echo '<section>';
    }
    else
    {
        echo '<section hidden>';
    }

    ?>



    <div class="main-content">

        <section id="CrearCuenta">

            <div class= "formulario_Crear_Cuenta">
                <h1>Unete a los millones de comedores de elotes activos</h1>
                <h2>Estos elotes no se comeran solos</h2>
                <form action="Procesar_formularios.php" method="post">
                    <input type="hidden" name="formularioId" value="crearCuenta">
                <p>Nombre Completo:</p>
                <input type="text" name ="Nombre" required="" placeholder="Nombre(s)"/>
                <input type="text" name ="Apellido" required="" placeholder="Apellido(s)"/>
                <p>Correo electronico:</p>
                <input type="text" name ="email" required=""placeholder="ej: EloteNator3000@elotiza.com"/>
                <p>Numero de Telefono:</p>
                <input type="text" name ="telefono" required=""placeholder="ej: 3328343609"/>
                <p>Contraseña:</p>
                <input type="password" name ="password" required="" placeholder="ej: 3lotes_4ever" />
                <br><br>
                <input type = "submit" value="Listo"/>
                </form>
            
            
            
                <h3>Bienvenido el unico centro digital de comercio de Elotes!!!</h3>
            </div>


        </section>
    </div>
    <div>
        <section id="IniciarSesion">

            <div class= "formulario_Crear_Cuenta">
                <h1>Con que ya eres catador de Elotes?</h1>
                <h2>Recuerdanos quien eres por favor!!!</h2>
                <form action="Procesar_formularios.php" method="post">
                    <input type="hidden" name="formularioId" value="inicioSesion">
                <p>Correo electronico:</p>
                <input type="text" name ="email" required=""placeholder="ej: EloteNator3000@elotiza.com"/>
                <p>Contraseña:</p>
                <input type="password" name ="password" required="" placeholder="ej: 3lotes_4ever"/>
                <br><br>
                <input type = "submit" value="Entrar"/>
                </form>
            
                <h3>Bienvenido de vuelta, nunca apagamos la lumbre!!!</h3>
            </div>


        </section>

        </section>


    <?php
    if ($_SESSION['usuario'] == null) 
    {
        echo '<section hidden>';
    }
    else
    {
        echo '<section>';
    }

    ?>



        <section id="inicio">
            <div class="container">
                <h2 data-translate="bienvenida">Bienvenido, gustas un elote?</h2>
            </div>
            <div class="container">
                <p data-translate="descrip">Combina todos los ingredientes que tenemos a tu disposicion.</p>
            </div>
        </section>

        <section id="productos" class="productos">
            <form action="Procesar_formularios.php" method="post">
                <input type="hidden" name="formularioId" value="carrito">
            <div class="container">
                <h2 data-translate="produx">Cuantos Elotes te gustaria ordenar?</h2>
            <br>
                <input type="number" name ="cantidad" required="" placeholder="0"/>                  
                  <br>
            </div>
            <h2 data-translate="TipoElote">Elige el tipo de Elote</h2>

            <div class="Elote-container">
                <div class="Elote" >
                    <img src="img/Esquite.jpg" alt="Esquite">
                    <h3 data-translate="pastel1">Equite</h3>
                    <p data-translate="pastel1des">La presentacion mas clasica de los elotes en todo Jalisco</p>
                    <p class="precio">$25.00</p>
                    <input type="radio" name = "Telote" value = "1"></input>
                </div>
                <div class="Elote">
                    <img src="img/Cocido.jpg" alt="Cocido">
                    <h3>Cocido</h3>
                    <p>Blandito y perfecto para comerse a mordiscos</p>
                    <p class="precio">$20.00</p>
                    <input type="radio" name = "Telote" value = "2" ></input>
                </div>
                <div class="Elote">
                    <img src="img/Asado.jpg" alt="Asado">
                    <h3>Asado</h3>
                    <p>Tostadito, con un toque a brasas</p>
                    <p class="precio">$35.00</p>
                    <input type="radio" name = "Telote" value = "3"></input>
                </div>
                <div class="Elote">
                    <img src="img/Hervido.jpg" alt="Hervido">
                    <h3>Hervido</h3>
                    <p>Si el cocido estaba blandito, el hervido ya casi se esta deshaciendo</p>
                    <p class="precio">$30.00</p>
                    <input type="radio" name = "Telote" value = "4"></input>
                </div>

                  
            </div>
            <br>
                  <h2 data-translate="Toppings">Elige los Toppings</h2>
                  <br>
            <div class="Elote-container">
                <div class="Topping">
                    <img src="img/Crema.jpg" alt="Crema">
                    <h3 data-translate="pastel1">Crema</h3>
                    <p data-translate="pastel1des">Mucha crema para que amarre</p>
                    <p class="precio">$5.00</p>
                    <input type="checkbox" name = "top[]" value = "1" ></input>
                </div>
                <div class="Topping">
                    <img src="img/Queso.jpg" alt="Queso">
                    <h3>Queso</h3>
                    <p>Sin queso, ni si quiera se puede llamar elote</p>
                    <p class="precio">$10.00</p>
                    <input type="checkbox" name = "top[]" value = "2"></input>
                </div>
                <div class="Topping">
                    <img src="img/Mantequilla.jpg" alt="Mantequilla">
                    <h3>mantequilla</h3>
                    <p>Solo la mantequilla puede dejar mas amarillo a un elote</p>
                    <p class="precio">$5.00</p>
                    <input type="checkbox" name = "top[]" value = "3"></input>
                </div>
                <div class="Topping">
                    <img src="img/Sal.jpg" alt="Sal">
                    <h3>Sal</h3>
                    <p>La especia mas simple y perfecta del planeta</p>
                    <p class="precio">$3.00</p>
                    <input type="checkbox" name = "top[]" value = "4"></input>
                </div>
                <div class="Topping">
                    <img src="img/Mayonesa.jpg" alt="Mayonesa">
                    <h3>Mayonesa</h3>
                    <p>Ma-yo-ne-sa</p>
                    <p class="precio">$10.00</p>
                    <input type="checkbox" name = "top[]" value = "5"></input>
                </div>

            </div>

            <input type = "submit" value="Añadir al carrito"/>

        </form>

    <section id = "Pago">

        <div class= "formulario_Direccion">
            <h1>Ingresa la direccion a la que enviaremos los elote, y tu metodo de pagos: </h1>
            <form action="Procesar_formularios.php" method="post">
                <input type="hidden" name="formularioId" value="pago">
            <p>Ciudad:</p>
            <input type="text" name ="D_Ciudad" required="" placeholder="Ej. Zapopan"/>
            <p>Colonia:</p>
            <input type="text" name ="D_Colonia" required="" placeholder="Ej. Arcos de Zapopan"/>
            <p>Calle:</p>
            <input type="text" name ="D_Calle" required="" placeholder="Ej. Las Rosas"/>
            <p>Num. Exterior:</p>
            <input type="text" name ="D_Num_Ex" required="" placeholder="Ej. 4517"/>
            <p>Num. Interior (Opcional):</p>
            <input type="text" name ="D_Num_In" placeholder="Ej. 13B"/>
            <br>
            <br>

        <div class = "Tarjeta_Credito"> <!--Parte para los datos de la tarjeta de credito-->
            <p>Numero de la tarjeta:</p>
            <input type="text" name ="Num_Tarjeta" required=""placeholder="ej: 4455 3322 7788 9944"/>
            <p>Nombre del Propietario:</p>
            <input type="text" name ="Nom_Tarjeta" required="" placeholder="ej: Juanito el huerfanito"/>
            <p>Fecha de vencimiento:</p>
            <input type="date" name ="Ven_Tarjeta" required=""/>
            <p>CCV:</p>
            <input type="text" name ="CCV_Tarjeta" required="" placeholder="ej: 243"/>
            <br><br>
        
        
        
            <br><br>
            <input type = "submit" value="Listo"/>
            </form>
        </div>

    </section>

        
        
        
            <h3>Perfecto</h3>
        </div>
        
        
        </div>


        <?php

                    
            if ($_SESSION['rol'] == '1')
            {
                echo '<section id="Suministros">';

            }
            else
            {
                echo '<section id="Suministros" hidden>';

            }

        ?>
        

            <div class= "formulario_Crear_Lote_Suministros">
                <h1>Bienvenido a la zona de suministros</h1>
                <h2>Aqui puedes crerar un lote de suministros, ingresa la siguiente informacion:</h2>
                <form action="Procesar_formularios.php" method="post">
                    <input type="hidden" name="formularioId" value="lote">
                <p>No. Lote:</p>
                <input type="text" name ="Lote" required="" placeholder="Ej. 12345"/>
                <p>descripcion del Lote:</p>
                <input type="text" name ="Descripcion_Lote" required="" placeholder="Un lote de 7 elotes y 2 bolsas de sal"/>
                <p>Cantidad total de elementos:</p>
                <input type="number" name ="CT_Elementos_Lote" required=""placeholder="ej: 15"/>
                <p>Costo total del lote:</p>
                <input type="number" name ="Costo_Lote" required="" placeholder="ej: 35091.25"/>
                <p>Ubicacion del lote:</p>
                <input type="text" name ="Ubicacion_lote" required="" placeholder="ej: av bonita 1982"/>
                <p>Fecha de Caducidad del lote:</p>
                <input type="date" name ="Caducidad_lote" required=""/>

                <br><br>
                <input type = "submit" value="Listo"/>
                </form>
            

            </div>


        </section>

        <?php

            if ($_SESSION['rol'] == '1')
            {
                echo '<section id="Finanzas">';

            }
            else
            {
                echo '<section id="Finanzas" hidden>';

            }

        ?>

            <p>Hola, bienvenido a la seccion de finanzas, aqui se muestran los resultados de ventas y su contraste con el gasto supuso un lote en especifico</p>

            <p>Ventas Totales: 7 777 777.77</p>

            <p>Tabla de lotes y su costo:</p>
            <table>
                <tr>
                  <td>No. Lote</td>
                  <td>Costo Total</td>
                </tr>
                <tr>
                  <td>1234</td>
                  <td>15 345.25</td>
                </tr>
                <tr>
                    <td>1234</td>
                    <td>15 345.25</td>
                </tr>
                <tr>
                    <td>1234</td>
                    <td>15 345.25</td>
                </tr>
                <tr>
                    <td>1234</td>
                    <td>15 345.25</td>
                </tr>
              </table>

        </section>

        <?php

            if ($_SESSION['rol'] == '1')
            {
                echo '<section id="Distribucion">';

            }
            else
            {
                echo '<section id="Distribucion" hidden>';

            }

        ?>

            <p>Hola, bienvenido a la seccion de Distribucion, Aqui veras listada la informacion de los pedidos pendientes</p>

            <p>Datos de pedidos:</p>
            <table>
                <tr>
                  <td>Direccion de cliente </td>
                  <td>Fecha de envio</td>
                  <td>Fecha de entrega</td>
                  <td>Envio Exitoso</td>
                </tr>
                <tr>
                  <td>Zapopan, Arcos de zapopan, calle trafalgar 4523 12A</td>
                  <td>15/02/2024</td>
                  <td>16/02/2024</td>
                  <td>Si</td>
                </tr>
                <tr>
                    <td>Zapopan, Arcos de zapopan, calle trafalgar 4523 12A</td>
                    <td>15/02/2024</td>
                    <td>16/02/2024</td>
                    <td>No</td>
                </tr>
                <tr>
                    <td>Zapopan, Arcos de zapopan, calle trafalgar 4523 12A</td>
                    <td>15/02/2024</td>
                    <td>16/02/2024</td>
                    <td>Si</td>
                </tr>
                <tr>
                    <td>Zapopan, Arcos de zapopan, calle trafalgar 4523 12A</td>
                    <td>15/02/2024</td>
                    <td>16/02/2024</td>
                    <td>No</td>
                </tr>

              </table>

        </section>




        </section>

        



        <Seccion id = "Carrito">

            <h2>Tu carrito de compras: </h2>

            <div class="Elote-container">

            

            <?php

                    $doc = new DOMDocument();
                    $dir = "Datos/carrito". $_SESSION['usuario'].".xml";
                    
                    if(file_exists($dir))
                    {
                        
                        $doc->load("Datos/carrito". $_SESSION['usuario'].".xml");
                        
                        $index_elemento=0;
                        foreach ($doc->getElementsByTagName("ElementoCarrito") as $ob) 
                        { 
                            $index_elemento++;
                            $precioTotal = 0;         
                            echo'
                            
                            <div class="Topping">
                            
                            <h3 data-translate="pastel1">Orden</h3>
                            ';
                            echo '<p data-translate="pastel1des">Tipo de Elote:</p> ';
                            $Telote = $ob->getElementsByTagName("Elote")->item(0)->nodeValue;
                            switch($Telote)
                            {
                                case 1:
                                    {
                                        echo "Esquite";
                                        $precioTotal = $precioTotal + 25;
                                        break;
                                    }
                                    case 2:
                                        {
                                            echo "Cocido";
                                            $precioTotal = $precioTotal + 20;
                                            break;
                                        }
                                        case 3:
                                            {
                                                echo "Asado";
                                                $precioTotal = $precioTotal + 35;
                                                break;
                                            }
                                            case 4:
                                                {
                                                    echo "Hervido";
                                                    $precioTotal = $precioTotal + 30;
                                                    break;
                                                }
                                                default:
                                                    {
                                                        echo "?";
                                                        break;
                                                    }
                                    
                            }                        
                            echo ' <p data-translate="pastel1des">Cantidad de elotes:</p>';
                            $cantidad = $ob->getElementsByTagName("Cantidad")->item(0)->nodeValue;
                            echo $cantidad;
                            echo ' <p data-translate="pastel1des">Toppings:</p>';

                            //Acceder al elemento Toppings
                          $top =  $ob->getElementsByTagName("Toppings");

                                
                          //Iterar sobre todos los eementos de TOppings: que son cada uno de los topping

                            foreach ($top as $tp)
                            {
                                   $id_tp = $tp->nodeValue;

                                switch($id_tp)
                                {
                                    case 1:
                                        {
                                            echo "Crema";
                                            $precioTotal = $precioTotal + 5;
                                            break;
                                        }
                                        case 2:
                                            {
                                                echo "Queso";
                                                $precioTotal = $precioTotal + 10;
                                                break;
                                            }
                                            case 3:
                                                {
                                                    echo "Mantequilla";
                                                    $precioTotal = $precioTotal + 5;
                                                    break;
                                                }
                                                case 4:
                                                    {
                                                        echo "Sal";
                                                        $precioTotal = $precioTotal + 3;
                                                        break;
                                                    }
                                                    case 5:
                                                        {
                                                            echo "Mayonesa";
                                                            $precioTotal = $precioTotal + 10;
                                                            break;
                                                        }
                                                        default:
                                                            {
                                                                echo $id_tp;
                                                                break;
                                                            }
                                }
                            }
                           
                            echo '<p data-translate="pastel1des">Precio total:</p>';
                           
                            echo $precioTotal;
                            
                            echo'  <br>  <form action="Procesar_formularios.php" method="post">

                            <input type="hidden" name="IdElemento" value="<?php $index_elemento ?>">
                            <input type="hidden" name="formularioId" value="CambiarCarrito">
            
                        <input type = "submit" value="Borrar"/>
            
                        </form>';
                            echo '</div> ';
                            
                                
                            



                        }


                       
                        
                        
                        //<p data-translate="pastel1des">Crema</p>
                        //<p data-translate="pastel1des">Queso</p>
                        //<p data-translate="pastel1des">Sal</p>

                        //<p data-translate="pastel1des">3</p>
                        
                        //<p class="precio">$250.00</p> <!--Assencion to heaven-->
                        


                    }
                    else
                    {
                        echo ' <h2 data-translate="vacio">Esta Vacio :(</h2>';
                    }

            ?>




                
            </div>
            <form action="Procesar_formularios.php" method="post">

                <input type="hidden" name="formularioId" value="RealizarPedido">

            <input type = "submit" value="RealizarPedido"/>

            </form>






        </Seccion>

        </section>

        <section id="contacto">
            <div class="container">
                <h2 data-translate="contacto">Contacto</h2>
            </div>
            <div class="container">
                <p data-translate="telef">Numero</p>
                <p>: +52 33 3111 1235</p>
            </div>
            <div class="container">
                <p data-translate="correo">Correo</p>
                <p>: MrElotes@elotiza.com</p>
            </div>
        </section>




    </div>

    <footer>
        <div class="container">
            <p>&copy;</p>
            <p data-translate="pie">2024 La Elotiza. Todos los derechos reservados.</p>
        </div>
        <div class="container">
            <a href="Terms.html">Terminos y Condiciones</a>
        </div>
        <br>
        <div class="container">
            <a href="Priv.html">Aviso de Privacidad</a>
        </div>
    </footer>
</body>
</html>