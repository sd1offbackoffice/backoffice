<html>
<head>
    <title>TABEL MAX PEMBELIAN ITEM PER TRANSAKSI</title>
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
@if (!$data)
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
            <p>{{$perusahaan->prs_namaperusahaan ?? '..'}}</p>
            <p>{{$perusahaan->prs_namacabang ?? '..'}}</p>
            <p>{{$perusahaan->prs_namawilayah ?? '..'}}</p>
        </div>
        <div style="float:right; margin-top: -20px; line-height: 5px !important;">
            <p> Tgl. Cetak : {{ date("d/m/Y") }}<br><br>
                Jam Cetak : {{ $datetime->format('H:i:s') }}<br><br>
        </div>
        <div style="clear: right"></div>
        <h1 style="text-align: center; padding-top: 12px">* * TABEL MAX PEMBELIAN ITEM PER TRANSAKSI **</h1>
    </div>


    <table class="body" style="line-height: 10px">
        {{--        <thead style="text-align: center">--}}
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black; text-align: center">
        <tr style="text-align: center;">
            <th style="width: 40px">PLU<br>DESKRIPSI</th>
            <th style="width: 40px">MAX QTY REG BIRU</th>
            <th style="width: 40px">MAX QTY REG BIRU PLUS</th>
            <th style="width: 40px">MAX QTY FREEPASS</th>
            <th style="width: 40px">MAX QTY RET MERAH</th>
            <th style="width: 40px">MAX QTY SILVER</th>
            <th style="width: 40px">MAX QTY GOLD 1</th>
            <th style="width: 40px">MAX QTY GOLD 2</th>
            <th style="width: 40px">MAX QTY GOLD 3</th>
            <th style="width: 40px">MAX QTY PLATINUM</th>
        </tr>
        </thead>
        <tbody>
        @for($i = 0; $i < sizeof($data); $i++)
            <tr>
                <td style="width: 40px">{{$data[$i]->mtr_prdcd}}</td>
                <td align="center" style="width: 40px">{{$data[$i]->mtr_qtyregulerbiru}}</td>
                <td align="center" style="width: 40px">{{$data[$i]->mtr_qtyregulerbiruplus}}</td>
                <td align="center" style="width: 40px">{{$data[$i]->mtr_qtyfreepass}}</td>
                <td align="center" style="width: 40px">{{$data[$i]->mtr_qtyretailermerah}}</td>
                <td align="center" style="width: 40px">{{$data[$i]->mtr_qtysilver}}</td>
                <td align="center" style="width: 40px">{{$data[$i]->mtr_qtygold1}}</td>
                <td align="center" style="width: 40px">{{$data[$i]->mtr_qtygold2}}</td>
                <td align="center" style="width: 40px">{{$data[$i]->mtr_qtygold3}}</td>
                <td align="center" style="width: 40px">{{$data[$i]->mtr_qtyplatinum}}</td>
            </tr>
            <tr>
                <td style="width: 40px">{{$data[$i]->prd_deskripsipanjang}}</td>
                <td style="width: 40px">{{$data[$i]->unit}}</td>
            </tr>

        @endfor
        </tbody>
    </table>
    <br><br>
    <p style="text-align: right">**Akhir dari Laporan **</p>
@endif

</body>
</html>

{{--@foreach($data as $data)--}}
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
