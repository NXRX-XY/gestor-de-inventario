<?php

conexion();
function conexion(){
$server="localhost";
$user="usuario";
$contra="contraseña";
$BD="base_de_datos";

$conexion=mysqli_connect($server, $user, $contra, $BD ) or die ("error en la conexion");
return $conexion;
}
?>