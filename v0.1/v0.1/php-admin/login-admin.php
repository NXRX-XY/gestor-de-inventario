<?php
$server = "localhost";
$user = "usuario";
$contra = "contraseña";
$BD = "base_de_datos";

$conexion = mysqli_connect($server, $user, $contra, $BD) or die("Error en la conexión");

session_start();

$correo = $_POST["email"];
$contraseña = $_POST["psw"];
$tiempoBloqueo = 3600; // Duración del bloqueo en segundos (1 hora)
$intentosMaximos = 5; // Número máximo de intentos fallidos permitidos

// Verificar si el usuario está bloqueado
function verificarBloqueo($correo)
{
    global $conexion, $tiempoBloqueo;

    $consulta = "SELECT bloqueado, UNIX_TIMESTAMP(ultimo_intento) as ultimo_intento FROM administradores WHERE correo = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "s", $correo);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $fila = mysqli_fetch_assoc($resultado);


    if ($fila['bloqueado'] == 1) {
        $tiempoActual = time();
        $ultimoIntento = $fila['ultimo_intento'];

        if (($tiempoActual - $ultimoIntento) < $tiempoBloqueo) {
            return true;
        } else {
            // Si ha pasado el tiempo de bloqueo, desbloquear al usuario
            desbloquearUsuario($correo);
            return false;
        }
    }
    return false;
}


// Incrementar el contador de intentos fallidos y bloquear el usuario si se alcanza el límite máximo
function incrementarIntentosFallidos($correo)
{

    global $conexion, $intentosMaximos;


    $consulta = "UPDATE administradores SET intentos_fallidos = intentos_fallidos + 1, ultimo_intento = NOW() WHERE correo = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "s", $correo);
    mysqli_stmt_execute($stmt);

    $intentosFallidos = obtenerIntentosFallidos($correo);
    if ($intentosFallidos >= $intentosMaximos) {
        bloquearUsuario($correo);
    }
}

// Obtener el número de intentos fallidos
function obtenerIntentosFallidos($correo)
{

    global $conexion;


    $consulta = "SELECT intentos_fallidos FROM administradores WHERE correo = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "s", $correo);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $fila = mysqli_fetch_assoc($resultado);
    return $fila['intentos_fallidos'];
}

// Bloquear al usuario
function bloquearUsuario($correo)
{

    global $conexion;

    $consulta = "UPDATE administradores SET bloqueado = 1, ultimo_intento = NOW() WHERE correo = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "s", $correo);
    mysqli_stmt_execute($stmt);
}

// Desbloquear al usuario
function desbloquearUsuario($correo)
{

    global $conexion;

    $consulta = "UPDATE administradores SET bloqueado = 0, intentos_fallidos = 0 WHERE correo = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "s", $correo);
    mysqli_stmt_execute($stmt);
}

// Verificar si el usuario está bloqueado
if (verificarBloqueo($correo)) {
    echo "Has excedido el número máximo de intentos fallidos. Debes esperar un tiempo antes de intentar nuevamente.";
    echo '<script>alert("Has excedido el número máximo de intentos fallidos. Debes esperar un tiempo antes de intentar nuevamente."); window.location.href = "../html-admin/login-admin.php";</script>';
    exit();
}


// Preparar la consulta con un marcador de posición (?)
$consulta = "SELECT * FROM administradores WHERE correo = ?";
$stmt = mysqli_prepare($conexion, $consulta);
mysqli_stmt_bind_param($stmt, "s", $correo);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$administrador = mysqli_fetch_assoc($resultado);

if ($administrador) {
    if (password_verify($contraseña, $administrador['contrasea'])) {
        // Las credenciales son correctas, reiniciar los intentos fallidos si ha pasado un día desde el último intento
        $ultimoIntento = strtotime($administrador['ultimo_intento']);
        $tiempoActual = time();
        $tiempoDia = 24 * 60 * 60; // 24 horas en segundos

        if (($tiempoActual - $ultimoIntento) >= $tiempoDia) {
            desbloquearUsuario($correo);

        }

        $_SESSION['login'] = true;
        $_SESSION['nombres'] = $administrador['nombres'];
        $_SESSION['apellidos'] = $administrador['apellidos'];
        $_SESSION['correo'] = $administrador['correo'];
        $_SESSION['contrasea'] = $administrador['contrasea'];
        $_SESSION['rol'] = $administrador['rol'];
     
        //registro del log de sesion 
        if (isset($_SESSION['nombres']) && isset($_SESSION['apellidos'])) {
            // Ejecutar el script Python con el nombre completo como argumento
            $nombreCompleto = $_SESSION['nombres'] . ' ' . $_SESSION['apellidos'];
            $python = "../python/log.py";
            $output = shell_exec("python3 $python " . escapeshellarg($nombreCompleto));
        }

        // Redireccionar según el rol del usuario
        if ($_SESSION['rol'] == 'administrador') {
            header('Location: ../html-admin/aprovisionar.php');
            exit();
        }

    } else {
        // Incrementar el contador de intentos fallidos
        incrementarIntentosFallidos($correo);
        echo "Contraseña incorrecta";
        echo '<script>alert("Contraseña incorrecta."); window.location.href = "../html-admin/login-admin.php";</script>';
    }

} else {
    echo "El administrador no existe.";
    echo '<script>alert("El administrador no existe."); window.location.href = "../html-admin/login-admin.php";</script>';
}

mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>

