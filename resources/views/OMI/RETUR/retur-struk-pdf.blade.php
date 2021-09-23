@if(!$data)
    <p style="text-align: center">Data tidak ditemukan</p>
@else
    <!DOCTYPE html>
    <html>
    <head>
        <title>STRUK RETUR OMI</title>
    </head>
    <body>

    <?php
    $datetime = new DateTime();
    $timezone = new DateTimeZone('Asia/Jakarta');
    $datetime->setTimezone($timezone);
    ?>
    <header>
        {{--    <p>--}}
        {{--        {{ $perusahaan->prs_namaperusahaan }}<br>--}}
        {{--        {{ $perusahaan->prs_namacabang }}<br><br>--}}
        {{--    </p>--}}
        {{--    <h3 style="text-align: center">--}}
        {{--        ** STRUK RESET KASIR **<br>--}}
        {{--        No. Reset : {{ $noreset }}--}}
        {{--    </h3>--}}
    </header>
    <p style="text-align: center">
        ** {{ $perusahaan->prs_namacabang }} **<br>
        ** {{ $perusahaan->prs_namaperusahaan }} **<br>
        {{ $perusahaan->prs_alamat1 }}<br>
        {{ $perusahaan->prs_alamat2 }}
        {{ $perusahaan->prs_alamat3 }}<br>
        NPWP : {{ $perusahaan->prs_npwp }}<br>
        Telp : {{ $perusahaan->prs_telepon }}<br>
        {{ date("d/m/Y") }} {{ $datetime->format('H:i:s') }} {{ $perusahaan->prs_kodemto }} {{ $data[0]->rom_kodekasir }} {{ $data[0]->rom_station }} {{ $data[0]->rom_jenistransaksi }}
    </p>
    <footer>

    </footer>

    <main>
        <table width="100%">
            <thead>
            <tr>
                <td colspan="6" class="left top">NAMA BARANG / PLU</td>
            </tr>
            <tr>
                <td class="right bottom">QTY</td>
                <td class="right bottom" colspan="2">H. SATUAN</td>
                <td class="right bottom">DISC.</td>
                <td class="right bottom" colspan="2">TOTAL</td>
            </tr>
            </thead>
            <tbody>
            @php
                $total = 0;
                $ppn = 0;
            @endphp
            @foreach($data as $d)
                <tr>
                    <td colspan="4" class="left">{{ $d->prd_deskripsipendek }}</td>
                    <td colspan="2" class="right">({{ $d->cp_plu }})</td>
                </tr>
                <tr>
                    <td class="right">{{ $d->rom_qtyselisih }}</td>
                    <td class="right" colspan="2">{{ number_format($d->cp_hsat,0,'.',',') }}</td>
                    <td class="right">{{ number_format($d->trjd_discount,0,'.',',') }}</td>
                    <td class="right" colspan="2">{{ number_format($d->cp_total,0,'.',',') }}</td>
                </tr>

                @php
                    $total += $d->cp_total;
                    $ppn += $d->cp_ppn;
                @endphp
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td class="left" colspan="2">PENJUALAN</td>
                <td class="left">:</td>
                <td class="right" colspan="3">{{ number_format($total,0,'.',',') }}</td>
            </tr>
            <tr>
                <td class="left" colspan="2">PPN</td>
                <td class="left">:</td>
                <td class="right" colspan="3">{{ number_format($ppn,0,'.',',') }}</td>
            </tr>
            <tr>
                <td class="left" colspan="2">TOTAL ( +PPN )</td>
                <td class="left">:</td>
                <td class="right" colspan="3">{{ number_format($total+$ppn,0,'.',',') }}</td>
            </tr>
            <tr>
                <td class="left" colspan="2">TOTAL ITEM</td>
                <td class="left">:</td>
                <td class="left">{{ count($data) }}</td>
            </tr>
            <tr>
                <td colspan="6" class="center"><h3>*** Terima Kasih ***</h3></td>
            </tr>
            <tr>
                <td class="left" colspan="2">MEMBER</td>
                <td class="left" colspan="4">: {{ $data[0]->cus_namamember }} ( {{ $data[0]->cus_kodemember }} )</td>
            </tr>
            <tr>
                <td class="left" colspan="2">BUKTI RETUR</td>
                <td class="left" colspan="4">: {{ $data[0]->rom_noreferensi }} / {{ $data[0]->rom_nodokumen }}</td>
            </tr>
            <tr>
                <td class="left" colspan="2">DRIVER</td>
                <td class="left" colspan="4">: {{ $data[0]->rom_namadrive }}</td>
            </tr>
            </tfoot>
        </table>
    </main>

    <br>
    </body>
    <style>
        @page {
            /*margin: 25px 20px;*/
            /*size: 1071pt 792pt;*/
            /*size: 595pt 842pt;*/
            size: 298pt {{ 370+(count($data)*28) }}pt;
            /*size: 842pt 638pt;*/
        }
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
        }
        body {
            margin-top: 0px;
            margin-bottom: 0px;
            font-size: 12px;
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
        table{
            width: 100%;
            font-size: 10px;
            white-space: nowrap;
            color: #212529;
            /*padding-top: 20px;*/
            /*margin-top: 25px;*/
        }
        table tbody td {
            /*font-size: 6px;*/
            vertical-align: top;
            /*border-top: 1px solid #dee2e6;*/
            padding: 0.20rem 0;
            width: auto;
        }
        table th{
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
            line-height: 20px!important;
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
    </style>
    </html>

@endif
