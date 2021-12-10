<!DOCTYPE html>
<html>
<head>
    <title>LIST PERSETUJUAN RETUR</title>
</head>
<body>

<?php
$datetime = new DateTime();
$timezone = new DateTimeZone('Asia/Jakarta');
$datetime->setTimezone($timezone);
?>
<header>
    <div style="float:left; margin-top: 0px; line-height: 8px !important;">
        <p>
            {{ $perusahaan->prs_namaperusahaan }}<br><br>
            {{ $perusahaan->prs_namacabang }}<br><br>
            @if(count($data) > 0)
                Member : {{ $data[0]->rom_member }} - {{ $data[0]->cus_namamember }}<br><br>
                Alamat : {{ $data[0]->alamat }}
            @else
                Member : -
                Alamat :
            @endif
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>Waktu Cetak : {{ date("d/m/Y").' - '.$datetime->format('H:i:s') }}<br><br>
{{--            No. PO : {{ $data[0]->rom_nopo }}<br><br>--}}
            @if(count($data) > 0)
                No. NRB : {{ $data[0]->rom_noreferensi }}<br><br>
            @else
                No. NRB :
            @endif
{{--            TOP : {{ $data[0]->rom_tgljatuhtempo }}<br><br>--}}
        {{--            Hal. :<br><br>--}}
        {{--            <i>User ID</i> : {{ Session::get('usid') }}<br><br>--}}

    </div>
    <h2 style="text-align: center">
        ** LIST PERSETUJUAN RETUR **<br>
        No : {{ $nodoc }} Tanggal : {{ $tgldoc }}<br>
        (MANUAL)
    </h2>
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2" class="tengah">No.</th>
            <th rowspan="2" class="tengah left">PLU</th>
            <th rowspan="2" class="tengah left">Deskripsi</th>
            <th rowspan="2" class="tengah left">Satuan</th>
            <th colspan="6" class="center">----- Referensi -----</th>
            <th colspan="2" class="center">Kuantitas</th>
            <th rowspan="2" class="tengah right">H. Satuan</th>
            <th rowspan="2" class="tengah">Total</th>
        </tr>
        <tr>
            <th>H.Sat1</th>
            <th>Qty1</th>
            <th>H.Sat2</th>
            <th>Qty2</th>
            <th>H.Sat3</th>
            <th>Qty3</th>
            <th class="right">P 2 P</th>
            <th class="right">Real</th>
        </tr>
        </thead>
        <tbody>
        @php $i = 0; $subtotal = 0; $subppn = 0; @endphp
        @foreach($data as $d)
            @php
                if($d->rom_flagbkp == 'Y' && !in_array($d->rom_flagbkp2, ['P','G','W'])){
                    $harga = $d->rom_hrg / 1.1;
                    $total = $d->rom_ttl / 1.1;
                    $ppn = $d->rom_ttl - $total;
                }
                else{
                    $harga = $d->rom_hrg;
                    $total = $d->rom_ttl;
                    $ppn = 0;
                }

                $subtotal += $total;
                $subppn += $ppn;
            @endphp
            <tr>
                <td>{{ ++$i }}</td>
                <td class="left">{{ $d->rom_prdcd }}</td>
                <td class="left">{{ $d->prd_deskripsipanjang }}</td>
                <td class="left">{{ $d->kemasan }}</td>
                <td class="right">{{ $d->hrgsat1 }}</td>
                <td class="right">{{ $d->hso_qty1 }}</td>
                <td class="right">{{ $d->hrgsat2 }}</td>
                <td class="right">{{ $d->hso_qty2 }}</td>
                <td class="right">{{ $d->hrgsat3 }}</td>
                <td class="right">{{ $d->hso_qty3 }}</td>
                <td class="right">{{ $d->rom_qty }}</td>
                <td class="right">{{ $d->rom_qtyrealisasi }}</td>
                <td class="right">{{ number_format($harga,0,'.',',') }}</td>
                <td class="right">{{ number_format($total,0,'.',',') }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr class="bold">
            <td class="top right" colspan="13">TOTAL</td>
            <td class="top right">{{ number_format($subtotal,0,'.',',') }}</td>
        </tr>
        <tr class="bold">
            <td class="right" colspan="13">PPN</td>
            <td class="right">{{ number_format($subppn,0,'.',',') }}</td>
        </tr>
        <tr class="bold">
            <td class="bottom right" colspan="13">TOTAL + PPN</td>
            <td class="bottom right">{{ number_format($subtotal + $subppn,0,'.',',') }}</td>
        </tr>
        </tfoot>
    </table>
    <br>
    <table style="width: 100%; font-weight: bold" class="table table-ttd page-break-avoid">
        <tr>
            <td colspan="2">Penerimaan Barang Retur</td>
            <td>Disetujui,</td>
            <td>Dicetak,</td>
        </tr>
        <tr class="blank-row">
            <td colspan="4">.</td>
        </tr>
        <tr>
            <td><p class="overline">Receiving Officer</p></td>
            <td><p class="overline">Team Delivery</p></td>
            <td><p class="overline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></td>
            <td><p class="overline">Team Delivery / Sales Service Clerk</p></td>
        </tr>
    </table>
</main>

<br>
</body>
<style>
    @page {
        /*margin: 25px 20px;*/
        /*size: 1071pt 792pt;*/
        size: 595pt 442pt;
        /*size: 842pt 595pt;*/
    }
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 3cm;
    }
    body {
        margin-top: 80px;
        margin-bottom: 10px;
        font-size: 9px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 400;
        line-height: 1.25;
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
    td {
        display: table-cell;
    }
    thead{
        text-align: center;
    }
    tbody{
        text-align: center;
    }
    tfoot{
        border-top: 1px solid black;
    }

    .keterangan{
        text-align: left;
    }
    .table{
        width: 100%;
        font-size: 10px;
        white-space: nowrap;
        color: #212529;
        /*padding-top: 20px;*/
        /*margin-top: 25px;*/
    }
    .table tbody td {
        /*font-size: 6px;*/
        vertical-align: top;
        /*border-top: 1px solid #dee2e6;*/
        padding: 0.20rem 0;
        width: auto;
    }
    .table th{
        vertical-align: top;
        padding: 0.20rem 0;
    }
    .judul, .table-borderless{
        text-align: center;
    }
    .table-borderless th, .table-borderless td {
        border: 0;
        padding: 0.50rem;
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

    .page-break {
        page-break-before: always;
    }

    .page-break-avoid{
        page-break-inside: avoid;
    }

    .table-header td{
        white-space: nowrap;
    }

    .tengah{
        vertical-align: middle !important;
    }
    .blank-row
    {
        line-height: 70px!important;
        color: white;
    }

    .bold td{
        font-weight: bold;
    }

    .top-bottom{
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }

    .top{
        border-top: 1px solid black;
    }

    .bottom{
        border-bottom: 1px solid black;
    }

    .overline{
        text-decoration: overline;
    }
</style>
</html>
