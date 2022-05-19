<?php

namespace App\Http\Controllers;

use Dompdf\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelController extends Controller
{
    static function create($view, $filename, $title, $subtitle,$keterangan)
    {
        $password = 'rahasia';
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan', 'prs_namacabang', 'prs_namawilayah')
            ->first();
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        $spreadsheet = $reader->loadFromString($view);
        $spreadsheet->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 7);

        $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
        $spreadsheet->getActiveSheet()->getProtection()->setPassword($password);
        $security = $spreadsheet->getSecurity();
        $security->setLockWindows(true);
        $security->setLockStructure(true);
        $security->setWorkbookPassword($password);
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
