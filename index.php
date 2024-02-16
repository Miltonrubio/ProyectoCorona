<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['ID_usuario'])) {
    // El usuario ha iniciado sesión

    // Verificar el tipo de usuario
    if ($_SESSION['tipo'] === 'SUPERADMIN') {
        header('Location: ./app/Vistas/admin.php');
    } else if ($_SESSION['tipo'] === 'INVENTARIO') {
        // Redirigir al panel de administración
        header('Location: ./app/Vistas/inventarios.php');
        exit();
    } elseif ($_SESSION['tipo'] === 'COMPRADOR') {
        // Redirigir al panel de administración
        header('Location: ./app/Vistas/compradores.php');
        exit();
    }
} else {
    // El usuario no ha iniciado sesión, redirigir al formulario de inicio de sesión
    header('Location: ./app/Vistas/login.php');
    exit();
}
?>