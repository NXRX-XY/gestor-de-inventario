<?php
session_start();

if (isset($_SESSION['correo']) && $_SESSION['rol'] === 'administrador') {
    // Si hay una sesión iniciada y el usuario tiene el rol de administrador,
    // redirecciona a la página de aprovisionamiento
    header("Location: ../html-admin/aprovisionar.php");
    exit;
}

// Si no hay sesión iniciada, redirecciona al formulario de inicio de sesión
header("Location: ../html-admin/login-admin.php");
exit;
?>

