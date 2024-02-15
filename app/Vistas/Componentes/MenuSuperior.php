<nav class="navbar navbar-expand-md navbar-light bg-light">
        <div class="container-fluid">
            <!-- Logo o nombre de la aplicación -->
            <a class="navbar-brand" href="../../">Proyecto Hidalgo</a>

            <!-- Botón de hamburguesa para dispositivos móviles -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Contenedor de elementos de la barra de navegación -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Otros elementos de la barra de navegación, si es necesario -->

                    <!-- Desplegable con nombre del usuario y opción de cerrar sesión -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> <?php echo $_SESSION['nombre']?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <!-- Otras opciones si es necesario -->
                            <!-- <a class="dropdown-item" href="#">Opción 1</a>
                            <a class="dropdown-item" href="#">Opción 2</a>
                            <div class="dropdown-divider"></div> -->
                            <a class="dropdown-item" href="../Controlador/NotasControlador.php?operador=cerrar_sesion">
                                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>