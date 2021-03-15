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
        </div>
        <div style="margin-top: -100px; margin-left: 620px; line-height: 0.1px !important;">
            <p>TGL : {{ date("d-M-y  H:i:s") }}</p>
            <p>PRG : IGR_BO_CTBTBLIS</p>
        </div>
        <div style="line-height: 0.1 !important; margin-top: -50px">
            <h2 style="text-align: center">** EDIT LIST PENERIMAAN BARANG **</h2>
        </div>
{{--        <div>--}}
{{--            <table>--}}
{{--                <tr style="line-height: 10px">--}}
{{--                    <td>NOMOR TRN</td>--}}
{{--                    <td>: {{$datas[0]->trbo_nodoc}}</td>--}}
{{--                </tr>--}}
{{--                <tr style="line-height: 10px">--}}
{{--                    <td>TANGGAL</td>--}}
{{--                    <td>: {{$datas[0]->trbo_tgldoc}}</td>--}}
{{--                </tr>--}}
{{--                <tr style="line-height: 10px">--}}
{{--                    <td>PO</td>--}}
{{--                    <td>: NO. {{$datas[0]->trbo_nopo}}</td>--}}
{{--                    <td>TANGGAL</td>--}}
{{--                    <td>: {{$datas[0]->trbo_tglpo}}</td>--}}
{{--                </tr>--}}
{{--                <tr style="line-height: 10px">--}}
{{--                    <td>FAKTUR</td>--}}
{{--                    <td>: NO. {{$datas[0]->trbo_nofaktur}}</td>--}}
{{--                    <td>TANGGAL</td>--}}
{{--                    <td>: {{$datas[0]->trbo_tglfaktur}}</td>--}}
{{--                </tr>--}}
{{--                <tr style="line-height: 10px">--}}
{{--                    <td>SUPPLIER</td>--}}
{{--                    <td>: {{$datas[0]->supplier}}</td>--}}
{{--                </tr>--}}
{{--                <tr style="line-height: 10px">--}}
{{--                    <td>T.O.P</td>--}}
{{--                    <td>: {{$datas[0]->sup_top}} HARI</td>--}}
{{--                </tr>--}}
{{--            </table>--}}
{{--        </div>--}}
    </header>

    <main>
        <p style="color: white">{{$no = 0}}</p>
        @for($i=0; $i < sizeof($datas); $i++)
            @if($i == 0 || $datas[$i]->trbo_nodoc != $datas[$i-1] ->trbo_nodoc)
                @if($i != 0)
                    <div class="page-break"></div>
                @endif
                <div>
                    <table>
                        <tr style="line-height: 10px">
                            <td>NOMOR TRN</td>
                            <td>: {{$datas[$i]->trbo_nodoc}}</td>
                        </tr>
                        <tr style="line-height: 10px">
                            <td>TANGGAL</td>
                            <td>: {{$datas[$i]->trbo_tgldoc}}</td>
                        </tr>
                        <tr style="line-height: 10px">
                            <td>PO</td>
                            <td>: NO. {{$datas[$i]->trbo_nopo}}</td>
                            <td>TANGGAL</td>
                            <td>: {{$datas[$i]->trbo_tglpo}}</td>
                        </tr>
                        <tr style="line-height: 10px">
                            <td>FAKTUR</td>
                            <td>: NO. {{$datas[$i]->trbo_nofaktur}}</td>
                            <td>TANGGAL</td>
                            <td>: {{$datas[$i]->trbo_tglfaktur}}</td>
                        </tr>
                        <tr style="line-height: 10px">
                            <td>SUPPLIER</td>
                            <td>: {{$datas[$i]->supplier}}</td>
                        </tr>
                        <tr style="line-height: 10px">
                            <td>T.O.P</td>
                            <td>: {{$datas[$i]->sup_top}} HARI</td>
                        </tr>
                    </table>
                </div>

                    <table class="table table-bordered table-responsive">
                        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
                        <tr style="text-align: center;">
                            <th rowspan="2" style="width: 20px">NO</th>
                            <th rowspan="2" style="width: 40px">PLU</th>
                            <th rowspan="2" style="width: 155px !important; text-align: left">NAMA BARANG</th>
                            <th rowspan="2" style="width: 50px">KEMASAN</th>
                            <th colspan="2" style="width: 60px; text-align: center">KWANTUM</th>
                            <th colspan="2" style="width: 50px; text-align: center">BONUS</th>
                            <th rowspan="2" style="width: 60px">HARGA BELI</th>
                            <th colspan="2" style="width: 100px; text-align: center">--- POTONGAN ---</th>
                            <th rowspan="2" style="width: 30px; text-align: left">PPN</th>
                            <th rowspan="2" style="width: 30px; text-align: left">BM</th>
                            <th rowspan="2" style="width: 30px; text-align: left">BOTOL</th>
                            <th rowspan="2" style="width: 50px; text-align: left">TOTAL</th>
                        </tr>
                        <tr>
                            <th style="width: 30px">BESAR</th>
                            <th style="width: 30px">KECIL</th>
                            <th style="width: 30px">1</th>
                            <th style="width: 30px">2</th>
                            <th style="width: 30px">1</th>
                            <th style="width: 30px">2</th>
                        </tr>
                        </thead>
                        <tbody style="border-bottom: 1px solid black">
                        {{$totalPtg1 = 0, $totalPtg2 = 0, $totalPPN = 0, $totalBM = 0, $totalBTL = 0, $grandTotal = 0}}
                        @for($j=$i; $j< sizeof($datas); $j++)
                            <tr>
                                <td style="width: 20px">{{$no = $no+1}}</td>
                                <td style="width: 40px">{{$datas[$j]->trbo_prdcd}}</td>
                                <td style="width: 155px">{{$datas[$j]->prd_deskripsipanjang}}</td>
                                <td style="width: 50px">{{$datas[$j]->kemasan}}</td>
                                <td style="width: 30px">{{$datas[$j]->qtyk}}</td>
                                <td style="width: 30px">{{$datas[$j]->qty}}</td>
                                <td style="width: 30px">{{$datas[$j]->trbo_qtybonus1}}</td>
                                <td style="width: 30px">{{$datas[$j]->trbo_qtybonus2}}</td>
                                <td style="width: 60px">{{number_format( $datas[$j]->trbo_hrgsatuan ,2,',','.')}}</td>
                                <td style="width: 30px">{{number_format( $datas[$j]->ptg1 ,2,',','.')}}</td>
                                <td style="width: 30px">{{number_format( $datas[$j]->ptg2 ,2,',','.')}}</td>
                                <td style="width: 30px">{{number_format( $datas[$j]->trbo_ppnrph ,2,',','.')}}</td>
                                <td style="width: 30px">{{number_format( $datas[$j]->trbo_ppnbmrph ,2,',','.')}}</td>
                                <td style="width: 30px">{{number_format( $datas[$j]->trbo_ppnbtlrph ,2,',','.')}}</td>
                                <td>{{number_format( $datas[$j]->total ,2,',','.')}}</td>
                            </tr>
                            {{$totalPtg1 = $totalPtg1 + $datas[$j]->ptg1}}
                            {{$totalPtg2 = $totalPtg2 + $datas[$j]->ptg2}}
                            {{$totalPPN = $totalPPN + $datas[$j]->trbo_ppnrph}}
                            {{$totalBM = $totalBM + $datas[$j]->trbo_ppnbmrph}}
                            {{$totalBTL = $totalBTL + $datas[$j]->trbo_ppnbtlrph}}
                            {{$grandTotal = $grandTotal + $datas[$j]->total}}
                            @if($j == sizeof($datas)-1 || $datas[$j]->trbo_nodoc != $datas[$j+1]->trbo_nodoc)
                                <tr>
                                    <td colspan="15" style="border-bottom: 1px black solid"></td>
                                </tr>
                                <tr style="padding-top: 50px !important;">
                                    <td colspan="9" style="text-align: left">**TOTAL KESELURUHAN</td>
                                    <td style="width: 30px">{{number_format($totalPtg1 ,2,',','.')}}</td>
                                    <td style="width: 30px">{{number_format($totalPtg2 ,2,',','.')}}</td>
                                    <td style="width: 30px">{{number_format($totalPPN ,2,',','.')}}</td>
                                    <td style="width: 30px">{{number_format($totalBM ,2,',','.')}}</td>
                                    <td style="width: 30px">{{number_format($totalBTL ,2,',','.')}}</td>
                                    <td>{{number_format($grandTotal ,2,',','.')}}</td>
                                </tr>
                                @break
                            @endif
                        @endfor
                        </tbody>
                    </table>
            @endif
        @endfor
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

{{--                            <td style="text-align: right">{{number_format( $temp ,2,',','.')}}</td>--}}
