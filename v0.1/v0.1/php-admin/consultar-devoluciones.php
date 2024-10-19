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
$cone = mysqli_connect($servername, $username, $password, $dbname) or die("Error en la conexión");

mysqli_set_charset($cone, 'utf8');

// Recibir los datos del formulario
$busqueda = $_POST["busqueda"];
$opcion = $_POST["opcion"];
$tabla = $_POST["tablaa"];

$condition = '';
if ( $tabla !== 'todo') {
    $condition = "AND asignacion = '$tabla'";
}
$sql = "SELECT * FROM devolucion WHERE $opcion LIKE '%$busqueda%' $condition";

$resultado = mysqli_query($cone, $sql);


// Imprimir los resultados en una tabla con rayas

if (mysqli_num_rows($resultado) > 0) {
    echo "<div style='overflow-x:auto;' class='messages'>";
    echo "<table style='border-collapse: collapse;'>";
    echo "<style>td, th {border: 1px solid black;}</style>";
    echo "<tr style='background-color: grey;' class='excel-table'><th>Item</th><th>Nombres</th><th>Apellidos</th><th>Asignacion</th><th>Codigo</th><th>Número de guía</th><th>Objeto</th><th>Cantidad</th><th>Unidad</th><th>Fecha</th></tr>";

    $contador = 1; // Inicializar el contador en 1 para la nueva tabla

    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<tr><td>".$contador."</td><td>".$fila["nombres"]."</td><td>".$fila["apellidos"]."</td><td>".$fila["asignacion"]."</td><td>".$fila["codigo"]."</td><td>".$fila["numero_de_guia"]."</td><td>".$fila["descripcion"]."</td><td>".$fila["cantidad"]."</td><td>".$fila["unidad"]."</td><td>".$fila["fecha"]."</td></tr>";
        $contador++;
    }

    echo "</table>";
    echo "</div>";
} else {
    echo "No se encontraron resultados para la búsqueda realizada.";
}
?>
</body>
</html>