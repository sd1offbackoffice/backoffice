@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN CASH BACK / EVENT / ITEM
@endsection

@section('title')
    ** LAPORAN CASH BACK PER EVENT PROMOSI PER ITEM **
@endsection

@section('subtitle')
    Tanggal: {{$date1}} s/d {{$date2}}
@endsection

@php
    //rupiah formatter (no Rp or .00)
    function rupiah($angka){
        $hasil_rupiah = number_format($angka,0,'.',',');
        return $hasil_rupiah;
    }
@endphp
@section('content')

    <table class="table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr style="text-align: center; vertical-align: center">
                <th rowspan="2" style="width: 70px; border-right: 1px solid black; border-bottom: 1px solid black">Kd PLU</th>
                <th rowspan="2" style="width: 380px; border-right: 1px solid black; border-bottom: 1px solid black; text-align: left">Deskripsi</th>
                <th rowspan="2" style="width: 70px; border-right: 1px solid black; border-bottom: 1px solid black">Supplier</th>
                <th rowspan="2" style="width: 300px; border-right: 1px solid black;border-bottom: 1px solid black; text-align: left">Nama Supplier</th>
                <th colspan="2" style="border-right: 1px solid black;border-bottom: 1px solid black">Sales</th>
                <th colspan="2" style="border-bottom: 1px solid black">Refund</th>
            </tr>
            <tr>
                <th style="width: 50px; border-right: 1px solid black;">DPP</th>
                <th style="width: 100px; border-right: 1px solid black;">PPN</th>
                <th style="width: 50px; border-right: 1px solid black;">DPP</th>
                <th style="width: 100px">PPN</th>
            </tr>
        </thead>
        <tbody style="border-bottom: 2px solid black; text-align: center; vertical-align: center">
        <?php
            $kode = '';
            $cDeskripsi = '';
            $nilaiSalesDPP = 0;
            $nilaiRefundDPP = 0;
            $totalSalesDPP = 0;
            $totalRefundDPP = 0;
            $nilaiSalesPPN = 0;
            $nilaiRefundPPN = 0;
            $totalSalesPPN = 0;
            $totalRefundPPN = 0;
        ?>
        @for($i=0;$i<sizeof($data);$i++)
            <?php
            $awal = new DateTime($data[$i]->cbh_tglawal);
            $strip = $awal->format('d/m/Y');
            $akhir = new DateTime($data[$i]->cbh_tglakhir);
            $strip2 = $akhir->format('d/m/Y');
            ?>
            @if($kode != $data[$i]->cbh_kodepromosi)
                @if($i != 0)
                    <tr style="font-weight: bold">
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td style="text-align: right">Total Per Event</td>
                        <td style="text-align: right">{{rupiah($nilaiSalesDPP)}}</td>
                        <td style="text-align: right">{{rupiah($nilaiSalesPPN)}}</td>
                        <td style="text-align: right">{{rupiah($nilaiRefundDPP)}}</td>
                        <td style="text-align: right">{{rupiah($nilaiRefundPPN)}}</td>
                    </tr>
                @endif
                <tr>
                    <td>{{$data[$i]->cbh_kodepromosi}}</td>
                    <td>{{$data[$i]->cbh_kodeperjanjian}}</td>
                    <td> </td>
                    <td style="text-align: left"> {{$data[$i]->cbh_namapromosi}}</td>
                    <td colspan="4">({{$strip}} S/D {{$strip2}})</td>
                </tr>
                <?php
                $kode = $data[$i]->cbh_kodepromosi;
                $totalSalesDPP += $nilaiSalesDPP;
                $totalRefundDPP += $nilaiRefundDPP;
                $nilaiSalesDPP = 0;
                $nilaiRefundDPP = 0;

                $totalSalesPPN += $nilaiSalesPPN;
                $totalRefundPPN += $nilaiRefundPPN;
                $nilaiSalesPPN = 0;
                $nilaiRefundPPN = 0;
                ?>
            @endif
            @if($data[$i]->prd_deskripsipanjang == null || $data[$i]->prd_deskripsipanjang == '')
                <?php
                    $cDeskripsi = 'CASHBACK GABUNGAN';
                ?>
            @else
                <?php
                $cDeskripsi = $data[$i]->prd_deskripsipanjang;
                ?>
            @endif
            <tr>
                <td>{{$data[$i]->plu}}</td>
                <td style="text-align: left">{{$cDeskripsi}}</td>
                <td>{{$data[$i]->sup_kodesupplier}}</td>
                <td style="text-align: left">{{$data[$i]->sup_namasupplier}}</td>
                <td style="text-align: right">{{rupiah($data[$i]->sls_dpp)}}</td>
                <td style="text-align: right">{{rupiah($data[$i]->sls_ppn)}}</td>
                <td style="text-align: right">{{rupiah($data[$i]->ref_dpp)}}</td>
                <td style="text-align: right">{{rupiah($data[$i]->ref_ppn)}}</td>
            </tr>
            <?php
            $nilaiSalesDPP += ($data[$i]->sls_dpp);
            $nilaiRefundDPP += ($data[$i]->ref_dpp);
            $nilaiSalesPPN += ($data[$i]->sls_ppn);
            $nilaiRefundPPN += ($data[$i]->ref_ppn);
            ?>
        @endfor
        <tr style="font-weight: bold">
            <td> </td>
            <td> </td>
            <td> </td>
            <td style="text-align: right">Total Per Event</td>
            <td style="text-align: right">{{rupiah($nilaiSalesDPP)}}</td>
            <td style="text-align: right">{{rupiah($nilaiSalesPPN)}}</td>
            <td style="text-align: right">{{rupiah($nilaiRefundDPP)}}</td>
            <td style="text-align: right">{{rupiah($nilaiRefundPPN)}}</td>
        </tr>
        <?php
        $totalSalesDPP += $nilaiSalesDPP;
        $totalSalesPPN += $nilaiSalesPPN;
        $totalRefundDPP += $nilaiRefundDPP;
        $totalRefundPPN += $nilaiRefundPPN;

        ?>
        <tr style="font-weight: bold; border-top: 1px solid black">
            <td style="border-top: 1px solid black"> </td>
            <td style="border-top: 1px solid black"> </td>
            <td style="border-top: 1px solid black"> </td>
            <td style="text-align: right; border-top: 1px solid black">Grand Total</td>
            <td style="text-align: right; border-top: 1px solid black">{{rupiah($totalSalesDPP)}}</td>
            <td style="text-align: right; border-top: 1px solid black">{{rupiah($totalSalesPPN)}}</td>
            <td style="text-align: right; border-top: 1px solid black">{{rupiah($totalRefundDPP)}}</td>
            <td style="text-align: right; border-top: 1px solid black">{{rupiah($totalRefundPPN)}}</td>
        </tr>
        </tbody>
    </table>
{{--    <p style="float: right; line-height: 0.1px !important;">** AKHIR LAPORAN **</p>--}}

{{--</body>--}}

{{--</html>--}}
@endsection
