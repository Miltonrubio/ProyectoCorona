<!DOCTYPE html>
<html lang="en">

<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['id'])) {
    // Redirigir a la página de inicio de sesión
    header('Location: ../../');
    exit();
}
?>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/css/login.css" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet" />

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

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../assets/js/config.js"></script>
    <link rel="stylesheet" href="../../librerias/toastr/toastr.min.css" />
</head>

<body>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card" style="border-radius: 1rem">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4">
                                <h2 class="fw-bold mb-2 text-uppercase">Inicio de sesión</h2>
                                <p class="mb-5">Ingresa tu teléfono y tu contraseña</p>
                                <div id="mensaje-verificacion" class="alert alert-warning" style="display: none; margin-top: -40px;">
                                    Verifica los datos ingresados.
                                </div>
                                <form id="form_inicio_sesion" enctype="multipart/form-data">
                                    <div class="mb-4">
                                        <label for="inputEmail4" class="form-label">Teléfono</label>
                                        <input type="tel" onkeypress="return [45, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57].includes(event.charCode);" maxlength="10" required class="form-control" placeholder="Ingresa el numero de telefono" name="phone" id="phone">
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputPassword4" class="form-label">Contraseña</label>
                                        <input placeholder="Ingresa tu contraseña" type="password"
                                            class="form-control mb-3" name="password" id="password" required>
                                    </div>
                                    <div class="form form-switch mb-5">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="mostrarPassword">
                                        <label class="form-check-label" for="mostrarPassword">Mostrar Contraseña</label>
                                    </div>
                                    <button class="btn btn-primary btn-lg px-5" type="submit">
                                        Iniciar sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    <script src="../../assets/js/Login.js" type="text/javascript"></script>
</body>

</html>