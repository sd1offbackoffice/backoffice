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
        size: 595pt 442pt;
    }

    /** Define now the real margins of every page in the PDF **/
    body {
        /*margin-top: 150px;*/
        margin-top: 50px;
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
        height: 1cm;
    }
    table{
        border: 1px;
    }
    .page-numbers:after { content: counter(page); }


    /*Untuk break ke paper selanjutnya*/
    .page-break {
        page-break-after: always;
    }
</style>


<body>
<!-- Define header and footer blocks before your content -->
<?php
$i = 1;
$datetime = new DateTime();
$timezone = new DateTimeZone('Asia/Jakarta');
$datetime->setTimezone($timezone);
?>

@if($datas)
    <header>
        <div style="margin-top: -20px; line-height: 0.1px !important;">
            <p>{{$datas[0]->prs_namaperusahaan}}</p>
            <p>{{$datas[0]->prs_namacabang}}</p>
            <p>{{$datas[0]->prs_namawilayah}}</p>
        </div>
        <div style="margin-top: -100px; margin-left: 620px; line-height: 0.1px !important;">
            <p>TGL : {{ date("d-M-y  H:i:s") }}</p>
            <p>PRG : ...</p>
        </div>
        <div style="line-height: 0.1 !important; margin-top: -50px">
            <h2 style="text-align: center">** LIST PENEMPATAN LOKASI BARANG  **</h2>
        </div>
    </header>

    <main>
        <table class="table table-bordered table-responsive">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr style="text-align: center;">
                <th style="width: 40px">PLU</th>
                <th style="width: 200px !important; text-align: left">NAMA BARANG</th>
                <th style="width: 50px">SATUAN</th>
                <th style="width: 30px; text-align: left">KODE RAK</th>
                <th style="width: 30px; text-align: left">SUB RAK</th>
                <th style="width: 30px; text-align: left">TIPE RAK</th>
                <th style="width: 50px; text-align: left">SELVING</th>
                <th style="width: 50px; text-align: left">QTY BESAR</th>
                <th style="width: 50px; text-align: left">QTY KECIL</th>
                <th style="width: 150px; text-align: left">KETERANGAN</th>
            </tr>

            </thead>
            <tbody style="border-bottom: 1px solid black">
                @foreach($datas as $data)
                    <tr>
                        <td style="width: 40px"> {{$data->trbo_prdcd}}</td>
                        <td style="width: 200px !important; text-align: left">{{$data->desc2}}</td>
                        <td style="width: 50px" {{$data->kemasan}}</td>
                        <td style="width: 30px; text-align: left">{{$data->lks_koderak}}</td>
                        <td style="width: 30px; text-align: left">{{$data->lks_kodesubrak}}</td>
                        <td style="width: 30px; text-align: left">{{$data->lks_tiperak}}</td>
                        <td style="width: 50px; text-align: left" {{$data->lks_shelvingrak}}</td>
                        <td style="width: 50px; text-align: left">{{$data->qty}}</td>
                        <td style="width: 50px; text-align: left">{{$data->qtyk}}</td>
                        <td style="width: 150px; text-align: left" {{$data->keterangan}}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <p style="text-align: right">*** AKHIR LAPORAN ***</p>
    </main>

@else
    <header>
        <div style="float:left; margin-top: -20px; line-height: 5px !important;">
            <p>--</p>
            <p>--</p>
        </div>
        <div style="float:right; margin-top: 0px; line-height: 5px !important;">
            <p>{{ date("d-M-y  H:i:s") }}</p>
            <p> IGR_BO_CTKTLKNPBPSUP </p>
        </div>
        <div style="line-height: 0.3 !important; text-align: center !important;">
            <h2 style="text-align: center">** LIST PENEMPATAN LOKASI BARANG **</h2>
        </div>
    </header>

    <main>

        <table class="table table-bordered table-responsive" style="">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr style="text-align: center;">
                <th rowspan="2" style="width: 20px">NO</th>
                <th rowspan="2" style="width: 40px">PLU</th>
                <th rowspan="2" style="width: 285px !important; text-align: left">DESKRIPSI</th>
                <th rowspan="2" style="width: 50px">SATUAN</th>
                <th colspan="2" style="width: 60px">KUANTITAS</th>
                <th rowspan="2" style="width: 50px">HRG SATUAN<br>IN CTN</th>
                <th rowspan="2" style="width: 50px">TOTAL</th>
                <th rowspan="2" style="width: 140px">KETERANGAN</th>
            </tr>
            <tr>
                <th style="width: 30px">QTY</th>
                <th style="width: 30px">FRAC</th>
            </tr>
            </thead>
            <tbody style="border-bottom: 1px solid black">
            <tr>
                <td colspan="8" style="text-align: center">** No Data **</td>
            </tr>
            </tbody>
        </table>
        <p style="text-align: right"> ** Akhir Dari Laporan ** </p>
    </main>

@endif

</body>
</html>

{{--                            <td style="text-align: right">{{number_format( $temp ,2,',','.')}}</td>--}}
