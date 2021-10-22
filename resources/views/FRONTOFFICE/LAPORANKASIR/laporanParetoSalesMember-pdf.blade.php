<html>
<head>
    <title>Laporan Pareto Sales Member </title>
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
            /*border: 1px solid black;*/
            line-height: 12px;
        }

    </style>
</head>
<body>

{{--@if (isset($query))--}}
@if (!$query)
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
            <p>{{$cabang[0]->prs_namaperusahaan}}</p>
            <p>{{$cabang[0]->prs_namacabang}}</p>
        </div>
        <div style="float:right; margin-top: -20px; line-height: 5px !important;">
            <p>Tgl. Cetak : {{ date("d/m/Y") }}<br><br>
                Jam Cetak : {{ $datetime->format('H:i:s') }}<br><br>
                PGM : LAP235F <br><br>
                Hal. :
        </div>
        <h1 style="text-align: center">LAPORAN PARETO SALES BY MEMBER</h1>
        <h4 style="text-align: center; clear: right">Dari : {{$tgl_start}} s/d {{$tgl_end}}</h4>
    </div>


    <table class="body" style="line-height: 10px">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black; text-align: center">
        <tr style="text-align: center;">
            <th style="width: 30px">NO</th>
            <th style="width: 50px">NOMOR</th>
            <th style="width: 170px">NAMA LANGGANAN</th>
            <th style="width: 70px">OUTLET</th>
            <th style="width: 60px">KUNJUNGAN</th>
            <th style="width: 60px">SLIP</th>
            <th style="width: 60px">PRODUK</th>
            <th style="width: 60px">RUPIAH</th>
            <th style="width: 60px">MARGIN</th>
            <th style="width: 50px">%</th>
        </tr>
        </thead>
        <tbody>
        <?php $no = 1 ?>
        <?php $kunjungan = 0; $slip = 0; $produk = 0; $rupiah = 0; $margin = 0; ?>
        @foreach($query as $value)
            <tr>
                <td style="width: 30px; text-align: left">{{$no++}}</td>
                <th style="width: 50px; text-align: left">{{$value->fcusno}}</th>
                <th style="width: 170px; text-align: left">{{$value->fnama}}</th>
                <th style="width: 70px; text-align: left">{{$value->foutlt}} - {{$value->out_namaoutlet}}</th>
                <th style="width: 60px; text-align: right">{{$value->fwfreq}}</th>
                <th style="width: 60px; text-align: right">{{$value->fwslip}}</th>
                <th style="width: 60px; text-align: right">{{number_format($value->fwprod ,0,',','.')}}</th>
                <th style="width: 60px; text-align: right">{{number_format($value->fwamt ,0,',','.')}}</th>
                <th style="width: 60px; text-align: right">{{number_format($value->fgrsmargn ,0,',','.')}}</th>
                <th style="width: 50px; text-align: right">{{number_format((($value->fgrsmargn/$value->fwamt)*100),2) }}</th>
            </tr>
            {{$kunjungan = $kunjungan + $value->fwfreq}};
            {{$slip = $slip + $value->fwslip}};
            {{$produk = $produk + $value->fwprod}};
            {{$rupiah = $rupiah + $value->fwamt}};
            {{$margin = $margin + $value->fgrsmargn}};
        @endforeach
        <tr><td colspan="10" style="line-height: 10px; border-bottom: 1px solid black"></td></tr>
        <tr style="text-align: right">
            <td colspan="4">Total :</td>
            <td>{{$kunjungan}}</td>
            <td>{{$slip}}</td>
            <td>{{number_format($produk ,0,',','.')}}</td>
            <td>{{number_format($rupiah ,0,',','.')}}</td>
            <td>{{number_format($margin ,0,',','.')}}</td>
            <td>{{number_format((($margin/$rupiah)*100),2) }}</td>
        </tr>
        <tr><td colspan="10" style="line-height: 10px; border-bottom: 1px solid black"></td></tr>
        </tbody>
    </table>
    <br><br>
    <p style="text-align: right">**Akhir dari Laporan **</p>
@endif

</body>
</html>
