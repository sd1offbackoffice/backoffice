@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN BARANG HADIAH
@endsection

@section('title')
    ** LAPORAN BARANG HADIAH**
@endsection

@section('subtitle')
    Tanggal: {{$date}}
@endsection

@section('content')
    {{-- <table class=" table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr style="text-align: center; vertical-align: center">
                <th style="width: 70px; border-right: 1px solid black; border-bottom: 1px solid black">No.</th>
                <th colspan="4" style="width: 380px; border-right: 1px solid black; border-bottom: 1px solid black; text-align: left">Periode Promosi</th>
                <th colspan="2" style="width: 70px; border-right: 1px solid black; border-bottom: 1px solid black">PLU</th>
                <th colspan="10" style="width: 300px; border-right: 1px solid black;border-bottom: 1px solid black; text-align: left">Nama Barang</th>
                <th style="border-right: 1px solid black;border-bottom: 1px solid black">Frac / Unit</th>
            </tr>
            <tr>
                <th style="width: 50px; border-right: 1px solid black;">DPP</th>
                <th style="width: 100px; border-right: 1px solid black;">PPN</th>
                <th style="width: 50px; border-right: 1px solid black;">DPP</th>
                <th style="width: 100px">PPN</th>
            </tr>
        </thead>
    </table> --}}
    <table>
        <thead style="border-top: 1px solid black; border-bottom: 1px solid black; text-align: left">
            <tr>
                <th>No.</th>
                <th colspan="4" style="width: 150px">Periode Promosi</th>
                <th colspan="2" style="width: 30px">PLU</th>
                <th colspan="10" style="width: 200px">Nama Barang</th>
                <th style="width: 200px">Frac / Unit</th>                
            </tr>
            <tr>
                <th colspan="3">Saldo Awal</th>
                <th colspan="2">Dr. Supplier</th>
                <th colspan="2">Dr. Cabang</th>
                <th colspan="2">Hdh. Customer</th>
                <th colspan="2">Ke Cabang</th>
                <th colspan="2">Dr. Kasir</th>
                <th colspan="2">Penyesuaian</th>
                <th colspan="2">Saldo Akhir</th>
                <th>Nama Event Prom</th>
            </tr>
            <tr>
                <th colspan="2" style="width: 30px">Qty</th>
                <th style="width: 30px">Fr.</th>
                <th style="width: 30px">Qty</th>
                <th style="width: 30px">Fr.</th>
                <th style="width: 30px">Qty</th>
                <th style="width: 30px">Fr.</th>
                <th style="width: 30px">Qty</th>
                <th style="width: 30px">Fr.</th>
                <th style="width: 30px">Qty</th>
                <th style="width: 30px">Fr.</th>
                <th style="width: 30px">Qty</th>
                <th style="width: 30px">Fr.</th>
                <th style="width: 30px">Qty</th>
                <th style="width: 30px">Fr.</th>
                <th style="width: 30px">Qty</th>
                <th style="width: 30px">Fr.</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $d)
                @php
                    $i = 1
                    if (substr($d->bom, 4, 2) == '01') {
                        # code...
                    }
                @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $d->gfh_tglawal }}</td>
                    <td>{{ $d->gfh_tglakhir }}</td>
                    <td>{{ $d->prdcd }}</td>
                    <td>{{ $d->bprp_ketpanjang }}</td>
                    <td>{{ $d->kemasan }}</td>
                </tr>
                <tr>
                    <td>{{ floor($d->) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection