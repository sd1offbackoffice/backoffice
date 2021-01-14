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
        <p>{{$datas[0]->prs_namawilayah}}</p>
    </div>
    <div style="margin-top: -40px; margin-left: 594px; line-height: 0.1px !important;">
        <span style="float: right; margin-right: 15px"> {{$today}}</span>
        <p>NPWP : &nbsp;&nbsp;&nbsp;&nbsp;{{$datas[0]->prs_npwp}}</p>
        <p>TELP&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;{{$datas[0]->prs_telepon}}</p>
    </div>
    <div style="line-height: 0.1 !important;">
        <h2 style="text-align: center">{{$datas[0]->judul}}</h2>
    </div>
    <div style="line-height: 0.1px !important;">
        <p>{{$datas[0]->label}} : {{$datas[0]->msth_nodoc}}</p>
        <p>Tanggal : {{date('d-M-y', strtotime($datas[0]->msth_tgldoc))}}</p>
    </div>
    <div style="margin-top: -50px; margin-left: 484px; line-height: 0.1px !important;">
        <p>No. Referensi &nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;{{$datas[0]->msth_nopo}}</p>
        <p>No. Sortir&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;{{$datas[0]->msth_nofaktur}}</p>
    </div>
    <hr style="margin-top: -50px">
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
            <th style="width: 35px">Hrg Satuan</th>
            <th style="width: 55px">Total</th>
        </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black">
        {{$counter = 12}}
        {{$subTotal = 0}}
        @for($i=0; $i<sizeof($datas); $i++)
            <tr>
                <td style="width: 40px">{{$datas[$i]->mstd_prdcd}}</td>
                <td style="width: 385px !important; text-align: left">{{$datas[$i]->prd_deskripsipanjang}}</td>
                <td style="width: 60px; text-align: center">{{$datas[$i]->mstd_unit}} / {{$datas[$i]->mstd_frac}}</td>
                <td style="width: 55px; text-align: center">{{$datas[$i]->ctn}}</td>
                <td style="width: 55px; text-align: center">{{$datas[$i]->pcs}}</td>
                <td style="width: 35px; text-align: center">{{$datas[$i]->mstd_hrgsatuan}}</td>
                <td style="width: 55px; text-align: center">{{$datas[$i]->total}}</td>
                {{$subTotal = $subTotal + $datas[$i]->total}}
            </tr>
            <tr>
                @if($i+1!=sizeof($datas))
                    <td style="width: 40px; border-bottom: gray 1px solid">{{$datas[$i]->hgb_kodesupplier}}</td>
                    <td style="width: 385px !important; text-align: left; border-bottom: gray 1px solid">{{$datas[$i]->sup_namasupplier}}</td>
                @else
                    <td style="width: 40px;">{{$datas[$i]->hgb_kodesupplier}}</td>
                    <td style="width: 385px !important; text-align: left;">{{$datas[$i]->sup_namasupplier}}</td>
                @endif
                <td style="width: 60px; text-align: center"></td>
                <td style="width: 55px; text-align: center"></td>
                <td style="width: 55px; text-align: center"></td>
                <td style="width: 35px; text-align: center"></td>
                <td style="width: 55px; text-align: center"></td>
            </tr>
                @if($i==$counter)
                    </tbody>
                    </table>
                    <div class="page-break"></div>
                    {{$counter = $counter + 12}}
                    <table class="table table-bordered table-responsive">
                        <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
                        <tr style="text-align: center; vertical-align: center">
                            <th style="width: 40px">PLU</th>
                            <th style="width: 385px !important; text-align: left">DESKRIPSI</th>
                            <th style="width: 60px">SATUAN</th>
                            <th style="width: 55px">QTY</th>
                            <th style="width: 55px">Fr</th>
                            <th style="width: 35px">Hrg Satuan</th>
                            <th style="width: 55px">Total</th>
                        </tr>
                        </thead>
                        <tbody style="border-bottom: 3px solid black">
                @endif
            @endfor
            </tbody>
        </table>
    <div style="line-height: 0.1px !important; margin-top: 3px; display: inline-block; margin-left: 612px">
        <label for="subTotal">SUB <span style="font-weight: bold">TOTAL</span> : </label>
        <span id="subTotal">{{$subTotal}}</span>
    </div>
    <hr style="margin-top: 20px; margin-botton: 30px">
    <div style="line-height: 0.1px !important;">
        <label for="keterangan">Keterangan : </label>
        <p id="keterangan">{{$datas[0]->msth_keterangan_header}}</p>
    </div>
    <hr style="margin-top: 20px; margin-botton: 20px">
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



</body>
</html>
