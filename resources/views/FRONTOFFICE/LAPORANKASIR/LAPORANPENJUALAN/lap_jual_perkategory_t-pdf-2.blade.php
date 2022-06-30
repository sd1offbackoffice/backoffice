@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    PENJUALAN PER KATEGORY
@endsection

@section('title')
    LAPORAN PENJUALAN PER KATEGORY
@endsection

@section('subtitle')
    {{$periode}}
@endsection

@php
    //rupiah formatter (no Rp or .00)
    function rupiah($angka){
    //    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,2,'.',',');
        return $hasil_rupiah;
    }
    function twopoint($angka){
        $hasil_rupiah = number_format($angka,2,'.',',');
        return $hasil_rupiah;
    }
    function percent($angka){
        $hasil_rupiah = number_format($angka,2,'.',',');
        return $hasil_rupiah;
    }
@endphp

@section('content')

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr>
                @if($qty == 'Y')
                    <th rowspan="2" colspan="2" style="text-align: left; vertical-align: middle;">KATEGORI</th>
                    <th rowspan="2" style="width: 60px; text-align: right; vertical-align: middle;">QTY</th>
                @else
                    <th rowspan="2" colspan="2" style="text-align: left; vertical-align: middle;">KATEGORI</th>
                    <th rowspan="2" style="width: 60px;">&nbsp;&nbsp;</th>
                @endif
                <th rowspan="2" style="width: 80px; text-align: right; vertical-align: middle;">PENJUALAN<br>KOTOR</th>
                <th rowspan="2" style="width: 80px; text-align: right; vertical-align: middle;">PAJAK</th>
                <th rowspan="2" style="width: 80px; text-align: right; vertical-align: middle;">BEBAS PPN</th>
                <th rowspan="2" style="width: 80px; text-align: right; vertical-align: middle;">PPN DTP</th>
                <th rowspan="2" style="width: 80px; text-align: right; vertical-align: middle;">PENJUALAN<br>BERSIH</th>
                <th rowspan="2" style="width: 80px; text-align: right; vertical-align: middle;">H.P.P RATA2</th>
                <th colspan="2" style="text-align: right; vertical-align: middle;">------MARGIN------</th>
            </tr>
            <tr>
                <td style="width: 70px">Rp.</td>
                <td style="width: 10px">%</td>
            </tr>
        </thead>
        <tbody style="border-bottom: 2px solid black; text-align: right">
        <?php
            $counterDiv = 0;
            $counterDept = 0;

            $divisi = '';
            $departemen = '';

            $qtyTotal = 0;
            $grossTotal = 0;
            $taxTotal = 0;
            $netTotal = 0;
            $hppTotal = 0;
            $marginTotal = 0;
            $percentageTotal = 0;
            // dd($data);
        ?>
        @for($i=0;$i<sizeof($data);$i++)
        
        </tbody>
    </table>
@endsection
