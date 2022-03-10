@extends('html-template')

@section('table_font_size','7 px')

@section('paper_height','595pt')
@section('paper_width','1200pt')

@section('page_title')
    DAFTAR ANGGOTA / MEMBER
@endsection

@section('title')
    ** DAFTAR ANGGOTA / MEMBER **
@endsection

@section('subtitle')
    {{$urut}}
@endsection

@php
    function zeroDigit($angka){
        $digit = number_format($angka,0,'.',',');
        return $digit;
    }
    $counter = 0;
    $counterOutlet = 0;
    $counterArea = 0;
    $outlet = '';
    $suboutlet = '';
    $area = '';
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
                <th style="vertical-align: middle; text-align: left">JENIS<br>CUSTOMER&nbsp;&nbsp;&nbsp;&nbsp;</th>
            </tr>
        </thead>
        <tbody style="text-align: center; vertical-align: middle">
        @for($i=0;$i<sizeof($data);$i++)
            @if($sort == 1 || $sort == 2 || $sort == 5 || $sort == 6)
                @if(($area != $data[$i]->area1 && $i != 0) || $outlet != $data[$i]->outlet && $i != 0)
                    <tr style="text-align: left; font-weight: bold">
                        <td colspan="12" style="border-bottom: 1px solid black">SUBTOTAL AREA : {{$counterArea}}</td>
                    </tr>
                    <?php $counterArea = 0; ?>
                @endif
            @endif
            @if($sort == 1 || $sort == 2 || $sort == 3 || $sort == 4)
                @if($outlet != $data[$i]->outlet && $i != 0)
                    <tr style="text-align: left; font-weight: bold">
                        <td colspan="12" style="border-bottom: 1px solid black">SUBTOTAL OUTLET : {{$counterOutlet}}</td>
                    </tr>
                    <?php $counterOutlet = 0; ?>
                @endif
            @endif

            @if($sort == 1 || $sort == 2 || $sort == 3 || $sort == 4)
                @if($outlet != $data[$i]->outlet)
                    <tr style="text-align: left; font-weight: bold">
                        <td colspan="12">OUTLET : {{$data[$i]->outlet}}</td>
                    </tr>
                @endif
            @endif
            @if($sort == 1 || $sort == 2 || $sort == 3 || $sort == 4)
                @if($suboutlet != $data[$i]->suboutlet)
                    <tr style="text-align: left; font-weight: bold">
                        <td colspan="12">SUB OUTLET : {{$data[$i]->suboutlet}}</td>
                    </tr>
                @endif
            @endif
            @if($sort == 1 || $sort == 2 || $sort == 5 || $sort == 6)
                @if($area != $data[$i]->area1 || $suboutlet != $data[$i]->suboutlet)
                    <tr style="text-align: left; font-weight: bold">
                        <td colspan="12">AREA : {{$data[$i]->area1}} - {{$p_area[$i]}}</td>
                    </tr>
                @endif
            @endif
            <tr>
                <td style="text-align: left">{{$data[$i]->kd}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->kartu}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->cus_namamember}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->alamat}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->telp}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->pkp}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->cus_npwp}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{zeroDigit($data[$i]->cus_creditlimit)}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->top}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->area2}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->kodeoutlet}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->cus_jenismember}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
            @php
                $outlet = $data[$i]->outlet;
                $suboutlet = $data[$i]->suboutlet;
                $area = $data[$i]->area1;
                $counter++;
                $counterOutlet++;
                $counterArea++;
            @endphp
        @endfor

        @if($sort == 1 || $sort == 2 || $sort == 5 || $sort == 6)
                    <tr style="text-align: left; font-weight: bold">
                        <td colspan="12" style="border-bottom: 1px solid black">SUBTOTAL AREA : {{$counterArea}}</td>
                    </tr>
        @endif
        @if($sort == 1 || $sort == 2 || $sort == 3 || $sort == 4)
                    <tr style="text-align: left; font-weight: bold">
                        <td colspan="12" style="border-bottom: 1px solid black">SUBTOTAL OUTLET : {{$counterOutlet}}</td>
                    </tr>
        @endif
        </tbody>
    </table>
    <p style="font-weight: bold">TOTAL&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$counter}} PELANGGAN</p>
@endsection
