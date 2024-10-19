<?php
session_start();

if (!isset($_SESSION['correo'])) {
    // Redirecciona al formulario de inicio de sesión o muestra un mensaje de error.
    header("Location: ../html-admin/login-admin.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $selectedOption = $_POST["serial"];
    $customSerial = $_POST["otroSerial"];
    $selectedmac = $_POST["mac"];
    $custommac = $_POST["otroMac"];
    $selectedproduct = $_POST["producto"];
    $customproduct = $_POST["otroproducto"];

    // Conectarse a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "Win123456789jd*";
    $dbname = "jdmallau_almacen";
    $cone = mysqli_connect($servername, $username, $password, $dbname) or die("Error en la conexi��n: " . mysqli_connect_error());
    mysqli_set_charset($cone, 'utf8');

    $inserted = false; // Bandera para verificar si se insertó correctamente

    // Verificar si al menos una combinación es válida y realizar la inserción correspondiente
    if ($selectedOption !== "" && $selectedmac !== "" && !empty($selectedproduct)) {
        $sql = "INSERT INTO ontused (producto, serial, mac) VALUES ('$selectedproduct', '$selectedOption', '$selectedmac')";
        if (mysqli_query($cone, $sql)) {
            $inserted = true;
        }
    } elseif ($selectedOption !== "" && $custommac !== "" && !empty($selectedproduct)) {
        $sql = "INSERT INTO ontused (producto, serial, mac) VALUES ('$selectedproduct', '$selectedOption', '$custommac')";
        if (mysqli_query($cone, $sql)) {
            $inserted = true;
        }
    } elseif ($selectedOption !== "" && $selectedmac !== "" && !empty($customproduct)) {
        $sql = "INSERT INTO ontused (producto, serial, mac) VALUES ('$customproduct', '$selectedOption', '$selectedmac')";
        if (mysqli_query($cone, $sql)) {
            $inserted = true;
        }
    } elseif ($customSerial !== "" && $selectedmac !== "" && !empty($selectedproduct)) {
        $sql = "INSERT INTO ontused (producto, serial, mac) VALUES ('$selectedproduct', '$customSerial', '$selectedmac')";
        if (mysqli_query($cone, $sql)) {
            $inserted = true;
        }
    } elseif ($selectedOption !== "" && $custommac !== "" && !empty($customproduct)) {
        $sql = "INSERT INTO ontused (producto, serial, mac) VALUES ('$customproduct', '$selectedOption', '$custommac')";
        if (mysqli_query($cone, $sql)) {
            $inserted = true;
        }
    } elseif ($customSerial !== "" && $selectedmac !== "" && !empty($customproduct)) {
        $sql = "INSERT INTO ontused (producto, serial, mac) VALUES ('$customproduct', '$customSerial', '$selectedmac')";
        if (mysqli_query($cone, $sql)) {
            $inserted = true;
        }
    }


    if ($inserted) {
        echo "Nuevo valor agregado a la base de datos";
    } else {
        echo "Error al agregar el valor: " . mysqli_error($cone);
    }


    // Cerrar la conexión a la base de datos
    mysqli_close($cone);
}
?>

