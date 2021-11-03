@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN-REKAP STRUK PER / KASIR
@endsection

@section('title')
    ** REKAP STRUK REFUND KASIR **
@endsection

@section('subtitle')
    Tanggal : {{$date1}} s/d {{$date2}}
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
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr>
                <th style="width: 110px; text-align: left">Tgl. Refund</th>
                <th style="width: 50px; text-align: left">Kasir</th>
                <th style="width: 210px;">&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="width: 100px; text-align: left">No. TRN</th>
                <th style="width: 110px; text-align: left">Tgl. Transaksi</th>
                <th style="width: 150px; text-align: right">Nilai</th>
            </tr>
        </thead>
        <?php
        $theDate = '';
        $cashier = '';
        $countKasir = 0;
        $countTotal = 0;
        ?>
        <tbody style="border-bottom: 2px solid black;">
        @for($i=0;$i<sizeof($data);$i++)
            <?php
            $createDate = new DateTime($val['tgl_refund'][$i]);
            $strip = $createDate->format('d-m-Y');
            $createDate = new DateTime($val['tgl_trn'][$i]);
            $strip2 = $createDate->format('d-m-Y');
            ?>
            @if($theDate != $strip)
                <?php
                $cashier = '';
                ?>
            @endif
            @if($i!=0 && $cashier != $val['cashierid'][$i])
                <tr style="font-weight: bold">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: left;" colspan="4">Total Kasir : </td>
                    <td style="text-align: right; border-top: 1px solid black;">{{rupiah($countKasir)}}</td>
                </tr>
            @endif
            <tr>
                @if($theDate != $strip)
                    <?php
                    $theDate = $strip;
                    ?>
                        <td style="text-align: left">{{$strip}}</td>
                @else
                    <td style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                @endif
                @if($cashier != $val['cashierid'][$i])
                    <?php
                    $countKasir = 0;
                    $cashier = $val['cashierid'][$i];
                    ?>
                        <td style="text-align: right">{{$cashier}}</td>
                        <td style="text-align: left">- {{$val['cashiername'][$i]}}</td>
                @else
                    <td style="text-align: right">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                @endif
                <td style="text-align: left">{{$val['no_trn'][$i]}}</td>
                <td style="text-align: left">{{$strip2}}</td>
                <td style="text-align: right">{{rupiah($val['nilai'][$i])}}</td>
                <?php
                $countKasir = $countKasir + ($val['nilai'][$i]);
                $countTotal = $countTotal + ($val['nilai'][$i]);
                ?>
            </tr>

        @endfor
        <tr style="font-weight: bold">
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td style="text-align: left;" colspan="4">Total Kasir : </td>
            <td style="border-top: 1px solid black; text-align: right">{{rupiah($countKasir)}}</td>
        </tr>
        <tr style="font-weight: bold">
            <td style="border-top: 2px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td style="border-top: 2px solid black; text-align: left;" colspan="4">Total Seluruhnya : </td>
            <td style="border-top: 2px solid black; text-align: right">{{rupiah($countTotal)}}</td>
        </tr>
        </tbody>
    </table>
@endsection
