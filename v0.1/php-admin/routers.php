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
$dbname = "base_de_datos";
$cone = mysqli_connect($servername, $username, $password, $dbname) or die("Error en la conexión: " . mysqli_connect_error());
mysqli_set_charset($cone, 'utf8');

// Verificar si se recibió el número de guía
if (!isset($_POST["mac"])) {
    die("Error: No se recibió el número de guía.");
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['archivo'])) {
        $nombreArchivo = $_FILES['archivo']['name'];
        $tipoArchivo = $_FILES['archivo']['type'];
        $rutaArchivo = $_FILES['archivo']['tmp_name'];
        $errorArchivo = $_FILES['archivo']['error'];
        $tamañoArchivo = $_FILES['archivo']['size'];

        $mac = $_POST["mac"];
        $extensionArchivo = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
        $nombreArchivoNuevo = $mac . '.' . $extensionArchivo;


        // Verificar si no hubo errores al subir el archivo
        if ($errorArchivo === UPLOAD_ERR_OK) {
            // Mover el archivo subido a una ubicación deseada en el servidor
            $carpetaExterior = '../imagenes-ont/';
            $destino = $carpetaExterior . $nombreArchivoNuevo;
            if (move_uploaded_file($rutaArchivo, $destino)) {
                echo 'La foto se ha subido correctamente.';
            } else {
                echo 'Error al mover el archivo subido.';
            }
        } else {
            echo 'Error al subir el archivo: ' . $errorArchivo;
        }
    } else {
        echo 'No se ha seleccionado ninguna foto.';
    }

}



// Recordar que al momento de hacer una variable de selección y luego agregar a la consulta el name del select y el value de las opciones
$producto = $_POST["producto-id"];
$mac = $_POST["mac"];
$serial = $_POST["numero-serial"];
$fecha = $_POST["fecha"];

            $sql = "INSERT INTO ont (productoid, serial, mac, fecha) VALUES ('$producto', '$mac','$serial','$fecha')";
            if (mysqli_query($cone, $sql)) {
                echo '<script>alert("Los datos se han insertado correctamente."); window.location.href = "../html-admin/routers.php";</script>';
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($cone);
            }

    

// Cerrar la conexión
mysqli_close($cone);
?>

