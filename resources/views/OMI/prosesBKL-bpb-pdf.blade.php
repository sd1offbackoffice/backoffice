<html>
<head>
    <title>BPB BKL</title>
    <style>
        @page {
            /*margin: 130px 25px 25px 25px;*/
            /*size: 595pt 442pt;*/
        }

        .header {
            position:fixed;
            top: 0px;
            left: 0px;
            right: 0px;
            height: 2.1cm;
            line-height: 0.1px !important;
            border-bottom: 1px solid grey;
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
            font-size: 9px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-weight: bold;
            margin-top: 90px;
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
            /*border-color: inherit;*/
        }
        th, td {
            /*border: 1px solid black;*/
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

    <div class="header" style="">
        <div style="width: 20%">
            <div>
                <p>{{$result[0]->prs_namaperusahaan}}</p>
                <p>NPWP : {{$result[0]->prs_npwp}}</p>
            </div>
        </div>
        <div style="width: 20%; margin-left: 20%; margin-top: -100px">
            <div>
                <p>BUKTI PENERIMAAN BARANG</p>
                <p>{{$result[0]->judul}}</p>
            </div>
        </div>
        <div style="width: 60%; margin-left: 40%; margin-top: -100px">
            <div>
                <p>{{$result[0]->prs_namacabang}}</p>
                <p>{{$result[0]->prs_alamatfakturpajak1}} <span/> {{$result[0]->prs_alamatfakturpajak2}} <span/> {{$result[0]->prs_alamatfakturpajak3}} </p>
            </div>
        </div>

        <div style="width: 20%">
            <table style="line-height: 8px !important;">
                <tbody>
                <tr>
                    <td>No.BPB</td>
                    <td>: {{$result[0]->msth_nodoc}}</td>
                </tr>
                <tr>
                    <td>No.PO</td>
                    <td>: {{$result[0]->msth_nopo}}</td>
                </tr>
                <tr>
                    <td>FAKTUR</td>
                    <td>: {{$result[0]->msth_nofaktur}}</td>
                </tr>
                <tr>
                    <td>T.O.P</td>
                    <td>: {{$result[0]->msth_cterm}} Hari</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="width: 20%; margin-left: 20%; margin-top: -100px">
            <table style="line-height: 8px !important;">
                <tbody>
                <tr>
                    <td>TANGGAL</td>
                    <td>: {{($result[0]->msth_tgldoc) ? date('d/m/Y', strtotime($result[0]->msth_tgldoc)) : ''}}</td>
                </tr>
                <tr>
                    <td>TANGGAL</td>
                    <td>: {{($result[0]->msth_tglpo) ? date('d/m/Y', strtotime($result[0]->msth_tglpo)) : ''}}</td>
                </tr>
                <tr>
                    <td>TANGGAL</td>
                    <td>: {{($result[0]->msth_tglfaktur) ? date('d/m/Y', strtotime($result[0]->msth_tglfaktur)) : ''}}</td>
                </tr>
                <tr>
                    <td>JATUH TEMPO</td>
                    <td>: {{($result[0]->tgljt) ? date('d/m/Y', strtotime($result[0]->tgljt)) : ''}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="width: 80%; margin-left: 40%; margin-top: -100px">
            <table style="line-height: 8px !important;">
                <tbody>
                <tr>
                    <td>SUPPLIER</td>
                    <td>: {{$result[0]->supplier}}</td>
                </tr>
                <tr>
                    <td>NPWP</td>
                    <td>: {{$result[0]->sup_npwp}}</td>
                </tr>
                <tr>
                    <td>ALAMAT</td>
                    <td>: {{$result[0]->alamat_supplier}}</td>
                </tr>
                <tr>
                    <td>TELP</td>
                    <td>: {{$result[0]->sup_telpsupplier}}</td>
                    <td style="width: 10px"></td>
                    <td>C. PERSON</td>
                    <td>: {{$result[0]->contact_person}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <table class="body" style="line-height: 10px;margin-top: 10px">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th rowspan="2" style="width: 20px; text-align: left;">NO</th>
            <th rowspan="2" style="width: 265px; text-align: left;">PLU - NAMA BARANG</th>
            <th colspan="1" style="width: 50px">KEMASAN</th>
            <th colspan="1" style="width: 50px; text-align: center">QTY</th>
            <th colspan="1" style="width: 50px; text-align: center">FR</th>
            <th colspan="1" style="width: 50px; text-align: center">HARGA SAT</th>
            <th colspan="1" style="width: 50px; text-align: center">PPNBM</th>
            <th colspan="1" style="width: 50px; text-align: center">BOTOL</th>
            <th rowspan="2" style="width: 50px; text-align: left">JUMLAH</th>
        </tr>
        <tr>
            <th style="width: 50px; text-align: center">DISC #1</th>
            <th style="width: 50px; text-align: center">DISC #2</th>
            <th style="width: 50px; text-align: center">DISC #3</th>
            <th style="width: 50px; text-align: center">BONUS 1</th>
            <th style="width: 50px; text-align: center">BONUS 2</th>
            <th style="width: 100px">KETERANGAN</th>
        </tr>
        </thead>
        <tbody>
{{--        @for($i = 0; $i < 10; $i++)--}}
            <?php $no = 1 ; $total = 0; $ppn = 0; $disc4 = 0?>
            @foreach($result as $data)
                <tr style="border-top: 1px solid black">
                    <td rowspan="2" style="width: 20px; text-align: left;">{{$no++}}</td>
                    <td rowspan="2" style="width: 265px; text-align: left;">{{$data->plu}}</td>
                    <td colspan="1" style="width: 50px; text-align: center">{{$data->kemasan}}</td>
                    <td colspan="1" style="width: 50px; text-align: right">{{$data->qty}}</td>
                    <td colspan="1" style="width: 50px; text-align: right">{{$data->qtyk}}</td>
                    <td colspan="1" style="width: 50px; text-align: right">Rp. {{number_format(round($data->mstd_hrgsatuan), 0, '.', ',')}}</td>
                    <td colspan="1" style="width: 50px; text-align: right">Rp. {{number_format(round($data->mstd_ppnbmrph), 0, '.', ',')}}</td>
                    <td colspan="1" style="width: 50px; text-align: right">Rp. {{number_format(round($data->mstd_ppnbtlrph), 0, '.', ',')}}</td>
                    <td rowspan="2" style="width: 50px; text-align: right">Rp. {{number_format(round($data->jumlah), 0, '.', ',')}}</td>
                </tr>
                <tr style="">
                    <td colspan="1" style="width: 50px; text-align: right">Rp. {{number_format(round($data->rphdisc1), 0, '.', ',')}}</td>
                    <td colspan="1" style="width: 50px; text-align: right">Rp. {{number_format(round($data->disc2), 0, '.', ',')}}</td>
                    <td colspan="1" style="width: 50px; text-align: right">Rp. {{number_format(round($data->rphdisc3), 0, '.', ',')}}</td>
                    <td colspan="1" style="width: 50px; text-align: right">{{$data->qtybonus1}}</td>
                    <td colspan="1" style="width: 50px; text-align: right">{{$data->qtybonus2}}</td>
                    <td colspan="1" style="width: 50px; text-align: right">{{$data->keterangan}}</td>
                </tr>
                <tr><td colspan="9" style="height: 1px; border-bottom: 1px solid black"></td></tr>
                {{$total = $total + $data->jumlah}}
                {{$ppn = $ppn + (0.1 * $data->jumlah)}}
                {{$disc4 = $disc4 + $data->dis4}}
            @endforeach
{{--        @endfor--}}

        <tr>
            <td colspan="7" style="text-align: right"> TOTAL HARGA BELI</td>
            <td colspan="2" style="text-align: right">Rp. {{number_format(round($total), 0, '.', ',')}}</td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: right"> TOTAL PPN</td>
            <td colspan="2" style="border-bottom: 1px black solid; text-align: right">Rp. {{number_format(round($ppn), 0, '.', ',')}}</td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: right"> TOTAL SELURUHNYA</td>
            <td colspan="2" style="text-align: right"> Rp. {{number_format(round(($total + $ppn) - $disc4), 0, '.', ',')}}</td>
        </tr>
        </tbody>
    </table>

    <table style="border: 1px solid black ;margin-top: 20px">
        <tbody>
        <tr>
            <td style="border: 1px black solid; height: 60px; vertical-align: baseline; width: 235px">
                DIBUAT :
            </td>
            <td style="border: 1px black solid; height: 60px; vertical-align: baseline; width: 235px">
                MENYETUJUI :
            </td>
            <td style="border: 1px black solid; height: 60px; vertical-align: baseline; width: 235px">
            </td>
        </tr>
        <tr>
            <td>ADMINISTRASI</td>
            <td>KEPALA GUDANG</td>
            <td>SUPPLIER</td>
        </tr>
        </tbody>
    </table>
    <p>KETERANGAN : JANGKA WAKTU PENUKARAN FAKTUR PALING LAMBAT 3 BULAN SEJAK BARANG DITERIMA. <br>
        <span
            style="margin-left: 71px">APABILA LEWAT DARI WAKTU YANG DITENTUKAN TIDAK AKAN KAMI LAYANI</span>
    </p>
@endif

</body>
</html>
