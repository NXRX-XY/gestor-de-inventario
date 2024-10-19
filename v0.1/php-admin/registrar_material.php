<?php
include("conexion.php");

session_start();

if (!isset($_SESSION['correo'])) {
    // Redirecciona al formulario de inicio de sesión o muestra un mensaje de error.
    header("Location: ../html-admin/login-admin.php"); // Redirecciona al formulario de inicio de sesión
    exit;
}
// Conexión a la base de datos
$servername = "localhost";
$username = "usuario";
$password = "contraseña";
$dbname = "base_de_Datos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $material = $_POST["material"]; // Ajustar según el nombre del campo en tu formulario

  // Generar el siguiente código dinámico
  $siguiente_codigo = generarSiguienteCodigo($conn);

  // Insertar el nuevo registro con el siguiente código generado
  $insert_sql = "INSERT INTO lista_asignaciones (material, codigo) VALUES ('$material', '$siguiente_codigo')";
  if ($conn->query($insert_sql) === TRUE) {
    echo '<script>alert("El material se ha insertado correctamente."); window.location.href = "../html-admin/materiales.php";</script>';
  } else {
    echo '<script>alert("El material no se registró debido a un error inesperado."); window.location.href = "../html-admin/materiales.php";</script>';
  }
}

// Función para generar el siguiente código dinámico
function generarSiguienteCodigo($conn) {
  // Consultar el último código registrado
  $sql = "SELECT codigo FROM lista_asignaciones ORDER BY codigo DESC LIMIT 1";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ultimo_codigo = $row["codigo"];

    // Extraer el número del último código
    preg_match('/(\d+)/', $ultimo_codigo, $matches);
    $numero = (int)$matches[1]; // Convertir a número entero

    // Incrementar el número y construir el siguiente código
    $siguiente_numero = $numero + 1;
    return str_pad($siguiente_numero, strlen($ultimo_codigo), '0', STR_PAD_LEFT);
  } else {
  }
}

// Cerrar conexión
$conn->close();
?>