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
                <th>Periode Promosi</th>
                <th></th>
                <th></th>
                <th></th>
                <th>PLU</th>
                <th></th>
                <th>Nama Barang</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Frac / Unit</th>                                
            </tr>
            <tr>
                <th></th>
                <th colspan="2">Saldo Awal</th>
                <th colspan="2">Dr. Supplier</th>
                <th colspan="2">Dr. Cabang</th>
                <th colspan="2">Hdh. Customer</th>
                <th colspan="2">Ke Cabang</th>
                <th colspan="2">Dr. Kasir</th>
                <th colspan="2">Penyesuaian</th>
                <th colspan="2">Saldo Akhir</th>
                <th>Nama Event Prom</th>
                {{-- <th colspan="3">Saldo Awal</th>
                <th colspan="2">Dr. Supplier</th>
                <th colspan="2">Dr. Cabang</th>
                <th colspan="2">Hdh. Customer</th>
                <th colspan="2">Ke Cabang</th>
                <th colspan="2">Dr. Kasir</th>
                <th colspan="2">Penyesuaian</th>
                <th colspan="2">Saldo Akhir</th>
                <th>Nama Event Prom</th> --}}
            </tr>
            <tr>
                <th></th>
                <th>Qty</th>
                <th>Fr.</th>
                <th>Qty</th>
                <th>Fr.</th>
                <th>Qty</th>
                <th>Fr.</th>
                <th>Qty</th>
                <th>Fr.</th>
                <th>Qty</th>
                <th>Fr.</th>
                <th>Qty</th>
                <th>Fr.</th>
                <th>Qty</th>
                <th>Fr.</th>
                <th>Qty</th>
                <th>Fr.</th>
            </tr>
        </thead>

        <tbody>
            
            @foreach ($data as $d)
            @if ($dataType == 'early')
                @php
                    $index = 1;

                    if (substr($d->bom, 4, 2) == '01') {
                        $cp_qtyawal = $d->qtyawal01;
                        $cp_qtykawal = $d->qtykawal01;
                        $cp_qtybpb = $d->qtybpb01;
                        $cp_qtykbpb = $d->qtykbpb01;
                        $cp_qtydrcab = $d->qtydrcab01;
                        $cp_qtykdrcab = $d->qtykdrcab01;
                        $cp_qtysales = $d->qtysales01;
                        $cp_qtyksales = $d->qtyksales01;
                        $cp_qtykecab  = $d->qtykecab01;
                        $cp_qtykkecab = $d->qtykkecab01;
                        $cp_qtympp	= $d->qtympp01;
                        $cp_qtykmpp   = $d->qtykmpp01;
                        $cp_qtyakhir  = $d->qtyakhir01;
                        $cp_qtykakhir = $d->qtykakhir01;
                    }

                    if (substr($d->bom, 4, 2) == '02') {
                        $cp_qtyawal = $d->qtyawal02;
                        $cp_qtykawal = $d->qtykawal02;
                        $cp_qtybpb = $d->qtybpb02;
                        $cp_qtykbpb = $d->qtykbpb02;
                        $cp_qtydrcab = $d->qtydrcab02;
                        $cp_qtykdrcab = $d->qtykdrcab02;
                        $cp_qtysales = $d->qtysales02;
                        $cp_qtyksales = $d->qtyksales02;
                        $cp_qtykecab  = $d->qtykecab02;
                        $cp_qtykkecab = $d->qtykkecab02;
                        $cp_qtympp	= $d->qtympp02;
                        $cp_qtykmpp   = $d->qtykmpp02;
                        $cp_qtyakhir  = $d->qtyakhir02;
                        $cp_qtykakhir = $d->qtykakhir02;
                    }

                    if (substr($d->bom, 4, 2) == '03') {
                        $cp_qtyawal = $d->qtyawal03;
                        $cp_qtykawal = $d->qtykawal03;
                        $cp_qtybpb = $d->qtybpb03;
                        $cp_qtykbpb = $d->qtykbpb03;
                        $cp_qtydrcab = $d->qtydrcab03;
                        $cp_qtykdrcab = $d->qtykdrcab03;
                        $cp_qtysales = $d->qtysales03;
                        $cp_qtyksales = $d->qtyksales03;
                        $cp_qtykecab  = $d->qtykecab03;
                        $cp_qtykkecab = $d->qtykkecab03;
                        $cp_qtympp	= $d->qtympp03;
                        $cp_qtykmpp   = $d->qtykmpp03;
                        $cp_qtyakhir  = $d->qtyakhir03;
                        $cp_qtykakhir = $d->qtykakhir03;
                    }

                    if (substr($d->bom, 4, 2) == '04') {
                        $cp_qtyawal = $d->qtyawal04;
                        $cp_qtykawal = $d->qtykawal04;
                        $cp_qtybpb = $d->qtybpb04;
                        $cp_qtykbpb = $d->qtykbpb04;
                        $cp_qtydrcab = $d->qtydrcab04;
                        $cp_qtykdrcab = $d->qtykdrcab04;
                        $cp_qtysales = $d->qtysales04;
                        $cp_qtyksales = $d->qtyksales04;
                        $cp_qtykecab  = $d->qtykecab04;
                        $cp_qtykkecab = $d->qtykkecab04;
                        $cp_qtympp	= $d->qtympp04;
                        $cp_qtykmpp   = $d->qtykmpp04;
                        $cp_qtyakhir  = $d->qtyakhir04;
                        $cp_qtykakhir = $d->qtykakhir04;
                    }

                    if (substr($d->bom, 4, 2) == '05') {
                        $cp_qtyawal = $d->qtyawal05;
                        $cp_qtykawal = $d->qtykawal05;
                        $cp_qtybpb = $d->qtybpb05;
                        $cp_qtykbpb = $d->qtykbpb05;
                        $cp_qtydrcab = $d->qtydrcab05;
                        $cp_qtykdrcab = $d->qtykdrcab05;
                        $cp_qtysales = $d->qtysales05;
                        $cp_qtyksales = $d->qtyksales05;
                        $cp_qtykecab  = $d->qtykecab05;
                        $cp_qtykkecab = $d->qtykkecab05;
                        $cp_qtympp	= $d->qtympp05;
                        $cp_qtykmpp   = $d->qtykmpp05;
                        $cp_qtyakhir  = $d->qtyakhir05;
                        $cp_qtykakhir = $d->qtykakhir05;
                    }

                    if (substr($d->bom, 4, 2) == '06') {
                        $cp_qtyawal = $d->qtyawal06;
                        $cp_qtykawal = $d->qtykawal06;
                        $cp_qtybpb = $d->qtybpb06;
                        $cp_qtykbpb = $d->qtykbpb06;
                        $cp_qtydrcab = $d->qtydrcab06;
                        $cp_qtykdrcab = $d->qtykdrcab06;
                        $cp_qtysales = $d->qtysales06;
                        $cp_qtyksales = $d->qtyksales06;
                        $cp_qtykecab  = $d->qtykecab06;
                        $cp_qtykkecab = $d->qtykkecab06;
                        $cp_qtympp	= $d->qtympp06;
                        $cp_qtykmpp   = $d->qtykmpp06;
                        $cp_qtyakhir  = $d->qtyakhir06;
                        $cp_qtykakhir = $d->qtykakhir06;
                    }

                    if (substr($d->bom, 4, 2) == '07') {
                        $cp_qtyawal = $d->qtyawal07;
                        $cp_qtykawal = $d->qtykawal07;
                        $cp_qtybpb = $d->qtybpb07;
                        $cp_qtykbpb = $d->qtykbpb07;
                        $cp_qtydrcab = $d->qtydrcab07;
                        $cp_qtykdrcab = $d->qtykdrcab07;
                        $cp_qtysales = $d->qtysales07;
                        $cp_qtyksales = $d->qtyksales07;
                        $cp_qtykecab  = $d->qtykecab07;
                        $cp_qtykkecab = $d->qtykkecab07;
                        $cp_qtympp	= $d->qtympp07;
                        $cp_qtykmpp   = $d->qtykmpp07;
                        $cp_qtyakhir  = $d->qtyakhir07;
                        $cp_qtykakhir = $d->qtykakhir07;
                    }
                    
                    if (substr($d->bom, 4, 2) == '08') {
                        $cp_qtyawal = $d->qtyawal08;
                        $cp_qtykawal = $d->qtykawal08;
                        $cp_qtybpb = $d->qtybpb08;
                        $cp_qtykbpb = $d->qtykbpb08;
                        $cp_qtydrcab = $d->qtydrcab08;
                        $cp_qtykdrcab = $d->qtykdrcab08;
                        $cp_qtysales = $d->qtysales08;
                        $cp_qtyksales = $d->qtyksales08;
                        $cp_qtykecab  = $d->qtykecab08;
                        $cp_qtykkecab = $d->qtykkecab08;
                        $cp_qtympp	= $d->qtympp08;
                        $cp_qtykmpp   = $d->qtykmpp08;
                        $cp_qtyakhir  = $d->qtyakhir08;
                        $cp_qtykakhir = $d->qtykakhir08;
                    }

                    if (substr($d->bom, 4, 2) == '09') {
                        $cp_qtyawal = $d->qtyawal09;
                        $cp_qtykawal = $d->qtykawal09;
                        $cp_qtybpb = $d->qtybpb09;
                        $cp_qtykbpb = $d->qtykbpb09;
                        $cp_qtydrcab = $d->qtydrcab09;
                        $cp_qtykdrcab = $d->qtykdrcab09;
                        $cp_qtysales = $d->qtysales09;
                        $cp_qtyksales = $d->qtyksales09;
                        $cp_qtykecab  = $d->qtykecab09;
                        $cp_qtykkecab = $d->qtykkecab09;
                        $cp_qtympp	= $d->qtympp09;
                        $cp_qtykmpp   = $d->qtykmpp09;
                        $cp_qtyakhir  = $d->qtyakhir09;
                        $cp_qtykakhir = $d->qtykakhir09;
                    }

                    if (substr($d->bom, 4, 2) == '10') {
                        $cp_qtyawal = $d->qtyawal10;
                        $cp_qtykawal = $d->qtykawal10;
                        $cp_qtybpb = $d->qtybpb10;
                        $cp_qtykbpb = $d->qtykbpb10;
                        $cp_qtydrcab = $d->qtydrcab10;
                        $cp_qtykdrcab = $d->qtykdrcab10;
                        $cp_qtysales = $d->qtysales10;
                        $cp_qtyksales = $d->qtyksales10;
                        $cp_qtykecab  = $d->qtykecab10;
                        $cp_qtykkecab = $d->qtykkecab10;
                        $cp_qtympp	= $d->qtympp10;
                        $cp_qtykmpp   = $d->qtykmpp10;
                        $cp_qtyakhir  = $d->qtyakhir10;
                        $cp_qtykakhir = $d->qtykakhir10;
                    }

                    if (substr($d->bom, 4, 2) == '11') {
                        $cp_qtyawal = $d->qtyawal11;
                        $cp_qtykawal = $d->qtykawal11;
                        $cp_qtybpb = $d->qtybpb11;
                        $cp_qtykbpb = $d->qtykbpb11;
                        $cp_qtydrcab = $d->qtydrcab11;
                        $cp_qtykdrcab = $d->qtykdrcab11;
                        $cp_qtysales = $d->qtysales11;
                        $cp_qtyksales = $d->qtyksales11;
                        $cp_qtykecab  = $d->qtykecab11;
                        $cp_qtykkecab = $d->qtykkecab11;
                        $cp_qtympp	= $d->qtympp11;
                        $cp_qtykmpp   = $d->qtykmpp11;
                        $cp_qtyakhir  = $d->qtyakhir11;
                        $cp_qtykakhir = $d->qtykakhir11;
                    }

                    if (substr($d->bom, 4, 2) == '12') {
                        $cp_qtyawal = $d->qtyawal12;
                        $cp_qtykawal = $d->qtykawal12;
                        $cp_qtybpb = $d->qtybpb12;
                        $cp_qtykbpb = $d->qtykbpb12;
                        $cp_qtydrcab = $d->qtydrcab12;
                        $cp_qtykdrcab = $d->qtykdrcab12;
                        $cp_qtysales = $d->qtysales12;
                        $cp_qtyksales = $d->qtyksales12;
                        $cp_qtykecab  = $d->qtykecab12;
                        $cp_qtykkecab = $d->qtykkecab12;
                        $cp_qtympp	= $d->qtympp12;
                        $cp_qtykmpp   = $d->qtykmpp12;
                        $cp_qtyakhir  = $d->qtyakhir12;
                        $cp_qtykakhir = $d->qtykakhir12;
                    }
                @endphp                
            @else
                @php
                    $index = 1;

                    if ($d->bprp_frackonversi == 0) {
                        $frac = 1;
                    } else {
                        $frac = $d->bprp_frackonversi;
                    }

                    $cp_qtyawal   = floor($d->qtyawal / $frac);
                    $cp_qtykawal  = mod($d->qtyawal, $frac);
                    $cp_qtybpb    = floor($d->qtybpb / $frac);
                    $cp_qtykbpb   = mod($d->qtybpb, $frac);
                    $cp_qtydrcab  = floor($d->qtydrcab / $frac);
                    $cp_qtykdrcab = mod($d->qtydrcab, $frac);
                    $cp_qtysales  = floor($d->qtysales / $frac);
                    $cp_qtyksales = mod($d->qtysales, $frac);
                    $cp_qtykecab  = floor($d->qtykecab / $frac);
                    $cp_qtykkecab = mod($d->qtykecab, $frac);
                    $cp_qtympp    = floor($d->qtympp / $frac);
                    $cp_qtykmpp   = mod($d->qtympp, $frac);
                    $cp_qtyakhir  = floor($d->qtyakhir / $frac);
                    $cp_qtykakhir = mod($d->qtyakhir, $frac);
                @endphp
            @endif
                
                @php
                    if (isset($cp_qtyawal) == null) {
                        $cp_qtyawal = 0;
                    }
                    if (isset($cp_qtykawal) == null) {
                        $cp_qtykawal = 0;
                    }
                    if (isset($cp_qtybpb) == null) {
                        $cp_qtybpb = 0;
                    }
                    if (isset($cp_qtykbpb) == null) {
                        $cp_qtykbpb = 0;
                    }
                    if (isset($cp_qtydrcab) == null) {
                        $cp_qtydrcab = 0;
                    }
                    if (isset($cp_qtykdrcab) == null) {
                        $cp_qtykdrcab = 0;
                    }
                    if (isset($cp_qtysales) == null) {
                        $cp_qtysales = 0;
                    }
                    if (isset($cp_qtyksales) == null) {
                        $cp_qtyksales = 0;
                    }
                    if (isset($cp_qtykecab) == null) {
                        $cp_qtykecab = 0;
                    }
                    if (isset($cp_qtykkecab) == null) {
                        $cp_qtykkecab = 0;
                    }
                    if (isset($cp_qtympp) == null) {
                        $cp_qtympp = 0;
                    }
                    if (isset($cp_qtykmpp) == null) {
                        $cp_qtykmpp = 0;
                    }
                    if (isset($cp_qtyakhir) == null) {
                        $cp_qtyakhir = 0;
                    }
                    if (isset($cp_qtykakhir) == null) {
                        $cp_qtykakhir = 0;
                    }
                @endphp
                <tr>
                    {{-- <th colspan="3">Saldo Awal</th>
                    <th colspan="2">Dr. Supplier</th>
                    <th colspan="2">Dr. Cabang</th>
                    <th colspan="2">Hdh. Customer</th>
                    <th colspan="2">Ke Cabang</th>
                    <th colspan="2">Dr. Kasir</th>
                    <th colspan="2">Penyesuaian</th>
                    <th colspan="2">Saldo Akhir</th>
                    <th>Nama Event Prom</th> --}}

                    <td>{{ $index }}</td>
                    <td colspan="3">{{ date_format(new Datetime($d->gfh_tglawal), "d-m-Y") }}</td>
                    <td colspan="3">s/d {{ date_format(new Datetime($d->gfh_tglakhir), "d-m-Y") }}</td>
                    <td></td>
                    {{-- <td></td> --}}
                    <td>{{ $d->prdcd }}</td>
                    <td>{{ $d->bprp_ketpanjang }}</td>
                    <td>{{ $d->kemasan }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>{{ $cp_qtyawal }}</td>
                    <td>{{ $cp_qtykawal }}</td>
                    <td>{{ $cp_qtybpb }}</td>
                    <td>{{ $cp_qtykbpb }}</td>
                    <td>{{ $cp_qtydrcab }}</td>
                    <td>{{ $cp_qtykdrcab }}</td>
                    <td>{{ $cp_qtysales }}</td>
                    <td>{{ $cp_qtyksales }}</td>
                    <td>{{ $cp_qtykecab }}</td>
                    <td>{{ $cp_qtykkecab }}</td>
                    <td>{{ $cp_qtympp }}</td>
                    <td>{{ $cp_qtykmpp }}</td>
                    <td>{{ $cp_qtyakhir }}</td>
                    <td>{{ $cp_qtykakhir }}</td>
                    <td>{{ $d->gfh_kodepromosi }}</td>
                    <td>{{ $d->gfh_namapromosi }}</td>
                </tr>
                @php
                    $index++;
                @endphp
            @endforeach
        </tbody>
    </table>
@endsection