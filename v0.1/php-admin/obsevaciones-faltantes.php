<?php
        include("conexion.php");

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
$conn = mysqli_connect($servername, $username, $password, $dbname);
mysqli_set_charset($conn, 'utf8');

// Creamos un arreglo para almacenar los números de guía que ya se han impreso
$impresos = array();

// Hacemos la consulta a la base de datos
$sql = "SELECT *
FROM herramientas
WHERE observacion IS NULL
UNION
SELECT *
FROM materiales
WHERE observacion IS NULL;";
$result = mysqli_query($conn, $sql);

// Construimos la tabla con los resultados
echo "<table><tr><th>Nombres</th><th>Apellidos</th><th>Fecha</th><th>Número de guía</th><th>Asignación</th></tr>";
while($row = mysqli_fetch_assoc($result)) {
    // Verificamos si el número de guía ya se ha impreso
    if (in_array($row["nombres"] . "</td><td>" . $row["apellidos"] . "</td><td>" . $row["fecha"] . "</td><td>" . $row["numero_de_guia"] . "</td><td>" . $row["asignacion"] . "</td></tr>";)) {
        continue; // Si ya se ha impreso, saltamos a la siguiente fila
    }
    // Si no se ha impreso, imprimimos la fila y agregamos el número de guía al arreglo
    echo "<tr><td>Herramientas</td><td>" . $row["nombres"] . "</td><td>" . $row["apellidos"] . "</td><td>" . $row["fecha"] . "</td><td>" . $row["numero_de_guia"] . "</td><td>" . $row["asignacion"] . "</td></tr>";
    echo "<tr><td>Materiales</td><td>" . $row["nombres"] . "</td><td>" . $row["apellidos"] . "</td><td>" . $row["fecha"] . "</td><td>" . $row["numero_de_guia"] . "</td><td>" . $row["asignacion"] . "</td></tr>";
    array_push($impresos, $row["nombres"] . "</td><td>" . $row["apellidos"] . "</td><td>" . $row["fecha"] . "</td><td>" . $row["numero_de_guia"] . "</td><td>" . $row["asignacion"] . "</td></tr>";
}
echo "</table>";

// Cerramos la conexión
mysqli_close($conn);
?>