<html>
<head>
    <title>
        LAPORAN
    </title>
</head>
</html>
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
        margin-top: 70px;
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
    .page-numbers:after { content: counter(page); }
</style>
<body>
<?php
$i = 1;
$datetime = new DateTime();
$timezone = new DateTimeZone('Asia/Jakarta');
$datetime->setTimezone($timezone);
?>

@if($data)
    <header>
        <div style="margin-top: -20px; line-height: 0.1px !important;">
            <p>{{$perusahaan->prs_namaperusahaan}}</p>
            <p>{{$perusahaan->prs_namacabang}}</p>
            {{--<p>{{$data[0]->cab_alamat2}}</p>--}}
        </div>
        <div style="margin-top: -100px; margin-left: 660px; line-height: 0.1px !important;">
            <p>{{ date("d-M-y  H:i:s") }}</p>
        </div>
        <div style="line-height: 0.1 !important; margin-top: -50px">
            <h2 style="text-align: center">** DAFTAR PERUBAHAN HARGA JUAL **</h2>
            <p style="font-size: 10px !important;text-align: center; margin-left: 0px">No. Dokumen : {{$data[0]->rsk_nodoc}}</p>
            <p style="font-size: 10px !important; text-align: center; margin-left: 0px">Tgl. Dokumen : {{date('d-M-y', strtotime($data[0]->rsk_tgldoc))}}</p>
            <p style="font-size: 10px !important;text-align: center; margin-left: 0px">{{$datas[0]->reprint}}</p>
        </div>
        {{--<p style="font-size: 10px !important;text-align: right; margin-top: -25px">{{$datas[0]->reprint}}</p>--}}
    </header>

    <main>
        <table class="table table-bordered table-responsive">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr style="text-align: center;">
                <th rowspan="2" style="width: 20px">KODE</th>
                <th rowspan="2" style="width: 140px">NAMA BARANG</th>
                <th rowspan="2" style="width: 50px">UNIT</th>
                <th colspan="2" style="width: 60px">HPP TERAKHIR</th>
                <th colspan="2" style="width: 60px">HPP RATA2</th>
                <th colspan="2" style="width: 60px">MIN JUAL</th>
                <th colspan="2" style="width: 60px">HARGA JUAL</th>
                {{--<th colspan="2" style="width: 60px">BARU</th>--}}
                <th colspan="2" style="width: 60px">MARGIN BARU</th>
                <th colspan="2" style="width: 60px">TGL AKTIF</th>
                <th colspan="2" style="width: 60px">TAG</th>
                <th colspan="2" style="width: 60px">PROMO</th>
            </tr>
            <tr>
                <th style="width: 30px">LAMA</th>
                <th style="width: 30px">BARU</th>
            </tr>
            </thead>
            <tbody style="border-bottom: 1px solid black">
            {{$temp = 0}}
            @for($i=0; $i<sizeof($data); $i++)
                {{--{{$j = $i}}--}}
                {{--{{$temp = $temp + $data[$i]->rsk_nilai}}--}}
                <tr>
                    <td style="width: 20px">{{$data[$i]->prdcd}}</td>
                    <td style="width: 140px">{{$data[$i]->prd_deskripsipanjang}}</td>
                    <td style="width: 50px">{{$data[$i]->prd_unit}}</td>
                    {{--<td style="width: 60px">{{hpp terakhir}}</td>--}}
                    {{--<td style="width: 60px">{{hpp rata}}</td>--}}
                    <td style="width: 60px">{{$data[$i]->prd_minjual}}</td>
                    <td style="width: 60px">{{$data[$i]->prd_hrgjual}}</td>
                    {{--<td style="width: 60px">{{margin baru}}</td>--}}
                    {{--<td style="width: 60px">{{aktif}}</td>--}}
                    <td style="width: 60px">{{$data[$i]->prd_kodetag}}</td>
                    {{--<td style="width: 60px">{{promo}}</td>--}}

                </tr>
            @endfor
            <tr>
                <td colspan="9" style="border-bottom: 1px black solid"></td>
            </tr>
            {{--<tr style="padding-top: 50px !important;">--}}
                {{--<td colspan="7" style="text-align: right">TOTAL :</td>--}}
                {{--<td style="text-align: right">{{number_format( $temp ,2,',','.')}}</td>--}}
                {{--<td style="text-align: right">{{$temp}}</td>--}}
            {{--</tr>--}}
            </tbody>
        </table>

        {{--<table style="font-size: 12px; margin-top: 20px">--}}
            {{--<tbody>--}}
            {{--<tr>--}}
                {{--<td style="width: 150px">Disetujui</td>--}}
                {{--<td style="width: 120px"> </td>--}}
                {{--<td style="width: 150px">Diperiksa</td>--}}
                {{--<td style="width: 120px"> </td>--}}
                {{--<td style="width: 150px">Dicetak</td>--}}
            {{--</tr>--}}
            {{--@for($i=0; $i<10; $i++)--}}
                {{--<tr><td colspan="5"></td></tr>--}}
            {{--@endfor--}}
            {{--<tr>--}}
                {{--<td style="width: 150px; border-bottom: 1px black solid">{{$datas[0]->rap_store_manager}}</td>--}}
                {{--<td style="width: 120px"></td>--}}
                {{--<td style="width: 150px;border-bottom: 1px black solid">{{$datas[0]->rap_logistic_supervisor}}</td>--}}
                {{--<td style="width: 120px"></td>--}}
                {{--<td style="width: 150px;border-bottom: 1px black solid">{{$datas[0]->rap_administrasi}}</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td style="width: 150px">Store Manager</td>--}}
                {{--<td style="width: 120px"></td>--}}
                {{--<td style="width: 150px">Logistic Supv./Jr.Supv.</td>--}}
                {{--<td style="width: 120px"></td>--}}
                {{--<td style="width: 150px">Logistic Adm. Clerk</td>--}}
            {{--</tr>--}}
            {{--</tbody>--}}
        {{--</table>--}}
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
            <h2 style="text-align: center">LAPORAN DAFTAR TOLAKAN PB / SUPPLIER </h2>
            <p style="font-size: 10px !important; text-align: center !important; margin-left: 100px">TANGGAL : -- s/d --</p>
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

@endif

</body>