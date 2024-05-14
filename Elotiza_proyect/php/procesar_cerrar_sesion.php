<?php

//Archivo: procesar_cerrar_sesion
//Función: solo cierra la sesion y redirige al usuario al inicio de sesion
session_destroy();
session_start();
$_SESSION['usuario'] = null;
$_SESSION['token'] = null;// Generar un token aleatorio
$_SESSION['rol'] = null;

header("location: ../index.php");





