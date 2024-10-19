<?php
    include("conexion.php");

    session_start();

    if (!isset($_SESSION['correo'])) {
        // Redirecciona al formulario de inicio de sesión o muestra un mensaje de error.
        header("Location: ../html-admin/login-admin.php"); // Redirecciona al formulario de inicio de sesión
        exit;
    }

    // Conectarse a la base de datos
    $servername = "localhost";
    $username = "usuario";
    $password = "contraseña";
    $dbname = "base_de_datos";
    $cone = mysqli_connect($servername, $username, $password, $dbname) or die("Error en la conexion: " . mysqli_connect_error());

    $guia = $_POST["eliminar"];

    $sql = "DELETE FROM tabla WHERE numero_de_guia = '$guia'";

    if (mysqli_query($cone, $sql)) {
        echo '<script>alert("La guía fue eliminada correctamente."); window.location.href = "../html-admin/eliminar_aprovisiones.php";</script>';
    } 
    if (isset($_SESSION['nombres']) && isset($_SESSION['apellidos'])) {
        // Ejecutar el script Python con el nombre completo como argumento
        $nombreCompleto = $_SESSION['nombres'] . ' ' . $_SESSION['apellidos'];
        $python = "../python/log11.py";
        $output = shell_exec("python3 $python " . escapeshellarg($nombreCompleto) . " " . escapeshellarg($guia));
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($cone);
    }

    // Cerrar la conexión
    mysqli_close($cone);
?>
