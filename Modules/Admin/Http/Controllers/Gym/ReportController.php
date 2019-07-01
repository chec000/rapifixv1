<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReportController
 *
 * @author sergio
 */

namespace Modules\Admin\Http\Controllers\gym;

use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\Admin\Entities\Gym\UsuarioCliente;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Modules\Admin\Entities\Gym\Venta;
use Illuminate\Http\Request;
use Carbon\Carbon;
use View;

class ReportController extends Controller {

    public function reporteVenta(Request $request) {
        $ventas = Venta::with('usuario')->with('detalleVenta')->get();
        $v = $this->buildExcelVenta($ventas);
        $documento = new Spreadsheet();
        $documento
                ->getProperties()
                ->setCreator("portalgym.com")
                ->setTitle('Reporte de ventas')
                ->setSubject('Ventas')
                ->setDescription('Este documento presenta un informa de las ventas')
                ->setCategory('Ventas');

        $hoja = $documento->getActiveSheet();
        $hoja->setTitle("Ventas del mes");
        $hoja->setCellValue('A1', "Cliente")->set;
        $hoja->setCellValue("B1", "Tipo de pago");
        $hoja->setCellValue("D1", "Fecha");
        $hoja->setCellValue("C1", "Total");

        $hoja->fromArray($v, NULL, 'A2');
        $nombreDelDocumento = "Ventas.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($documento, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    private function buildExcelVenta($data) {
        $array = array();
        if (count($data) > 0) {
            foreach ($data as $result) {
                $newRow['Cliente'] = $result->nombre_cliente;
                $newRow['TipoPago'] = $result->tipo_pago;
                $newRow['Fecha'] = $result->created_at->format('d/m/Y');
                $newRow['Total'] = $result->total;
                array_push($array, $newRow);
            }
        }

        return $array;
    }

    public function index() {
        $view = View::make('admin::gym.reportes.index'
        );
        $this->layoutData['content'] = $view->render();
    }

    public function reportClientes(Request $request) {
        $status = "";
        $ini = new \DateTime($request->date_start_client);

        $end = new \DateTime($request->date_end_client);
        if ($request->estado == 1) {
            $status = 'Al dia';
        } else if ($request->estado) {
            $status = 'Atrasado';
        }

        $cl = UsuarioCliente::where('estado_cliente', '=', $status)->whereBetween('created_at', array($ini, $end))->get();

        if ($request->estado == 0) {
            $cl = UsuarioCliente::whereBetween('created_at', array($ini, $end))->get();
        }

        if (count($cl) > 0) {
            $listClientes = $this->buildExcelCliente($cl);
            $fecha = Carbon::now();
            $documento = new Spreadsheet();
            $documento
                    ->getProperties()
                    ->setCreator("portalgym.com")
                    ->setTitle('Clietes')
                    ->setSubject('Clientes')
                    ->setDescription('Este documento presenta un informe de clientes')
                    ->setCategory('Clientes');

            $hoja = $documento->getActiveSheet();
            $hoja->setTitle("Usuarios");
            $hoja->setCellValue('A1', "Número");
            $hoja->setCellValue('B1', "Nombre");
            $hoja->setCellValue("C1", "Clave de identificacion");
            $hoja->setCellValue("D1", "Dirección");
            $hoja->setCellValue("E1", "Telefono celular");
            $hoja->setCellValue("F1", "Fecha inscripción");
            $hoja->setCellValue("G1", "Código cliente");
            $hoja->setCellValue("H1", "Estatus cliente");
            $hoja->fromArray($listClientes, NULL, 'A2');
            $nombreDelDocumento = "Clientes-" . $fecha->toDateString() . ".xlsx";
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
            header('Cache-Control: max-age=0');
            $writer = IOFactory::createWriter($documento, 'Xlsx');
            $writer->save('php://output');
            exit;
        } else {

            return redirect()->route('admin.shopping-report.index');
        }
    }

    public function reporteGeneral(Request $request) {       
        $date = Carbon::now();       
        if ($request->has('ventas')) {
            switch ($request->ventas) {
                case 0:
                    $ventas = Venta::whereMonth('created_at', '=', $date->month)->whereYear('created_at', '=', $date->year)->get();
                    break;
                case 1:
                    $ventas = Venta::whereBetween('created_at', [$request->date_start, $request->date_end])->get();

                    break;
                case 2:
                    $ventas = Venta::whereYear('created_at', '=', $date->year)->get();
                    break;
                case 3:
                    $ventas = Venta::where('tipo_pago', '=', 'efectivo')->whereBetween('created_at', [$request->date_start, $request->date_end])->get();
                    break;
                case 4:
                    $ventas = Venta::where('tipo_pago', '=', 'tarjeta')->whereBetween('created_at', [$request->date_start, $request->date_end])->get();

                    break;

                default:
                    $ventas = Venta::orderBy('tipo_pago', 'ASC')->get();
            }
        }

        if (count($ventas) > 0) {
            $listVentas = $this->buildReporteGeneral($ventas);
            $documento = new Spreadsheet();
            $documento
                    ->getProperties()
                    ->setCreator("portalgym.com")
                    ->setTitle('Clietes')
                    ->setSubject('Clientes')
                    ->setDescription('Este documento presenta un informe de clientes')
                    ->setCategory('Clientes');

            $celda = 3 + count($listVentas['ventas']);
            $celda = 'F3:F' . $celda;
            $documento->getActiveSheet()->getStyle($celda)->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
            $hoja = $documento->getActiveSheet();
            $hoja->setTitle("Usuarios");
            $hoja->setCellValue('B1', "REPORTE  DÍA: ".$date->toDateString());
            $hoja->setCellValue('A2', "ID");
            $hoja->setCellValue('B2', "CLIENTE");
            $hoja->setCellValue("C2", "USUARIO");
            $hoja->setCellValue("D2", "TICKET");
            $hoja->setCellValue("E2", "CONCEPTO");
            $hoja->setCellValue("F2", "MONTO");
            $hoja->setCellValue("G2", "FECHA");
            $hoja->setCellValue("H2", "VENDEDOR");
            $hoja->setCellValue("I2", "TIPO PAGO");
            $celdaLimite = 3 + count($listVentas['ventas']);
            $hoja->setCellValue('E' . ($celdaLimite + 1), "EFECTIVO");
            $hoja->setCellValue('F' . ($celdaLimite + 1), $listVentas['pago_efectivo'])->getStyle('F' . ($celdaLimite + 1))->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
            $hoja->setCellValue('E' . ($celdaLimite + 2), "TARJETA DE CREDITO Y TRANSFERENCIA BANCARIA");
            $hoja->setCellValue('F' . ($celdaLimite + 2), $listVentas['pago_tarjeta'])->getStyle('F' . ($celdaLimite + 2))->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);

            $hoja->setCellValue('E' . ($celdaLimite + 3), "TOTAL");
            $hoja->setCellValue('F' . ($celdaLimite + 3), $listVentas['total'])->getStyle('F' . ($celdaLimite + 3))->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);

            $hoja->fromArray($listVentas['ventas'], NULL, 'A3');

            $nombreDelDocumento = "Ventas-" .$date->toDateString().".xlsx";
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
            header('Cache-Control: max-age=0');
            $writer = IOFactory::createWriter($documento, 'Xlsx');
            $writer->save('php://output');
            exit;
        } else {

            return redirect()->route('admin.shopping-report.index');
        }
    }

    private function buildExcelCliente($data) {
        $array = array();

        if (count($data) > 0) {
            $id = 0;
            foreach ($data as $result) {
                $id = $id + 1;
                $newRow['id'] = $id;
                $newRow['nombre'] = $result->usuario->name . ' ' . '' . $result->usuario->apellido_paterno;
                $newRow['clave_identificacion'] = $result->usuario->clave_unica;
                $newRow['direccion'] = $result->usuario->direccion;
                $newRow['telefono_celular'] = $result->usuario->telefono_celular;
                $newRow['fechainscripcion'] = $result->fecha_inscripcion;
                $newRow['codigo_cliente'] = $result->codigo_cliente;
                $newRow['estado_cliente'] = $result->estado_cliente;
                array_push($array, $newRow);
            }
        }

        return $array;
    }

    private function buildReporteGeneral($data) {

        $array = array();
        $pago_tarjeta = 0;
        $pago_efectivo = 0;
        if (count($data) > 0) {
            $id = 0;
            foreach ($data as $result) {
                if ($result->cliente != null && $result->seller != null) {
                    $id = $id + 1;
                    $newRow['id'] = $result->cliente->codigo_cliente;
                    $newRow['cliente'] = strtoupper($result->usuario->name . ' ' . '' . $result->usuario->apellido_paterno);
                    $newRow['usuario'] = strtoupper($result->usuario->clave_unica);
                    $newRow['tiket'] = $result->codigo_factura;
                    $newRow['Concepto'] = strtoupper($result->concepto);
                    $newRow['monto'] = $result->total;
                        $newRow['fecha'] = $result->fecha_inscripcion;
                    $newRow['vendedor'] = strtoupper($result->seller->name);
                    $newRow['tipo_pgo'] = strtoupper($result->tipo_pago);

                    if ($result->tipo_pago == 'efectivo') {
                        $pago_efectivo = $pago_efectivo + $result->total;
                    } else {
                        $pago_tarjeta = $pago_tarjeta + $result->total;
                    }
                    array_push($array, $newRow);
                }
            }
        }
        return array(
            "pago_tarjeta" => $pago_tarjeta,
            'pago_efectivo' => $pago_efectivo,
            'total' => $pago_efectivo + $pago_tarjeta,
            'ventas' => $array
        );
    }

}
