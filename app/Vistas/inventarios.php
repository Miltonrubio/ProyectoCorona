<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['ID_usuario'])) {
    // Redirigir a la página de inicio de sesión
    header('Location: ./login.php');
    exit();
}

//Verificar si el usuario tiene el permiso adecuado
if ($_SESSION['tipo'] !== 'INVENTARIO' && $_SESSION['tipo'] !== 'SUPERADMIN') {
    // Redirigir o mostrar un mensaje de error
    header('Location: ./error.html');
    exit();
}
?>
<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Administrador Notas Mayoreo</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />

    <link rel="stylesheet" href="../../assets/vendor/fonts/materialdesignicons.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />
    <link rel="stylesheet" href="../../assets/css/colores.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />
    <!-- Page CSS -->
    <!-- Añade esta línea en el encabezado del documento para incluir la librería de iconos Bootstrap -->
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../assets/js/config.js"></script>
    <link rel="stylesheet" href="../../librerias/toastr/toastr.min.css">
</head>

<body>
    <?php
    include './Componentes/MenuSuperior.php';
    ?>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <div class="layout-page">
                <div class="content-wrapper">
                    <div class="container-fluid d-flex flex-column vh-100">
                        <div class="row">
                            <div class="col-md-12 mt-md-5 mt-lg-4 pt-md-2 pt-lg-0">
                                <div class="card">
                                    <div class="card-body">
                                    <h2>Solicitudes</h2>
                                        <div class="d-flex justify-content-between align-items-center mb-3 bg-light p-2 rounded">
                                       
                                            <div class="d-flex">
                                                <!--                                                 <button  class="btn btn-success mx-3" onclick="modalAgregarUsuario();">Agregar</button> -->
                                                <p> Fecha de inicio: <input type="date" class="form-control" name="fecha_inicio"></p>
                                                <p> Fecha de fin: <input type="date" class="form-control" name="fecha_fin"> </p>
                                            </div>

                                            <div class="d-flex">
                                               <button class="btn btn-primary" type="button"> <i class="bi bi-file-earmark-pdf-fill">Descargar</i></button>
                                            </div>
                                        </div>
                                        <div class="overflow-auto">
                                            <table class="table color-de-texto">
                                                <thead class="table-light">
                                                    <tr class="text-center">
                                                        <th>Fecha De Solicitud</th>
                                                        <th>Proveedor</th>
                                                        <th>Fecha Entrega</th>
                                                        <th>Solicita</th>
                                                        <th>Empresa</th>
                                                        <th>Observaciones</th>
                                                        <th>Status</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bodyTableSolicitudes" class="text-center">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

include './Modales/RechazarSolicitud.php';
include './Modales/RestaurarSolicitud.php';
include './Modales/EntregarSolicitud.php';

/*
    include './Modales/ModalAgregarUsuario.php';
    include './Modales/EliminarUsuario.php';
    include './Modales/EditarUsuario.php';
    include './Modales/VerPassword.php';
*/


    ?>
    <!-- / Layout wrapper -->
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../../assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <script src="../../librerias/toastr/toastr.min.js"></script>
    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>

    <!-- JS Funciones-->
    <script src="../../assets/js/inventarios.js" type="text/javascript"></script>



</body>

</html>