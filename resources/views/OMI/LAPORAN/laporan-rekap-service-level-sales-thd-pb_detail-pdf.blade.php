@extends('html-template')

@section('table_font_size','8px')

@section('page_title')
    LAPORAN SERVICE LEVEL SALES THD PB (DETAIL)
@endsection

@section('title')
    ** LAPORAN SERVICE LEVEL SALES THD PB (DETAIL) **
@endsection

@section('subtitle')
    {{--    Periode :--}}
    {{--    {{ date("d/m/Y") }}--}}
@endsection

@php
    function rupiah($angka){
        //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,0,'.',',');
        return $hasil_rupiah;
        }
@endphp

@section('content')
<table class="table table-bordered table-responsive" style="border-collapse: collapse">
    <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
    <tr>
        <td rowspan="2" style="border-right: 1px solid black">No.</td>
        <td rowspan="2" style="border-right: 1px solid black">Member</td>
        <td rowspan="2" style="border-right: 1px solid black">Cabang</td>
        <td colspan="3" style="text-align: center; border-bottom: 1px solid black; border-right: 1px solid black">-------- R U P I A H --------</td>
        <td colspan="3" style="text-align: center; border-bottom: 1px solid black; border-right: 1px solid black">--- Q U A N T I T Y ---</td>
        <td colspan="3" style="text-align: center; border-bottom: 1px solid black;">------ I T E M ------</td>
    </tr>
    <tr style="text-align: center;">
        <td style="border-right: 1px solid black">PO </td>
        <td style="border-right: 1px solid black">Realisasi </td>
        <td style="border-right: 1px solid black">% </td>

        <td style="border-right: 1px solid black">PO </td>
        <td style="border-right: 1px solid black">Realisasi </td>
        <td style="border-right: 1px solid black">% </td>

        <td style="border-right: 1px solid black">PO </td>
        <td style="border-right: 1px solid black">Realisasi </td>
        <td>% </td>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 0;
        $kode = '';

        $nilo = 0;
        $nilr = 0;

        $qtyo = 0;
        $qtyr = 0;

        $itemo = 0;
        $itemr = 0;
    ?>
    @for($i=0;$i<sizeof($data);$i++)
        <tr>
            @if($kode != $data[$i]->kodemember)
                @if($i!=0)
                    <tr style="font-weight: bold">
                        <td colspan="3" style="border-top: 2px solid black;">TOTAL PER MEMBER</td>
                        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($nilo)}}</td>
                        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($nilr)}}</td>
                        @if($nilo == 0 || $nilr == 0)
                            <td style="text-align: right; border-top: 2px solid black;">0</td>
                        @else
                            <td style="text-align: right; border-top: 2px solid black;">{{round($nilr/$nilo * 100, 2)}}</td>
                        @endif

                        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($qtyo)}}</td>
                        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($qtyr)}}</td>
                        @if($qtyo == 0 || $qtyr == 0)
                            <td style="text-align: right; border-top: 2px solid black;">0</td>
                        @else
                            <td style="text-align: right; border-top: 2px solid black;">{{round($qtyr/$qtyo * 100, 2)}}</td>
                        @endif

                        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($itemo)}}</td>
                        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($itemr)}}</td>
                        @if($itemo == 0 || $itemr == 0)
                            <td style="text-align: right; border-top: 2px solid black;">0</td>
                        @else
                            <td style="text-align: right; border-top: 2px solid black;">{{round($itemr/$itemo * 100, 2)}}</td>
                        @endif
                    </tr>
                    <?php
                    $nilo = 0;
                    $nilr = 0;

                    $qtyo = 0;
                    $qtyr = 0;

                    $itemo = 0;
                    $itemr = 0;
                    ?>
                @endif
                <?php
                $kode = $data[$i]->kodemember;
                $counter++;
                ?>
                <td>{{$counter}}</td>
                <td style="text-align: left">{{$data[$i]->kodemember}} {{$data[$i]->namamember}}</td>
                <td style="text-align: left">{{$data[$i]->pbo_kodeomi}} - {{$data[$i]->tko_namaomi}}</td>
            @else
                <td></td>
                <td></td>
                <td></td>
            @endif
            <td style="text-align: right">{{rupiah($data[$i]->nilaio)}}</td>
            <td style="text-align: right">{{rupiah($data[$i]->nilair)}}</td>
            @if($data[$i]->nilaio == '0' || $data[$i]->nilair == '0')
                <td style="text-align: right">0</td>
            @else
                <td style="text-align: right">{{round((float)($data[$i]->nilair)/(float)($data[$i]->nilaio) * 100, 2)}}</td>
            @endif

            <td style="text-align: right">{{rupiah($data[$i]->qtyo)}}</td>
            <td style="text-align: right">{{rupiah($data[$i]->qtyr)}}</td>
            @if($data[$i]->qtyo == '0' || $data[$i]->qtyr == '0')
                <td style="text-align: right">0</td>
            @else
                <td style="text-align: right">{{round((float)($data[$i]->qtyr)/(float)($data[$i]->qtyo) * 100, 2)}}</td>
            @endif

            <td style="text-align: right">{{rupiah($data[$i]->itemo)}}</td>
            <td style="text-align: right">{{rupiah($data[$i]->itemr)}}</td>
            @if($data[$i]->itemo == '0' || $data[$i]->itemr == '0')
                <td style="text-align: right">0</td>
            @else
                <td style="text-align: right">{{round((float)($data[$i]->itemr)/(float)($data[$i]->itemo) * 100, 2)}}</td>
            @endif
        </tr>
        <?php
            $nilo = $nilo + $data[$i]->nilaio;
            $nilr = $nilr + $data[$i]->nilair;

            $qtyo = $qtyo + $data[$i]->qtyo;
            $qtyr = $qtyr + $data[$i]->qtyr;

            $itemo = $itemo + $data[$i]->itemo;
            $itemr = $itemr + $data[$i]->itemr;
        ?>
    @endfor
    <tr style="font-weight: bold">
        <td colspan="3" style="border-top: 2px solid black;">TOTAL PER MEMBER</td>
        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($nilo)}}</td>
        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($nilr)}}</td>
        @if($nilo == 0 || $nilr == 0)
            <td style="text-align: right; border-top: 2px solid black;">0</td>
        @else
            <td style="text-align: right; border-top: 2px solid black;">{{round($nilr/$nilo * 100, 2)}}</td>
        @endif

        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($qtyo)}}</td>
        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($qtyr)}}</td>
        @if($qtyo == 0 || $qtyr == 0)
            <td style="text-align: right; border-top: 2px solid black;">0</td>
        @else
            <td style="text-align: right; border-top: 2px solid black;">{{round($qtyr/$qtyo * 100, 2)}}</td>
        @endif

        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($itemo)}}</td>
        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($itemr)}}</td>
        @if($itemo == 0 || $itemr == 0)
            <td style="text-align: right; border-top: 2px solid black;">0</td>
        @else
            <td style="text-align: right; border-top: 2px solid black;">{{round($itemr/$itemo * 100, 2)}}</td>
        @endif
    </tr>
    <tr style="font-weight: bold">
        <td colspan="3" style="border-top: 2px solid black;">TOTAL SELURUHNYA</td>
        <td style="text-align: right; border-top: 2px solid black;">&nbsp;&nbsp;{{rupiah($val['tnilo'])}}</td>
        <td style="text-align: right; border-top: 2px solid black;">&nbsp;&nbsp;{{rupiah($val['tnilr'])}}</td>
        <td style="text-align: right; border-top: 2px solid black;">&nbsp;&nbsp;{{$val['totnil']}}</td>

        <td style="text-align: right; border-top: 2px solid black;">&nbsp;&nbsp;{{rupiah($val['tqtyo'])}}</td>
        <td style="text-align: right; border-top: 2px solid black;">&nbsp;&nbsp;{{rupiah($val['tqtyr'])}}</td>
        <td style="text-align: right; border-top: 2px solid black;">&nbsp;&nbsp;{{$val['totqty']}}</td>

        <td style="text-align: right; border-top: 2px solid black;">&nbsp;&nbsp;{{rupiah($val['titemo'])}}</td>
        <td style="text-align: right; border-top: 2px solid black;">&nbsp;&nbsp;{{rupiah($val['titemr'])}}</td>
        <td style="text-align: right; border-top: 2px solid black;">&nbsp;&nbsp;{{$val['totitem']}}</td>
    </tr>
    </tbody>
</table>
@endsection

