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

// Conexión a la base de datos
$cone = mysqli_connect($servername, $username, $password, $dbname);
if (!$cone) {
    die("Error en la conexión: " . mysqli_connect_error());
}

// Establecer el conjunto de caracteres
mysqli_set_charset($cone, 'utf8');

$guia = $_POST["eliminar"]; // Obtener el valor de "eliminar" enviado por el formulario
$opcion = $_POST["opcion"];

// Definir la consulta según la opción seleccionada
switch ($opcion) {
    case "materiales":
        $sql = "DELETE FROM materiales WHERE numero_de_guia = ?";
        break;
    case "herramientas":
        $sql = "DELETE FROM herramientas WHERE numero_de_guia = ?";
        break;
    case "uniformes":
        $sql = "DELETE FROM uniforme WHERE numero_de_guia = ?";
        break;
    default:
        echo "Opción no válida.";
}

// Preparar la consulta
$stmt = mysqli_prepare($cone, $sql);
if (!$stmt) {
    die("Error al preparar la consulta: " . mysqli_error($cone));
}

// Asignar valor al parámetro
mysqli_stmt_bind_param($stmt, "s", $guia);

// Ejecutar la consulta
$result = mysqli_stmt_execute($stmt);

// Verificar si la consulta afectó a alguna fila
if (mysqli_affected_rows($cone) > 0) {
    if (isset($_SESSION['nombres']) && isset($_SESSION['apellidos'])) {
        // Ejecutar el script Python con el nombre completo como argumento
        $nombreCompleto = $_SESSION['nombres'] . ' ' . $_SESSION['apellidos'];
        $python = "../python/log5.py";
        $output = shell_exec("python3 $python " . escapeshellarg($nombreCompleto) . " " . escapeshellarg($guia) . " " . escapeshellarg($opcion));
    }
} else {
    echo '<script>alert("La guía que intenta eliminar no existe."); window.location.href = "../html-admin/eliminar-guias.php";</script>';
    exit;
}

// Cerrar la declaración
mysqli_stmt_close($stmt);

// Mostrar mensaje de éxito y redireccionar
echo '<script>alert("Los datos se han eliminado correctamente."); window.location.href = "../html-admin/eliminar-guias.php";</script>';

// Cerrar la conexión
mysqli_close($cone);
?>

