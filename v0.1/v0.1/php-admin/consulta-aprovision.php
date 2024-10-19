<?php
    include("conexion.php");
    include("validacion.php");

    session_start();

if (!isset($_SESSION['correo'])) {
    // Redirecciona al formulario de inicio de sesión o muestra un mensaje de error.
    header("Location: ../html-admin/login-admin.html"); // Redirecciona al formulario de inicio de sesión
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="messages" style="margin-left: 50px;">
    <button onclick="descargarExcel()">Descargar Excel</button>
</div>

<script>
    function descargarExcel() {
        var tablas = document.querySelectorAll('.messages table');

        var contenidoHTML = '<html><head><meta charset="UTF-8"><style>td, th {border: 1px solid black;}</style></head><body>';

        for (var i = 0; i < tablas.length; i++) {
            contenidoHTML += tablas[i].outerHTML;
        }

        contenidoHTML += '</body></html>';

        var enlaceDescarga = document.createElement('a');
        enlaceDescarga.href = 'data:application/vnd.ms-excel,' + encodeURIComponent(contenidoHTML);
        enlaceDescarga.download = 'tabla.xls';
        enlaceDescarga.click();
    }
</script>
<?php
$servername = "localhost";
$username = "usuario";
$password = "contraseña";
$dbname = "base_de_datos";
$cone=mysqli_connect($servername, $username, $password, $dbname)or die ("error en la conexion");
mysqli_set_charset($cone, 'utf8');

// Recibir los datos del formulario
$busqueda = $_POST["busqueda"];
$opcion = $_POST["opcion"];

// Ejecutar la consulta SQL correspondiente
if ($opcion == "opcion1") {
    $sql = "SELECT * FROM tabla WHERE numero_de_guia = '$busqueda' ORDER BY fecha";
} elseif ($opcion == "opcion2") {
    $sql = "SELECT * FROM tabla WHERE descripcion LIKE '%$busqueda%' ORDER BY fecha";
} elseif ($opcion == "opcion3") {
    $sql = "SELECT * FROM tabla WHERE fecha LIKE '%$busqueda%' ORDER BY fecha";
} else {
    echo "Error: Opción inválida.";
}

$resultado = mysqli_query($cone, $sql);

// Imprimir los resultados en una tabla con rayas
if (mysqli_num_rows($resultado) > 0) {
    echo "<div style='overflow-x:auto;' class='messages'>";
    echo "<table style='border-collapse: collapse;'>";
    $num_guia_actual = null; // Variable auxiliar para almacenar el número de guía actual
    echo "<style>td, th {border: 1px solid black;}</style>";
    
    while($fila = mysqli_fetch_assoc($resultado)) {
        if ($fila["numero_de_guia"] != $num_guia_actual) {
            // Si el número de guía es diferente al actual, cerrar la tabla actual y abrir una nueva tabla
            if (!is_null($num_guia_actual)) {
                echo "</table>";
            }
            echo "<table style='border-collapse: collapse;'>";
            echo "<tr><th>Item</th><th>Numero de guia</th><th>Código</th><th>Material</th><th>Cantidad</th><th>Unidad</th><th>Fecha</th><th>Provedor</th></tr>";
            
            $num_guia_actual = $fila["numero_de_guia"];
            $contador = 1; // Inicializar el contador en 1 para la nueva tabla
        }
        echo "<tr><td>".$contador."</td><td>".$fila["numero_de_guia"]."</td><td>".$fila["codigo"]."</td><td>".$fila["descripcion"]."</td><td>".$fila["cantidad"]."</td><td>".$fila["unidad"]."</td><td>".$fila["fecha"]."</td><td>".$fila["provedor"]."</td></tr>";
        $contador++;
    }
    echo "</table>";
    echo "</div>";
} else {
    echo "No se encontraron resultados para la búsqueda realizada.";
}


mysqli_close($cone);

?>

</body>
</html>
