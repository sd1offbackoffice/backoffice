<html>

<head>
    <title>LAPORAN</title>
</head>

<style>
    @page {
        margin: 130px 25px 25px 25px;
        size: 595pt 442pt;
    }

    .header {
        position: fixed;
        top: -110px;
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

<body>
    <header>
        <div style="width: 100%; margin-top: -120px">
            <table style="line-height: 8px !important;">
                <tbody>
                    <tr>
                        <td>INDOGROSIR</td>
                    </tr>
                    <tr>
                        <td>(Nama Badan Hukum)*</td>
                    </tr>
                    <tr>
                        <td>(NPWP Badan Hukum)*</td>
                    </tr>
                    <tr>
                        <td>(Alamat Badan Hukum)*</td>
                    </tr>
                    <tr>
                        <td>Indogrosir ..........*</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="width: 100%; margin-left: 42.5%; padding-bottom: 25px">
            <div style="text-align: right;line-height: 0.1px !important;">
                <p> date("d-M-y H:i:s") </p>
            </div>
            <table style="line-height: 8px !important; text-align: center;">
                <tbody>
                    <tr>
                        <td>BUKTI PENERIMAAN BARANG</td>
                    </tr>
                    <tr>
                        <td>Transaksi: Pembelian*</td>
                    </tr>
                    <tr>
                        <td>No: ..........* &nbsp; Tanggal: ..........*</td>
                    </tr>
                </tbody>
            </table>
            <br>
            @php
            $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
            @endphp
            <img style="max-width: 250px;" src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode('test', $generatorPNG::TYPE_CODE_128)) }}">
        </div>
        <table style="line-height: 8px">
            <tbody>
                <tr>
                    <td>Supplier : .......... (Kode- Nama Supplier)*</td>
                </tr>
                <tr>
                    <td>N.P.W.P : .......... &nbsp; Telp. : .......... &nbsp; CP: ..........</td>
                </tr>
            </tbody>
        </table>
        <table style="line-height: 8px; margin-left: 475px; margin-top: -100px; width: 100%">
            <tbody>
                <tr>
                    <td>No. PB <span style="display: inline-block; width: 40px;"></span>: ..........</td>
                    <td><span style="display: inline-block; width: 20px;"></span>Tanggal <span style="display: inline-block; width: 40px;"></span>: ..........</td>
                </tr>
                <tr>
                    <td>No. PO <span style="display: inline-block; width: 40px;"></span>: ..........</td>
                    <td><span style="display: inline-block; width: 20px;"></span>Tanggal <span style="display: inline-block; width: 40px;"></span>: ..........</td>
                </tr>
                <tr>
                    <td>No. SJ <span style="display: inline-block; width: 41.5px;"></span>: ..........</td>
                    <td><span style="display: inline-block; width: 20px;"></span>Tanggal <span style="display: inline-block; width: 40px;"></span>: ..........</td>
                </tr>
                <tr>
                    <td>No. BA-SK <span style="display: inline-block; width: 24px;"></span>: ..........</td>
                    <td><span style="display: inline-block; width: 20px;"></span>Tanggal <span style="display: inline-block; width: 40px;"></span>: ..........</td>
                </tr>
                <tr>
                    <td>T.O.P <span style="display: inline-block; width: 46px;"></span>: ..........</td>
                    <td><span style="display: inline-block; width: 20px;"></span>Jatuh Tempo <span style="display: inline-block; width: 18.5px;"></span>: ..........</td>
                </tr>
            </tbody>
        </table>
    </header>
    <table class="body" style="line-height: 10px;margin-top: 10px; width:100%;">
        <thead style="border-top: 1px solid black; border-bottom: 1px solid black">
            <tr style="text-align: center;">
                <th rowspan="2" style="width:10px;">No.</th>
                <th rowspan="2" style="width:10px;">PLU</th>
                <th rowspan="2" style="width:60px;">Nama Barang</th>
                <th rowspan="2" style="width:10px;">Frac. / Unit</th>
                <th rowspan="1" colspan="2" style="width:30px;">Kuantitas</th>
                <th rowspan="2" style="width:10px;">Harga Satuan (Rp.)</th>
                <th rowspan="1" colspan="2" style="width:60px;">Bonus (Qty.)</th>
                <th rowspan="1" colspan="3" style="width:60px;">Discount (Rp.)</th>
                <th rowspan="2" style="width:50px;">PPN-BM* (Rp.)</th>
                <th rowspan="2" style="width:50px;">PPN Botol* (Rp.)</th>
                <th rowspan="2" style="width:50px;">Jumlah (Rp.)</th>
            </tr>
            <tr style="text-align: center;">
                <th style="width:30px;">Ctn.</th>
                <th style="width:30px;">Pcs.</th>
                <th style="width:30px;">1</th>
                <th style="width:30px;">2</th>
                <th style="width:30px;">1</th>
                <th style="width:30px;">2</th>
                <th style="width:30px;">3</th>
            </tr>
        </thead>
        <tbody>
            <tr style="text-align: center;">
                <td style="width:10px;">no</td>
                <td style="width:10px;">plu</td>
                <td style="width:60px;">barang</td>
                <td style="width:10px;">kemasan</td>
                <td style="width:30px;">qty</td>
                <td style="width:30px;">qtyk</td>
                <td style="width:10px;">mstd_hrgsatuan</td>
                <td style="width:30px;">bonus1</td>
                <td style="width:30px;">bonus2</td>
                <td style="width:10px;">disc1</td>
                <td style="width:10px;">disc2</td>
                <td style="width:10px;">disc3</td>
                <td style="width:50px;">bm</td>
                <td style="width:50px;">btl</td>
                <td style="width:50px;">jumlah</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px black solid" colspan="15"></td>
            </tr>
        </tbody>
    </table>
    <table class="body" style="line-height: 10px; margin-top: 10px; width:100%; margin-top: 10px;">
        <thead>
            <tr style="text-align: center;">
                <th style="width:60px;">Diterima,</th>
                <th colspan="2"></th>
                <th style="width:60px;">Disetujui,</th>
                <th colspan="2"></th>
                <th style="width:60px;">Dicetak,</th>
                <th colspan="2"></th>
                <th style="width:100px; text-align: left;">Total Jumlah</th>
                <th style="width:60px;">-</th>
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
                <th colspan="2"></th>
                <th style="width:100px; text-align: left;">Discount 4</th>
                <th style="width:60px;">-</th>
            </tr>
            <tr style="text-align: center;">
                <th colspan="9"></th>
                <th style="width:100px; text-align: left;">PPN-BM</th>
                <th style="width:60px;">-</th>
            </tr>
            <tr style="text-align: center;">
                <th colspan="9"></th>
                <th style="width:100px; text-align: left;">PPN-Botol</th>
                <th style="width:60px;">-</th>
            </tr>
            <tr style="text-align: center;">
                <th colspan="9"></th>
                <th style="width:100px; text-align: left;">Grand Total</th>
                <th style="width:60px;">-</th>
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
                <th style="width:60px;">Supplier</th>
                <th colspan="2"></th>
                <th style="width:60px;">Logistic Adm. Sr. Clerk</th>
                <th colspan="2"></th>
                <th style="width:60px;">Logistic Adm. Clerk</th>
                <th colspan="2"></th>
            </tr>
        </tbody>
    </table>
    <div class="page-break"></div>
    <div style="width: 100%; margin-left: 42.5%; padding-bottom: 25px">
        <table style="line-height: 8px !important; text-align: center;">
            <tbody>
                <tr>
                    <td>BERITA ACARA SELISIH KURANG</td>
                </tr>
                <tr>
                    <td>Tanggal: ..........* &nbsp; No.: ..........*<span style="display: block; height: 25px;"></span></td>
                </tr>
                <tr style="text-align: left;">
                    <td>No. Ref. BPB: ..........*</td>
                </tr>
                <tr style="text-align: left;">
                    <td>No. Ref.SJ: ..........*</td>
                </tr>
            </tbody>
        </table>
        <table style="line-height: 8px !important; width: 100%;">
            <tbody>
                <tr>
                    <td>Dengan rincian sbb:</td>
                </tr>
                <tr>
                    <td>* &nbsp; PLU <span style="display:inline-block; width: 80px;"></span>: ..........*</td>
                </tr>
                <tr>
                    <td>&nbsp; &nbsp; Deskripsi/Satuan <span style="display:inline-block; width: 26px;"></span>: ..........*</td>
                </tr>
                <tr>
                    <td>&nbsp; &nbsp; Qty BA-SK <span style="display:inline-block; width: 52.5px;"></span>: ..........*</td>
                </tr>
                <tr>
                    <td>&nbsp; &nbsp; Jumlah BA-SK <span style="display:inline-block; width: 36px;"></span>: ..........*</td>
                </tr>
                <tr>
                    <span style="display:inline-block; border-bottom: 1px solid black; width: 40%;"></span>
                </tr>
            </tbody>
        </table>
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td>* &nbsp; BKP <span style="display:inline-block; width: 79px;"></span>: ..........*</td>
                </tr>
                <tr>
                    <td>&nbsp; &nbsp; Non BKP <span style="display:inline-block; width: 60px;"></span>: ..........*</td>
                </tr>
                <tr>
                    <td>&nbsp; &nbsp; DPP <span style="display:inline-block; width: 80px;"></span>: ..........*</td>
                </tr>
                <tr>
                    <td>&nbsp; &nbsp; PPN <span style="display:inline-block; width: 80px;"></span>: ..........*</td>
                </tr>
                <tr>
                    <td>&nbsp; &nbsp; DPP+PPN <span style="display:inline-block; width: 56px;"></span>: ..........*</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>