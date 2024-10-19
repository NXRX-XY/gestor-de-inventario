
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Stock</title>
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
            <a href="../php-admin/cerrar.php"  class="btn btn-primary">Cerrar Sesión</a>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              
              <div class="col-6">
              <style>
  .table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
}

.table th,
.table td {
    padding: 0.75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}

.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
    border-top: 2px solid #dee2e6;
}

.table .table {
    background-color: #fff;
}

.table-bordered {
    border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
    border: 1px solid #dee2e6;
}

.table-bordered thead th,
.table-bordered thead td {
    border-bottom-width: 2px;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, 0.05);
}

@media screen and (max-width: 575.98px) {
    .table-responsive {
        display: block;
        width: 200%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: -ms-autohiding-scrollbar;
    }
    .table-responsive > .table {
        margin-bottom: 0;
    }
    .table-responsive > .table > thead > tr > th,
    .table-responsive > .table > tbody > tr > th,
    .table-responsive > .table > tfoot > tr > th,
    .table-responsive > .table > thead > tr > td,
    .table-responsive > .table > tbody > tr > td,
    .table-responsive > .table > tfoot > tr > td {
        white-space: nowrap;
    }
}

</style>
<div class="table-responsive">
        <table class="table">
        <form id="searchForm" style="margin-bottom: 15px;">
          <input type="text" id="searchInput" placeholder="Buscar por nombre de material" style="padding: 5px;">
          <button type="submit" style="padding: 5px;">Buscar</button>
       </form>
       <div class="messages" style="margin-left: 50px;">
    <button onclick="descargarExcel()">Descargar Excel</button>
      </div>
       <?php
$servername = "localhost";
$username = "root";
$password = "Win123456789jd*";
$dbname = "jdmallau_almacen";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la lista de materiales
$sql = "SELECT id, codigo, material FROM lista_asignaciones";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Inventario de Materiales</h1>";
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped'>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Cantidad Disponible</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
    $material_id = $row['id'];
    $codigo = $row['codigo'];
    $descripcion = $row['material'];

    // Calcular el total de ingresos para este material
    $stmt_ingresos = $conn->prepare("SELECT SUM(cantidad) AS total_ingresos FROM tabla WHERE descripcion = ? AND fecha >= '2024-03-09'");
    $stmt_ingresos->bind_param("s", $descripcion);
    $stmt_ingresos->execute();
    $result_ingresos = $stmt_ingresos->get_result();
    $total_ingresos = $result_ingresos->fetch_assoc()['total_ingresos'];

    // Calcular el total de salidas para este material en diferentes tablas
    $stmt_salidas_m = $conn->prepare("SELECT SUM(cantidad) AS total_salidas_m FROM materiales WHERE descripcion = ? AND fecha >= '2024-03-09'");
    $stmt_salidas_m->bind_param("s", $descripcion);
    $stmt_salidas_m->execute();
    $result_salidas_m = $stmt_salidas_m->get_result();
    $total_salidas_m = $result_salidas_m->fetch_assoc()['total_salidas_m'];

    $stmt_salidas_h = $conn->prepare("SELECT SUM(cantidad) AS total_salidas_h FROM herramientas WHERE descripcion = ? AND fecha >= '2024-03-09'");
    $stmt_salidas_h->bind_param("s", $descripcion);
    $stmt_salidas_h->execute();
    $result_salidas_h = $stmt_salidas_h->get_result();
    $total_salidas_h = $result_salidas_h->fetch_assoc()['total_salidas_h'];

    $stmt_salidas_u = $conn->prepare("SELECT SUM(cantidad) AS total_salidas_u FROM uniforme WHERE descripcion = ? AND fecha >= '2024-03-09'");
    $stmt_salidas_u->bind_param("s", $descripcion);
    $stmt_salidas_u->execute();
    $result_salidas_u = $stmt_salidas_u->get_result();
    $total_salidas_u = $result_salidas_u->fetch_assoc()['total_salidas_u'];

    // Calcular la cantidad disponible
    $cantidad_disponible = $total_ingresos - $total_salidas_m - $total_salidas_h - $total_salidas_u;

        echo "<tr>
                <td>$codigo</td>
                <td>$descripcion</td>
                <td>$cantidad_disponible</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No hay materiales registrados.";
}

$conn->close();
?>

<!-- Script de JavaScript para filtrar los resultados -->
<script>
document.getElementById('searchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var searchTerm = document.getElementById('searchInput').value.toLowerCase();
    var tableRows = document.querySelectorAll('.table tr');

    tableRows.forEach(function(row, index) {
        if (index === 0) return; // Saltar la fila de encabezado
        var descripcion = row.cells[1].innerText.toLowerCase(); // Cambiar el índice a 1 para la columna de descripción
        if (descripcion.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
<script>
function descargarExcel() {
    // Construir la URL con los parámetros necesarios
    var codigo = encodeURIComponent('<?php echo $codigo; ?>');
    var descripcion = encodeURIComponent('<?php echo $descripcion; ?>');
    var cantidad = encodeURIComponent('<?php echo $cantidad_disponible; ?>');

    // Construir la URL con todos los parámetros necesarios
    var url = '../export/stock.php?' +
              'codigo=' + codigo + '&' +
              'descripcion=' + descripcion + '&' +
              'cantidad=' + cantidad;

    // Redirigir al usuario para descargar el archivo
    window.location.href = url;
}
</script>
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
