<?php
require 'vendor/autoload.php';  // Asegúrate de que la ruta a autoload.php es correcta

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Fill;

function exportToExcel($fecha_inicio, $fecha_fin, $busqueda, $opcion, $tabla) {
    $host = 'localhost';
    $db = 'base_de_datos';
    $user = 'usuario';
    $password = 'contraseña';

    try {
        // Conectar a la base de datos
        $conn = new mysqli($host, $user, $password, $db);
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }
    
        // Construir la parte de la consulta para los filtros de fecha
        $fechaCondition = '';
        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $fechaCondition = "AND fecha >= ? AND fecha <= ?";
        } elseif (!empty($fecha_inicio)) {
            $fechaCondition = "AND fecha = ?";
        }

        // Definir la consulta SQL
        $query = "SELECT * FROM $tabla WHERE $opcion LIKE ? $fechaCondition ORDER BY fecha ASC";
        $stmt = $conn->prepare($query);

        // Preparar los parámetros
        $searchTerm = "%$busqueda%";
        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $stmt->bind_param('sss', $searchTerm, $fecha_inicio, $fecha_fin);
        } elseif (!empty($fecha_inicio)) {
            $stmt->bind_param('ss', $searchTerm, $fecha_inicio);
        } else {
            $stmt->bind_param('s', $searchTerm);
        }
    
        // Ejecutar la consulta
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Crear un nuevo objeto Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Escribir los encabezados
        $sheet->setCellValue('A1', 'Item');
        $sheet->setCellValue('B1', 'Numero de guia');
        $sheet->setCellValue('C1', 'Nombres');
        $sheet->setCellValue('D1', 'Apellidos');
        $sheet->setCellValue('E1', 'Cuadrilla');
        $sheet->setCellValue('F1', 'Material');
        $sheet->setCellValue('G1', 'Cantidad');
        $sheet->setCellValue('H1', 'Unidad');
        $sheet->setCellValue('I1', 'Fecha');
        $sheet->setCellValue('J1', 'Codigo');
    
        // Cambiar a color celeste las celdas de encabezado
        $celeste = 'FF00FFFF';
        foreach (['A1', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1', 'H1', 'I1', 'J1'] as $cell) {
            $sheet->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID);
            $sheet->getStyle($cell)->getFill()->getStartColor()->setARGB($celeste);
        }
    
        // Escribir los datos
        $row = 2;
        $itemCounter = 1; // Contador del ítem
        $previousGuia = null; // Almacenar el número de guía anterior

        
        while ($data = $result->fetch_assoc()) {
            // Reiniciar el contador del ítem si el número de guía cambia
            if ($opcion !== 'descripcion' && $data["numero_de_guia"] !== $previousGuia) {
                if ($previousGuia !== null) {
                    // Aplicar color a la fila según el valor de "descripcion"
                    $cellValue = trim($data["descripcion"]);
                    if ($cellValue === 'falta') {
                        $sheet->getStyle('A' . $row . ':J' . $row)->getFill()->setFillType(Fill::FILL_SOLID);
                        $sheet->getStyle('A' . $row . ':J' . $row)->getFill()->getStartColor()->setARGB('FFFF0000'); // Rojo
                    } elseif ($cellValue === 'tardanza') {
                        $sheet->getStyle('A' . $row . ':J' . $row)->getFill()->setFillType(Fill::FILL_SOLID);
                        $sheet->getStyle('A' . $row . ':J' . $row)->getFill()->getStartColor()->setARGB('FFFFFF00'); // Amarillo
                    } elseif ($cellValue === 'asistencia') {
                        $sheet->getStyle('A' . $row . ':J' . $row)->getFill()->setFillType(Fill::FILL_SOLID);
                        $sheet->getStyle('A' . $row . ':J' . $row)->getFill()->getStartColor()->setARGB('FF4CAF50'); // Verde claro
                    }
                }
                $previousGuia = $data["numero_de_guia"];
                $itemCounter = 1; // Reiniciar el contador para el nuevo número de guía
            }
            
            // Escribir el ítem
            $sheet->setCellValue('A' . $row, $itemCounter++); // Item

            // Escribir los datos en la hoja de cálculo
            $sheet->setCellValue('B' . $row, $data["numero_de_guia"]);
            $sheet->setCellValue('C' . $row, $data["nombres"]);
            $sheet->setCellValue('D' . $row, $data["apellidos"]);
            $sheet->setCellValue('E' . $row, $data["cuadrilla"]);
            $sheet->setCellValue('F' . $row, $data["descripcion"]);
            $sheet->setCellValue('G' . $row, $data["cantidad"]);
            $sheet->setCellValue('H' . $row, $data["unidad"]);
            $sheet->setCellValue('I' . $row, Date::dateTimeToExcel(new \DateTime($data["fecha"])));
            $sheet->setCellValue('J' . $row, $data["codigo"]);
    
            $row++;
        }
        
        // Ajustar el ancho de las columnas
        foreach (range('A', 'J') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        // Aplicar estilo a las celdas
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
        $sheet->getStyle('A1:J' . ($row - 1))->applyFromArray($styleArray);

        // Aplicar formato a la columna de fechas
        $sheet->getStyle('I2:I' . ($row - 1))->getNumberFormat()->setFormatCode('DD/MM/YYYY');
    
        // Forzar actualización de la hoja
        $spreadsheet->getActiveSheet()->setTitle('Datos');
        $spreadsheet->getActiveSheet()->calculateColumnWidths();
    
        // Crear un escritor Xlsx
        $writer = new Xlsx($spreadsheet);
    
        // Generar el nombre del archivo con fecha y hora actuales
        $fechaHora = new \DateTime();
        $nombreArchivo = 'datos_' . $fechaHora->format('dmY_His') . '.xlsx';
        
        // Enviar el archivo al navegador
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

// Obtener los parámetros de la URL o establecer valores predeterminados
$fecha_inicio = $_GET['fecha_inicio'] ?? null;
$fecha_fin = $_GET['fecha_fin'] ?? null;
$busqueda = $_GET['busqueda'] ?? '';
$opcion = $_GET['opcion'] ?? '';
$tabla = $_GET['tabla'] ?? 'default_table'; // Reemplaza 'default_table' con el nombre de una tabla predeterminada si es necesario

// Llamar a la función con los parámetros obtenidos o predeterminados
exportToExcel($fecha_inicio, $fecha_fin, $busqueda, $opcion, $tabla);
?>
