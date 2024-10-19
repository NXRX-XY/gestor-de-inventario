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
  <title>Consultar devoluciones</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/LOGO.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <!DOCTYPE html>
  <script>
function agregarFila() {
  // Obtener la referencia de la tabla
  var tabla = document.getElementById("miTabla");
  // Obtener el número de filas en la tabla y sumarle uno para obtener el valor inicial de item
  var item = tabla.tBodies[0].rows.length + 1;
  // Insertar una nueva fila en la tabla
  var nuevaFila = tabla.insertRow(-1);
  // Insertar celdas en la nueva fila
  var nuevaCelda1 = nuevaFila.insertCell(0);
  var nuevaCelda2 = nuevaFila.insertCell(1);
  var nuevaCelda3 = nuevaFila.insertCell(2);
  var nuevaCelda4 = nuevaFila.insertCell(3);
  var nuevaCelda5 = nuevaFila.insertCell(4);
  // Añadir contenido a las celdas
  nuevaCelda1.innerHTML = '<input type="text" name="item[]" style="width:30px;" value="' + item + '" readonly>';
  nuevaCelda1.classList.add("item-cell");
  nuevaCelda2.innerHTML = '<input type="text" name="cantidad[]" style="width: 70px;">';
  nuevaCelda3.innerHTML = '<select name="unidad[]" style="width: 70px;"><option value="unidad">Unidad</option><option value="metros">Metros</option></select>';
  nuevaCelda4.innerHTML = '<input type="text" name="codigo[]" style="width: 90px;" oninput="fillDescription(this)">'; 
  nuevaCelda5.innerHTML = '<input type="text" name="descripcion[]" style="width: 100px;" oninput="fillCodigo(this)">';
}
</script>
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
              <a href="../php-admin/cerrar.php"  class="btn btn-primary">Cerrar Sesión</a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <div class="container-fluid">
                  <div class="card">
            <div class="card-body">
              
    <style>
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .asig {
            font-weight: bold;
            font-size: 1.3rem;
            margin-right: 10px;
        }
    </style>
   
                
                      <style>
                        table {
  width: 100%;
  border: 1px solid #ddd;
  border-collapse: collapse;
}

thead tr {
  background-color: #f2f2f2;
}

th {
  width: 10%;
  border: 1px solid #ddd;
  padding: 8px;
}

td {
  border: 1px solid #ddd;
  padding: 4px;
}

.item-cell {
  width: 10%;
}

                      </style>                    
                   
              <h5 class="card-title fw-semibold mb-4" style="text-align:center; margin: 0 auto;">Consultar devoluciones</h5>
              <form method="post" action="../php-admin/consultar-devoluciones.php" target="_blank" class="card mb-0" style="width: 90%; height: 25%;position: relative; display: flex; flex-direction: column; align-items: center; left: 4%; border: 4px solid skyblue; border-radius: 5px;">
                  <section class="card-body p-4" style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                      <h2 style="font-size: 1.3rem; margin: 1rem 0;">Ingrese su búsqueda:</h2>
                      <input id="descripción" name="busqueda" type="text" style="width: 90%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);" required>
                      <h2 style="font-size: 1.3rem; margin: 1rem 0;">Filtrar por:</h2>
                      <select name="opcion" id="opcion" style="width: 90%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);">
                          <option value="nombres">Nombres</option>
                          <option value="apellidos">Apellidos</option>
                          <option value="fecha">Fecha</option>
                          <option value="descripcion">Material</option>
                          <option value="numero_de_guia">N° de guía</option>
                      </select>
                      <select name="tablaa" id="tipo-asignacion" style="margin-top: 40px;width: 90%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);">
                        <option value="materiales">Asignacion de materiales</option>
                        <option value="herramientas">Asignacion de herramientas</option>
                        <option value="uniforme">Asignacion de uniformes</option>
                        <option value="todo">Todo</option>
                    </select>
                  </section>
                  <button type="submit" class="btn btn-outline-danger m-1" style="font-size: 1.3rem; background-color: greenyellow; border-color: greenyellow; color: white;">Enviar</button>
              </form>
              
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
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../js-admin/incidencias.js"></script>
</body>

</html>
