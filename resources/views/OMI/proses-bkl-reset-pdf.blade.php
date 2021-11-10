<html>
<head>
    <title>Reset - BKL</title>
    <style>
        @page {
            margin: 25px 25px;
            /*size: 595pt 442pt;*/
            /*size: 298pt 350pt;*/
        }

        .header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
        }

        .header table td{
            border: none !important;
        }

        .sp {
            page-break-after: always;
        }

        .sp:last-child {
            page-break-after: never;
        }

        body {
            margin-top: 0px;
            margin-bottom: 0px;
            width: 200pt;
            font-size: 9px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-weight: 400;
            line-height: 1.25;
        }

        .page-break {
            page-break-after: always;
        }

        table{
            border-collapse: collapse;
        }
        thead {
            border-bottom: 1px solid black;
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

        .center{
            text-align: center;
        }

        .left{
            text-align: left;
        }

        .right{
            text-align: right;
        }

    </style>
</head>
<body>

@if (!$data)
    <h1 style="text-align: center">Data Tidak Ada</h1>
@else
    <?php
    $datetime = new DateTime();
    $timezone = new DateTimeZone('Asia/Jakarta');
    $datetime->setTimezone($timezone);
    ?>
    <header>
    </header>
    <p style="text-align: left">
        {{$data[0]->prs_namaperusahaan}}<br>
        {{$data[0]->prs_namacabang}}<br>
    </p>
    <p style="text-align: center">
        ** STRUK RESET KASIR ** <br>
        {{$data[0]->nomor}}
    </p>
    <main>
        <hr>
        <table style="width: 100%;">
            <tbody>
            <tr>
                <td>KODE CABANG</td>
                <td>: {{$data[0]->prs_kodecabang}}</td>
            </tr>
            <tr>
                <td>TANGGAL</td>
                <td>: {{$data[0]->tgl}}</td>
            </tr>
            <tr>
                <td>JAM SELESAI</td>
                <td>: {{$data[0]->jam}}</td>
            </tr>
            <tr>
                <td>NOMOR STATION</td>
                <td>: {{$data[0]->js_cashierstation}}</td>
            </tr>
            <tr>
                <td>KASIR</td>
                <td>: BKL - BKL</td>
            </tr>

            <tr><td style="height: 10px" colspan="4"> </td></tr>

            <tr>
                <td>DI RESET OLEH</td>
                <td>: {{$data[0]->userid}} - {{$data[0]->username}}</td>

            </tr>
            <tr>
                <td>TANGGAL</td>
                <td>: {{$data[0]->tgl}}</td>
            </tr>
            <tr>
                <td>JAM</td>
                <td>: {{$data[0]->jam}}</td>
            </tr>

            <tr><td style="height: 10px" colspan="4"> </td></tr>

            <tr>
                <td>RP. KREDIT</td>
                <td>: {{number_format($data[0]->js_totcreditsalesamt,0,'.',',')}}</td>
            </tr>

            <tr><td style="height: 10px" colspan="4"> </td></tr>
            <tr style="text-align: center"><td colspan="4">* ------------------ INFORMASI TRANSAKSI ---------------------- * </td></tr>

            <tr>
                <td>PENJUALAN</td>
                <td>: {{number_format($data[0]->js_totcreditsalesamt,0,'.',',')}}</td>
            </tr>
            <tr>
                <td>TOTAL TRANSAKSI</td>
                <td>: {{number_format($data[0]->js_totcreditsalesamt,0,'.',',')}}</td>
            </tr>

            <tr><td style="height: 10px" colspan="4"> </td></tr>
            <tr style="text-align: center"><td colspan="4">* ------------------ INFORMASI LAIN - LAIN ---------------------- * </td></tr>

            <tr>
                <td>JUMLAH TRANSAKSI</td>
                <td>: {{$data[0]->jmlh_trans}}</td>
            </tr>
            <tr>
                <td>JUMLAH VOID </td>
                <td>: {{$data[0]->void}}</td>
            </tr>

            </tbody>
        </table>

        @endif


    </main>

    <br>
</body>
</html>




