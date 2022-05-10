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
        margin-top: 60px;
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

    table {
        border: 1px;
    }

    .page-numbers:after {
        content: counter(page);
    }


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
        <div style="float:left; margin-top: -20px; line-height: 5px !important;">
            <p>{{$datas[0]->prs_namaperusahaan}}</p>
            <p>{{$datas[0]->prs_namacabang}}</p>
        </div>
        <div style="float:right; margin-top: 0px; line-height: 5px !important;">
            <p>{{ date("d-M-y  H:i:s") }}</p>
            <p> PRG : IGR031G </p>
        </div>
    </header>

    <main style="margin-top: 10px">
        <div style="line-height: 0.3 !important; text-align: center ;">
            <p style="text-align: center">** LIST DRAFT PO **</p>
            <p style="text-align: center">NO. PO : {{$datas[0]->tpoh_nopo}}<span style="margin-left: 1rem;">SUPPPLIER : </span> {{$datas[0]->supplier}}</p>
            <p>TANGGAL : {{date('d-m-y', strtotime($datas[0]->tpoh_tglpo))}}</p><p style="float: right;">{{$datas[0]->alokasi}}</p>
        </div>
        <table class="table table-bordered table-responsive" style="">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
                <tr style="text-align: center;">
                    <th colspan="1" style="width: 50px">PLU</th>
                    <th colspan="6" style="width: 240px">NAMA BARANG</th>
                    <th rowspan="2" style="width: 40px">KONVERSI</th>
                    <th rowspan="2" style="width: 20px">QTY B</th>
                    <th rowspan="2" style="width: 20px">QTY K</th>
                    <th rowspan="2" style="width: 40px; text-align: center">HRG.SAT</th>
                    <th rowspan="2" style="width: 40px; text-align: center">GROSS</th>
                    <th rowspan="2" style="width: 40px; text-align: center">DISC</th>
                    <th rowspan="2" style="width: 40px; text-align: center">PPN</th>
                    <th rowspan="2" style="width: 40px; text-align: center">PPN BM</th>
                    <th rowspan="2" style="width: 40px; text-align: center">PPN BOTOL</th>
                </tr>
                <tr>
                    <th style="width: 50px">DISC-1</th>
                    <th style="width: 40px">DISC-2</th>
                    <th style="width: 40px">DISC-3</th>
                    <th style="width: 40px">BNS PO1</th>
                    <th style="width: 40px">BNS PO2</th>
                    <th style="width: 40px">BNS BPB1</th>
                    <th style="width: 40px">BNS BPB2</th>
                </tr>
            </thead>
            <tbody style="border-bottom: 1px solid black">
                @foreach($datas as $data)
                <tr>
                    <td colspan="1" style="width: 50px">{{$data->prd_prdcd}}</td>
                    <td colspan="6" style="width: 240px">{{$data->prd_deskripsipanjang}}</td>
                    <td style="width: 40px">{{$data->konversi}}</td>
                    <td style="width: 20px; text-align: center">{{$data->qty}}</td>
                    <td style="width: 20px; text-align: center">{{$data->qtyk}}</td>
                    <td style="width: 40px; text-align: center">{{number_format(round($data->tpod_hrgsatuan) ,2,',','.')}}</td>
                    <td style="width: 40px; text-align: center">{{number_format(round($data->tpod_gross) ,2,',','.')}}</td>
                    <td style="width: 40px; text-align: center">{{number_format(round($data->tpod_rphttldisc) ,2,',','.')}}</td>
                    <td style="width: 40px; text-align: center">{{number_format(round($data->tpod_ppn) ,2,',','.')}}</td>
                    <td style="width: 40px; text-align: center">{{number_format(round($data->tpod_ppnbm) ,2,',','.')}}</td>
                    <td style="width: 40px; text-align: center">{{number_format(round($data->tpod_ppnbotol) ,2,',','.')}}</td>
                </tr>
                <tr>
                    <td style="width: 50px; text-align: center">{{$data->discount1}}</td>
                    <td style="width: 40px; text-align: center">{{$data->discount2}}</td>
                    <td style="width: 40px; text-align: center">{{$data->discount3}}</td>
                    <td style="width: 40px; text-align: center">{{$data->tpod_bonuspo1}}</td>
                    <td style="width: 40px; text-align: center">{{$data->tpod_bonuspo2}}</td>
                    <td style="width: 40px; text-align: center">{{$data->tpod_bonusbpb1}}</td>
                    <td style="width: 40px; text-align: center">{{$data->tpod_bonusbpb2}}</td>
                    <td colspan="6">Sat Jual : {{$data->satjual}}</td>
                </tr>
                @endforeach
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
            <p> PRG : IGR031G </p>
        </div>
        <div style="line-height: 0.3 !important; text-align: center !important;">
            <p style="text-align: center">** LIST DRAFT PO **</p>
            <p style="text-align: center">NO. PO : ... <span>SUPPPLIER : </span> ...</p>
            <p style="text-align: center">TANGGAL : ... </p>
        </div>
    </header>

    <main style="margin-top: 10px">
        <table class="table table-bordered table-responsive" style="">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
                <tr style="text-align: center;">
                    <th colspan="1" style="width: 50px">PLU</th>
                    <th colspan="6" style="width: 300px">NAMA BARANG</th>
                    <th rowspan="2" style="width: 40px">KONVERSI</th>
                    <th rowspan="2" style="width: 20px">QTY B</th>
                    <th rowspan="2" style="width: 20px">QTY K</th>
                    <th rowspan="2" style="width: 40px">HRG.SAT</th>
                    <th rowspan="2" style="width: 40px">GROSS</th>
                    <th rowspan="2" style="width: 40px">DISC</th>
                    <th rowspan="2" style="width: 40px">PPN</th>
                    <th rowspan="2" style="width: 40px">PPN BM</th>
                    <th rowspan="2" style="width: 40px">PPN BOTOL</th>
                </tr>
                <tr>
                    <th style="width: 50px">DISC-1</th>
                    <th style="width: 50px">DISC-2</th>
                    <th style="width: 50px">DISC-3</th>
                    <th style="width: 50px">BNS PO1</th>
                    <th style="width: 50px">BNS PO2</th>
                    <th style="width: 50px">BNS BPB1</th>
                    <th style="width: 50px">BNS BPB2</th>
                </tr>
            </thead>
            <tbody style="border-bottom: 1px solid black">
                <tr>
                    <td colspan="16" style="text-align: center">** No Data **</td>
                </tr>
            </tbody>
        </table>
        <p style="text-align: right"> ** Akhir Dari Laporan ** </p>
    </main>

    @endif

</body>

</html>