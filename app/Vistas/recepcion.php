<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id'])) {
    // Redirigir a la página de inicio de sesión
    header('Location: ./login.php');
    exit();
}
// Verificar si el usuario tiene el permiso adecuado
if ($_SESSION['tipo'] !== 'recepcion' && $_SESSION['tipo'] !== 'admin' && $_SESSION['tipo'] !== 'atencion') {
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
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="container-fluid d-flex flex-column vh-100">
                        <div class="row">
                            <div class="col-md-12 align-self-end mt-md-5 mt-lg-4 pt-md-2 pt-lg-0">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="card-body">
                                                <h4 class="card-title mb-4 text-truncate">BUSCAR NOTA</h4>
                                                <form class="d-flex" onsubmit="return false">
                                                    <input id="busfolio" class="form-control me-2" type="search" placeholder="FOLIO O ESCANEAR" aria-label="Search">
                                                    <button class="btn btn-outline-primary waves-effect" onclick="buscarnota()">BUSCAR</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 position-relative text-center">
                                            <img src="../../assets/img/illustrations/illustration-john-2.png" class="card-img-position bottom-0 w-auto end-0 scaleX-n1-rtl" alt="View Profile">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="display: none;" id="resultado_busqueda" class="row">

                        </div>
                        <div id="contenido_notas">
                            <div class="row">
                                <div class="col-md-12 mt-md-5 mt-lg-4 pt-md-2 pt-lg-0 my-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3 bg-light p-2 rounded">
                                                <div class="d-flex align-items-center">
                                                    <h1 class="title-table2 ms-2 me-4">Notas listas para entregar</h1>
                                                    <button type="button" class="btn btn-primary" onclick="recargarContenido();">Recargar</button>
                                                </div>
                                                <input style="width: 50%;" type="search" class="form-control me-2" id="inputBusquedaNotas" placeholder="Realiza una búsqueda en la tabla">
                                            </div>

                                            <div class="overflow-auto">
                                                <table class="table color-de-texto">
                                                    <thead class="table-light">
                                                        <tr class="text-center">
                                                            <th>Folio</th>
                                                            <th>Cliente</th>
                                                            <th>Hora</th>
                                                            <th>Estado</th>
                                                            <th>Opciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="bodyTableNotas" class="text-center">
                                                        <!-- Contenido de la tabla -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>




                        </div>

                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>
            <!-- Overlay -->
        </div>
        <?php

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
        <script src="../../assets/js/Recepcion.js" type="text/javascript"></script>



</body>

</html>