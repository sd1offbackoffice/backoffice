<html>
<head>
    <title>List Detail BKL</title>
    <style>
        @page {
            /*margin: 130px 25px 25px 25px;*/
            /*margin: 25px 25px 25px 25px;*/
        }

        .header {
            position:fixed;
            top: 0px;
            left: 0px;
            right: 0px;
            height: 1.5cm;
            line-height: 0.1px !important;
            border-bottom: 1px solid grey;
        }

        .sp {
            page-break-after: always;
        }

        .sp:last-child {
            page-break-after: never;
        }

        body {
            font-size: 9px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-weight: bold;
            margin-top: 70px;
        }

        .page-break {
            page-break-after: always;
        }

        table{
            /*border-collapse: collapse;*/
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            /*border-color: inherit;*/
        }
        tr {
            /*display: table-row;*/
            /*vertical-align: inherit;*/
            /*border-color: inherit;*/
        }
        td {
            /*border-bottom: 1px solid black;*/
            line-height: 12px;
        }

    </style>
</head>
<body>

{{--@if (isset($query))--}}
@if (!$result)
    <h1 style="text-align: center">Data Tidak Ada</h1>
@else

    <?php
    $i = 1;
    $datetime = new DateTime();
    $timezone = new DateTimeZone('Asia/Jakarta');
    $datetime->setTimezone($timezone);
    ?>

    <div class="header">
        <div style="float:left; margin-top: -20px; line-height: 5px !important;">
            <p>{{$result[0]->prs_namaperusahaan ?? '..'}}</p>
            <p>{{$result[0]->prs_namacabang ?? '..'}}</p>
            <p>{{$result[0]->prs_namawilayah ?? '..'}}</p>
        </div>
        <div style="float:right; margin-top: -20px; line-height: 5px !important;">
            <p> Tgl. Cetak : {{ date("d/m/Y") }}<br><br>
                Jam Cetak : {{ $datetime->format('H:i:s') }}<br><br>
                Hal. :
        </div>
        <div style="clear: right"></div>
        <h1 style="text-align: center; padding-top: 12px">* * LISTING BUKTI TRANSFER BARANG KIRIM LANGSUNG DARI OMI **</h1>
    </div>


    <table class="body" style="line-height: 10px">
{{--        <thead style="text-align: center">--}}
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black; text-align: center">
        <tr style="text-align: center;">
            <th style="width: 40px">NO DOK</th>
            <th style="width: 40px">TGL DOK</th>
            <th style="width: 40px">TOKO</th>
            <th style="width: 40px">MEMBER</th>
            <th style="width: 100px" colspan="2">SUPPLIER</th>
            <th style="width: 40px">STRUK</th>
            <th style="width: 40px">TGL STRUK</th>
            <th style="width: 40px">PLU</th>
            <th style="width: 120px">NAMA BARANG</th>
            <th style="width: 40px">SATUAN</th>
            <th style="width: 30px">QTY</th>
            <th style="width: 40px">BNS</th>
            <th style="width: 50px">PRICE</th>
            <th style="width: 60px">TOTAL</th>
            <th style="width: 60px">TOTAL STRUK</th>
        </tr>
        </thead>
        <tbody>
        <?php $total_all = 0;$struk_all = 0; $total = 0; $struk = 0; ?>
        @for($i = 0; $i < sizeof($result); $i++)
            <tr>
                <td style="width: 40px">{{$result[$i]->no_bukti}}</td>
                <td style="width: 40px;">{{date('d/m/Y', strtotime($result[$i]->tgl_bukti))}}</td>
                <td style="width: 40px">{{$result[$i]->kodetoko}}</td>
                <td style="width: 40px;">{{$result[$i]->cus_kodemember}}</td>
                <td style="">{{$result[$i]->kodesupplier}}</td>
                <td style="width: 100px">{{$result[$i]->sup_namasupplier}}</td>
                <td style="width: 40px;">{{$result[$i]->no_tran}}</td>
                <td style="width: 40px;">{{date('d/m/Y', strtotime($result[$i]->tgl_tran))}}</td>
                <td style="width: 40px;">{{$result[$i]->prdcd}}</td>
                <td style="width: 150px;">{{$result[$i]->prd_deskripsipendek}}</td>
                <td style="width: 40px;">{{$result[$i]->satuan}}</td>
                <td style="width: 30px; text-align: right" >{{$result[$i]->qty}}</td>
                <td style="width: 40px; text-align: right" >{{$result[$i]->bonus}}</td>
                <td style="width: 50px; text-align: right">Rp. {{number_format(round($result[$i]->harga), 0, '.', ',')}}</td>
                <td style="width: 50px; text-align: right">Rp. {{number_format(round($result[$i]->total), 0, '.', ',')}}</td>
                <td style="width: 50px; text-align: right">Rp. {{number_format(round($result[$i]->gross), 0, '.', ',')}}</td>
            </tr>

            {{$total = $total + $result[$i]->total}}
            {{$struk = $struk + $result[$i]->gross}}
            {{$total_all = $total_all + $result[$i]->total}}
            {{$struk_all = $struk_all + $result[$i]->gross}}

            @if($i == (sizeof($result)-1) || $result[$i]->no_bukti != $result[$i+1]->no_bukti)
                <tr style="border-bottom: 1px solid black">
                    <td colspan="14" style="text-align: right; border-bottom: 1px solid black">** Sub Total :</td>
                    <td style="text-align: right; border-bottom: 1px solid black">Rp. {{number_format($total ,0,',','.')}}</td>
                    <td style="text-align: right; border-bottom: 1px solid black">Rp. {{number_format($struk ,0,',','.')}}</td>
                    {{$total = 0}} {{$struk = 0}}
                </tr>
{{--                <tr style="border-bottom: 1px solid black"><td colspan="16"></td></tr>--}}
            @endif

        @endfor
        <tr>
            <td colspan="14" style="text-align: right">** Total Akhir :</td>
            <td style="text-align: right">Rp. {{number_format($total_all ,0,',','.')}}</td>
            <td style="text-align: right">Rp. {{number_format($struk_all ,0,',','.')}}</td>
        </tr>
        </tbody>
    </table>
    <br><br>
    <p style="text-align: right">**Akhir dari Laporan **</p>
@endif

</body>
</html>

{{--@foreach($result as $data)--}}
{{--    <tr>--}}
{{--        <td style="width: 40px">{{$data->no_bukti}}</td>--}}
{{--        <td style="width: 40px;">{{date('d/m/Y', strtotime($data->tgl_bukti))}}</td>--}}
{{--        <td style="width: 40px">{{$data->kodetoko}}</td>--}}
{{--        <td style="width: 40px;">{{$data->cus_kodemember}}</td>--}}
{{--        <td style="">{{$data->kodesupplier}}</td>--}}
{{--        <td style="width: 100px">{{$data->sup_namasupplier}}</td>--}}
{{--        <td style="width: 40px;">{{$data->no_tran}}</td>--}}
{{--        <td style="width: 40px;">{{date('d/m/Y', strtotime($data->tgl_tran))}}</td>--}}
{{--        <td style="width: 40px;">{{$data->prdcd}}</td>--}}
{{--        <td style="width: 150px;">{{$data->prd_deskripsipendek}}</td>--}}
{{--        <td style="width: 40px;">{{$data->satuan}}</td>--}}
{{--        <td style="width: 30px; text-align: right" >{{$data->qty}}</td>--}}
{{--        <td style="width: 40px; text-align: right" >{{$data->bonus}}</td>--}}
{{--        <td style="width: 50px; text-align: right">Rp. {{number_format(round($data->harga), 0, '.', ',')}}</td>--}}
{{--        <td style="width: 50px; text-align: right">Rp. {{number_format(round($data->total), 0, '.', ',')}}</td>--}}
{{--        <td style="width: 50px; text-align: right">Rp. {{number_format(round($data->gross), 0, '.', ',')}}</td>--}}
{{--    </tr>--}}
{{--    {{$total_all = $total_all + $data->harga}}--}}
{{--    {{$struk_all = $struk_all + $data->gross}}--}}
{{--@endforeach--}}
