<?php
session_start();
$nombreCompleto = $_SESSION['nombres'] . ' ' . $_SESSION['apellidos'];
$_SESSION = array();
session_destroy();

// Ejecutar el script Python para registrar el cierre de sesión con el nombre completo del usuario
$python = "../python/log1.py";
$output = shell_exec("python3 $python " . escapeshellarg($nombreCompleto));
    
header('Location: ../html-admin/login-admin.php');
?>
