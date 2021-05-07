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
        /*size: 595pt 842pt;*/
    }

    /** Define now the real margins of every page in the PDF **/
    body {
        /*margin-top: 150px;*/
        margin-top: 80px;
        margin-bottom: 30px;
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
                <p> PRG : IGR031G  </p>
            </div>
            <div style="line-height: 0.3 !important; text-align: center ;">
                <h2 style="text-align: center"><strong>** RINCIAN POS **</strong></h2>
            </div>
            <div style="margin-left: 320px">
                <table>
                    <tbody>
                    <tr>
                        <td>NO. PO</td>
                        <td> : {{$datas[0]->tpoh_nopo}}</td>
                        <td>TGL</td>
                        <td>: {{date('d-m-y', strtotime($datas[0]->tpoh_tglpo))}}</td>
                    </tr>
                    <tr>
                        <td>NO. PB</td>
                        <td> : ...</td>
                        <td>TGL</td>
                        <td> : ...</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </header>
    </header>

    <main style=" ">
        @php
            $no = 1;
        @endphp
        <div style="line-height: 0.3 !important;">
            <p style="text-align: left">{{($datas[0]->pbh_nopb) ? 'PO ATAS PB' : 'PO ALOKASI'}}</p>
            <p style="text-align: left">{{$datas[0]->supplier}}</p>
        </div>
        <table class="table table-bordered table-responsive" style=" ">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr style="text-align: center">
                <th style="width: 50px">NO</th>
                <th style="width: 330px;">NAMA BARANG</th>
                <th style="width: 65px">SATUAN</th>
                <th style="width: 65px">BARC</th>
                <th style="width: 65px">KUANTITAS</th>
                <th style="width: 65px">1</th>
                <th style="width: 65px">BONUS 2</th>
            </tr>
            </thead>
            <tbody style="border-bottom: 1px solid black">
            @foreach($datas as $data)
                <tr>
                    <td rowspan="3" style="width: 50px; text-align: center">{{$no++}}</td>
                    <td colspan="1" style="width: 330px">{{$data->tpod_prdcd}}</td>
                    <td rowspan="3" style="width: 65px; text-align: center">{{$data->satuan}}</td>
                    <td rowspan="3" style="width: 65px; text-align: center">{{$data->prd_flagbarcode1}}</td>
                    <td rowspan="3" style="width: 65px; text-align: center">----------------------</td>
                    <td rowspan="3" style="width: 65px; text-align: center">{{$data->tpod_bonuspo1}}</td>
                    <td rowspan="3" style="width: 65px; text-align: center">{{$data->tpod_bonuspo2}}</td>
                </tr>
                <tr>
                    <td>{{$data->prd_deskripsipanjang}}</td>
                </tr>
                <tr>
                    <td>Sat Jual : {{$data->satjual}}</td>
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
            <p> PRG : IGR031G  </p>
        </div>
        <div style="line-height: 0.3 !important; text-align: center !important;">
            <h2 style="text-align: center"><strong>** RINCIAN PO **</strong></h2>
            <p style="text-align: center">NO. PO : ...    <span>TGL : </span>  ...</p>
            <p style="text-align: center">NO. PB : ...    <span>TGL : </span>  ...</p>
        </div>
    </header>

    <main style="margin-top: 10px">
        <div style="line-height: 0.3 !important;">
            <p style="text-align: left">PO ATAS PB</p>
            <p style="text-align: left">...</p>
        </div>
        <table class="table table-bordered table-responsive" style="">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr>
                <th style="width: 50px">NO</th>
                <th style="width: 400px">NAMA BARANG</th>
                <th style="width: 80px">SATUAN</th>
                <th style="width: 80px">BARC</th>
                <th style="width: 80px">KUANTITAS</th>
                <th style="width: 80px">1</th>
                <th style="width: 80px">BONUS 2</th>
            </tr>
            </thead>
            <tbody style="border-bottom: 1px solid black">
            <tr>
                <td colspan="7" style="text-align: center">** No Data **</td>
            </tr>
            </tbody>
        </table>
        <p style="text-align: right"> ** Akhir Dari Laporan ** </p>
    </main>

@endif

</body>
</html>
