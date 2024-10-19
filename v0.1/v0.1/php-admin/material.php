<?php
    include("conexion.php");
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
$tabla = $_POST["tablaa"];
$fi = isset($_POST["fecha-inicio"]) ? $_POST["fecha-inicio"] : '';
$ff = isset($_POST["fecha-fin"]) ? $_POST["fecha-fin"] : '';
$fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : '';

// Construir la parte de la consulta para los filtros de fecha
$fechaCondition = '';
if (!empty($fi) && !empty($ff)) {
    $fechaCondition = "AND fecha >= '$fi' AND fecha <= '$ff'";
}
else if (!empty($fecha)) {
    $fechaCondition = "AND fecha = '$fecha'";
}


// Construir la consulta SQL
$sql = "SELECT * FROM $tabla WHERE $opcion LIKE '%$busqueda%' $fechaCondition ORDER BY fecha ASC";

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
            echo "<tr><th>Item</th><th>Numero de guia</th><th>Nombres</th><th>Apellidos</th><th>Cuadrilla</th><th>Material</th><th>Cantidad</th><th>Unidad</th><th>Fecha</th><th>Codigo</th></tr>";
            
            $num_guia_actual = $fila["numero_de_guia"];
            $contador = 1; // Inicializar el contador en 1 para la nueva tabla
        }
        echo "<tr><td>".$contador."</td><td>".$fila["numero_de_guia"]."</td><td>".$fila["nombres"]."</td><td>".$fila["apellidos"]."</td><td>".$fila["cuadrilla"]."</td><td>".$fila["descripcion"]."</td><td>".$fila["cantidad"]."</td><td>".$fila["unidad"]."</td><td>".$fila["fecha"]."</td><td>".$fila["codigo"]."</td></tr>";
        $num_guia_actuall = $fila["numero_de_guia"];
        $contador++;
    }
    echo "</table>";
    echo "</div>";
} else {
    echo "No se encontraron resultados para la búsqueda realizada.";
}


mysqli_close($cone);

?>
<script>
function descargarExcel() {
    // Construir la URL con los parámetros necesarios
    var busqueda = encodeURIComponent('<?php echo $busqueda; ?>');
    var opcion = encodeURIComponent('<?php echo $opcion; ?>');
    var tabla = encodeURIComponent('<?php echo $tabla; ?>');
    var fechaInicio = encodeURIComponent('<?php echo $fi; ?>');
    var fechaFin = encodeURIComponent('<?php echo $ff; ?>');
    var fecha = encodeURIComponent('<?php echo $fecha; ?>');

    // Construir la URL con todos los parámetros necesarios
    var url = '../export/material.php?' +
              'busqueda=' + busqueda + '&' +
              'opcion=' + opcion + '&' +
              'tabla=' + tabla + '&' +
              'fecha_inicio=' + fechaInicio + '&' +
              'fecha_fin=' + fechaFin + '&' +
              'fecha=' + fecha;

    // Redirigir al usuario para descargar el archivo
    window.location.href = url;
}
</script>
</body>
</html>
