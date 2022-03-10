@php
    $judul = "";
    $label = "";
    $nodoc = "";
    $tgldoc = "";
    $noref = "";
    $nosortir = "";
    for($i=0; $i<sizeof($data); $i++){
        if($data[$i]->label == "No. NB-Retur"){
            $judul = $data[$i]->judul;
            $label = $data[$i]->label;
            $nodoc = $data[$i]->msth_nodoc;
            $tgldoc = date('d-M-y', strtotime($data[$i]->msth_tgldoc));
            $noref = $data[$i]->msth_nopo;
            $nosortir = $data[$i]->msth_nofaktur;
            break;
        }
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
    LAPORAN RUBAH STATUS
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
    {{$judul}}
    <hr>
@endsection

@section('subtitle')
    <span style="float: left !important; text-align: left !important;">
        {{$label}} : {{$nodoc}}<br>
        Tanggal : {{$tgldoc}}
    </span>
    <span style="float: right !important; text-align: left !important;">
        No. Referensi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;{{$noref}}<br>
        No. Sortir&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;{{$nosortir}}
    </span>
@endsection

@section('content')
    <table class="table table-bordered table-responsive">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
        <tr style="text-align: left; vertical-align: middle">
            <th style="width: 40px">PLU</th>
            <th style="width: 385px !important; text-align: left">DESKRIPSI</th>
            <th style="width: 60px">SATUAN</th>
            <th style="width: 55px">QTY</th>
            <th style="width: 55px">Fr</th>
            <th style="text-align: right; width: 35px">Hrg Satuan</th>
            <th style="text-align: right; width: 55px">Total</th>
        </tr>
        </thead>
        <tbody style="border-bottom: 2px solid black">
        @php
            $subTotal = 0
        @endphp
        @for($i=0; $i<sizeof($data); $i++)
            @if($data[$i]->label == "No. NB-Retur")
                <tr style="text-align: left">
                    <td style="width: 40px">{{$data[$i]->mstd_prdcd}}</td>
                    <td style="width: 385px !important;">{{$data[$i]->prd_deskripsipanjang}}</td>
                    <td style="width: 60px;">{{$data[$i]->mstd_unit}} / {{$data[$i]->mstd_frac}}</td>
                    <td style="width: 55px;">{{$data[$i]->ctn}}</td>
                    <td style="width: 55px;">{{$data[$i]->pcs}}</td>
                    <td style="width: 35px; text-align: right">{{twoDigit($data[$i]->mstd_hrgsatuan)}}</td>
                    <td style="width: 55px; text-align: right">{{twoDigit($data[$i]->total)}}</td>
                    @php
                        $subTotal = $subTotal + $data[$i]->total
                    @endphp
                </tr>
                <tr style="text-align: left">
                    @if($i+1!=sizeof($data))
                        <td style="width: 40px; border-bottom: gray 1px solid">{{$data[$i]->hgb_kodesupplier}}</td>
                        <td style="width: 385px !important; border-bottom: gray 1px solid">{{$data[$i]->sup_namasupplier}}</td>
                    @else
                        <td style="width: 40px;">{{$data[$i]->hgb_kodesupplier}}</td>
                        <td style="width: 385px !important;">{{$data[$i]->sup_namasupplier}}</td>
                    @endif
                    <td style="width: 60px;"></td>
                    <td style="width: 55px;"></td>
                    <td style="width: 55px;"></td>
                    <td style="width: 35px; text-align: right"></td>
                    <td style="width: 55px; text-align: right"></td>
                </tr>
            @endif
        @endfor
        </tbody>
    </table>
    <div style="line-height: 0.1px !important; margin-top: 3px; display: inline-block; margin-left: 635px">
        <label for="subTotal"><span style="font-weight: bold">TOTAL</span> : </label>
        <span id="subTotal">{{twoDigit($subTotal)}}</span>
    </div>
    <hr style="margin-top: 20px; margin-botton: 30px">
    <div style="line-height: 0.1px !important;">
        <p>Keterangan : {{$data[0]->msth_keterangan_header}}</p>
    </div>
    <br>
@endsection
@section('footer',"")
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


