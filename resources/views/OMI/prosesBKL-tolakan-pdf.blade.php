<html>
<head>
    <title>Tolakan - BKL</title>
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
            height: 1cm;
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
            margin-top: 50px;
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
                Hal. :
        </div>
        <div style="clear: right"></div>
        <h1 style="text-align: center">LISTING TOLAKAN BKL OMI</h1>
    </div>


    <table class="body" style="line-height: 10px">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black; text-align: center">
        <tr style="text-align: center;">
            <th style="width: 20px">NO</th>
            <th style="width: 25px">CAB</th>
            <th style="width: 100px">NAMA</th>
            <th style="width: 20px">NO</th>
            <th style="width: 50px">TGL</th>
            <th style="width: 40px">SUPPLIER</th>
            <th style="width: 40px">PLU</th>
            <th style="width: 120px">NAMA</th>
            <th style="width: 40px">SATUAN</th>
            <th style="width: 30px">QTY</th>
            <th style="width: 30px">BONUS</th>
            <th style="width: 150px">KETERANGAN</th>
        </tr>
        </thead>
        <tbody>
        @php $no = 1; @endphp
        @foreach($result as $data)
            <tr>
                <th style="width: 20px">{{$no}}</th>
                <th style="width: 25px">{{$data->kodetoko}}</th>
                <th style="width: 100px">{{$data->tko_namaomi}}</th>
                <th style="width: 20px">{{$data->no_bukti}}</th>
                <th style="width: 50px">{{date('d/m/Y', strtotime($data->tgl_bukti))}}</th>
                <th style="width: 40px">{{$data->kodesupplier}}</th>
                <th style="width: 40px">{{$data->prdcd}}</th>
                <th style="width: 120px">{{$data->prd_deskripsipendek}}</th>
                <th style="width: 40px">{{$data->satuan}}</th>
                <th style="width: 30px">{{$data->qty}}</th>
                <th style="width: 30px">{{$data->bonus}}</th>
                <th style="width: 150px">{{$data->keterangan}}</th>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br><br>
    <p style="text-align: right">**Akhir dari Laporan **</p>
@endif

</body>
</html>
