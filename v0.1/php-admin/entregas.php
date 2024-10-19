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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tabla = $_POST["tablaa"];
    $guia = $_POST["numero_de_guia"];
    $cantidades = $_POST["cantidad"];
    $unidades = $_POST["unidad"];
    $codigos = $_POST["codigo"];
    $descripciones = $_POST["descripcion"];
    $fecha = $_POST["fecha"];
    
    if (isset($_POST["tecnicos"])) {
        $valorSeleccionado = $_POST["tecnicos"];
        $parts = explode('-', $valorSeleccionado);
        $nombres = $parts[0];
        $apellidos = $parts[1];
    }
    if (isset($_SESSION['nombres']) && isset($_SESSION['apellidos'])) {
        // Ejecutar el script Python con el nombre completo como argumento
        $nombreCompleto = $_SESSION['nombres'] . ' ' . $_SESSION['apellidos'];
        $usuario = $nombres . " " . $apellidos;
        $python = "../python/log8.py";
        $output = shell_exec("python3 $python " . escapeshellarg($nombreCompleto) . " " . escapeshellarg($tabla) . " " . escapeshellarg($valorSeleccionado));
    }
    if (count($cantidades) == count($unidades) && count($cantidades) == count($codigos) && count($cantidades) == count($descripciones)) {
        $num_rows = count($cantidades);
        
        for ($i = 0; $i < $num_rows; $i++) {
            $cantidad = $cantidades[$i];
            $unidad = $unidades[$i];
            $codigo = $codigos[$i];
            $descripcion = $descripciones[$i];
            
            $sql = "INSERT INTO devolucion (nombres, apellidos, numero_de_guia, fecha, cantidad, unidad, descripcion, asignacion, codigo) VALUES ('$nombres', '$apellidos', '$guia', '$fecha' ,'$cantidad', '$unidad', '$descripcion', '$tabla', '$codigo')";
            
            if (mysqli_query($cone, $sql)) {
                echo '<script>alert("Los datos se han insertado correctamente."); window.location.href = "../html-admin/entregas.php";</script>';
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($cone);
            }
        }
    } else {
        echo "Error: Los datos recibidos no tienen la misma cantidad de elementos.";
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($cone);

?>