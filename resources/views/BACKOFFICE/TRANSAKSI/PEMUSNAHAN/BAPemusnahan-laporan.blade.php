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
        /*margin-top: 70px;*/
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
        <div style="margin-top: -100px; margin-left: 660px; line-height: 0.1px !important;">
            <p>{{ date("d-M-y  H:i:s") }}</p>
        </div>
        <div style="line-height: 0.1 !important; margin-top: -50px">
            <h2 style="text-align: center">BERITA ACARA PEMUSNAHAN BARANG RUSAK</h2>
            <p style="font-size: 10px !important;text-align: center; margin-left: 0px">No. Reff PPBR : {{$datas[0]->brsk_noref}}</p>
        </div>
        <p>Pada hari ini, {{date('d-m-Y', strtotime(substr($datas[0]->brsk_tgldoc,0,10)))}}, telah dilaksanakan pemusnahan
            <br> barang rusak di Indogrosir No.Dokumen : {{$datas[0]->brsk_nodoc}} yang berlokasi di {{$datas[0]->prs_namacabang}}
            <br> Barang rusak yang dimusnahkan merupakan milik : <span style="margin-left: 100px">{{$datas[0]->prs_namaperusahaan}}</span>
        </p>
        <p style="text-align: center; margin-top: -20px">ALAMAT : {{$datas[0]->prs_alamat1}} , {{$datas[0]->prs_alamat3}}</p>
        <p style="text-align: center; margin-top: -20px">NPWP : {{$datas[0]->prs_npwp}}</p>
        <p style="font-size: 10px !important;text-align: right; margin-top: -25px"><strong>REPRINT</strong></p>
    </header>

    <main>
        <table class="table table-bordered table-responsive">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr style="text-align: center;">
                <th rowspan="2" style="width: 20px">NO</th>
                <th rowspan="2" style="width: 40px">PLU</th>
                <th rowspan="2" style="width: 285px !important; text-align: left">DESKRIPSI</th>
                <th rowspan="2" style="width: 50px">SATUAN</th>
                <th colspan="2" style="width: 60px">KUANTITAS</th>
                <th rowspan="2" style="width: 50px">HRG SATUAN</th>
                <th rowspan="2" style="width: 60px">TOTAL</th>
                <th rowspan="2" style="width: 130px; text-align: left">KETERANGAN</th>
            </tr>
            <tr>
                <th style="width: 30px">CTN</th>
                <th style="width: 30px">PCS</th>
            </tr>
            </thead>
            <tbody style="border-bottom: 1px solid black">
            {{$temp = 0}}
            @for($i=0; $i<sizeof($datas); $i++)
                {{$j = $i}}
                {{$temp = $temp + $datas[$i]->brsk_nilai}}
                <tr>
                    <td style="width: 20px">{{$j+1}}</td>
                    <td style="width: 40px">{{$datas[$i]->brsk_prdcd}}</td>
                    <td style="width: 285px !important; text-align: left">{{$datas[$i]->prd_deskripsipanjang}}</td>
                    <td style="width: 50px; text-align: center">{{$datas[$i]->prd_unit}}/{{$datas[$i]->prd_frac}}</td>
                    <td style="width: 30px; text-align: right">{{floor($datas[$i]->brsk_qty_real/$datas[$i]->prd_frac)}}</td>
                    <td style="width: 30px; text-align: right">{{$datas[$i]->brsk_qty_real%$datas[$i]->prd_frac}}</td>
                    <td style="width: 50px; text-align: right">{{number_format( $datas[$i]->brsk_hrgsatuan ,2,',','.')}}</td>
                    <td style="width: 60px; text-align: right">{{number_format( $datas[$i]->brsk_nilai ,2,',','.')}}</td>
                    <td style="width: 130px; text-align: left">{{$datas[$i]->brsk_keterangan}}</td>
                </tr>
            @endfor
            <tr>
                <td colspan="9" style="border-bottom: 1px black solid"></td>
            </tr>
            <tr style="padding-top: 50px !important;">
                <td colspan="7" style="text-align: right">TOTAL :</td>
                <td style="text-align: right">{{number_format( $temp ,2,',','.')}}</td>
                {{--<td style="text-align: right">{{$temp}}</td>--}}
            </tr>
            </tbody>
        </table>

      <table style="font-size: 12px; margin-top: 20px">
          <tbody>
          <tr>
              <td style="width: 140px">Mengetahui</td>
              <td style="width: 140px">Disaksikan</td>
              <td style="width: 140px"></td>
              <td style="width: 140px">Dilaksanakan</td>
              <td style="width: 140px">Saksi</td>
          </tr>
          @for($i=0; $i<10; $i++)
              <tr><td colspan="5"></td></tr>
          @endfor
          <tr>
              <td style="width: 140px; border-bottom: 1px black solid">{{$datas[0]->rap_store_manager}}</td>
              <td style="width: 140px; border-bottom: 1px black solid">{{$datas[0]->rap_store_adm}}</td>
              <td style="width: 140px; border-bottom: 1px black solid">{{$datas[0]->rap_logistic_supervisor}}</td>
              <td style="width: 140px; border-bottom: 1px black solid">{{$datas[0]->rap_stockkeeper_ii}}</td>
              <td style="width: 140px; border-bottom: 1px black solid"></td>
          </tr>
          <tr>
              <td style="width: 140px">Store Manager</td>
              <td style="width: 140px">Store Adm.Mgr/Logistic Mg</td>
              <td style="width: 140px">Logistic Supervisor</td>
              <td style="width: 140px">Stock Keeper-II</td>
              <td style="width: 140px">Ketua RT</td>
          </tr>
          </tbody>
      </table>
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
    </main>

@endif

</body>
</html>
