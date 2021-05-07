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
        /*size: 595pt 842pt;*/
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
        <header>
            <div style="float:left; margin-top: -20px; line-height: 5px !important;">
                <p>{{$datas[0]->prs_namaperusahaan}}</p>
                <p>{{$datas[0]->prs_namacabang}}</p>
            </div>
            <div style="float:right; margin-top: 0px; line-height: 5px !important;">
                <p>{{ date("d-M-y  H:i:s") }}</p>
                <p> PRG : IGR031E  </p>
            </div>
            <div style="line-height: 0.3 !important; text-align: center !important;">
                <p style="text-align: center">** DAFTAR TRANSAKSI YANG BELUM PROSES BPB **</p>
                <p style="text-align: center">TANGGAL : {{date('m-d-y', strtotime($datas[0]->startdate))}} s/d {{date('m-d-y', strtotime($datas[0]->enddate))}}</p>
            </div>
        </header>
    </header>

    <main>
        <table class="table table-bordered table-responsive" style="">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr style="text-align: center;">
                <th rowspan="2" style="width: 50px">NO</th>
                <th colspan="2" style="width: 120px">*********** BPB ***********</th>
                <th rowspan="2" style="width: 50px">TOP</th>
                <th rowspan="2" style="width: 50px">J.TEMPO</th>
                <th rowspan="2" style="width: 180px">***************************** SUPPLIER *****************************</th>
                <th rowspan="2" style="width: 70px; text-align: right">GROSS</th>
                <th rowspan="2" style="width: 70px; text-align: right">POTONGAN</th>
                <th rowspan="2" style="width: 70px; text-align: right">PPN</th>
                <th rowspan="2" style="width: 70px; text-align: right">PPN - BM</th>
                <th rowspan="2" style="width: 70px; text-align: right">BOTOL</th>
                <th rowspan="2" style="width: 70px; text-align: right">TOTAL NILAI</th>
                <th rowspan="2" style="width: 70px;">STATUS</th>
            </tr>
            <tr>
                <th style="width: 60px">NOMOR</th>
                <th style="width: 60px">TANGGAL</th>
            </tr>
            </thead>
            <tbody style="border-bottom: 1px solid black">
            @php
            $no = 1;
            $total_gross = 0;
            $total_potongan = 0;
            $total_ppn = 0;
            $total_bm = 0;
            $total_btl = 0;
            $total_nilai = 0;
            @endphp
            @foreach($datas as $data)
                <tr>
                    <td style="width: 50px">{{$no++}}</td>
                    <td style="width: 60px">{{$data->trbo_nodoc}}</td>
                    <td style="width: 60px">{{date('d-m-y', strtotime($data->trbo_tgldoc))}}</td>
                    <td style="width: 50px;text-align: center">{{$data->top}}</td>
                    <td style="width: 50px">{{date('d-m-y', strtotime($data->jkwkt))}}</td>
                    <td style="width: 180px">{{$data->supplier}}</td>
                    <td style="width: 70px; text-align: right">{{number_format($data->gross ,2,',','.')}}</td>
                    <td style="width: 70px; text-align: right">{{number_format($data->pot ,2,',','.')}}</td>
                    <td style="width: 70px; text-align: right">{{number_format($data->ppn ,2,',','.')}}</td>
                    <td style="width: 70px; text-align: right">{{number_format($data->bm ,2,',','.')}}</td>
                    <td style="width: 70px; text-align: right">{{number_format($data->btl ,2,',','.')}}</td>
                    <td style="width: 70px; text-align: right">{{number_format($data->total ,2,',','.')}}</td>
                    <td style="width: 70px; text-align: center">{{$data->status}}</td>
                </tr>
                @php
                    $total_gross = $total_gross + $data->gross;
                    $total_potongan = $total_potongan + $data->pot;
                    $total_ppn = $total_ppn + $data->ppn;
                    $total_bm = $total_bm + $data->bm;
                    $total_btl = $total_btl + $data->btl;
                    $total_nilai = $total_nilai + $data->total;
                @endphp
            @endforeach
            <tr>
                <td colspan="6">TOTAL SELURUHNYA</td>
                <td style="width: 70px; text-align: right">{{number_format($total_gross ,2,',','.')}}</td>
                <td style="width: 70px; text-align: right">{{number_format($total_potongan ,2,',','.')}}</td>
                <td style="width: 70px; text-align: right">{{number_format($total_ppn ,2,',','.')}}</td>
                <td style="width: 70px; text-align: right">{{number_format($total_bm ,2,',','.')}}</td>
                <td style="width: 70px; text-align: right">{{number_format($total_btl ,2,',','.')}}</td>
                <td style="width: 70px; text-align: right">{{number_format($total_nilai ,2,',','.')}}</td>
            </tr>
            </tbody>
        </table>
        <p style="text-align: right"> ** Akhir Dari Laporan ** </p>
    </main>

@else
    <header>
        <div style="float:left; margin-top: -20px; line-height: 5px !important;">
            <p>PT.INTI CAKRAWALA CITRA</p>
            <p>INDOGROSIR SEMARANG</p>
        </div>
        <div style="float:right; margin-top: 0px; line-height: 5px !important;">
            <p>{{ date("d-M-y  H:i:s") }}</p>
            <p> PRG : IGR031E  </p>
        </div>
        <div style="line-height: 0.3 !important; text-align: center !important;">
            <p style="text-align: center">** DAFTAR TRANSAKSI YANG BELUM PROSES BPB **</p>
            <p style="text-align: center">TANGGAL : ... s/d ...</p>
        </div>
    </header>

    <main>
        <table class="table table-bordered table-responsive" style="">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr style="text-align: center;">
                <th rowspan="2" style="width: 50px">NO</th>
                <th colspan="2" style="width: 120px">*********** BPB ***********</th>
                <th rowspan="2" style="width: 50px">TOP</th>
                <th rowspan="2" style="width: 50px">J.TEMPO</th>
                <th rowspan="2" style="width: 150px">******************* SUPPLIER *******************</th>
                <th rowspan="2" style="width: 70px; text-align: right">GROSS</th>
                <th rowspan="2" style="width: 70px; text-align: right">POTONGAN</th>
                <th rowspan="2" style="width: 70px; text-align: right">PPN</th>
                <th rowspan="2" style="width: 70px; text-align: right">PPN - BM</th>
                <th rowspan="2" style="width: 70px; text-align: right">BOTOL</th>
                <th rowspan="2" style="width: 70px; text-align: right">TOTAL</th>
                <th rowspan="2" style="width: 70px; text-align: right">TOTAL NILAI</th>
                <th rowspan="2" style="width: 70px;">STATUS</th>
            </tr>
            <tr>
                <th style="width: 60px">NOMOR</th>
                <th style="width: 60px">TANGGAL</th>
            </tr>
            </thead>
            <tbody style="border-bottom: 1px solid black">
            <tr>
                <td colspan="14" style="text-align: center">** No Data **</td>
            </tr>
            </tbody>
        </table>
        <p style="text-align: right"> ** Akhir Dari Laporan ** </p>
    </main>

@endif

</body>
</html>
