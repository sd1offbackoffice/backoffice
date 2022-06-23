@extends('html-template')

@section('table_font_size','9 px')

@section('page_title')
    LAPORAN PENYERAHAN BARANG DAGANGAN YANG DITUKAR
@endsection

@section('title')
    LAPORAN PENYERAHAN BARANG DAGANGAN YANG DITUKAR
@endsection

@section('subtitle')
Tanggal : {{ $tgl1 }} 
@endsection

@section('content')
    <table  class="table">
        <thead style="border: 1px solid black">
            <tr>
                <th style="border-right: 1px solid black;" class="tengah" rowspan="2">No.</th>
                <th style="border-bottom: 1px solid black;"class="tengah" colspan="5" rowspan="1">Struk Penukaran Barang</th>
            </tr>
            <tr>
                <th style="border-left: 1px solid black; border-right: 1px solid black;" class="tengah center">No.</th>
                <th style="border-right: 1px solid black;" class="tengah center">Tanggal</th>
                <th style="border-right: 1px solid black;" class="tengah center">PLU</th>
                <th style="border-right: 1px solid black;" class="tengah center">Deskripsi</th>
                <th style="border-right: 1px solid black;" class="tengah center">Qty.</th>
            </tr>
        </thead>
        <tbody>
                @for($i=0;$i<sizeof($data);$i++)
                    <tr style="min-height: 25px">
                        <td>{{ $i+1 }}</td>
                        <td>{{ $data[$i]->rom_nodokumen }}</td>
                        {{-- <td>{{ $data[$i]->rom_tgldokumen }}</td> --}}
                        <td>{{ $tgl1 }}</td>
        
                        <td>{{ $data[$i]->rom_prdcd }}</td>
                        <td class="left">{{ $data[$i]->prd_deskripsipanjang }}</td>
                        <td class="right">{{ $data[$i]->rom_qty }}</td> 
                    </tr>
                @endfor
        </tbody>
    </table>
    <table style="margin-top: 10px; padding-top: 15px; border: 1px solid black; min-width: 100%;" >
        <tbody>
            <tr>
                <td style=" height: 65px; vertical-align: baseline; width: 50%; text-align: center;">
                    Diterima,
                    
                    <div class="row align-items-center">
                        <div>                         </div>
                    </div>
                </td>
                <td style="height: 65px; vertical-align: baseline; width: 50%; text-align: center;">
                    Dibuat,
                    
                    <div class="row align-items-center">
                        <div></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; text-align: center;">
                    (Stock Keeper - Barang Baik)
                </td>
                <td style="width: 50%; text-align: center;">
                    (Customer Service Supv./Jr. Supv.)
                </td>
            </tr>
        </tbody>
    </table>
@endsection