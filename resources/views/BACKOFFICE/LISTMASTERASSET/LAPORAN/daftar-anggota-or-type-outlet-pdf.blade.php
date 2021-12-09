@extends('html-template')

@section('table_font_size','7 px')

@section('paper_size','1200pt 595pt')
@section('paper_height','595pt')
@section('paper_width','1200pt')

@section('page_title')
    DAFTAR ANGGOTA / MEMBER
@endsection

@section('title')
    ** DAFTAR ANGGOTA / MEMBER **
@endsection

@section('subtitle')
@endsection

@php
    function zeroDigit($angka){
        $digit = number_format($angka,0,'.',',');
        return $digit;
    }
    $counter = 0;
    $counterOutlet = 0;
    $outlet = '';
@endphp
@section('content')

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr>
                <th style="vertical-align: middle; text-align: left">KODE&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">NOMOR KARTU&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">NAMA PELANGGAN&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">ALAMAT&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">NO. TELP&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">PKP&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">N.P.W.P&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">KREDIT LIMIT&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">TERM&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">AREA&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">OUTLET&nbsp;&nbsp;&nbsp;&nbsp;</th>
            </tr>
        </thead>
        <tbody style="text-align: center; vertical-align: middle">
        @for($i=0;$i<sizeof($data);$i++)
            @if($outlet != $data[$i]->outlet && $i != 0)
                <tr style="text-align: left; font-weight: bold">
                    <td colspan="11" style="border-bottom: 1px solid black">SUBTOTAL OUTLET : {{$counterOutlet}}</td>
                </tr>
                <?php $counterOutlet = 0; ?>
            @endif
            @if($outlet != $data[$i]->outlet)
                <tr style="text-align: left; font-weight: bold">
                    <td colspan="11">OUTLET : {{$data[$i]->outlet}}</td>
                </tr>
            @endif
            <tr>
                <td style="text-align: left">{{$data[$i]->kd}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->cus_nokartumember}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->cus_namamember}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->alamat}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->cus_tlpmember}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->cus_flagpkp}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->cus_npwp}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{zeroDigit($data[$i]->cus_creditlimit)}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->cus_top}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->cus_kodearea}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->cus_kodeoutlet}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
            @php
                $outlet = $data[$i]->outlet;
                $counter++;
                $counterOutlet++;
            @endphp
        @endfor
            <tr style="text-align: left; font-weight: bold">
                <td colspan="11" style="border-bottom: 1px solid black">SUBTOTAL OUTLET : {{$counterOutlet}}</td>
            </tr>
        </tbody>
    </table>
    <p style="font-weight: bold">TOTAL&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$counter}} PELANGGAN</p>
@endsection
