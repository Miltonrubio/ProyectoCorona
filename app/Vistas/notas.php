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

         <!-- <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
          <a href="#" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-semibold ms-2">MAYOREO</span>
          </a>
        </div>
        <ul class="menu-inner py-1">
          
          <div id="productividad">
          </div>
          
          <li class="menu-header fw-medium mt-4">
            <span class="menu-header-text" data-i18n="Apps &amp; Pages">--</span>
          </li>
          
          <div class="">
            <div class="card">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Top 10 de Surtidores</h5>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="saleStatus" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical mdi-24px"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="saleStatus">
                    <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                    <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                    <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                  </div>
                </div>
              </div>
              <div class="card-body" id="tabla_top_10">
              </div>
            </div>
          </div>
        </ul>
      </aside> -->
         <!-- / Menu -->

         <!-- Layout container -->
         <div class="layout-page">

            <!-- Content wrapper -->
            <div class="content-wrapper">


               <div class="container-fluid d-flex flex-column vh-100">
                  <div class="row gy-4">
                     <div class="col-xl-8 col-lg-7 align-self-end mt-md-5 mt-lg-4 pt-md-2 pt-lg-0">
                        <div class="card">
                           <div class="row">
                              <div class="col-12 col-md-6">
                                 <div class="card-body">
                                    <h4 class="card-title mb-4 text-truncate">BUSCAR NOTA 🎉</h4>
                                    <form class="d-flex" onsubmit="return false">
                                       <input id="busfolio" class="form-control me-2" type="search" placeholder="FOLIO O ESCANEAR" aria-label="Search" onkeyup="metaKeyUp(event)">
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

                     <div id="ajaxBusy" class="col-auto p-5 text-center">
                        <p>
                           <img src="../../assets/img/elements/carga.gif">
                        </p>
                     </div>
                     <div id="ajaxfecha" class="col-auto text-center mt-5  mx-auto">
                        <h2 class="mb-0" id="fechax">2023-01-01</h2>
                        <h2 class="mb-0" id="horax">00:00:00</h2>
                        <br />
                        <label>proxima actualizacion:</label><br />

                        <progress id="respuesta" class="progress-bar" value="0" max="80"> </progress>
                     </div>

                     <div style="display: none;" id="resultado_busqueda">

                     </div>

                     <div id="tablas_notas" class="row">
                        <center class="mt-4">
                           <button type="button" class="btn btn-primary" onclick="recargarContenido(); evitarDobleClic(this);">Recargar</button>
                           <button type="button" class="btn btn-primary" onclick="modalReporteNotasGeneral();">reportes</button>
                        </center>
                        <div class="col-md-4 col-sm-12 mt-md-5 mt-lg-4 pt-md-2 pt-lg-0 my-3">
                           <?php
                           include './Componentes/TablasPersonal.php';
                           ?>
                           <div class="card">
                              <h1 class="title-table">Notas Asignadas</h1>

                              <div id="tabla_notas_asignadas">

                              </div>
                           </div>
                        </div>

                        <div class="col-md-4 col-sm-12 mt-md-5 mt-lg-4 pt-md-2 pt-lg-0 my-3">
                           <div class="card">
                              <h1 class="title-table">Notas sin asignar</h1>
                              <input style="width: auto !important; margin:5px;" type="search" class="form-control " id="inputBusquedaNotas" placeholder="Realiza una busqueda">
                              <div style="  max-height: 65vh;" class="overflow-auto">
                                 <table class="table color-de-texto">
                                    <thead class="table-light">
                                       <tr class="text-center">
                                          <th>Folio</th>
                                          <th>Cliente</th>
                                          <th class="hidden-xl">Hora</th>
                                          <th>Opciones</th>
                                       </tr>
                                    </thead>
                                    <tbody id="bodyTableNotasSinAsignar" class="text-center">

                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-4 col-sm-12 mt-md-5 mt-lg-4 pt-md-2 pt-lg-0my-3">
                           <?php
                           include './Componentes/TablasPendientes.php';
                           ?>
                           <div class="card ">
                              <h1 class="title-table">Cargar notas</h1>
                              <div style="  max-height: 60vh;" class="overflow-auto">
                                 <table class="table ">
                                    <thead class="table-light">
                                       <tr class="text-center">
                                          <th>Numero</th>
                                          <th class="hidden-xl">Pag</th>
                                          <th>CLIENTE</th>
                                          <th class="hidden-xl">Fecha</th>
                                          <th>Opciones</th>
                                       </tr>
                                    </thead>
                                    <tbody id="bodyTableNotasSinCargar" class="text-center ">
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="modal fade" id="modal_asignar_nota" tabindex="-1" aria-labelledby="modal_asignar_nota" aria-hidden="true">
                        <div class="modal-dialog">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title">Asignar Nota</h5>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                 <form id="formulario">
                                    <input type="text" hidden value="" id="idDoc">
                                    <div class="form-floating mb-3">
                                       <input type="text" class="form-control" id="nlEmpleado" placeholder="Clave del empleado">
                                       <label for="nlEmpleado">Clave del empleado</label>
                                    </div>
                                    <div id="hojasContainer" class="container">
                                    </div>
                                 </form>
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                 <button type="button" id="btnAsignarNota" class="btn btn-primary">Asignar</button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="modal fade" id="modal_confirmacion" tabindex="-1" aria-labelledby="modal_confirmacion" aria-hidden="true">>
                        <div class="modal-dialog">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title">Cambiar a Pendiente</h5>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                 <form id="form_asignar_nota_pendiente" action="">
                                    <input type="text" hidden value="" name="input_idDoc_Pendiente" id="input_idDoc_Pendiente">
                                    <p>¿Estás seguro que deseas pasar a no surtir la nota seleccionada?</p>
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                 <button type="submit" class="btn btn-primary">confirmar</button>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!--/ Data Tables -->
                  </div>
               </div>
               <!-- / Content -->

               <!-- Footer -->
               <!-- <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl">
              <div class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
                <div class="text-body mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made with <span class="text-danger"><i class="tf-icons mdi mdi-heart"></i></span>

                </div>

              </div>
            </div>
          </footer> -->
               <!-- / Footer -->


            </div>
            <!-- Content wrapper -->
         </div>
         <!-- / Layout page -->
      </div>

      <!-- Overlay -->

   </div>
   <?php
   include './Modales/ProductividadSurtidor.php';
   include './Modales/ModalReporteNotasGeneral.php';
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
   <script src="../../assets/js/Notas.js" type="text/javascript"></script>



</body>

</html>