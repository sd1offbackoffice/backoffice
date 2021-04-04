<html>
<head>
    <title>LAPORAN-REPACK-BIASA</title>
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
        margin-top: 152px;
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
        <p>{{$datas[0]->prs_namawilayah}}</p>
    </div>
    <div style="margin-top: -123px; margin-left: 544px; line-height: 0.1px !important;">
        <p style="">Tgl/Jam Cetak &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp; {{$today}}</p>
        <p style="">NPWP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp; {{$datas[0]->prs_npwp}}</p>
        <p style="">TELP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp; {{$datas[0]->prs_telepon}}</p>
    </div>
    <div style="line-height: 0.1 !important;">
        <h2 style="text-align: center">NOTA BARANG PREPACKING</h2>
        <h4 style="text-align: center">{{$datas[0]->judul}}</h4>
    </div>
    <div style="line-height: 0.1px !important;">
        <p>{{$RePrint}}</p>
    </div>
    <div style="margin-top: -50px; margin-left: 54px; line-height: 0.1px !important;">
        <p style="margin-top: -2px">No. NBF : {{$datas[0]->msth_nodoc}}</p>
        <p>Tanggal : {{$datas[0]->msth_tgldoc}}</p>
    </div>
    <div style="margin-top: -50px; margin-left: 454px; line-height: 0.1px !important;">
        <p style="margin-top: -2px">No. Referensi : {{$datas[0]->msth_nopo}}</p>
    </div>
    <hr style="margin-top: 20px">
</header>

<body>

    <table class="table table-bordered table-responsive">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
        <tr style="text-align: center; vertical-align: center">
            <th style="width: 40px">PLU</th>
            <th style="width: 255px !important; text-align: left">DESKRIPSI</th>
            <th style="width: 60px">SATUAN</th>
            <th style="width: 50px">QTY</th>
            <th style="width: 50px">Fr</th>
            <th style="width: 35px">PPN</th>
            <th style="width: 50px">HARGA SAT</th>
            <th style="width: 50px">PPN BM</th>
            <th style="width: 50px">BOTOL</th>
            <th style="width: 50px">JUMLAH</th>
        </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black">
        {{$counter = 10}}
        {{$cs_total = 0}}
        @for($i=0; $i<sizeof($datas); $i++)
            <tr>
                <td style="width: 40px">{{$datas[$i]->mstd_prdcd}}</td>
                <td style="width: 255px !important; text-align: left">{{$datas[$i]->prd_deskripsipanjang}}</td>
                <td style="width: 60px; text-align: center">{{$datas[$i]->mstd_unit}} / {{$datas[$i]->mstd_frac}}</td>
                <td style="width: 50px; text-align: center">{{$datas[$i]->ctn}}</td>
                <td style="width: 50px; text-align: center">{{$datas[$i]->pcs}}</td>
                <td style="width: 35px; text-align: center">{{$datas[$i]->mstd_ppnrph}}</td>
                <td style="width: 50px; text-align: center">{{$datas[$i]->mstd_hrgsatuan}}</td>
                <td style="width: 50px; text-align: center">{{$datas[$i]->mstd_ppnbmrph}}</td>
                <td style="width: 50px; text-align: center">{{$datas[$i]->mstd_ppnbtlrph}}</td>
                <td style="width: 50px; text-align: center">{{$datas[$i]->total}}</td>
                {{$cs_total = $cs_total + $datas[$i]->total}}
            </tr>
            @if($i==$counter)
        </tbody>
    </table>
    <div class="page-break"></div>
    {{$counter = $counter + 10}}
    <table class="table table-bordered table-responsive">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
        <tr style="text-align: center; vertical-align: center">
            <th style="width: 40px">PLU</th>
            <th style="width: 255px !important; text-align: left">DESKRIPSI</th>
            <th style="width: 60px">SATUAN</th>
            <th style="width: 50px">QTY</th>
            <th style="width: 50px">Fr</th>
            <th style="width: 35px">PPN</th>
            <th style="width: 50px">HARGA SAT</th>
            <th style="width: 50px">PPN BM</th>
            <th style="width: 50px">BOTOL</th>
            <th style="width: 50px">JUMLAH</th>
        </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black">
        @endif
        @endfor
        </tbody>
    </table>
    <hr>
    <p style="margin-left: 650px;margin-top: -8px;margin-bottom: 2px">TOTAL : {{$cs_total}}</p>
    <hr>
    <p style="text-align: center">KETERANGAN : {{$datas[0]->msth_keterangan_header}}</p>

<table style="font-size: 12px; margin-top: 20px">
    <tbody>
    <tr>
        <td style="width: 50px"> </td>
        <td style="width: 120px">Dibuat Oleh :</td>
        <td style="width: 110px"> </td>
        <td style="width: 120px">Diketahui :</td>
        <td style="width: 110px"> </td>
        <td style="width: 120px">Disetujui Oleh :</td>
    </tr>
    @for($i=0; $i<10; $i++)
        <tr><td colspan="5"></td></tr>
    @endfor
    <tr>
        <td style="width: 50px"> </td>
        <td style="width: 120px; border-bottom: 1px black solid"></td>
        <td style="width: 110px"> </td>
        <td style="width: 120px;border-bottom: 1px black solid"></td>
        <td style="width: 110px"> </td>
        <td style="width: 120px;border-bottom: 1px black solid"></td>
    </tr>
    <tr>
        <td style="width: 50px"> </td>
        <td style="width: 120px">Back Office</td>
        <td style="width: 110px"> </td>
        <td style="width: 120px">Ka.Adm.Logistik</td>
        <td style="width: 110px"> </td>
        <td style="width: 120px">Ass Manager Logistik</td>
    </tr>
    </tbody>
</table>
</body>

</html>
