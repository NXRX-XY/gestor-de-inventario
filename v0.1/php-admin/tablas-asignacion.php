<?php
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
$dbname = "base_de_Datos";
$cone = mysqli_connect($servername, $username, $password, $dbname) or die("Error en la conexión: " . mysqli_connect_error());

mysqli_set_charset($cone, 'utf8');

// Verificar si se recibió el número de guía
if (!isset($_POST["numero_de_guia"])) {
    die("Error: No se recibió el número de guía.");
}

if (!isset($_POST["cuadrilla"])) {
    die("Error: No se recibió el número de guía.");
}

// Recibir los datos de la tabla
$tabla = $_POST["tablaa"];

// Recordar que al momento de hacer una variable de selección y luego agregar a la consulta el name del select y el value de las opciones
$cantidades = $_POST["cantidad"];
$unidades = $_POST["unidad"];
$descripciones = $_POST["descripcion"];
$codigos = $_POST["codigo"];
$fecha = $_POST["fecha"];

// Recibir los datos adicionales
$numero_de_guia = $_POST["numero_de_guia"];
$cuadrilla = $_POST["cuadrilla"];

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
    $python = "../python/log6.py";
    $output = shell_exec("python3 $python " . escapeshellarg($nombreCompleto) . " " . escapeshellarg($numero_de_guia) . " " . escapeshellarg($tabla));
}

if (count($cantidades) == count($unidades) && count($cantidades) == count($codigos) && count($cantidades) == count($descripciones)) {
    $num_rows = count($cantidades);

    for ($i = 0; $i < $num_rows; $i++) {
        $cantidad = $cantidades[$i];
        $unidad = $unidades[$i];
        $codigo = $codigos[$i];
        $descripcion = $descripciones[$i];

        if ($tabla == "materiales") {
            $sql = "INSERT INTO materiales (nombres, apellidos, numero_de_guia, cuadrilla, fecha, cantidad, unidad, descripcion, asignacion, codigo) VALUES ('$nombres', '$apellidos','$numero_de_guia', '$cuadrilla', '$fecha' ,'$cantidad', '$unidad', '$descripcion', 'materiales', '$codigo')";
            
            if (mysqli_query($cone, $sql)) {
                echo '<script>alert("Los datos se han insertado correctamente."); window.location.href = "../html-admin/asignaciones.php";</script>';
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($cone);
            }

        } elseif ($tabla == "herramientas") {
            $sqlr = "INSERT INTO herramientas (nombres, apellidos, numero_de_guia, cuadrilla, fecha ,cantidad, unidad, descripcion, asignacion, codigo) VALUES ('$nombres', '$apellidos', '$numero_de_guia', '$cuadrilla', '$fecha' ,'$cantidad', '$unidad', '$descripcion', 'herramientas', '$codigo')";
            
            if (mysqli_query($cone, $sqlr)) {
                echo '<script>alert("Los datos se han insertado correctamente."); window.location.href = "../html-admin/asignaciones.php";</script>';
            } 

        } elseif ($tabla == "uniforme") {
            $sqlt = "INSERT INTO uniforme (nombres, apellidos, numero_de_guia, cuadrilla, fecha ,cantidad, unidad, descripcion, asignacion, codigo) VALUES ('$nombres', '$apellidos', '$numero_de_guia', '$cuadrilla', '$fecha' ,'$cantidad', '$unidad', '$descripcion', 'uniforme', '$codigo')";
            
            if (mysqli_query($cone, $sqlt)) {
                echo '<script>alert("Los datos se han insertado correctamente."); window.location.href = "../html-admin/asignaciones.php";</script>';
            } 
             else {
                echo "Error: " . $sqlt . "<br>" . mysqli_error($cone);
            }
        }
    }
    echo "Los datos se han insertado correctamente.<br>";

} else {
    echo "Error: los arreglos no tienen la misma longitud.";
}

// Cerrar la conexión
mysqli_close($cone);
?>

