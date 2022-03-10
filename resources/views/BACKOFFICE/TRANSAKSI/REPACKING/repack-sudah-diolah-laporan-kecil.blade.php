@php
    $nbp = "";
    $tgldoc = "";
    $noref = "";

    $cs_total = 0;
    if(sizeof($data)>0){
        $nbp = $data[0]->msth_nodoc;
        $tgldoc = $data[0]->msth_tgldoc;
        $noref = $data[0]->msth_nopo;
    }
    function twoDigit($angka){
        $digit = number_format($angka,2,'.',',');
        return $digit;
    }
@endphp
@extends('html-template')

@section('paper_height','442pt')
@section('paper_width','595pt')

@section('table_font_size','7px')

@section('page_title')
    LAPORAN-REPACK-BIASA
@endsection

@section('header_left')
    <p>{{ $perusahaan->prs_alamat1 }}</p>
    <p>{{ $perusahaan->prs_namawilayah }}</p>
@endsection
@section('header_right')
    <p>NPWP : {{ $perusahaan->prs_npwp }}</p>
    <p>TELP : {{ $perusahaan->prs_telepon }}</p>
@endsection

@section('title')
    <br><br><br>
    NOTA BARANG PREPACKING
@endsection

@section('subtitle')
    <span>
        ### BARANG SUDAH DIOLAH ###
    </span>
    <br>
    <span style="float: left !important; text-align: left !important;">
        <br>
        &nbsp;&nbsp;&nbsp;&nbsp;{{$RePrint}}&nbsp;&nbsp;&nbsp;&nbsp;
    </span>
    <span style="float: left !important; text-align: left !important;">
        No. NBP : {{$nbp}}<br>
        Tanggal : {{$tgldoc}}
    </span>
    <span style="float: right !important; text-align: left !important;">
        No. Referensi : {{$noref}}
    </span>
@endsection


@section('content')

    <table class="table table-bordered table-responsive">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
        <tr style="text-align: right; vertical-align: middle">
            <th style="width: 40px; text-align: left">PLU</th>
            <th style="width: 255px !important; text-align: left">DESKRIPSI</th>
            <th style="width: 60px">SATUAN</th>
            <th style="width: 50px">QTY</th>
            <th style="width: 50px">Fr</th>
            <th style="width: 35px">PPN</th>
            <th style="width: 50px">HARGA SAT</th>
            <th style="width: 50px">PPN BM</th>
            <th style="width: 50px">BOTOL</th>
            <th style="width: 50px">JUMLAH</th>
        </tr>
        </thead>
        <tbody style="border-bottom: 2px solid black">
        @for($i=0; $i<sizeof($data); $i++)
            @if($data[$i]->judul == "### BARANG SUDAH DIOLAH ###")
                <tr style="text-align: right">
                    <td style="width: 40px; text-align: left">{{$data[$i]->mstd_prdcd}}</td>
                    <td style="width: 255px !important; text-align: left">{{$data[$i]->prd_deskripsipanjang}}</td>
                    <td style="width: 60px;">{{$data[$i]->mstd_unit}} / {{$data[$i]->mstd_frac}}</td>
                    <td style="width: 50px;">{{$data[$i]->ctn}}</td>
                    <td style="width: 50px;">{{$data[$i]->pcs}}</td>
                    <td style="width: 35px;">{{$data[$i]->mstd_ppnrph}}</td>
                    <td style="width: 50px;">{{twoDigit($data[$i]->mstd_hrgsatuan)}}</td>
                    <td style="width: 50px;">{{$data[$i]->mstd_ppnbmrph}}</td>
                    <td style="width: 50px;">{{$data[$i]->mstd_ppnbtlrph}}</td>
                    <td style="width: 50px;">{{twoDigit($data[$i]->total)}}</td>
                </tr>
                @php
                    $cs_total = $cs_total + $data[$i]->total
                @endphp
            @endif
        @endfor
            <tr>
                <td colspan="9" style="border-top: 2px solid black"></td>
                <td style="border-top: 2px solid black; text-align: right">TOTAL : {{$cs_total}}</td>
            </tr>
        </tbody>
    </table>
{{--    <hr>--}}
{{--    <p style="margin-left: 650px;margin-top: -8px;margin-bottom: 2px"></p>--}}
    <hr>
    <p style="text-align: left">KETERANGAN : {{$data[0]->msth_keterangan_header}}</p>
@endsection
@section('ttd')
    <table style="font-size: 12px; margin-top: 20px">
        <tbody>
        <tr>
            <td style="width: 50px"> </td>
            <td style="width: 120px">Dibuat Oleh :</td>
            <td style="width: 110px"> </td>
            <td style="width: 120px">Diketahui :</td>
            <td style="width: 110px"> </td>
            <td style="width: 120px">Disetujui Oleh :</td>
        </tr>
        @for($i=0; $i<10; $i++)
            <tr><td colspan="5"></td></tr>
        @endfor
        <tr>
            <td style="width: 50px"> </td>
            <td style="width: 120px; border-bottom: 1px black solid"></td>
            <td style="width: 110px"> </td>
            <td style="width: 120px;border-bottom: 1px black solid"></td>
            <td style="width: 110px"> </td>
            <td style="width: 120px;border-bottom: 1px black solid"></td>
        </tr>
        <tr>
            <td style="width: 50px"> </td>
            <td style="width: 120px">Back Office</td>
            <td style="width: 110px"> </td>
            <td style="width: 120px">Ka.Adm.Logistik</td>
            <td style="width: 110px"> </td>
            <td style="width: 120px">Ass Manager Logistik</td>
        </tr>
        </tbody>
    </table>
@endsection
