<html>

<head>
    <title>LAPORAN</title>
</head>

<style>
    @page {
        margin: 50px 25px 25px 25px;
        size: 595pt 442pt;
    }

    .header {
        position: fixed;
        top: -50px;
        left: 0px;
        right: 0px;
        height: 100px;
        line-height: 0.1px !important;
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
    }

    .page-break {
        page-break-after: always;
    }
</style>

@if ($data)
<body>
    <header>
        <div style="width: 100%; margin-left: 32.5%; padding-bottom: 25px">
            <table style="line-height: 8px !important; text-align: center;">
                <tbody>
                    <tr>
                        <td>SURAT JALAN EKSPEDISI</td>
                    </tr>
                    <tr>
                        <td>GUDANG INDUK INDOGROSIR CIPUTAT</td>
                    </tr>
                    <tr>
                        <td>JLN RAYA PARUNG CIPUTAT NO. 21, SAWANGAN, DEPOK</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <table style="line-height: 8px; width:100%;">
            <tbody>
                <tr>
                    <td>EKSPEDISI <span style="display: inline-block; width: 50px;"></span>:</td>
                </tr>
                <tr>
                    <td>CONTAINER <span style="display: inline-block; width: 45px;"></span>:</td>
                </tr>
                <tr>
                    <td>SEAL <span style="display: inline-block; width: 74.5px;"></span>:</td>
                </tr>
                <tr>
                    <td>NO. MOBIL <span style="display: inline-block; width: 51px;"></span>:</td>
                </tr>
                <tr>
                    <td>TUJUAN <span style="display: inline-block; width: 61.5px;"></span>:</td>
                </tr>
            </tbody>
        </table>
        <table style="line-height: 8px; margin-left: 425px; margin-top: -100px; width: 100%">
            <tbody>
                <tr>
                    <td>No. SJ <span style="display: inline-block; width: 10px;"></span>:</td>
                </tr>
                <tr>
                    <td>KIRIM <span style="display: inline-block; width: 12.5px;"></span>:</td>
                </tr>
                <tr>
                    <td>KAPAL <span style="display: inline-block; width: 7px;"></span>:</td>
                </tr>
                <tr>
                    <td>ETD <span style="display: inline-block; width: 20px;"></span>:</td>
                </tr>
                <tr>
                    <td>ETA <span style="display: inline-block; width: 20px;"></span>:</td>
                </tr>
            </tbody>
        </table>
    </header>
    <table class="body" style="line-height: 10px;margin-top: 10px; width:100%;">
        <thead style="border: 1px solid black">
            <tr style="text-align: center;">
                <th style="width:5px;">NO</th>
                <th style="width:10px;">KODE</th>
                <th style="width:60px;">NAMA BARANG</th>
                <th style="width:10px;">FRAC</th>
                <th style="width:10px;">QTY</th>
                <th style="width:10px;">M3</th>
                <th style="width:10px;">TON</th>
                <th style="width:10px;">KET</th>
            </tr>
        </thead>
        <tbody style="border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black;">
            //for bla bla here
            <tr style="text-align: center;">
                <td style="width:5px;">test</td>
                <td style="width:10px;">test</td>
                <td style="width:60px; text-align: left;">test</td>
                <td style="width:10px;">test</td>
                <td style="width:10px;">test</td>
                <td style="width:10px;">test</td>
                <td style="width:10px;">test</td>
                <td style="width:10px;">test</td>
            </tr>
            //end here
            <tr style="text-align: center;">
                <td colspan="3" style="border-top: 1px solid black">TOTAL</td>
                <td colspan="2" style="border-top: 1px solid black">test</td>
                <td style="border-top: 1px solid black">test</td>
                <td style="border-top: 1px solid black">test</td>
                <td style="border-top: 1px solid black">test</td>
            </tr>
            <tr style="text-align: center;">
                <td colspan="3" style="border-top: 1px solid black"></td>
                <td colspan="3" style="border-top: 1px solid black; text-align: left;">KAPASITAS 20 FEET</td>
                <td style="border-top: 1px solid black">test</td>
                <td style="border-top: 1px solid black">test</td>
            </tr>
            <tr style="text-align: center;">
                <td colspan="3"></td>
                <td colspan="3" style="border-top: 1px solid black; text-align: left;">PEMENUHAN KAPASITAS</td>
                <td style="border-top: 1px solid black">test</td>
                <td style="border-top: 1px solid black">test</td>
            </tr>
        </tbody>
    </table>
    <table class="body" style="line-height: 10px; margin-top: 10px; width:100%; margin-left: 100px;">
        <thead>
            <tr style="text-align: center;">
                <th style="width:60px;">MENGETAHUI,</th>
                <th colspan="2"></th>
                <th style="width:60px;">DITERIMA,</th>
                <th colspan="2"></th>
                <th style="width:60px;">DIBUAT,</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            <tr style="text-align: center;">
                <th style="width:60px;">
                    <img style="max-width: 100px; position: absolute; margin-left:20%; z-index: 0;" src="../storage/signature_expedition/x.ong"></img>
                </th>
                <th colspan="2"></th>
                <th style="width:60px;">
                    <img style="max-width: 100px; position: absolute; margin-left:20%; z-index: 0;" src="../storage/signature_expedition/x.ong"></img>
                    <img style="max-width: 100px; position: absolute; margin-left:20%; z-index: 0;" src="../storage/signature_expedition/x.ong"></img>
                </th>
                <th colspan="2"></th>
                <th style="width:60px;">
                    <img style="max-width: 100px; position: absolute; margin-left:20%; z-index: 0;" src="../storage/signature_expedition/x.ong"></img>
                </th>
            </tr>
            <tr style="text-align: center;">
                <th style="width:100px;">( Nama Jelas )</th>
                <th colspan="2"></th>
                <th style="width:100px;">( Nama Jelas )</th>
                <th colspan="2"></th>
                <th style="width:100px;">( Nama Jelas )</th>
                <th colspan="2"></th>
            </tr>
            <tr style="text-align: center;">
                <th style="width:60px;">(SPV /MGR. GI)</th>
                <th colspan="2"></th>
                <th style="width:60px;">(EXPEDISI/ NAMA) (IGR CABANG)</th>
                <th colspan="2"></th>
                <th style="width:60px;">(ADM. GUDANG)</th>
                <th colspan="2"></th>
            </tr>
        </tbody>
    </table>
    <div class="keterangan" style="line-height: 4px;">
        <p>1. Setelah diperiksa, tanda terima ini ditandatangani dan distempel bahwa barang/dokumen sudah diterima dalam keadaan baik.</p>
        <p>2. Kami tidak bertanggung jawab atas kehilangan & kerusakan setelah barang /dokumen diterima & tanda terima ini ditandatangani.</p>
        <p>3. Jadwal bongkar barang di tujuan: Senin - Jum'at 08:00-16:00; Sabtu 08:00-13:00; MINGGU LIBUR</p>
    </div>
</body>
@else

<body>
    <header>
        <div style="width: 100%; margin-left: 32.5%; padding-bottom: 25px">
            <table style="line-height: 8px !important; text-align: center;">
                <tbody>
                    <tr>
                        <td>SURAT JALAN EKSPEDISI</td>
                    </tr>
                    <tr>
                        <td>GUDANG INDUK INDOGROSIR CIPUTAT</td>
                    </tr>
                    <tr>
                        <td>JLN RAYA PARUNG CIPUTAT NO. 21, SAWANGAN, DEPOK</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <table style="line-height: 8px; width:100%;">
            <tbody>
                <tr>
                    <td>EKSPEDISI <span style="display: inline-block; width: 50px;"></span>:</td>
                </tr>
                <tr>
                    <td>CONTAINER <span style="display: inline-block; width: 45px;"></span>:</td>
                </tr>
                <tr>
                    <td>SEAL <span style="display: inline-block; width: 74.5px;"></span>:</td>
                </tr>
                <tr>
                    <td>NO. MOBIL <span style="display: inline-block; width: 51px;"></span>:</td>
                </tr>
                <tr>
                    <td>TUJUAN <span style="display: inline-block; width: 61.5px;"></span>:</td>
                </tr>
            </tbody>
        </table>
        <table style="line-height: 8px; margin-left: 425px; margin-top: -100px; width: 100%">
            <tbody>
                <tr>
                    <td>No. SJ <span style="display: inline-block; width: 10px;"></span>:</td>
                </tr>
                <tr>
                    <td>KIRIM <span style="display: inline-block; width: 12.5px;"></span>:</td>
                </tr>
                <tr>
                    <td>KAPAL <span style="display: inline-block; width: 7px;"></span>:</td>
                </tr>
                <tr>
                    <td>ETD <span style="display: inline-block; width: 20px;"></span>:</td>
                </tr>
                <tr>
                    <td>ETA <span style="display: inline-block; width: 20px;"></span>:</td>
                </tr>
            </tbody>
        </table>
    </header>
    <table class="body" style="line-height: 10px;margin-top: 10px; width:100%;">
        <thead style="border: 1px solid black">
            <tr style="text-align: center;">
                <th style="width:5px;">NO</th>
                <th style="width:10px;">KODE</th>
                <th style="width:60px;">NAMA BARANG</th>
                <th style="width:10px;">FRAC</th>
                <th style="width:10px;">QTY</th>
                <th style="width:10px;">M3</th>
                <th style="width:10px;">TON</th>
                <th style="width:10px;">KET</th>
            </tr>
        </thead>
        <tbody style="border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black;">
            //for bla bla here
            <tr style="text-align: center;">
                <td style="width:5px;">test</td>
                <td style="width:10px;">test</td>
                <td style="width:60px; text-align: left;">test</td>
                <td style="width:10px;">test</td>
                <td style="width:10px;">test</td>
                <td style="width:10px;">test</td>
                <td style="width:10px;">test</td>
                <td style="width:10px;">test</td>
            </tr>
            //end here
            <tr style="text-align: center;">
                <td colspan="3" style="border-top: 1px solid black">TOTAL</td>
                <td colspan="2" style="border-top: 1px solid black">test</td>
                <td style="border-top: 1px solid black">test</td>
                <td style="border-top: 1px solid black">test</td>
                <td style="border-top: 1px solid black">test</td>
            </tr>
            <tr style="text-align: center;">
                <td colspan="3" style="border-top: 1px solid black"></td>
                <td colspan="3" style="border-top: 1px solid black; text-align: left;">KAPASITAS 20 FEET</td>
                <td style="border-top: 1px solid black">test</td>
                <td style="border-top: 1px solid black">test</td>
            </tr>
            <tr style="text-align: center;">
                <td colspan="3"></td>
                <td colspan="3" style="border-top: 1px solid black; text-align: left;">PEMENUHAN KAPASITAS</td>
                <td style="border-top: 1px solid black">test</td>
                <td style="border-top: 1px solid black">test</td>
            </tr>
        </tbody>
    </table>
    <table class="body" style="line-height: 10px; margin-top: 10px; width:100%; margin-left: 100px;">
        <thead>
            <tr style="text-align: center;">
                <th style="width:60px;">MENGETAHUI,</th>
                <th colspan="2"></th>
                <th style="width:60px;">DITERIMA,</th>
                <th colspan="2"></th>
                <th style="width:60px;">DIBUAT,</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            <tr style="text-align: center;">
                <th style="width:60px;">
                    <img style="max-width: 100px; position: absolute; margin-left:20%; z-index: 0;" src="../storage/signature_expedition/x.ong"></img>
                </th>
                <th colspan="2"></th>
                <th style="width:60px;">
                    <img style="max-width: 100px; position: absolute; margin-left:20%; z-index: 0;" src="../storage/signature_expedition/x.ong"></img>
                    <img style="max-width: 100px; position: absolute; margin-left:20%; z-index: 0;" src="../storage/signature_expedition/x.ong"></img>
                </th>
                <th colspan="2"></th>
                <th style="width:60px;">
                    <img style="max-width: 100px; position: absolute; margin-left:20%; z-index: 0;" src="../storage/signature_expedition/x.ong"></img>
                </th>
            </tr>
            <tr style="text-align: center;">
                <th style="width:100px;">( Nama Jelas )</th>
                <th colspan="2"></th>
                <th style="width:100px;">( Nama Jelas )</th>
                <th colspan="2"></th>
                <th style="width:100px;">( Nama Jelas )</th>
                <th colspan="2"></th>
            </tr>
            <tr style="text-align: center;">
                <th style="width:60px;">(SPV /MGR. GI)</th>
                <th colspan="2"></th>
                <th style="width:60px;">(EXPEDISI/ NAMA) (IGR CABANG)</th>
                <th colspan="2"></th>
                <th style="width:60px;">(ADM. GUDANG)</th>
                <th colspan="2"></th>
            </tr>
        </tbody>
    </table>
    <div class="keterangan" style="line-height: 4px;">
        <p>1. Setelah diperiksa, tanda terima ini ditandatangani dan distempel bahwa barang/dokumen sudah diterima dalam keadaan baik.</p>
        <p>2. Kami tidak bertanggung jawab atas kehilangan & kerusakan setelah barang /dokumen diterima & tanda terima ini ditandatangani.</p>
        <p>3. Jadwal bongkar barang di tujuan: Senin - Jum'at 08:00-16:00; Sabtu 08:00-13:00; MINGGU LIBUR</p>
    </div>
</body>
@endif

</html>