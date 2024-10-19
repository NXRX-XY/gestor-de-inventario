<?php
session_start();

if (!isset($_SESSION['correo'])) {
    // Redirecciona al formulario de inicio de sesión o muestra un mensaje de error.
    header("Location: ../html-admin/login-admin.html");
    exit;
}

$servername = "localhost";
$username = "usuario";
$password = "contraseña";
$dbname = "base_de_datos";

$cone = mysqli_connect($servername, $username, $password, $dbname) or die("Error en la conexión: " . mysqli_connect_error());

mysqli_set_charset($cone, 'utf8');

$ctn = mysqli_real_escape_string($cone, $_POST['ctn_id']);
$prod = mysqli_real_escape_string($cone, $_POST['prod_id']);
$mac = mysqli_real_escape_string($cone, $_POST['mac']);
$serie = mysqli_real_escape_string($cone, $_POST['numero_serial']);
$cuadrilla = mysqli_real_escape_string($cone, $_POST['cuadrilla']);
$t1 = mysqli_real_escape_string($cone, $_POST['tecnico1']);
$t2 = mysqli_real_escape_string($cone, $_POST['tecnico2']);
$fecha = mysqli_real_escape_string($cone, $_POST['fecha']);

$sql = "INSERT INTO entrega_ont (ctn, prod, mac, sn, cuadrilla, tecnico1, tecnico2, fecha) VALUES ('$ctn', '$prod', '$mac', '$serie', '$cuadrilla', '$t1', '$t2', '$fecha')";

if (mysqli_query($cone, $sql)) {
    echo '<script>alert("Los datos se han insertado correctamente."); window.location.href = "../html-admin/entrega_ont.php";</script>';
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($cone);
}

mysqli_close($cone);
?>
