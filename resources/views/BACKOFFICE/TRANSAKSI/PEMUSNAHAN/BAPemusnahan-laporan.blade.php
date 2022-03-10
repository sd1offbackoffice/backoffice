{{----------------------------------------------------------------------------}}
@extends('html-template')

@section('table_font_size','7 px')

@section('paper_height',$ukuran == 'besar' ? '842pt': '442pt')

@section('page_title')
    Berita Acara Pemusnahan Barang Rusak
@endsection

@section('title')
    BERITA ACARA PEMUSNAHAN BARANG RUSAK
@endsection

@section('subtitle')
    No. Reff PPBR : {{$data[0]->brsk_noref}}
@endsection

@section('header_optional')
    <p class="left">
    Pada hari ini, {{\Carbon\Carbon::now()->format('d-m-Y')}}, telah dilaksanakan pemusnahan
    <br> barang rusak di Indogrosir No.Dokumen : {{$data[0]->brsk_nodoc}} yang berlokasi di {{$data[0]->prs_namacabang}}
    <br> Barang rusak yang dimusnahkan merupakan milik :
    </p>
    <p class="center" style="margin-top: -20px">
        {{$data[0]->prs_namaperusahaan}}
        <br style="margin-left: 100px">ALAMAT : {{$data[0]->prs_alamat1}} , {{$data[0]->prs_alamat3}}
        <br>NPWP : {{$data[0]->prs_npwp}}
        @if($data[0]->brsk_flagdoc == 'P')
            <br><strong>REPRINT</strong>
        @endif
    </p>
@endsection


@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">

        <tr>
            <th class="left">NO</th>
            <th class="left">PLU</th>
            <th class="left">DESKRIPSI</th>
            <th class="left">SATUAN</th>
            <th class="right">CTN</th>
            <th class="right">FRAC</th>
            <th class="right">HRG SATUAN</th>
            <th class="right padding-right">TOTAL</th>
            <th class="left">KETERANGAN</th>
        </tr>
        </thead>
        <tbody>
        @php
            $temp = 0;
            $j = 1;
        @endphp
        @foreach($data as $value)
            <tr>
                <td class="left">{{$j++}}</td>
                <td class="left">{{$value->brsk_prdcd}}</td>
                <td class="left">{{$value->prd_deskripsipanjang}}</td>
                <td class="left">{{$value->prd_unit}}/{{$value->prd_frac}}</td>
                <td class="right">{{floor($value->brsk_qty_real/$value->prd_frac)}}</td>
                <td class="right">{{$value->brsk_qty_real%$value->prd_frac}}</td>
                <td class="right">{{number_format( $value->brsk_hrgsatuan ,2,'.',',')}}</td>
                <td class="right padding-right">{{number_format( $value->brsk_nilai ,2,',','.')}}</td>
                <td class="left">{{$value->brsk_keterangan}}</td>
            </tr>
            @php
                $temp = $temp + $value->brsk_nilai;
            @endphp
        @endforeach
        <tr style="padding-top: 50px !important; ">
            <td colspan="7" style="text-align: right; border-bottom : 1px black solid; border-top : 1px black solid">TOTAL :</td>
            <td style="text-align: right; border-bottom: 1px black solid; border-top : 1px black solid">{{number_format( $temp ,2,',','.')}}</td>
            <td style="text-align: right; border-bottom: 1px black solid; border-top : 1px black solid"> </td>
        </tr>
        </tbody>
    </table>
    <table style="font-size: 10px; margin-top: 20px">
        <tbody>
        <tr>
            <td style="width: 140px">Mengetahui</td>
            <td style="width: 10px"></td>
            <td style="width: 140px">Disaksikan</td>
            <td style="width: 10px"></td>
            <td style="width: 140px"></td>
            <td style="width: 10px"></td>
            <td style="width: 140px">Dilaksanakan</td>
            <td style="width: 10px"></td>
            <td style="width: 140px">Saksi</td>
        </tr>
        @for($i=0; $i<15; $i++)
            <tr><td colspan="5"></td></tr>
        @endfor
        <tr>
            <td style="width: 140px; border-bottom: 1px black solid">{{$data[0]->rap_store_manager}}</td>
            <td style="width: 10px"></td>
            <td style="width: 140px; border-bottom: 1px black solid">{{$data[0]->rap_store_adm}}</td>
            <td style="width: 10px"></td>
            <td style="width: 140px; border-bottom: 1px black solid">{{$data[0]->rap_logistic_supervisor}}</td>
            <td style="width: 10px"></td>
            <td style="width: 140px; border-bottom: 1px black solid">{{$data[0]->rap_stockkeeper_ii}}</td>
            <td style="width: 10px"></td>
            <td style="width: 140px; border-bottom: 1px black solid"></td>
        </tr>
        <tr>
            <td style="width: 140px;">Store Manager</td>
            <td style="width: 10px"></td>
            <td style="width: 140px">Store Adm.Mgr/Logistic Mg</td>
            <td style="width: 10px"></td>
            <td style="width: 140px">Logistic Supervisor</td>
            <td style="width: 10px"></td>
            <td style="width: 140px">Stock Keeper-II</td>
            <td style="width: 10px"></td>
            <td style="width: 140px">Ketua RT</td>
        </tr>
        </tbody>
    </table>
@endsection
