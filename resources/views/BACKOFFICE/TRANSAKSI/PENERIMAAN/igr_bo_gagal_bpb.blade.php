<html>

<head>
    <title>Berita Acara - Gagal Proses BPB</title>
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

    body {
        font-size: 9px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: bold;
    }
</style>

<body>
    <header>
        <div style="width: 100%">
            <div style="margin-top: -120px;">
                <p>{{$kodeigr}} / {{$toko}}</p>
            </div>
            <div style="margin-top: -120px;">
                <p style="text-align: center">BERITA ACARA</p>
                <p style="text-align: center">- GAGAL PROSES BPB -</p>
            </div>
            <table style="line-height: 8px !important; padding-top: 10%;">
                <tbody>
                    <tr>
                        <td>No. / Tanggal SJ</td>
                        <td>: {{$noBTB}} / {{$date}}</td>
                    </tr>
                    <tr>
                        <td>Kode / Nama Supplier</td>
                        <td>: {{$code}} / {{$name}}</td>
                    </tr>
                </tbody>
            </table>
            <p>Tidak dapat diproses, karena tidak ada data SJ.</p>
        </div>
    </header>
    <table style="margin: 0 auto; padding-top: 25%;">
        <tbody>
            <tr>
                <td style="border: 1px black solid; height: 60px; vertical-align: baseline; width: 240px; text-align: center;">
                    Dicetak,
                    <hr>
                    <div class="row align-items-center">
                        <div class="col-5" style="margin-top: 10px; height: 120px;">
                            <img style="max-width: 120px; position: absolute; margin-left:25%; z-index: 0;" src="../storage/signature/srclerk.png"></img>
                            <span style="padding-top: 30px;"></span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border: 1px black solid; width: 240px; text-align: center;">
                    {{ file_get_contents('../storage/names/srclerk.txt') }}
                </td>
            </tr>
            <tr>
                <td style="border: 1px black solid; width: 240px; text-align: center;">
                    Logistic Adm. Clerk
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>