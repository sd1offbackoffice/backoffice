@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    TRANSAKSI SALES VOUCHER
@endsection

@section('title')
    LAPORAN DETAIL TRANSAKSI SALES VOUCHER
@endsection

@section('subtitle')
    {{$periode}}
@endsection

@php
    //rupiah formatter (no Rp or .00)
    function rupiah($angka){
        //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,0,'.',',');
        return $hasil_rupiah;
    }
@endphp
@section('content')
    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black; text-align: center">
            <tr style="text-align: center; vertical-align: center">
                <th rowspan="2" style="width: 80px; border-right: 1px solid black; border-bottom: 1px solid black;">TANGGAL</th>
                <th rowspan="2" style="width: 70px; border-right: 1px solid black; border-bottom: 1px solid black">DESKRIPSI</th>
                <th colspan="5" style="width: 360px; border-right: 1px solid black; border-left: 1px solid black;">QTY</th>
                <th rowspan="2" style="width: 65px; border-right: 1px solid black; border-left: 1px solid black;">TOTAL</th>
                <th rowspan="2" style="width: 55px; border-right: 1px solid black; border-left: 1px solid black;">GIFT<br>VCR</th>
                <th rowspan="2" style="width: 65px; border-left: 1px solid black;">JUMLAH</th>
            </tr>
            <tr>
                <th style="border: 1px solid black;">PLATINUM</th>
                <th style="border: 1px solid black;">GOLD</th>
                <th style="border: 1px solid black;">SILVER</th>
                <th style="border: 1px solid black;">REGULER</th>
                <th style="border: 1px solid black;">BIRU</th>
            </tr>
        </thead>
        <tbody style="border-bottom: 2px solid black; text-align: right">
        @for($i=0;$i<sizeof($data);$i++)
            <?php
            $date = ($data[$i]->trndate);
            $createDate = new DateTime($date);
            $strip = $createDate->format('d-m-Y');
            ?>
            <tr>
                <td style="text-align: center">{{$strip}}</td>
                <td style="text-align: left">{{$data[$i]->kodevoucher}}</td>
                <td>{{rupiah($data[$i]->platinum)}}</td>
                <td>{{rupiah($data[$i]->gold)}}</td>
                <td>{{rupiah($data[$i]->silver)}}</td>
                <td>{{rupiah($data[$i]->reguler)}}</td>
                <td>{{rupiah($data[$i]->biru)}}</td>
                <td>{{rupiah(($data[$i]->platinum)+($data[$i]->gold)+($data[$i]->silver)+($data[$i]->reguler)+($data[$i]->biru))}}</td>
                <td>{{rupiah($data[$i]->gift_vcr)}}</td>
                <td>{{rupiah(($data[$i]->platinum)+($data[$i]->gold)+($data[$i]->silver)+($data[$i]->reguler)+($data[$i]->biru)+($data[$i]->gift_vcr))}}</td>
            </tr>
        @endfor
        <tr style="font-weight: bold">
            <td colspan="2" style="text-align: center; border-top: 1px black solid">TOTAL :</td>
            <td style="border-top: 1px solid black;">{{rupiah($val['platinum'])}}</td>
            <td style="border-top: 1px solid black;">{{rupiah($val['gold'])}}</td>
            <td style="border-top: 1px solid black;">{{rupiah($val['silver'])}}</td>
            <td style="border-top: 1px solid black;">{{rupiah($val['reguler'])}}</td>
            <td style="border-top: 1px solid black;">{{rupiah($val['biru'])}}</td>
            <td style="border-top: 1px solid black;">{{rupiah($val['platinum']+$val['gold']+$val['silver']+$val['reguler']+$val['biru'])}}</td>
            <td style="border-top: 1px solid black;">{{rupiah($val['gift_vcr'])}}</td>
            <td style="border-top: 1px solid black;">{{rupiah($val['platinum']+$val['gold']+$val['silver']+$val['reguler']+$val['biru']+$val['gift_vcr'])}}</td>
        </tr>
        </tbody>
    </table>
@endsection
