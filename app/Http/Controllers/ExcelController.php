<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelController extends Controller
{
    static $password = 'rahasia';
    static function create($view, $filename, $title, $subtitle,$keterangan, $fixedRow = 7)
    {
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan', 'prs_namacabang', 'prs_namawilayah')
            ->first();
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        $spreadsheet = $reader->loadFromString($view);
        $spreadsheet->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, $fixedRow);

        $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
        $spreadsheet->getActiveSheet()->getProtection()->setPassword(Self::$password);
        $security = $spreadsheet->getSecurity();
        $security->setLockWindows(true);
        $security->setLockStructure(true);
        $security->setWorkbookPassword(Self::$password);
        $sheet = $spreadsheet->getActiveSheet();
        $maxColumn = $sheet->getHighestColumn();
        $column = [];
        $letter = 'A';
        while ($letter !== $maxColumn) {
            $column[] = $letter++;
        }
        $column[] = $letter++;
        foreach ($column as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        for ($i=0;$i<5;$i++){
            $sheet->insertNewRowBefore(1);
        }
        $sheet->setCellValue('A1', $perusahaan->prs_namaperusahaan);
        $sheet->setCellValue('A2', $perusahaan->prs_namacabang);
        $sheet->setCellValue('B1', $title);
        $sheet->setCellValue('B3', $subtitle);
        $sheet->getStyle('B1')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B3')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->mergeCells('B1:' . $column[sizeof($column) - 2] . '2');
        $sheet->mergeCells('B3:' . $column[sizeof($column) - 2] . '3');
        $sheet->setCellValue($maxColumn . '1', 'Tgl. Cetak : ' . date("d/m/Y"));
        $sheet->setCellValue($maxColumn . '2', 'Jam Cetak : ' . date('H:i:s'));
        $sheet->setCellValue($maxColumn . '3', 'User ID : ' . Session::get('usid'));
        $sheet->setCellValue($maxColumn . '4', $keterangan);
        $sheet->getStyle('A1:' . $maxColumn . '4')->getFont()->setBold(true);
        $sheet->getStyle('A1');

//        for ($i=0;$i<7000;$i++){
//            $sheet->setCellValue('A'.$i, $perusahaan->prs_namaperusahaan);
//            $sheet->setCellValue('B'.$i, $perusahaan->prs_namaperusahaan);
//            $sheet->setCellValue('C'.$i, $perusahaan->prs_namaperusahaan);
//            $sheet->setCellValue('D'.$i, $perusahaan->prs_namaperusahaan);
//            $sheet->setCellValue('E'.$i, $perusahaan->prs_namaperusahaan);
//            $sheet->setCellValue('F'.$i, $perusahaan->prs_namaperusahaan);
//            $sheet->setCellValue('G'.$i, $perusahaan->prs_namaperusahaan);
//            $sheet->setCellValue('H'.$i, $perusahaan->prs_namaperusahaan);
//            $sheet->setCellValue('I'.$i, $perusahaan->prs_namaperusahaan);
//            $sheet->setCellValue('J'.$i, $perusahaan->prs_namaperusahaan);
//            $sheet->setCellValue('K'.$i, $perusahaan->prs_namaperusahaan);
//            $sheet->setCellValue('L'.$i, $perusahaan->prs_namaperusahaan);
//        }


        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path($filename));
    }

    static function createFromData($spreadsheet,$data, $filename, $title, $subtitle,$keterangan, $fixedRow = 7)
    {
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan', 'prs_namacabang', 'prs_namawilayah')
            ->first();

        $spreadsheet->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, $fixedRow);
        $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
        $spreadsheet->getActiveSheet()->getProtection()->setPassword(Self::$password);
        $security = $spreadsheet->getSecurity();
        $security->setLockWindows(true);
        $security->setLockStructure(true);
        $security->setWorkbookPassword(Self::$password);
        $sheet = $spreadsheet->getActiveSheet();

        $maxColumn = $sheet->getHighestColumn();
        $column = [];
        $letter = 'A';
        while ($letter !== $maxColumn) {
            $column[] = $letter++;
        }
        $column[] = $letter++;
        foreach ($column as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        for ($i=0;$i<5;$i++){
            $sheet->insertNewRowBefore(1);
        }
        $sheet->setCellValue('A1', $perusahaan->prs_namaperusahaan);
        $sheet->setCellValue('A2', $perusahaan->prs_namacabang);
        $sheet->setCellValue('B1', $title);
        $sheet->setCellValue('B3', $subtitle);
        $sheet->getStyle('B1')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('B3')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->mergeCells('B1:' . $column[sizeof($column) - 2] . '2');
        $sheet->mergeCells('B3:' . $column[sizeof($column) - 2] . '3');
        $sheet->setCellValue($maxColumn . '1', 'Tgl. Cetak : ' . date("d/m/Y"));
        $sheet->setCellValue($maxColumn . '2', 'Jam Cetak : ' . date('H:i:s'));
        $sheet->setCellValue($maxColumn . '3', 'User ID : ' . Session::get('usid'));
        $sheet->setCellValue($maxColumn . '4', $keterangan);
        $sheet->getStyle('A1:' . $maxColumn . '4')->getFont()->setBold(true);
        $sheet->getStyle('A1');

        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path($filename));
    }
}
