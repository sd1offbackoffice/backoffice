<html>
<head>
    <title>LAPORAN</title>
</head>
<style>
    /**
        Set the margins of the page to 0, so the footer and the header
        can be of the full height and width !
     **/
    @page {
        margin: 25px 25px;
    }

    /** Define now the real margins of every page in the PDF **/
    body {
        margin-top: 150px;
        margin-bottom: 10px;
        font-size: 9px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 400;
        line-height: 1.8;
        /*font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/
    }

    /** Define the header rules **/
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2cm;
    }
    table{
        border: 1px;
    }
    .page-break {
        page-break-after: always;
    }
    .page-numbers:after { content: counter(page); }
</style>


<body>
<!-- Define header and footer blocks before your content -->
<?php
$i = 1;
$datetime = new DateTime();
$timezone = new DateTimeZone('Asia/Jakarta');
$datetime->setTimezone($timezone);
?>
    <header>
        <div style="margin-top: -20px; line-height: 0.1px !important;">
            <p>{{$datas[0]->prs_namaperusahaan}}</p>
            <p>{{$datas[0]->prs_namacabang}}</p>
            <p>{{$datas[0]->prs_alamat1}}</p>
            <p>{{$datas[0]->prs_namaregional}}</p>
        </div>
        <div style="margin-top: -50px; margin-left: 594px; line-height: 0.1px !important;">
            <p>NPWP : &nbsp;&nbsp;&nbsp;&nbsp;{{$datas[0]->prs_npwp}}</p>
            <p>TELP&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;{{$datas[0]->prs_telepon}}</p>
        </div>
        <div style="line-height: 0.1 !important;">
            <h2 style="text-align: center">BUKTI SORTIR BARANG</h2>
        </div>
        <div style="line-height: 0.1px !important;">
            <p>Tanggal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{date('d-M-y', strtotime($datas[0]->srt_tglsortir))}}</p>
            <p>No. Referensi : {{$datas[0]->srt_nosortir}}</p>
        </div>
        <div style="margin-top: -50px; margin-left: 484px; line-height: 0.1px !important;">
            <p>TGL : &nbsp;&nbsp;&nbsp;&nbsp;{{date("d-M-y")}}</p>
            <p>JAM : &nbsp;&nbsp;&nbsp;&nbsp;{{date("H:i:s")}}</p>
        </div>
        <div style="margin-top: -100px; margin-left: 594px; line-height: 0.1px !important;">
            <p>PRG : </p>
        </div>
        <hr style="margin-top: 20px">
    </header>

    <body>
        <table class="table table-bordered table-responsive">
            <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
                <tr style="text-align: center; vertical-align: center">
                    <th style="width: 40px">PLU</th>
                    <th style="width: 385px !important; text-align: left">DESKRIPSI</th>
                    <th style="width: 60px">SATUAN</th>
                    <th style="width: 55px">QTY</th>
                    <th style="width: 55px">Fr</th>
                    <th style="width: 35px">TAG</th>
                    <th style="width: 25px">PT</th>
                    <th style="width: 55px">RT / TG</th>
                </tr>
            </thead>
            <tbody style="border-bottom: 3px solid black">
            {{$counter = 25}}
                @for($i=0; $i<sizeof($datas); $i++)
                    <tr>
                        <td style="width: 40px">{{$datas[$i]->srt_prdcd}}</td>
                        <td style="width: 385px !important; text-align: left">{{$datas[$i]->prd_deskripsipanjang}}</td>
                        <td style="width: 60px; text-align: center">{{$datas[$i]->satuan}}</td>
                        <td style="width: 55px; text-align: center">{{$datas[$i]->srt_qtykarton}}</td>
                        <td style="width: 55px; text-align: center">{{$datas[$i]->srt_qtypcs}}</td>
                        <td style="width: 35px; text-align: center">{{$datas[$i]->prd_kodetag}}</td>
                        @if($datas[$i]->prd_perlakuanbarang == 'PT')
                            <td style="width: 25px; text-align: center">{{$datas[$i]->prd_perlakuanbarang}}</td>
                            <td style="width: 55px; text-align: center"></td>
                            @elseif($datas[$i]->prd_perlakuanbarang == 'RT' || $datas[$i]->prd_perlakuanbarang == 'TG')
                            <td style="width: 25px; text-align: center"></td>
                            <td style="width: 55px; text-align: center">{{$datas[$i]->prd_perlakuanbarang}}</td>
                            @else
                            <td style="width: 25px; text-align: center"></td>
                            <td style="width: 55px; text-align: center"></td>
                        @endif
                    </tr>
                    @if($i==$counter)
                            </tbody>
                        </table>
                        <div class="page-break"></div>
                        {{$counter = $counter + 25}}
                        <table class="table table-bordered table-responsive">
                            <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
                            <tr style="text-align: center; vertical-align: center">
                                <th style="width: 40px">PLU</th>
                                <th style="width: 385px !important; text-align: left">DESKRIPSI</th>
                                <th style="width: 60px">SATUAN</th>
                                <th style="width: 55px">QTY</th>
                                <th style="width: 55px">Fr</th>
                                <th style="width: 35px">TAG</th>
                                <th style="width: 25px">PT</th>
                                <th style="width: 55px">RT / TG</th>
                            </tr>
                            </thead>
                            <tbody style="border-bottom: 3px solid black">

                    @endif
                @endfor
            </tbody>
        </table>
        <hr style="margin-top: 20px; margin-botton: 30px">
            <div style="line-height: 0.1px !important;">
                <label for="keterangan">Keterangan : </label>
                <p id="keterangan">{{$datas[0]->srt_keterangan}}</p>
            </div>
        <hr style="margin-top: 20px; margin-botton: 20px">
        <table style="font-size: 12px; margin-top: 20px">
            <tbody>
            <tr>
                <td style="width: 120px">Dibuat Oleh :</td>
                <td style="width: 25px"> </td>
                <td style="width: 120px">Diserahkan :</td>
                <td style="width: 25px"> </td>
                <td style="width: 120px">Diterima :</td>
                <td style="width: 25px"> </td>
                <td style="width: 120px">Diketahui :</td>
                <td style="width: 25px"> </td>
                <td style="width: 120px">Disetujui Oleh :</td>
            </tr>
            @for($i=0; $i<10; $i++)
                <tr><td colspan="5"></td></tr>
            @endfor
            <tr>
                <td style="width: 120px; border-bottom: 1px black solid"></td>
                <td style="width: 25px"> </td>
                <td style="width: 120px;border-bottom: 1px black solid"></td>
                <td style="width: 25px"> </td>
                <td style="width: 120px;border-bottom: 1px black solid"></td>
                <td style="width: 25px"> </td>
                <td style="width: 120px;border-bottom: 1px black solid"></td>
                <td style="width: 25px"> </td>
                <td style="width: 120px;border-bottom: 1px black solid"></td>
            </tr>
            <tr>
                <td style="width: 120px">Back Office</td>
                <td style="width: 25px"> </td>
                <td style="width: 120px">Ka. Stand</td>
                <td style="width: 25px"> </td>
                <td style="width: 120px">Godown Keeper</td>
                <td style="width: 25px"> </td>
                <td style="width: 120px">Log Spv/Store Spv</td>
                <td style="width: 25px"> </td>
                <td style="width: 120px">Ass. Manager Logistik</td>
            </tr>
            </tbody>
        </table>
    </body>



</body>
</html>
