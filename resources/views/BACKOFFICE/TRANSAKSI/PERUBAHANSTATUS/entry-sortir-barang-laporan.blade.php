@php
    $noref = "";
    $tgldoc = "";
    if(sizeof($data)>0){
        $noref = $data[0]->srt_nosortir;
        $tgldoc = date('d-M-y', strtotime($data[0]->srt_tglsortir));
    }
    function twoDigit($angka){
        $digit = number_format($angka,2,'.',',');
        return $digit;
    }
@endphp
@extends('html-template')

@section('paper_size','595pt 842pt')
@section('paper_height','830pt')
@section('paper_width','595pt')

@section('table_font_size','7px')

@section('page_title')
    LAPORAN SORTIR BARANG
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
    BUKTI SORTIR BARANG
    <hr>
@endsection

@section('subtitle')
    <span style="float: left !important; text-align: left !important;">
        No. Referensi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;{{$noref}}<br>
        Tanggal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;{{$tgldoc}}
    </span>
@endsection

@section('content')
        <table class="table table-bordered table-responsive">
            <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
                <tr style="text-align: center; vertical-align: center">
                    <th style="width: 40px">PLU</th>
                    <th style="width: 385px !important; text-align: left">DESKRIPSI</th>
                    <th colspan="2" style="width: 60px">SATUAN</th>
                    <th style="width: 55px">QTY</th>
                    <th style="width: 55px">Fr</th>
                    <th style="width: 35px">TAG</th>
                    <th style="width: 25px">PT</th>
                    <th style="width: 55px">RT / TG</th>
                </tr>
            </thead>
            <tbody style="border-bottom: 3px solid black">
                @for($i=0; $i<sizeof($data); $i++)
                    <tr>
                        <td style="width: 40px">{{$data[$i]->srt_prdcd}}</td>
                        <td style="width: 385px !important; text-align: left">{{$data[$i]->prd_deskripsipanjang}}</td>
                        <td style="width: 30px; text-align: right">{{$data[$i]->prd_unit}} /</td>
                        <td style="width: 30px; text-align: left"> {{$data[$i]->prd_frac}}</td>
                        <td style="width: 55px; text-align: center">{{$data[$i]->srt_qtykarton}}</td>
                        <td style="width: 55px; text-align: center">{{$data[$i]->srt_qtypcs}}</td>
                        <td style="width: 35px; text-align: center">{{$data[$i]->prd_kodetag}}</td>
                        <td style="width: 25px; text-align: center">{{$data[$i]->flag_pt}}</td>
                        <td style="width: 55px; text-align: center">{{$data[$i]->flag_rttg}}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
        <hr style="margin-top: 20px; margin-botton: 30px">
            <div style="line-height: 0.1px !important;">
                <label for="keterangan">Keterangan : </label>
                <p id="keterangan">{{$data[0]->srt_keterangan}}</p>
            </div>
        <br>
@endsection
@section('footer',"")
@section('ttd')
        <table style="font-size: 12px; margin-top: 20px">
            <tbody>
            <tr>
                <td style="width: 120px">Dibuat Oleh :</td>
                <td style="width: 25px"> </td>
                <td style="width: 120px">Diserahkan :</td>
                <td style="width: 25px"> </td>
                <td style="width: 120px">Diterima :</td>
                <td style="width: 25px"> </td>
                <td style="width: 120px">Diketahui :</td>
                <td style="width: 25px"> </td>
                <td style="width: 120px">Disetujui Oleh :</td>
            </tr>
            @for($i=0; $i<10; $i++)
                <tr><td colspan="5"></td></tr>
            @endfor
            <tr>
                <td style="width: 120px; border-bottom: 1px black solid"></td>
                <td style="width: 25px"> </td>
                <td style="width: 120px;border-bottom: 1px black solid"></td>
                <td style="width: 25px"> </td>
                <td style="width: 120px;border-bottom: 1px black solid"></td>
                <td style="width: 25px"> </td>
                <td style="width: 120px;border-bottom: 1px black solid"></td>
                <td style="width: 25px"> </td>
                <td style="width: 120px;border-bottom: 1px black solid"></td>
            </tr>
            <tr>
                <td style="width: 120px">Back Office</td>
                <td style="width: 25px"> </td>
                <td style="width: 120px">Ka. Stand</td>
                <td style="width: 25px"> </td>
                <td style="width: 120px">Godown Keeper</td>
                <td style="width: 25px"> </td>
                <td style="width: 120px">Log Spv/Store Spv</td>
                <td style="width: 25px"> </td>
                <td style="width: 120px">Ass. Manager Logistik</td>
            </tr>
            </tbody>
        </table>
        @endsection
