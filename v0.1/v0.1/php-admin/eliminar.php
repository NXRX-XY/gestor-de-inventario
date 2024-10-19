<?php
    include("conexion.php");
  

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
    $cone = mysqli_connect($servername, $username, $password, $dbname) or die("Error en la conexion: " . mysqli_connect_error());

    if (isset($_POST["tecnicos"])) {
        $valorSeleccionado = $_POST["tecnicos"];
        $parts = explode('-', $valorSeleccionado);
        $nombres = $parts[0];
        $apellidos = $parts[1];
    }

    // Obtener el valor de $_POST["documento"] después de verificar si el formulario fue enviado
    $documento = $_POST["documento"];

    $sql = "DELETE FROM usuarios WHERE nombres = '$nombres' AND apellidos = '$apellidos'";

    if (mysqli_query($cone, $sql)) {
        echo '<script>alert("El usuario fue borrado correctamente."); window.location.href = "../html-admin/eliminar.php";</script>';
    } 
    if (isset($_SESSION['nombres']) && isset($_SESSION['apellidos'])) {
        // Ejecutar el script Python con el nombre completo como argumento
        $nombreCompleto = $_SESSION['nombres'] . ' ' . $_SESSION['apellidos'];
        $usuario = $nombres . " " . $apellidos;
        $python = "../python/log4.py";
        $output = shell_exec("python3 $python " . escapeshellarg($nombreCompleto) . " " . escapeshellarg($usuario) . " " . escapeshellarg($documento));
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($cone);
    }

    // Cerrar la conexión
    mysqli_close($cone);
?>
