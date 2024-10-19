<?php
session_start();

if (!isset($_SESSION['correo'])) {
    // Redirecciona al formulario de inicio de sesión o muestra un mensaje de error.
    header("Location: ../html-admin/login-admin.html");
    exit;
}

// Conectarse a la base de datos
$servername = "localhost";
$username = "usuario";
$password = "contraseña";
$dbname = "base_de_datos";
$cone = mysqli_connect($servername, $username, $password, $dbname) or die("Error en la conexión: " . mysqli_connect_error());
mysqli_set_charset($cone, 'utf8');

// Verificar si se recibió el número de guía
if (!isset($_POST["numero_de_guia"])) {
    die("Error: No se recibió el número de guía.");
}

if (isset($_POST["tecnicos"])) {
    // Obtener el técnico seleccionado
    $valorSeleccionado = $_POST["tecnicos"];
    $parts = explode('-', $valorSeleccionado);
    $nombres = $parts[0];
    $apellidos = $parts[1];
    $tecnico = $nombres . ' ' . $apellidos; // Añadir un espacio entre nombres y apellidos
}

// Recibir los datos de la tabla
$tabla = $_POST["tablaa"];
$cantidades = $_POST["cantidad"];
$descripciones = $_POST["descripcion"];
$fecha = $_POST["fecha"];

// Recibir los datos adicionales
$numero_de_guia = $_POST["numero_de_guia"];
$cuadrilla = $_POST["cuadrilla"];

if (count($cantidades) == count($descripciones)) {
    $num_rows = count($cantidades);
    for ($i = 0; $i < $num_rows; $i++) {
        $cantidad = $cantidades[$i];
        $descripcion = $descripciones[$i];

        // Prevenir inyección SQL usando prepared statements
        $stmt = $cone->prepare("INSERT INTO actasconsumido (fecha, numeroacta, cuadrilla, tecnico, material, cantidad) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $fecha, $numero_de_guia, $cuadrilla, $tecnico, $descripcion, $cantidad);
        if (isset($_SESSION['nombres']) && isset($_SESSION['apellidos'])) {
            // Ejecutar el script Python con el nombre completo como argumento
            $nombreCompleto = $_SESSION['nombres'] . ' ' . $_SESSION['apellidos'];
            $usuario = $nombres . " " . $apellidos;
            $python = "../python/log7.py";
            $output = shell_exec("python3 $python " . escapeshellarg($nombreCompleto) . " " . escapeshellarg($numero_de_guia));
        }         
        if ($stmt->execute()) {
            echo '<script>alert("Los datos se han insertado correctamente."); window.location.href = "../html-admin/pendientes.php";</script>';
        } else {
            echo "Error: " . $stmt->error;
        }
    }
} else {
    echo "Error: los arreglos no tienen la misma longitud.";
}

// Cerrar la conexión
mysqli_close($cone);
?>
