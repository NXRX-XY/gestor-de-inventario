<?php
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
$cone = mysqli_connect($servername, $username, $password, $dbname) or die("Error en la conexión: " . mysqli_connect_error());

mysqli_set_charset($cone, 'utf8');

// Verificar si se recibió el número de guía
if (!isset($_POST["numero_de_guia"])) {
    die("Error: No se recibió el número de guía.");
}

// Recibir los datos de la tabla
$cantidades = $_POST["cantidad"];
$unidades = $_POST["unidad"];
$codigos = $_POST["codigo"];
$descripciones = $_POST["descripcion"];
$provedores = $_POST["provedor"];
$fecha = $_POST["fecha"];

// Recibir los datos adicionales
$numero_de_guia = $_POST["numero_de_guia"];

// Insertar los datos en la base de datos
if (count($cantidades) == count($unidades) && count($cantidades) == count($codigos) && count($cantidades) == count($descripciones) && count($cantidades) == count($provedores)) {
    $num_rows = count($cantidades);
    for ($i = 0; $i < $num_rows; $i++) {
        $cantidad = $cantidades[$i];
        $unidad = $unidades[$i];
        $codigo = $codigos[$i];
        $descripcion = $descripciones[$i];
        $provedor = $provedores[$i];

        $sql = "INSERT INTO tabla (numero_de_guia, fecha, cantidad, unidad, codigo, descripcion, provedor) VALUES  ('$numero_de_guia', '$fecha', '$cantidad', '$unidad', '$codigo', '$descripcion', '$provedor')";

        // Ejecutar la consulta SQL
        if (mysqli_query($cone, $sql)) {
            echo '<script>alert("Los datos se han insertado correctamente."); window.location.href = "../html-admin/aprovisionar.php";</script>';
        }
        if (isset($_SESSION['nombres']) && isset($_SESSION['apellidos'])) {
            // Ejecutar el script Python con el nombre completo y el número de guía como argumentos
            $nombreCompleto = $_SESSION['nombres'] . ' ' . $_SESSION['apellidos'];
            $python = "../python/log2.py";
            $output = shell_exec("python3 $python " . escapeshellarg($nombreCompleto) . " " . escapeshellarg($numero_de_guia));
        }
        else {
            echo "Error: " . $sql . "<br>" . mysqli_error($cone);
        }
    }
} else {
    echo "Error: Los datos recibidos no tienen la misma cantidad de elementos.";
}

// Cerrar la conexión a la base de datos
mysqli_close($cone);
?>

