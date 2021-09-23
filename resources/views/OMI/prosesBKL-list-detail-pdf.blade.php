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
            border-collapse: collapse;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        th, td {
            border: 1px solid black;
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
                PGM : ?????? <br><br>
                Hal. :
        </div>
        <div style="clear: right"></div>
        <h1 style="text-align: center; padding-top: 12px">* * LISTING BUKTI TRANSFER BARANG KIRIM LANGSUNG DARI OMI **</h1>
    </div>


    <table class="body" style="line-height: 10px">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black; text-align: center">
        <tr style="text-align: center;">
            <th style="width: 50px">NO DOK</th>
            <th style="width: 50px">TGL DOK</th>
            <th style="width: 50px">TOKO</th>
            <th style="width: 90px" colspan="2">MEMBER</th>
            <th style="width: 90px" colspan="2">SUPPLIER</th>
            <th style="width: 50px">STRUK</th>
            <th style="width: 60px">TGL STRUK</th>
            <th style="width: 50px">PLU</th>
            <th style="width: 50px">NAMA BARANG</th>
            <th style="width: 50px">SATUAN</th>
            <th style="width: 50px">QTY</th>
            <th style="width: 50px">BNS</th>
            <th style="width: 50px">PRICE</th>
            <th style="width: 60px">TOTAL</th>
            <th style="width: 60px">TOTAL STRUK</th>
        </tr>
        </thead>
        <tbody>
        {{--        @for($i = 0; $i<100;$i++)--}}
{{--        <?php $total = 0;$total_struk = 0 ?>--}}
{{--        @foreach($result as $data)--}}
{{--            <tr>--}}
{{--                <td style="width: 50px">{{$data->no_bukti}}</td>--}}
{{--                <td style="width: 50px; text-align: right">{{date('d/m/Y', strtotime($data->tgl_bukti))}}</td>--}}
{{--                <td style="width: 50px">{{$data->kodetoko}}</td>--}}
{{--                <td style="">{{$data->cus_kodemember}}</td>--}}
{{--                <td style="width: 100px">{{$data->cus_namamember}}</td>--}}
{{--                <td style="">{{$data->kodesupplier}}</td>--}}
{{--                <td style="width: 100px">{{$data->sup_namasupplier}}</td>--}}
{{--                <td style="width: 50px; text-align: right" >{{$data->no_tran}}</td>--}}
{{--                <td style="width: 50px; text-align: right" >{{date('d/m/Y', strtotime($data->tgl_tran))}}</td>--}}
{{--                <td style="width: 50px; text-align: right">Rp. {{number_format(round($data->harga), 0, '.', ',')}}</td>--}}
{{--                <td style="width: 50px; text-align: right">Rp. {{number_format(round($data->gross), 0, '.', ',')}}</td>--}}
{{--            </tr>--}}
{{--            {{$total = $total + $data->harga}}--}}
{{--            {{$total_struk = $total_struk + $data->gross}}--}}
{{--        @endforeach--}}
        {{--        @endfor--}}
{{--        <tr>--}}
{{--            <td colspan="9" style="text-align: right">** Total Akhir :</td>--}}
{{--            <td style="text-align: right">Rp. {{number_format($total ,0,',','.')}}</td>--}}
{{--            <td style="text-align: right">Rp. {{number_format($total_struk ,0,',','.')}}</td>--}}
{{--        </tr>--}}
        </tbody>
    </table>
    <br><br>
    <p style="text-align: right">**Akhir dari Laporan **</p>
@endif

</body>
</html>
