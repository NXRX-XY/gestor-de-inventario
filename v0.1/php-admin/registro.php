<?php
    include("conexion.php");

    session_start();

if (!isset($_SESSION['correo'])) {
    // Redirecciona al formulario de inicio de sesión o muestra un mensaje de error.
    header("Location: ../html-admin/login-admin.html"); // Redirecciona al formulario de inicio de sesión
    exit;
}
    $servername = "localhost";
    $username = "usuario";
    $password = "contraseña";
    $dbname = "base_de_datos";
$cone=mysqli_connect($servername, $username, $password, $dbname)or die ("error en la conexion");
mysqli_set_charset($cone, 'utf8');
$documento=$_POST["documento"];
$nombres=$_POST["nombres"];
$apellidos=$_POST["apellidos"];


$sql = "INSERT INTO usuarios (documento, nombres, apellidos, rol) VALUES ('$documento', '$nombres', '$apellidos', 'usuario')";

if (mysqli_query($cone, $sql)) {
    echo '<script>alert("El usuario se registro exitosamente."); window.location.href = "../html-admin/registro.php";</script>';
}         // Verificar que los nombres y apellidos estén definidos
if (isset($_SESSION['nombres']) && isset($_SESSION['apellidos'])) {
    // Ejecutar el script Python con el nombre completo como argumento
    $nombreCompleto = $_SESSION['nombres'] . ' ' . $_SESSION['apellidos'];
    $usuario = $nombres . " " . $apellidos;
    $python = "../python/log3.py";
    $output = shell_exec("python3 $python " . escapeshellarg($nombreCompleto) . " " . escapeshellarg($usuario) . " " . escapeshellarg($documento));
}

else {
    echo "Error: " . $sql . "<br>" . mysqli_error($cone);
}
mysqli_close($cone);

?>
