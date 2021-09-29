<html>
<head>
    <title>Struk BKL</title>
    <style>
        @page {
            /*margin: 130px 25px 25px 25px;*/
            /*size: 595pt 442pt;*/
            size: 298pt {{ 370+(count($result)*28) }}pt;
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

@if (!$result)
    <h1 style="text-align: center">Data Tidak Ada</h1>
@else
    <?php
    $datetime = new DateTime();
    $timezone = new DateTimeZone('Asia/Jakarta');
    $datetime->setTimezone($timezone);
    ?>
    <header>
    </header>
    <p style="text-align: center">
        {{$result[0]->prs_namacabang}}<br>
        {{$result[0]->prs_namaperusahaan}}<br>
        {{$result[0]->prs_alamat1}}<br>
        {{$result[0]->alamat}}<br>
        {{$result[0]->prs_npwp}}<br>
        PROFORMA<br>
        {{$result[0]->prs_telepon}}<br>
    </p>
    <div style="float: left">{{$result[0]->tanggal}}</div>
    <div style="float: right; margin-left: 50%">{{$result[0]->nomor}}</div>
    <div style="clear: right"></div>
    <main>
        <hr>
        <table width="100%">
            <thead>
            <tr>
                <th style="width: 60%" colspan="2">NAMA BARANG / PLU </th>
                <th style="width: 40%" colspan="2"> </th>
            </tr>
            <tr>
                <td style="width: 30%">QTY</td>
                <td style="width: 30%; text-align: right">H.SATUAN</td>
                <td style="width: 20%; text-align: right">DISC</td>
                <td style="width: 20%; text-align: right">TOTAL</td>
            </tr>
            </thead>
            <tbody>
            @php
                $penjualan = 0;
                $dist_fee = 0;
                $total_item = 0;
                $grand_total = 0;
            @endphp

            @foreach($result as $data)
                <tr>
                    <td style="width: 60%" colspan="2">{{$data->prd_deskripsipendek}}</td>
                    <td style="text-align: right" colspan="2">{{$data->trjd_prdcd}}</td>
                </tr>
                <tr>
                    <td style="text-align: left">{{$data->trjd_quantity}}</td>
                    <td style="text-align: right">{{number_format($data->trjd_baseprice,0,'.',',')}}</td>
                    <td style="text-align: right">{{number_format($data->trjd_discount,0,'.',',')}}</td>
                    <td style="text-align: right">{{number_format($data->trjd_nominalamt,0,'.',',')}}</td>
                </tr>
                {{$penjualan = $penjualan +  $data->trjd_nominalamt}}
                {{$dist_fee = $dist_fee +  $data->trjd_admfee}}
                {{$total_item = $total_item + 1}}
            @endforeach

            </tbody>
            <tfoot>
            <tr><td colspan="4" style="height: 3px"></td></tr>
            <tr>
                <td class="left" colspan="1">PENJUALAN</td>
                <td class="left">:</td>
                <td class="right" colspan="2">{{ number_format($penjualan ,0,'.',',') }}</td>
            </tr>
            <tr>
                <td class="left" colspan="1">PPN</td>
                <td class="left">:</td>
                <td class="right" colspan="2">{{ number_format(($penjualan * 0.1),0,'.',',') }}</td>
            </tr>
            <tr>
                <td class="left" colspan="1">TOTAL PENJUALAN</td>
                <td class="left">:</td>
                <td class="right" colspan="2">{{ number_format($penjualan + ($penjualan * 0.1),0,'.',',') }}</td>
            </tr>
            <tr>
                <td class="left" colspan="1">DISTRIBUTION FEE</td>
                <td class="left">:</td>
                <td class="right" colspan="2">{{ number_format($dist_fee,0,'.',',') }}</td>
            </tr>
            <tr>
                <td class="left" colspan="1">PPN (DF)</td>
                <td class="left">:</td>
                <td class="right" colspan="2">{{ number_format(($dist_fee * 0.1),0,'.',',') }}</td>
            </tr>
            <tr>
                <td class="left" colspan="1">TOTAL FEE</td>
                <td class="left">:</td>
                <td class="right" colspan="2">{{ number_format($dist_fee + ($dist_fee * 0.1),0,'.',',') }}</td>
            </tr>
            {{$grand_total = ($penjualan + ($penjualan * 0.1)) + ($dist_fee + ($dist_fee * 0.1))}}
            <tr>
                <td class="left" colspan="1">TOTAL SELURUH</td>
                <td class="left">:</td>
                <td class="right" colspan="2">{{ number_format($grand_total,0,'.',',') }}</td>
            </tr>
            <tr>
                <td class="left" colspan="1">TOTAL ITEM</td>
                <td class="left">:</td>
                <td class="left" colspan="2">{{$total_item}}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center"><h3>*** Terima Kasih *** <br>UNTUK BARANG KENA PAJAK <br>HARGA SUDAH TERMASUK PPN</h3></td>
            </tr>
            <tr>
                <td>NO MEMBER</td>
                <td>: {{$result[0]->trjd_cus_kodemember}}</td>
                <td colspan="2">NAMA : {{$result[0]->cus_namamember}}</td>
            </tr>
            <tr>
                <td class="left" colspan="1">REFRENSI</td>
                <td class="left" colspan="2">: {{$result[0]->nobukti ?? '...'}} / {{$result[0]->tko_namaomi}}</td>
            </tr>
            </tfoot>
        </table>

@endif


</main>

<br>
</body>
</html>




