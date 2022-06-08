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
        <div style="width: 100%; margin-top: -80px">
            <table style="line-height: 8px">
                <tbody>
                    <tr>
                        <td>PT Inti Cakrawala Citra</td>
                    </tr>
                    <tr>
                        <td>..........*</td>
                    </tr>
                </tbody>
            </table>
            <table style="line-height: 8px; margin-left: 600px; margin-top: -100px; width: 100%;">
                <tbody>
                    <tr>
                        <td>Tgl. Cetak <span style="display: inline-block; width: 25px;"></span>: ..........</td>
                    </tr>
                    <tr>
                        <td>Pkl. Cetak <span style="display: inline-block; width: 25px;"></span>: ..........</td>
                    </tr>
                    <tr>
                        <td>No. SJ <span style="display: inline-block; width: 40px;"></span>: ..........</td>
                    </tr>
                    <tr>
                        <td><i>User ID</i> <span style="display: inline-block; width: 36.5px;"></span>: ..........</td>
                    </tr>
                    <tr>
                        <td>Halaman <span style="display: inline-block; width: 30.5px;"></span>: ..........</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="width: 100%; margin-left: 30%; padding-bottom: 25px">
            <table style="line-height: 8px !important; text-align: center;">
                <tbody>
                    <tr>
                        <td>DOKUMEN <i>MONITORING</i> PRODUKSI <i>ITEM(S) ROTI</i> SAY BREAD</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td style="padding-left: 50px;">Tanggal proses produksi <span style="display: inline-block; width: 20px;"></span>: ..........*</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td style="padding-left: 50px;">Proses produksi ke<span style="display: inline-block; width: 46.5px;"></span>: ..........*</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td style="padding-left: 50px;"><i>Shift</i><span style="display: inline-block; width: 109px;"></span>: ..........*</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </header>
    <table class="body" style="line-height: 10px;margin-top: 10px; width:100%;">
        <thead style="border-top: 1px solid black; border-bottom: 1px solid black">
            <tr style="text-align: center;">
                <th rowspan="2" style="width:10px;">No.</th>
                <th rowspan="2" style="width:10px;">PLU</th>
                <th rowspan="2" style="width:60px;">Deskripsi</th>
                <th rowspan="2" style="width:10px;">Total <i>Qty.</i> Produksi</th>
                <th rowspan="1" colspan="3" style="width:30px;">Hasil Proses Produksi (<i>Qty.</i>)</th>
            </tr>
            <tr style="text-align: center;">
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
                <td style="width:30px;">qtyk</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px black solid" colspan="7"></td>
            </tr>
        </tbody>
    </table>
    <table style="margin-left: 100%; padding-top: 25px;">
        <tbody>
            <tr>
                <td style="border: 1px black solid; height: 40px; vertical-align: baseline; width: 200px; text-align: center;">
                    Diterima,
                    <hr>
                    <div class="row align-items-center">
                        <div class="col-5" style="margin-top: 10px">
                            <img style="max-width: 125px;" src="../storage/signature/clerk.png"></img>
                        </div>
                    </div>
                </td>
                <td style="border: 1px black solid; height: 40px; vertical-align: baseline; width: 200px; text-align: center;">
                    Dibuat,
                    <hr>
                    <div class="row align-items-center">
                        <div class="col-5">
                            <img style="max-width: 125px; position: absolute; margin-left:30%; margin-top: 2.5%;z-index: 0;" src="../storage/signature/srclerk.png"></img>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border: 1px black solid; width: 200px; text-align: center;">
                    {{ file_get_contents('../storage/names/clerk.txt') }}
                </td>
                <td style="border: 1px black solid; width: 200px; text-align: center;">
                    {{ file_get_contents('../storage/names/srclerk.txt') }}
                </td>
            </tr>
            <tr>
                <td style="border: 1px black solid; width: 200px; text-align: center;">
                    (Duty Mgr.)
                </td>
                <td style="border: 1px black solid; width: 200px; text-align: center;">
                    (..........*)
                </td>
            </tr>
        </tbody>
    </table>
    <div style="line-height: 0.5px;">
        <p><i>Catatan :</i></p>
        <p><sup>1)</sup> <i>Qty.</i> Sukses di-<i>input</i> di program konversi.</p>
        <p><sup>2)</sup> <i>Qty.</i> Gagal dibuatkan BAP (Berita Acara Pemusnahan).</p>
        <p><sup>3)</sup> <i>Qty.</i> Cacat dibuatkan BA (Berita Acara) Tukar Gulung di program komputer Toko Igr., dan <i>email</i> ke pihak Adm. Say Bread HO (oleh Duty Mgr.).</p>
        <p>* Berisi jabatan dari pejabat yang ditunjuk untuk mengelola <i>item(s)</i> tertentu di Toko Igr.</p>
    </div>
</body>

</html>