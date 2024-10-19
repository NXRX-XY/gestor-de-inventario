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
<?php
    $servername = "localhost";
    $username = "usuario";
    $password = "contraseña";
    $dbname = "base_de_datos";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener datos de la base de datos
    $sql = "SELECT codigo, material FROM lista_asignaciones";
    $result = $conn->query($sql);

    $opciones = "";
    $codigosDescripcion = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $codigosDescripcion[$row["codigo"]] = $row["material"];
            $opciones .= "<option value='" . $row["material"] . "' data-codigo='" . $row["codigo"] . "'>" . $row["material"] . "</option>";
        }
    } else {
        echo "0 resultados";
    }
    $conn->close();
    ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Actas de trabajo</title>
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
  cantidadCell.innerHTML = '<input type="text" style="width: 70px;" name="cantidad[]" required>';

  var unidadCell = newRow.insertCell(2);
  unidadCell.innerHTML = '<select name="unidad[]"><option value="unidad">Unidad</option><option value="metros">Metros</option></select>';

  var codigoCell = newRow.insertCell(3);
  codigoCell.innerHTML = '<div class="autocomplete"><input type="text" name="codigo[]" style="width: 90px;" oninput="fillDescription(this)" onkeyup="fillAutocomplete(this, \'descripcion[]\')" required><div class="autocomplete-list" id="codigoAutocomplete"></div></div>';

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
<script>
        var codigosDescripcion = <?php echo json_encode($codigosDescripcion); ?>;

        function fillDescription(input) {
            var codigo = input.value.toLowerCase();
            var parent = input.closest('tr');
            var descripcionInput = parent.querySelector('select[name="descripcion[]"]');

            if (codigosDescripcion.hasOwnProperty(codigo)) {
                descripcionInput.value = codigosDescripcion[codigo];
            } else {
                descripcionInput.value = '';
            }
        }

        function fillCodigo(select) {
            var descripcion = select.value.toLowerCase();
            var parent = select.closest('tr');
            var codigoInput = parent.querySelector('input[name="codigo[]"]');

            for (var codigo in codigosDescripcion) {
                if (codigosDescripcion[codigo].toLowerCase() === descripcion) {
                    codigoInput.value = codigo;
                    return;
                }
            }
            codigoInput.value = '';
        }

        // Agrega el evento 'input' para actualizar la descripción mientras se escribe el código
        document.addEventListener('input', function(event) {
            var target = event.target;
            if (target.nodeName === 'INPUT' && target.getAttribute('name') === 'codigo[]') {
                fillDescription(target);
            }
        });

        // Agrega el evento 'change' para actualizar el código cuando se selecciona una descripción
        document.addEventListener('change', function(event) {
            var target = event.target;
            if (target.nodeName === 'SELECT' && target.getAttribute('name') === 'descripcion[]') {
                fillCodigo(target);
            }
        });

        // Generar las opciones del select basado en el objeto codigosDescripcion
        document.addEventListener('DOMContentLoaded', function() {
            var selectsDescripcion = document.querySelectorAll('select[name="descripcion[]"]');
            var opciones = `<?php echo $opciones; ?>`;

            selectsDescripcion.forEach(function(selectDescripcion) {
                selectDescripcion.innerHTML += opciones;
            });
        });
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
              
            <form method="post" action="../php-admin/pendientes.php" class="card" style="width: 90%; height: auto; position: relative; display: flex; flex-direction: column; align-items: center; left: 4%; border: 4px solid skyblue; border-radius: 5px;" enctype="multipart/form-data">        
 
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
        <h2 style="font-size: 1.3rem; margin-bottom: 1rem;">Número de acta</h2>
        <input id="numero-de-guia" type="number" name="numero_de_guia" pattern="[0-9]*" style="width: 100%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);" required>
        <br><br> 
        <h2 style="font-size: 1.3rem; margin-bottom: 1rem;">Cuadrilla</h2>
        <input id="cuadrilla" type="text" name="cuadrilla" style="width: 100%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);" required>
        <br><br>
        <h2 style="font-size: 1.3rem; margin-bottom: 1rem; margin-top: 10px;">Técnico</h2>
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
            echo '<select style="width: 100%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);" name="tecnicos">';
            while ($row = mysqli_fetch_assoc($result)) {
                $nombres = $row['nombres'];
                $apellidos= $row['apellidos'];
                echo '<option value="' . $nombres . '-' . $apellidos . '">' . $nombres . " " . $apellidos . '</option>';
            }
            echo '</select>';
        } else {
            echo "No se encontraron opciones.";
        }

        // Cerrar la conexión a la base de datos
        mysqli_close($conn);

?>
              
                  <div style="height: 100%; min-height: 100%;">
                    <div style="max-height: 200px; overflow-y: auto; margin-top: 1rem; border: 1px solid #ccc;">
                      <table id="miTabla" class="miTabla">
                        <thead>
                          <tr>
                            <th>Item</th>
                            <th>Cantidad</th>
                            <th>Unidad</th>
                            <th>Código</th>
                            <th>Descripción</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="item-cell"><input type="text" style="width: 30px;" name="item[]" value="1" readonly></td>
                            <td><input type="text" style="width: 70px;" name="cantidad[]" required></td>
                            <td><select name="unidad[]"><option value="unidad">Unidad</option><option value="metros">Metros</option></select></td>
                            <td><input type="text" name="codigo[]" style="width: 90px;" oninput="fillDescription(this)" required></td>
                            <td>
  <div class="autocomplete">
  <select style="width: 100px;" name="descripcion[]" oninput="fillCodigo(this)" onkeyup="fillAutocomplete(this, 'codigo[]')">
    <option value="">Seleccione</option>
  </select>
  <div class="autocomplete-list" id="descripcionAutocomplete"></div>
</div>

  </td>
                          </tr>
                        </tbody>
                      </table>
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
                    </div>
                  </div>
                  
                  <button type="button" onclick="agregarFila()" style="margin-top: 1rem;">Agregar fila</button>
                  <script>
                    document.getElementById("numero-de-guia").addEventListener("input", function(){
                      this.value = this.value.replace(/[^0-9]/g,'');
                    });
                  </script>
                  <h2 style="font-size: 1.3rem; margin: 1rem 0;">Fecha</h2>
                  <input id="fecha" type="date" name="fecha" style="width: 100%; height: 40px; border-radius: 20px; overflow: hidden; font-size: 1.5rem; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);" required>
                  <h2 style="margin-top: 5px;""></h2>
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
