@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN-REKAP STRUK PER / KASIR
@endsection

@section('title')
    ** REKAP STRUK PER / KASIR **
@endsection

@section('subtitle')
    Transaksi : Sales
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
                <th style="width: 8%; border-right: 1px solid black; border-bottom: 1px solid black;">TANGGAL</th>
                <th style="width: 5%; border-right: 1px solid black; border-bottom: 1px solid black;">STT</th>
                <th style="width: 30%; border-right: 1px solid black; border-bottom: 1px solid black;">-----KASIR-----</th>
                <th style="width: 12%; border-bottom: 1px solid black;">STRUK</th>
                <th style="width: 12%; border-right: 1px solid black; border-bottom: 1px solid black;">TOTAL</th>
                <th style="width: 12%; border-bottom: 1px solid black;">STRUK</th>
                <th style="width: 12%; border-right: 1px solid black; border-bottom: 1px solid black;">TOTAL</th>
                <th style="width: 12%; border-bottom: 1px solid black;">STRUK</th>
                <th style="width: 12%; border-bottom: 1px solid black;">TOTAL</th>
            </tr>
        </thead>
        <?php
        $theDate = '';
        $cashier = '';
        $countKasir = 0;
        $countTotal = 0;
        ?>
        <tbody style="border-bottom: 2px solid black; text-align: right">
        @for($i=0;$i<sizeof($data);$i = $i + 3)
            <?php
            $createDate = new DateTime($data[$i]->jh_transactiondate);
            $strip = $createDate->format('d-m-Y');
            ?>
            @if($i!=0 && $cashier != $data[$i]->jh_cashier)
                <tr style="font-weight: bold">
                    <td style="border-bottom: 1px solid black" colspan="5">Total Per Kasir : </td>
                    <td style="border-bottom: 1px solid black" colspan="4">{{rupiah($countKasir)}}</td>
                </tr>
            @endif
            <tr>
                @if($theDate != $strip)
                    <?php
                    $theDate = $strip
                    ?>
                        <td style="text-align: center">{{$strip}}</td>
                @else
                    <td style="text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                @endif
                @if($cashier != $data[$i]->jh_cashier)
                    <?php
                    $countKasir = 0;
                    $cashier = $data[$i]->jh_cashier
                    ?>
                        <td style="text-align: center">{{$data[$i]->jh_cashierstation}}</td>
                        <td style="text-align: left">{{$cashier}}</td>
                @else
                    <td style="text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                @endif
                <td style="text-align: center">{{$data[$i]->jh_transactionno}}</td>
                <td>{{rupiah($data[$i]->jh_transactionamt)}}</td>
                    <?php
                    $countKasir = $countKasir + ($data[$i]->jh_transactionamt);
                    $countTotal = $countTotal + ($data[$i]->jh_transactionamt);
                    ?>
                @if($i+1 < sizeof($data))
                    @if($cashier == $data[$i+1]->jh_cashier)
                        <td style="text-align: center">{{$data[$i+1]->jh_transactionno}}</td>
                        <td>{{rupiah($data[$i+1]->jh_transactionamt)}}</td>
                        <?php
                        $countKasir = $countKasir + ($data[$i+1]->jh_transactionamt);
                        $countTotal = $countTotal + ($data[$i+1]->jh_transactionamt);
                        ?>
                    @else
                        <?php $i--;//$i dikurangi 1,?>
                        <td style="text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    @endif
                @endif
                @if($i+2 < sizeof($data))
                    @if($cashier == $data[$i+2]->jh_cashier)
                        <td style="text-align: center">{{$data[$i+2]->jh_transactionno}}</td>
                        <td>{{rupiah($data[$i+2]->jh_transactionamt)}}</td>
                        <?php
                        $countKasir = $countKasir + ($data[$i+2]->jh_transactionamt);
                        $countTotal = $countTotal + ($data[$i+2]->jh_transactionamt);
                        ?>
                    @else
                        <?php $i--; //karena $i sudah dikurangi 1 sebelumnya maka, $i+2 akan terasa menjadi $i+1, $i+1 != data tidak ada, maka $i+2 juga tidak ada data?>
                        <td style="text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    @endif
                @endif
            </tr>

        @endfor
        <tr style="font-weight: bold">
            <td style="border-bottom: 1px solid black" colspan="5">Total Per Kasir : </td>
            <td style="border-bottom: 1px solid black" colspan="4">{{rupiah($countKasir)}}</td>
        </tr>
        <tr style="font-weight: bold">
            <td style="border-bottom: 1px solid black" colspan="5">Total Per Seluruhnya : </td>
            <td style="border-bottom: 1px solid black" colspan="4">{{rupiah($countTotal)}}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <p style="float: left">Khusus Member OMI Nilai Total Rupiah Telah Termasuk Distribution Fee ...</p>

@endsection
