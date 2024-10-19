<?php
    include("conexion.php");

    session_start();

if (!isset($_SESSION['correo'])) {
    // Redirecciona al formulario de inicio de sesión o muestra un mensaje de error.
    header("Location: ../html-admin/login-admin.html"); // Redirecciona al formulario de inicio de sesión
    exit;
}
// Conectarse a la base de datos
$servername = "localhost";
$username = "usuario";
$password = "contraseña";
$dbname = "base_de_datos";
$cone = mysqli_connect($servername, $username, $password, $dbname) or die("Error en la conexión");
mysqli_set_charset($cone, 'utf8');
$acta = $_POST["numero-de-acta-observacion"];
$comentario = $_POST["comentario"];
$completo = isset($_POST["completo"]) ? $_POST["completo"] : "";
$incompleto = isset($_POST["incompleto"]) ? $_POST["incompleto"] : "";

if ($completo) {
    $sql = "UPDATE actas SET observacion='$comentario', estado='completo', solucion='completo' WHERE numero_de_acta='$acta'";
    if (mysqli_query($cone, $sql)) {
        echo '<script>alert("Los datos se han insertado correctamente."); window.location.href = "../html-admin/observaciones.php";</script>';
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($cone);
    }
}
if ($incompleto) {
    $sql = "UPDATE actas SET observacion='$comentario', estado='incompleto' WHERE numero_de_acta='$acta'";
    if (mysqli_query($cone, $sql)) {
        echo '<script>alert("Los datos se han insertado correctamente."); window.location.href = "../html-admin/observaciones.php";</script>';
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($cone);
    }
}

mysqli_close($cone);
?>
