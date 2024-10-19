<?php
session_start();
if (!isset($_SESSION['correo'])) {
    // Redirecciona al formulario de inicio de sesión o muestra un mensaje de error.
    header("Location: ../html-admin/login-admin.html");
    exit;
}

// Verifica si se ha enviado el valor de "opcion" desde el formulario
if (!isset($_POST["opcion"])) {
    // Si no se ha enviado, muestra un mensaje de error o redirecciona a donde sea necesario
    echo "Error: La opción no está definida.";
    exit;
}

// Verifica si se ha enviado el valor de "eliminar" desde el formulario
if (!isset($_POST["eliminar"])) {
    // Si no se ha enviado, muestra un mensaje de error o redirecciona a donde sea necesario
    echo "Error: El valor a eliminar no está definido.";
    exit;
}

$servername = "localhost";
$username = "usuario";
$password = "contraseña";
$dbname = "base_de_datos";

$cone = mysqli_connect($servername, $username, $password, $dbname);
if (!$cone) {
    die("Error en la conexión: " . mysqli_connect_error());
}

mysqli_set_charset($cone, 'utf8');

$eliminar = $_POST["eliminar"];
$opcion = $_POST["opcion"];

$sql = "DELETE FROM entrada_ont WHERE $opcion = ?";

$stmt = mysqli_prepare($cone, $sql);
if (!$stmt) {
    die("Error al preparar la consulta: " . mysqli_error($cone));
}

mysqli_stmt_bind_param($stmt, "s", $eliminar);
$result = mysqli_stmt_execute($stmt);

if (mysqli_affected_rows($cone) > 0) {
    if (isset($_SESSION['nombres']) && isset($_SESSION['apellidos'])) {
        $nombreCompleto = $_SESSION['nombres'] . ' ' . $_SESSION['apellidos'];
        $python = "../python/log9.py";
        $output = shell_exec("python3 $python " . escapeshellarg($nombreCompleto) . " " . escapeshellarg($eliminar) . " " . escapeshellarg($opcion));
    }
} else {
    echo '<script>alert("La guía que intenta eliminar no existe."); window.location.href = "../html-admin/eliminar_entrada_ont.php";</script>';
    exit;
}

mysqli_stmt_close($stmt);

echo '<script>alert("Los datos se han eliminado correctamente."); window.location.href = "../html-admin/eliminar_entrada_ont.php";</script>';

mysqli_close($cone);
?>