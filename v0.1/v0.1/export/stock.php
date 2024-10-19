<?php
require 'vendor/autoload.php';  // Asegúrate de que la ruta a autoload.php es correcta

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle;

function exportToExcel() {
    $host = 'localhost';
    $db = 'base_de_datos';  // Nombre correcto de la base de datos
    $user = 'usuario';
    $password = 'contraseña';

    try {
        $conn = new mysqli($host, $user, $password, $db);
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Crear un nuevo objeto Spreadsheet
        $spreadsheet = new Spreadsheet();

        // Hoja 1: Datos de Materiales
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Stock');

        // Escribir los encabezados para la primera hoja
        $sheet1->setCellValue('A1', 'Codigo');
        $sheet1->setCellValue('B1', 'Material');
        $sheet1->setCellValue('C1', 'Cantidad Disponible');

        // Cambiar a color celeste las celdas de encabezado
        $celeste = 'FF00FFFF';
        foreach (['A1', 'B1', 'C1'] as $cell) {
            $sheet1->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID);
            $sheet1->getStyle($cell)->getFill()->getStartColor()->setARGB($celeste);
        }

        $row = 2; // Iniciar en la fila 2 ya que la 1 es para los encabezados

        // Obtener la lista de materiales
        $sql = "SELECT id, codigo, material FROM lista_asignaciones";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($data = $result->fetch_assoc()) {
            $descripcion = $data['material'];

            // Calcular el total de ingresos para este material
            $stmt_ingresos = $conn->prepare("SELECT SUM(cantidad) AS total_ingresos FROM tabla WHERE descripcion = ? AND fecha >= '2024-03-09'");
            $stmt_ingresos->bind_param("s", $descripcion);
            $stmt_ingresos->execute();
            $result_ingresos = $stmt_ingresos->get_result();
            $total_ingresos = $result_ingresos->fetch_assoc()['total_ingresos'] ?? 0;

            // Calcular el total de salidas para este material en diferentes tablas
            $stmt_salidas_m = $conn->prepare("SELECT SUM(cantidad) AS total_salidas_m FROM materiales WHERE descripcion = ? AND fecha >= '2024-03-09'");
            $stmt_salidas_m->bind_param("s", $descripcion);
            $stmt_salidas_m->execute();
            $result_salidas_m = $stmt_salidas_m->get_result();
            $total_salidas_m = $result_salidas_m->fetch_assoc()['total_salidas_m'] ?? 0;

            $stmt_salidas_h = $conn->prepare("SELECT SUM(cantidad) AS total_salidas_h FROM herramientas WHERE descripcion = ? AND fecha >= '2024-03-09'");
            $stmt_salidas_h->bind_param("s", $descripcion);
            $stmt_salidas_h->execute();
            $result_salidas_h = $stmt_salidas_h->get_result();
            $total_salidas_h = $result_salidas_h->fetch_assoc()['total_salidas_h'] ?? 0;

            $stmt_salidas_u = $conn->prepare("SELECT SUM(cantidad) AS total_salidas_u FROM uniforme WHERE descripcion = ? AND fecha >= '2024-03-09'");
            $stmt_salidas_u->bind_param("s", $descripcion);
            $stmt_salidas_u->execute();
            $result_salidas_u = $stmt_salidas_u->get_result();
            $total_salidas_u = $result_salidas_u->fetch_assoc()['total_salidas_u'] ?? 0;

            // Calcular la cantidad disponible
            $cantidad_disponible = $total_ingresos - $total_salidas_m - $total_salidas_h - $total_salidas_u;

            // Escribir los datos en la hoja de cálculo
            $sheet1->setCellValue('A' . $row, $data["codigo"]);
            $sheet1->setCellValue('B' . $row, $data["material"]);
            $sheet1->setCellValue('C' . $row, $cantidad_disponible);

            $row++;
        }

        // Ajustar el ancho de las columnas para la primera hoja
        foreach (range('A', 'C') as $columnID) {
            $sheet1->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Aplicar estilo a las celdas en la primera hoja
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet1->getStyle('A1:C' . ($row - 1))->applyFromArray($styleArray);

        // Hoja 2: Datos de Tabla
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Aprovisiones');

        // Escribir los encabezados para la segunda hoja
        $sheet2->setCellValue('A1', 'Número de guía');
        $sheet2->setCellValue('B1', 'Provedor');
        $sheet2->setCellValue('C1', 'Codigo');
        $sheet2->setCellValue('D1', 'Material');
        $sheet2->setCellValue('E1', 'Cantidad');
        $sheet2->setCellValue('F1', 'Unidad');
        $sheet2->setCellValue('G1', 'Fecha');

        // Cambiar a color celeste las celdas de encabezado
        foreach (['A1', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1'] as $cell) {
            $sheet2->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID);
            $sheet2->getStyle($cell)->getFill()->getStartColor()->setARGB($celeste);
        }

        $dataRow = 2; // Comenzar a escribir datos de la segunda sección en la fila 2

        // Obtener todos los registros de la tabla "tabla"
        $stmt_tabla = $conn->prepare("SELECT * FROM tabla WHERE fecha >= '2024-03-09'");
        $stmt_tabla->execute();
        $result_tabla = $stmt_tabla->get_result();

        while ($data = $result_tabla->fetch_assoc()) {
            $sheet2->setCellValue('A' . $dataRow, $data["numero_de_guia"]);
            $sheet2->setCellValue('B' . $dataRow, $data["provedor"]);
            $sheet2->setCellValue('C' . $dataRow, $data["codigo"]);
            $sheet2->setCellValue('D' . $dataRow, $data["descripcion"]);
            $sheet2->setCellValue('E' . $dataRow, $data["cantidad"]);
            $sheet2->setCellValue('F' . $dataRow, $data["unidad"]);
            $sheet2->setCellValue('G' . $dataRow, $data["fecha"]);

            $dataRow++;
        }

        // Ajustar el ancho de las columnas para la segunda hoja
        foreach (range('A', 'G') as $columnID) {
            $sheet2->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Aplicar estilo a las celdas en la segunda hoja
        $sheet2->getStyle('A1:G' . ($dataRow - 1))->applyFromArray($styleArray);

         // Hoja 3: Datos de Tabla
        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('Asignaciones de materiales');

        // Escribir los encabezados para la tercera hoja
        $sheet3->setCellValue('A1', 'Número de guía');
        $sheet3->setCellValue('B1', 'Nombres');
        $sheet3->setCellValue('C1', 'Apellidos');
        $sheet3->setCellValue('D1', 'Cuadrilla');
        $sheet3->setCellValue('E1', 'Codigo');
        $sheet3->setCellValue('F1', 'Material');
        $sheet3->setCellValue('G1', 'Cantidad');
        $sheet3->setCellValue('H1', 'Unidad');
        $sheet3->setCellValue('I1', 'Fecha');

        // Cambiar a color celeste las celdas de encabezado
        foreach (['A1', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1', 'H1', 'I1'] as $cell) {
            $sheet3->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID);
            $sheet3->getStyle($cell)->getFill()->getStartColor()->setARGB($celeste);
        }

        $dataRow = 2; // Comenzar a escribir datos de la segunda sección en la fila 2

        // Obtener todos los registros de la tabla "tabla"
        $stmt_tabla = $conn->prepare("SELECT * FROM materiales WHERE fecha >= '2024-03-09'");
        $stmt_tabla->execute();
        $result_tabla = $stmt_tabla->get_result();

        while ($data = $result_tabla->fetch_assoc()) {
            $sheet3->setCellValue('A' . $dataRow, $data["numero_de_guia"]);
            $sheet3->setCellValue('B' . $dataRow, $data["nombres"]);
            $sheet3->setCellValue('C' . $dataRow, $data["apellidos"]);
            $sheet3->setCellValue('D' . $dataRow, $data["cuadrilla"]);
            $sheet3->setCellValue('E' . $dataRow, $data["codigo"]);
            $sheet3->setCellValue('F' . $dataRow, $data["descripcion"]);
            $sheet3->setCellValue('G' . $dataRow, $data["cantidad"]);
            $sheet3->setCellValue('H' . $dataRow, $data["unidad"]);
            $sheet3->setCellValue('I' . $dataRow, $data["fecha"]);

            $dataRow++;
        }

        // Ajustar el ancho de las columnas para la tercera hoja
        foreach (range('A', 'I') as $columnID) {
            $sheet3->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Aplicar estilo a las celdas en la tercera hoja
        $sheet3->getStyle('A1:I' . ($dataRow - 1))->applyFromArray($styleArray);

        // Hoja 4: Datos de Tabla
        $sheet4 = $spreadsheet->createSheet();
        $sheet4->setTitle('Asignaciones de herramientas');

        // Escribir los encabezados para la tercera hoja
        $sheet4->setCellValue('A1', 'Número de guía');
        $sheet4->setCellValue('B1', 'Nombres');
        $sheet4->setCellValue('C1', 'Apellidos');
        $sheet4->setCellValue('D1', 'Cuadrilla');
        $sheet4->setCellValue('E1', 'Codigo');
        $sheet4->setCellValue('F1', 'Material');
        $sheet4->setCellValue('G1', 'Cantidad');
        $sheet4->setCellValue('H1', 'Unidad');
        $sheet4->setCellValue('I1', 'Fecha');

        // Cambiar a color celeste las celdas de encabezado
        foreach (['A1', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1', 'H1', 'I1'] as $cell) {
            $sheet4->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID);
            $sheet4->getStyle($cell)->getFill()->getStartColor()->setARGB($celeste);
        }

        $dataRow = 2; // Comenzar a escribir datos de la segunda sección en la fila 2

        // Obtener todos los registros de la tabla "tabla"
        $stmt_tabla = $conn->prepare("SELECT * FROM herramientas WHERE fecha >= '2024-03-09'");
        $stmt_tabla->execute();
        $result_tabla = $stmt_tabla->get_result();

        while ($data = $result_tabla->fetch_assoc()) {
            $sheet4->setCellValue('A' . $dataRow, $data["numero_de_guia"]);
            $sheet4->setCellValue('B' . $dataRow, $data["nombres"]);
            $sheet4->setCellValue('C' . $dataRow, $data["apellidos"]);
            $sheet4->setCellValue('D' . $dataRow, $data["cuadrilla"]);
            $sheet4->setCellValue('E' . $dataRow, $data["codigo"]);
            $sheet4->setCellValue('F' . $dataRow, $data["descripcion"]);
            $sheet4->setCellValue('G' . $dataRow, $data["cantidad"]);
            $sheet4->setCellValue('H' . $dataRow, $data["unidad"]);
            $sheet4->setCellValue('I' . $dataRow, $data["fecha"]);

            $dataRow++;
        }

        // Ajustar el ancho de las columnas para la cuarta hoja
        foreach (range('A', 'I') as $columnID) {
            $sheet4->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Aplicar estilo a las celdas en la cuarta hoja
        $sheet4->getStyle('A1:I' . ($dataRow - 1))->applyFromArray($styleArray);

        // Hoja 5: Datos de Tabla
        $sheet5 = $spreadsheet->createSheet();
        $sheet5->setTitle('Asignaciones de uniformes');

        // Escribir los encabezados para la quinta hoja
        $sheet5->setCellValue('A1', 'Número de guía');
        $sheet5->setCellValue('B1', 'Nombres');
        $sheet5->setCellValue('C1', 'Apellidos');
        $sheet5->setCellValue('D1', 'Cuadrilla');
        $sheet5->setCellValue('E1', 'Codigo');
        $sheet5->setCellValue('F1', 'Material');
        $sheet5->setCellValue('G1', 'Cantidad');
        $sheet5->setCellValue('H1', 'Unidad');
        $sheet5->setCellValue('I1', 'Fecha');

        // Cambiar a color celeste las celdas de encabezado
        foreach (['A1', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1', 'H1', 'I1'] as $cell) {
            $sheet5->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID);
            $sheet5->getStyle($cell)->getFill()->getStartColor()->setARGB($celeste);
        }

        $dataRow = 2; // Comenzar a escribir datos de la segunda sección en la fila 2

        // Obtener todos los registros de la tabla "tabla"
        $stmt_tabla = $conn->prepare("SELECT * FROM uniforme WHERE fecha >= '2024-03-09'");
        $stmt_tabla->execute();
        $result_tabla = $stmt_tabla->get_result();

        while ($data = $result_tabla->fetch_assoc()) {
            $sheet5->setCellValue('A' . $dataRow, $data["numero_de_guia"]);
            $sheet5->setCellValue('B' . $dataRow, $data["nombres"]);
            $sheet5->setCellValue('C' . $dataRow, $data["apellidos"]);
            $sheet5->setCellValue('D' . $dataRow, $data["cuadrilla"]);
            $sheet5->setCellValue('E' . $dataRow, $data["codigo"]);
            $sheet5->setCellValue('F' . $dataRow, $data["descripcion"]);
            $sheet5->setCellValue('G' . $dataRow, $data["cantidad"]);
            $sheet5->setCellValue('H' . $dataRow, $data["unidad"]);
            $sheet5->setCellValue('I' . $dataRow, $data["fecha"]);

            $dataRow++;
        }

        // Ajustar el ancho de las columnas para la quinta hoja
        foreach (range('A', 'I') as $columnID) {
            $sheet5->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Aplicar estilo a las celdas en la quinta hoja
        $sheet5->getStyle('A1:I' . ($dataRow - 1))->applyFromArray($styleArray);

        // Hoja 6: Datos de Tabla
        $sheet6 = $spreadsheet->createSheet();
        $sheet6->setTitle('Asignaciones (todo)');

        // Escribir los encabezados para la quinta hoja
        $sheet6->setCellValue('A1', 'Número de guía');
        $sheet6->setCellValue('B1', 'Nombres');
        $sheet6->setCellValue('C1', 'Apellidos');
        $sheet6->setCellValue('D1', 'Cuadrilla');
        $sheet6->setCellValue('E1', 'Codigo');
        $sheet6->setCellValue('F1', 'Material');
        $sheet6->setCellValue('G1', 'Cantidad');
        $sheet6->setCellValue('H1', 'Unidad');
        $sheet6->setCellValue('I1', 'Fecha');

        // Cambiar a color celeste las celdas de encabezado
        foreach (['A1', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1', 'H1', 'I1'] as $cell) {
            $sheet6->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID);
            $sheet6->getStyle($cell)->getFill()->getStartColor()->setARGB($celeste);
        }

        $dataRow = 2; // Comenzar a escribir datos de la segunda sección en la fila 2

        // Consultar la tabla 'uniforme'
        $stmt_uniforme = $conn->prepare("SELECT * FROM uniforme WHERE fecha >= '2024-03-09'");
        $stmt_uniforme->execute();
        $result_uniforme = $stmt_uniforme->get_result();

        // Consultar la tabla 'materiales'
        $stmt_materiales = $conn->prepare("SELECT * FROM materiales WHERE fecha >= '2024-03-09'");
        $stmt_materiales->execute();
        $result_materiales = $stmt_materiales->get_result();

        // Consultar la tabla 'herramientas'
        $stmt_herramientas = $conn->prepare("SELECT * FROM herramientas WHERE fecha >= '2024-03-09'");
        $stmt_herramientas->execute();
        $result_herramientas = $stmt_herramientas->get_result();

    

        // Comenzar a escribir datos de la primera tabla (uniforme)
       $dataRow = 2; // Comenzar a escribir datos en la fila 2

       while ($data = $result_uniforme->fetch_assoc()) {
          $sheet6->setCellValue('A' . $dataRow, $data["numero_de_guia"]);
          $sheet6->setCellValue('B' . $dataRow, $data["nombres"]);
          $sheet6->setCellValue('C' . $dataRow, $data["apellidos"]);
          $sheet6->setCellValue('D' . $dataRow, $data["cuadrilla"]);
          $sheet6->setCellValue('E' . $dataRow, $data["codigo"]);
          $sheet6->setCellValue('F' . $dataRow, $data["descripcion"]);
          $sheet6->setCellValue('G' . $dataRow, $data["cantidad"]);
          $sheet6->setCellValue('H' . $dataRow, $data["unidad"]);
          $sheet6->setCellValue('I' . $dataRow, $data["fecha"]);
          $dataRow++;
       }

       // Continuar escribiendo datos de la segunda tabla (materiales)
       while ($data = $result_materiales->fetch_assoc()) {
          $sheet6->setCellValue('A' . $dataRow, $data["numero_de_guia"]);
          $sheet6->setCellValue('B' . $dataRow, $data["nombres"]);
          $sheet6->setCellValue('C' . $dataRow, $data["apellidos"]);
          $sheet6->setCellValue('D' . $dataRow, $data["cuadrilla"]);
          $sheet6->setCellValue('E' . $dataRow, $data["codigo"]);
          $sheet6->setCellValue('F' . $dataRow, $data["descripcion"]);
          $sheet6->setCellValue('G' . $dataRow, $data["cantidad"]);
          $sheet6->setCellValue('H' . $dataRow, $data["unidad"]);
          $sheet6->setCellValue('I' . $dataRow, $data["fecha"]);
          $dataRow++;
        }

       // Continuar escribiendo datos de la tercera tabla (herramientas)
       while ($data = $result_herramientas->fetch_assoc()) {
           $sheet6->setCellValue('A' . $dataRow, $data["numero_de_guia"]);
           $sheet6->setCellValue('B' . $dataRow, $data["nombres"]);
           $sheet6->setCellValue('C' . $dataRow, $data["apellidos"]);
           $sheet6->setCellValue('D' . $dataRow, $data["cuadrilla"]);
           $sheet6->setCellValue('E' . $dataRow, $data["codigo"]);
           $sheet6->setCellValue('F' . $dataRow, $data["descripcion"]);
           $sheet6->setCellValue('G' . $dataRow, $data["cantidad"]);
           $sheet6->setCellValue('H' . $dataRow, $data["unidad"]);
           $sheet6->setCellValue('I' . $dataRow, $data["fecha"]);
           $dataRow++;
       }

    
        

        // Ajustar el ancho de las columnas para la quinta hoja
        foreach (range('A', 'I') as $columnID) {
            $sheet6->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Aplicar estilo a las celdas en la quinta hoja
        $sheet6->getStyle('A1:I' . ($dataRow - 1))->applyFromArray($styleArray);

        // Hoja 7: Datos de Tabla
        $sheet7 = $spreadsheet->createSheet();
        $sheet7->setTitle('Devolución');

        // Escribir los encabezados para la quinta hoja
        $sheet7->setCellValue('A1', 'Número de guía');
        $sheet7->setCellValue('B1', 'Nombres');
        $sheet7->setCellValue('C1', 'Apellidos');
        $sheet7->setCellValue('D1', 'Tipo de asignacion');
        $sheet7->setCellValue('E1', 'Codigo');
        $sheet7->setCellValue('F1', 'Material');
        $sheet7->setCellValue('G1', 'Cantidad');
        $sheet7->setCellValue('H1', 'Unidad');
        $sheet7->setCellValue('I1', 'Fecha');

        // Cambiar a color celeste las celdas de encabezado
        foreach (['A1', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1', 'H1', 'I1'] as $cell) {
            $sheet7->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID);
            $sheet7->getStyle($cell)->getFill()->getStartColor()->setARGB($celeste);
        }

        $dataRow = 2; // Comenzar a escribir datos de la segunda sección en la fila 2

        // Obtener todos los registros de la tabla "tabla"
        $stmt_tabla = $conn->prepare("SELECT * FROM devolucion WHERE fecha >= '2024-03-09'");
        $stmt_tabla->execute();
        $result_tabla = $stmt_tabla->get_result();

        while ($data = $result_tabla->fetch_assoc()) {
            $sheet7->setCellValue('A' . $dataRow, $data["numero_de_guia"]);
            $sheet7->setCellValue('B' . $dataRow, $data["nombres"]);
            $sheet7->setCellValue('C' . $dataRow, $data["apellidos"]);
            $sheet7->setCellValue('D' . $dataRow, $data["asignacion"]);
            $sheet7->setCellValue('E' . $dataRow, $data["codigo"]);
            $sheet7->setCellValue('F' . $dataRow, $data["descripcion"]);
            $sheet7->setCellValue('G' . $dataRow, $data["cantidad"]);
            $sheet7->setCellValue('H' . $dataRow, $data["unidad"]);
            $sheet7->setCellValue('I' . $dataRow, $data["fecha"]);

            $dataRow++;
        }

        // Ajustar el ancho de las columnas para la quinta hoja
        foreach (range('A', 'I') as $columnID) {
            $sheet7->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Aplicar estilo a las celdas en la quinta hoja
        $sheet7->getStyle('A1:I' . ($dataRow - 1))->applyFromArray($styleArray);
        
        // Crear un escritor Xlsx
        $writer = new Xlsx($spreadsheet);

        // Generar el nombre del archivo con fecha y hora actuales
        $fechaHora = new \DateTime();
        $nombreArchivo = 'stock_' . $fechaHora->format('dmY_His') . '.xlsx';

        // Enviar el archivo al navegador
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

        // Cerrar las conexiones y declaraciones
        $stmt->close();
        $stmt_tabla->close();
        $conn->close();

    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

// Llamar a la función para exportar a Excel
exportToExcel();
?>
