<?php
    include("../php-admin/conexion.php");

    session_start();

if (!isset($_SESSION['correo'])) {
    // Redirecciona al formulario de inicio de sesión o muestra un mensaje de error.
    header("Location: ../html-admin/login-admin.html"); // Redirecciona al formulario de inicio de sesión
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
  <title>Entrega ont</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/LOGO.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <style>
   @media (max-width: 767px) {
  /* Pantallas móviles */
  form.card {
    display: flex;
    flex-direction: column;
  }

  /* Cambiar el ancho de los campos */
  input[type="number"],
  input[type="text"],
  input[type="date"] {
    width: 100%;
    margin-bottom: 10px; /* Cambia este valor para ajustar el margen inferior */
  }
}
</style>
<script>
function agregarFila() {
  var table = document.getElementById('miTabla'); // Reemplaza 'miTabla' con el ID de tu tabla
  var rowCount = table.rows.length;
  var newRow = table.insertRow(rowCount);

  var itemCell = newRow.insertCell(0);
  itemCell.className = 'item-cell';
  itemCell.innerHTML = '<input type="text" style="width: 30px;" name="item[]" value="' + (rowCount - 1  + 1) + '" readonly>';

  var cantidadCell = newRow.insertCell(1);
  cantidadCell.innerHTML = '<input type="text" style="width: 70px;" name="cantidad[]">';

  var unidadCell = newRow.insertCell(2);
  unidadCell.innerHTML = '<select name="unidad[]"><option value="unidad">Unidad</option><option value="metros">Metros</option></select>';

  var codigoCell = newRow.insertCell(3);
  codigoCell.innerHTML = '<div class="autocomplete"><input type="text" name="codigo[]" style="width: 90px;" oninput="fillDescription(this)" onkeyup="fillAutocomplete(this, \'descripcion[]\')"><div class="autocomplete-list" id="codigoAutocomplete"></div></div>';

  var descripcionCell = newRow.insertCell(4);
  descripcionCell.innerHTML = '<div class="autocomplete"><select style="width: 100px;" name="descripcion[]" oninput="fillCodigo(this)" onkeyup="fillAutocomplete(this, \'codigo[]\')"><option value="">Seleccione</option><!-- Agrega las opciones restantes aquí --></select><div class="autocomplete-list" id="descripcionAutocomplete"></div></div>';

  // Agregar eventos y funciones para el autocompletado en los nuevos elementos de la fila
  var newCodigoInput = codigoCell.querySelector('input[name="codigo[]"]');
  var newDescripcionSelect = descripcionCell.querySelector('select[name="descripcion[]"]');

  newCodigoInput.addEventListener('input', function(event) {
    fillAutocomplete(this, 'descripcion[]');
  });

  newDescripcionSelect.addEventListener('input', function(event) {
    fillAutocomplete(this, 'codigo[]');
  });

  // Obtener el objeto select del formulario original
  var selectDescripcion = document.querySelector('select[name="descripcion[]"]');

  // Clonar las opciones del select original y agregarlas al nuevo select
  for (var i = 1; i < selectDescripcion.options.length; i++) {
    var option = selectDescripcion.options[i].cloneNode(true);
    newDescripcionSelect.appendChild(option);
  }
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
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
            <h5 class="card-title fw-semibold mb-4" style="text-align:center; margin: 0 auto;">Entrega de ONT</h5>
            <form method="post" action="../php-admin/entrega_ont.php" class="card" style="width: 90%; height: auto; position: relative; display: flex; flex-direction: column; align-items: center; left: 4%; border: 4px solid skyblue; border-radius: 5px;" enctype="multipart/form-data">       
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
    <section class="card-body p-4" style="width: 80%; max-width: 500px;">
    <h2 style="font-size: 1.3rem; margin-bottom: 1rem;">CTN ID</h2>
<input id="ctn-id" name="ctn_id" style="width: 100%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);" required>
<br><br>
<h2 style="font-size: 1.3rem; margin-bottom: 1rem;">PROD ID</h2>
<input id="prod-id" name="prod_id" style="width: 100%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);" required>
<br><br>
<h2 style="font-size: 1.3rem; margin-bottom: 1rem;">MAC</h2>
<input id="mac" name="mac" style="width: 100%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);" required>
<br><br>
<h2 style="font-size: 1.3rem; margin-bottom: 1rem;">Número serial (S/N)</h2>
<input id="numero-serial"  name="numero_serial" style="width: 100%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);" required>
<br><br>
<h2 style="font-size: 1.3rem; margin-bottom: 1rem; margin-top: 10px;">Cuadrilla</h2>
<input id="cuadrilla" name="cuadrilla" style="width: 100%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);" required>
<br><br>
<h2 style="font-size: 1.3rem; margin-bottom: 1rem; margin-top: 10px;">Técnico 1</h2>

<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "usuario";
$password = "contraseña";
$dbname = "base_de_datos";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Error en la conexión: " . mysqli_connect_error());
}
mysqli_set_charset($conn, 'utf8');
// Consulta para obtener valores únicos de una columna específica
$sql = "SELECT nombres, apellidos FROM usuarios";
$result = mysqli_query($conn, $sql);

// Verificar si se obtuvieron resultados
if (mysqli_num_rows($result) > 0) {
    // Generar las opciones dinámicamente
    echo '<select style="width: 100%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);" name="tecnico1">';
    while ($row = mysqli_fetch_assoc($result)) {
        $nombres = $row['nombres'];
        $apellidos= $row['apellidos'];
        echo '<option value="' . $nombres . ' ' . $apellidos . '">' . $nombres . " " . $apellidos . '</option>';
    }
    echo '</select>';
    
// Separador y título para el segundo select
echo '<br><br>';
echo '<h2 style="font-size: 1.3rem; margin-bottom: 1rem; margin-top: 10px;">Técnico 2</h2>';

// Reiniciar el puntero del resultado para recorrerlo nuevamente
mysqli_data_seek($result, 0);

// Segundo select
echo '<select style="width: 100%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);" name="tecnico2">';
// Opción predeterminada
echo '<option value="No hay t2">Sin técnico 2</option>';
while ($row = mysqli_fetch_assoc($result)) {
    $nombres = $row['nombres'];
    $apellidos= $row['apellidos'];
    echo '<option value="' . $nombres . ' ' . $apellidos . '">' . $nombres . " " . $apellidos . '</option>';
}
echo '</select>';
} else {
    echo "No se encontraron opciones.";
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>

              
                  <div style="height: 100%; min-height: 100%;">
                   
                  <h2 style="font-size: 1.3rem; margin: 1rem 0;">Fecha</h2>
                  <input id="fecha" type="date" name="fecha" style="width: 100%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);" required>
              <button type="submit" class="btn btn-danger m-1" style="position: relative; left: 50%; transform: translateX(-50%); bottom: -20px; font-size: 1.3rem; background-color: greenyellow; border-color: greenyellow;">Enviar</button>
                </section>
              </form>
              
              
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
