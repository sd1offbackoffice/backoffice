@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    FORM USULAN HARGA JUAL KHUSUS ( NAIK / TURUN )
@endsection

@section('title')
    FORM USULAN HARGA JUAL KHUSUS ( NAIK / TURUN )
@endsection

@section('subtitle')
    Periode : {{$date1}} s/d {{$date2}}
@endsection

@php
    //rupiah formatter (no Rp or .00)
    function rupiah($angka){
    //    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
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
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr style="text-align: center; vertical-align: center">
                <th rowspan="3" width="20px" style="text-align: center; vertical-align: middle; border-right: 1px solid black">No.</th>
                <th rowspan="3" width="40px" style="text-align: center; vertical-align: middle; border-right: 1px solid black">PLU</th>
                <th rowspan="3" width="150px" style="text-align: center; vertical-align: middle; border-right: 1px solid black">DESKRIPSI</th>
                <th rowspan="3" width="20px" style="text-align: center; vertical-align: middle; border-right: 1px solid black">QTY</th>
                <th rowspan="3" width="30px" style="text-align: center; vertical-align: middle; border-right: 1px solid black">SATUAN</th>
                <th colspan="4" style="border-right: 1px solid black">Rp.</th>
                <th colspan="3">% Margin</th>
            </tr>
            <tr style="text-align: center; vertical-align: center">
                <th colspan="2" style="border-right: 1px solid black; border-top: 1px solid black">HPP (Include PPN)</th>
                <th colspan="2" style="border-right: 1px solid black; border-top: 1px solid black">Harga Jual</th>
                <th rowspan="2" width="60px" style="text-align: center; vertical-align: middle; border-right: 1px solid black; border-top: 1px solid black">Normal</th>
                <th colspan="2" style="border-top: 1px solid black">Usulan</th>
            </tr>
            <tr style="text-align: center; vertical-align: center">
                <th width="60px" style="border-right: 1px solid black; border-top: 1px solid black">Last Cost</th>
                <th width="60px" style="border-right: 1px solid black; border-top: 1px solid black">Avg Cost</th>
                <th width="60px" style="border-right: 1px solid black; border-top: 1px solid black">Normal</th>
                <th width="60px" style="border-right: 1px solid black; border-top: 1px solid black">Usulan</th>
                <th width="60px" style="border-right: 1px solid black; border-top: 1px solid black">Last Cost</th>
                <th width="60px" style="border-top: 1px solid black">Avg Cost</th>
            </tr>
        </thead>
        <tbody style="border-bottom: 1px solid black">
        @for($i=1;$i<sizeof($data);$i++)
            <tr style="text-align: center; vertical-align: center">
                <td>{{$i}}</td>
                <td>{{$data[$i]['plu']}}</td>
                <td style="text-align: left">{{$data[$i]['deskripsi']}}</td>
                <td>{{$data[$i]['qty']}}</td>
                <td>{{$data[$i]['satuan']}}</td>
                <td style="text-align: right">{{rupiah($data[$i]['lcost'])}}</td>
                <td style="text-align: right">{{rupiah($data[$i]['avgcost'])}}</td>
                <td style="text-align: right">{{rupiah($data[$i]['normal'])}}</td>
                <td style="text-align: right">{{rupiah($data[$i]['usulan'])}}</td>
                <td>{{percent($data[$i]['normalmargin'])}}</td>
                <td>{{percent($data[$i]['lcostmargin'])}}</td>
                <td>{{percent($data[$i]['avgcostmargin'])}}</td>
            </tr>
        @endfor
        </tbody>
    </table>
    <br>
    <table style="width: 100%; font-weight: bold" class="table-ttd page-break-avoid">
        <tr>
            <td>Diproses :</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>Disetujui :</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>Disetujui :</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>Dibuat :</td>
        </tr>
        <tr class="blank-row">
            <td colspan="7">.</td>
        </tr>
        <tr>
            <td class="line">Merchandising Support Mgr.</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td class="line">Merchandising Sr. Mgr.</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td class="line">Merchandising Mgr.</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td class="line">Store Mgr. / Store Jr. Mgr.</td>
        </tr>
        <tr>
            <td colspan="7">*Qty. hasil deal dengan Member tertentu &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; KETERANGAN  : berlaku untuk satuan jual karton dan pcs.</td>
        </tr>
    </table>
    <style>
        .line{
            border-top: 1px solid black;
        }
    </style>
{{--    <table style="font-size: 12px; margin-top: 20px">--}}
{{--        <tbody>--}}
{{--        <tr>--}}
{{--            <td style="width: 50px"> </td>--}}
{{--            <td style="width: 120px">Diproses :</td>--}}
{{--            <td style="width: 20px"> </td>--}}
{{--            <td style="width: 120px">Disetujui :</td>--}}
{{--            <td style="width: 20px"> </td>--}}
{{--            <td style="width: 120px">Disetujui :</td>--}}
{{--            <td style="width: 20px"> </td>--}}
{{--            <td style="width: 120px">Dibuat :</td>--}}
{{--        </tr>--}}
{{--        @for($i=0; $i<3; $i++)--}}
{{--            <tr><td colspan="5">&nbsp;</td></tr>--}}
{{--        @endfor--}}
{{--        <tr>--}}
{{--            <td> </td>--}}
{{--            <td style="border-bottom: 1px black solid"></td>--}}
{{--            <td> </td>--}}
{{--            <td style="border-bottom: 1px black solid"></td>--}}
{{--            <td> </td>--}}
{{--            <td style="border-bottom: 1px black solid"></td>--}}
{{--            <td> </td>--}}
{{--            <td style="border-bottom: 1px black solid"></td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td> </td>--}}
{{--            <td>Merchandising Support Mgr.</td>--}}
{{--            <td> </td>--}}
{{--            <td>Merchandising Sr. Mgr.</td>--}}
{{--            <td> </td>--}}
{{--            <td>Merchandising Mgr.</td>--}}
{{--            <td> </td>--}}
{{--            <td>Store Mgr. / Store Jr. Mgr.</td>--}}
{{--        </tr>--}}
{{--        </tbody>--}}
{{--    </table>--}}

@endsection
