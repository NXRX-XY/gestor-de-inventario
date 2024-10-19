<?php
    include("../php-admin/conexion.php");

    session_start();

if (!isset($_SESSION['correo'])) {
    // Redirecciona al formulario de inicio de sesión o muestra un mensaje de error.
    header("Location: ../html-admin/login-admin.php"); // Redirecciona al formulario de inicio de sesión
    exit;
}
$rol = $_SESSION['rol'];

// Verificar si el usuario tiene el rol de administrador
if ($rol !== 'administrador') {
    // El usuario no tiene permiso para acceder a esta área
    echo "Acceso denegado";
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Consultar asignaciones</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/LOGO.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="../html-admin/aprovisionar.php" class="text-nowrap logo-img">
            <img src="../assets/images/logos/LOGO.png" width="180" alt="" style="position: absolute; top: 2%; left: 14%;"/>
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">CONSULTAS</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/aprovisionar.php" aria-expanded="false">
                <span>
                  <i class="ti ti-upload"></i>
                </span>
                <span class="hide-menu">Aprovisionar</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/eliminar_aprovisiones.php" aria-expanded="false">
                <span>
                  <i class="ti ti-notes-off"></i>
                </span>
                <span class="hide-menu">Eliminar aprovisiones</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/stock.php" aria-expanded="false">
                <span>
                  <i class="ti ti-list-details"></i>
                </span>
                <span class="hide-menu">Stock en almacén</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/materiales.php" aria-expanded="false">
                <span>
                  <i class="ti ti-tools"></i>
                </span>
                <span class="hide-menu">Agregar y quitar material</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/asignaciones.php" aria-expanded="false">
                <span>
                  <i class="ti ti-files"></i>
                </span>
                <span class="hide-menu">Asignaciones</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/flujo-de-proceso.php" aria-expanded="false">
                <span>
                  <i class="ti ti-file-search"></i>
                </span>
                <span class="hide-menu">Consultar asignaciones</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/eliminar-guias.php" aria-expanded="false">
                <span>
                  <i class="ti ti-article-off"></i>
                </span>
                <span class="hide-menu">Eliminar asignaciones</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/entregas.php" aria-expanded="false">
                <span>
                   <i class="ti ti-arrow-down"></i>
                </span>
                <span class="hide-menu">Devoluciones</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/consultar-devoluciones.php" aria-expanded="false">
                <span>
                   <i class="ti ti-search"></i>
                </span>
                <span class="hide-menu">Consultar devoluciones</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/eliminar_devoluciones.php" aria-expanded="false">
                <span>
                   <i class="ti ti-x"></i>
                </span>
                <span class="hide-menu">Eliminar devoluciones</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/entrada_ont.php" aria-expanded="false">
                <span>
                   <i class="ti ti-router"></i>
                </span>
                <span class="hide-menu">Entrada ont</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/consulta_entrada_ont.php" aria-expanded="false">
                <span>
                   <i class="ti ti-zoom-check"></i>
                </span>
                <span class="hide-menu">Consultar entrada ont</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/eliminar_entrada_ont.php" aria-expanded="false">
                <span>
                   <i class="ti ti-wifi-off"></i>
                </span>
                <span class="hide-menu">Eliminar entrada ont</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/entrega_ont.php" aria-expanded="false">
                <span>
                   <i class="ti ti-router-off"></i>
                </span>
                <span class="hide-menu">Entrega ont</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/consulta_entrega_ont.php" aria-expanded="false">
                <span>
                   <i class="ti ti-zoom-cancel"></i>
                </span>
                <span class="hide-menu">Consultar entrega ont</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/eliminar_entrega_ont.php" aria-expanded="false">
                <span>
                   <i class="ti ti-x"></i>
                </span>
                <span class="hide-menu">Eliminar entrega ont</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/pendientes.php" aria-expanded="false">
                <span>
                  <i class="ti ti-file-dollar"></i>
                </span>
                <span class="hide-menu">Actas de trabajo</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/consultar-actas.php" aria-expanded="false">
                <span>
                  <i class="ti ti-report-search"></i>
                </span>
                <span class="hide-menu">Consultar actas</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">AUTENTICACIÓN</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/registro.php" aria-expanded="false">
                <span>
                <i class="ti ti-user"></i>
                </span>
                <span class="hide-menu">Registrar</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../html-admin/eliminar.php" aria-expanded="false">
                <span>
                <i class="ti ti-user-off"></i>
                </span>
                <span class="hide-menu">Eliminar</span>
              </a>
            </li>
            
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
           
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <a href="../php-admin/cerrar.php" id="logoutButton" class="btn btn-primary" style="margin-left: 0.5rem; margin-right: 0.rem; border-right: 1rem;">Cerrar Sesión</a>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <div class="card">
                <h5 class="card-title fw-semibold mb-4" style="text-align:center; margin: 0 auto;">Consultas de Asignaciones</h5>
        <form id="myForm" method="post" action="../php-admin/material.php" target="_blank" class="card mb-0" style="width: 90%; height: 25%; position: relative; display: flex; flex-direction: column; align-items: center; left: 4%; border: 4px solid skyblue; border-radius: 5px;">
        <section class="card-body p-4" style="display: flex; flex-direction: column; align-items: center; width: 100%;">
        <h2 style="font-size: 1.3rem; margin: 1rem 0;">Ingrese su búsqueda:</h2>
        <input id="descripcion" name="busqueda" type="text" style="width: 90%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);">
        <h2 style="font-size: 1.3rem; margin: 1rem 0;">Filtrar por:</h2>
        <select name="opcion" id="opcion" style="width: 90%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);">
            <option value="nombres">Nombres</option>
            <option value="apellidos">Apellidos</option>
            <option value="numero_de_guia">Código</option>
            <option value="descripcion">Material</option>
            <option value="cuadrilla">Cuadrilla</option>
        </select>
        <select name="tablaa" id="tipo-asignacion" style="margin-top: 40px; width: 90%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);">
            <option value="materiales">Asignación de materiales</option>
            <option value="herramientas">Asignación de herramientas</option>
            <option value="uniforme">Asignación de uniforme</option>
        </select>
        
        <!-- Checkbox para mostrar/ocultar campos de fecha -->
        <div id="checkbox-container" style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
        <label id="label-toggle-fechas" style="margin-right: 20px; display: flex; align-items: center;">
            <input type="checkbox" id="toggle-fechas" style="margin-right: 10px;">
            Filtrar por rango de fecha
        </label>

        <label id="label-check-fecha" style="display: flex; align-items: center;">
            <input type="checkbox" id="check-fecha" style="margin-right: 10px;">
            Filtrar por fecha única
        </label>
    </div>

    <div id="fecha-container" style="display: none; width: 100%; text-align: center;">
        <h2 style="font-size: 1.3rem; margin: 1rem 0;">Fecha inicio</h2>
        <input id="fecha-inicio" type="date" name="fecha-inicio" style="width: 90%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);">
        <h2 style="font-size: 1.3rem; margin: 1rem 0;">Fecha fin</h2>
        <input id="fecha-fin" type="date" name="fecha-fin" style="width: 90%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);">
    </div>

    <div id="fecha" style="display: none; width: 100%; text-align: center;">
        <h2 style="font-size: 1.3rem; margin: 1rem 0;">Fecha</h2>
        <input id="fecha-input" type="date" name="fecha" style="width: 90%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);">
    </div>
    </section>
    <button type="submit" class="btn btn-outline-danger m-1" style="font-size: 1.3rem; background-color: greenyellow; border-color: greenyellow; color: white;">Enviar</button>
</form>
<script>
    // Función para ocultar un checkbox y su texto
    function ocultarCheckboxYTexto(id) {
        const checkbox = document.getElementById(id);
        if (checkbox) {
            checkbox.parentElement.style.display = 'none'; // Ocultar el checkbox y su texto
        }
    }

    // Función para mostrar un checkbox y su texto
    function mostrarCheckboxYTexto(id) {
        const checkbox = document.getElementById(id);
        if (checkbox) {
            checkbox.parentElement.style.display = 'inline'; // O 'block' dependiendo del diseño
        }
    }

    // Manejar el checkbox para mostrar/ocultar campos de fecha
    document.getElementById('toggle-fechas').addEventListener('change', function() {
        const fechaContainer = document.getElementById('fecha-container');
        const fechaInicio = document.getElementById('fecha-inicio');
        const fechaFin = document.getElementById('fecha-fin');
        const checkFecha = document.getElementById('check-fecha');

        if (this.checked) {
            fechaContainer.style.display = 'block';
            fechaInicio.disabled = false;
            fechaFin.disabled = false;
            // Desmarcar y ocultar el otro checkbox y su texto
            checkFecha.checked = false;
            ocultarCheckboxYTexto('check-fecha');
            document.getElementById('fecha').style.display = 'none';
        } else {
            fechaContainer.style.display = 'none';
            fechaInicio.value = '';
            fechaFin.value = '';
            fechaInicio.disabled = true;
            fechaFin.disabled = true;
            mostrarCheckboxYTexto('check-fecha'); // Mostrar el checkbox y su texto cuando se deselecciona
        }
    });

    // Manejar el cambio en el select tipo-asignacion para habilitar/inhabilitar campos de fecha
    document.getElementById('tipo-asignacion').addEventListener('change', function() {
        const fechaInicio = document.getElementById('fecha-inicio');
        const fechaFin = document.getElementById('fecha-fin');
        const selectedValue = this.value;
        
        if (document.getElementById('toggle-fechas').checked) {
            if (selectedValue === 'materiales' || selectedValue === 'herramientas') {
                fechaInicio.disabled = false;
                fechaFin.disabled = false;
            } else {
                fechaInicio.disabled = true;
                fechaFin.disabled = true;
            }
        }
    });

    // Manejar el checkbox para mostrar/ocultar el campo de fecha
    document.getElementById('check-fecha').addEventListener('change', function() {
        const fechaContainer = document.getElementById('fecha');
        const fechaInput = document.getElementById('fecha-input');
        const toggleFechas = document.getElementById('toggle-fechas');

        if (this.checked) {
            fechaContainer.style.display = 'block';
            fechaInput.disabled = false;
            // Desmarcar y ocultar el otro checkbox y su texto
            toggleFechas.checked = false;
            ocultarCheckboxYTexto('toggle-fechas');
            document.getElementById('fecha-container').style.display = 'none';
        } else {
            fechaContainer.style.display = 'none';
            fechaInput.value = '';
            fechaInput.disabled = true;
            mostrarCheckboxYTexto('toggle-fechas'); // Mostrar el checkbox y su texto cuando se deselecciona
        }
    });
</script>





                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>
