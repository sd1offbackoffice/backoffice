{{----------------------------------------------------------------------------}}
@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    Laporan Pemusnahan Barang Rusak
@endsection

@section('title')
    PERMOHONAN PEMUSNAHAN BARANG RUSAK
@endsection

@section('subtitle')
    No. Dokumen : {{$data[0]->rsk_nodoc}} <br>
    Tgl. Dokumen : {{date('d/m/Y', strtotime($data[0]->rsk_tgldoc))}} <br>
    {{$data[0]->reprint}}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">

        <tr>
            <th class="left">NO</th>
            <th class="left">PLU</th>
            <th class="left">DESKRIPSI</th>
            <th class="left">SATUAN</th>
            <th class="right">QTY</th>
            <th class="right">FRAC</th>
            <th class="right">HRG SATUAN IN CTN</th>
            <th class="right padding-right">TOTAL</th>
            <th class="left">KETERANGAN</th>
        </tr>
        </thead>
        <tbody>
        @php
        @endphp
        {{$temp = 0}}
        @for($i=0; $i<sizeof($data); $i++)
            {{$j = $i}}
            {{$temp = $temp + $data[$i]->rsk_nilai}}
            <tr>
                <td>{{$j+1}}</td>
                <td class="left">{{$data[$i]->rsk_prdcd}}</td>
                <td class="left">{{$data[$i]->prd_deskripsipanjang}}</td>
                <td class="left">{{$data[$i]->satuan}}</td>
                <td class="right">{{$data[$i]->qty}}</td>
                <td class="right">{{$data[$i]->qtyk}}</td>
                <td class="right">{{number_format( $data[$i]->rsk_hrgsatuan ,2,',','.')}}</td>
                <td class="right padding-right">{{number_format( $data[$i]->rsk_nilai ,2,'.',',')}}</td>
                <td class="left">{{$data[$i]->rsk_keterangan}}</td>
            </tr>
        @endfor
        <tr style="padding-top: 50px !important; ">
            <td colspan="7" style="text-align: right; border-bottom : 1px black solid; border-top : 1px black solid">TOTAL :</td>
            <td style="text-align: right; border-bottom: 1px black solid; border-top : 1px black solid">{{number_format( $temp ,2,'.',',')}}</td>
            <td style="text-align: right; border-bottom: 1px black solid; border-top : 1px black solid"> </td>
        </tr>
        </tbody>
    </table>
    <table style="font-size: 12px; margin-top: 20px">
        <tbody>
        <tr>
            <td style="width: 150px">Disetujui</td>
            <td style="width: 120px"> </td>
            <td style="width: 150px">Diperiksa</td>
            <td style="width: 120px"> </td>
            <td style="width: 150px">Dicetak</td>
        </tr>
        @for($i=0; $i<40; $i++)
            <tr><td colspan="5"></td></tr>
        @endfor
        <tr>
            <td style="width: 150px; border-bottom: 1px black solid">{{$data[0]->rap_store_manager}}</td>
            <td style="width: 120px"></td>
            <td style="width: 150px;border-bottom: 1px black solid">{{$data[0]->rap_logistic_supervisor}}</td>
            <td style="width: 120px"></td>
            <td style="width: 150px;border-bottom: 1px black solid">{{$data[0]->rap_administrasi}}</td>
        </tr>
        <tr>
            <td style="width: 150px">Store Manager</td>
            <td style="width: 120px"></td>
            <td style="width: 150px">Logistic Supv./Jr.Supv.</td>
            <td style="width: 120px"></td>
            <td style="width: 150px">Logistic Adm. Clerk</td>
        </tr>
        </tbody>
    </table>
@endsection
