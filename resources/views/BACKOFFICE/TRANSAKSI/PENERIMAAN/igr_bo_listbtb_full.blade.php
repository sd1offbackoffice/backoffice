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
        size: 595pt 842pt;
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
        {{-- <div>--}}
        {{-- <table>--}}
        {{-- <tr style="line-height: 10px">--}}
        {{-- <td>NOMOR TRN</td>--}}
        {{-- <td>: {{$datas[0]->trbo_nodoc}}</td>--}}
        {{-- </tr>--}}
        {{-- <tr style="line-height: 10px">--}}
        {{-- <td>TANGGAL</td>--}}
        {{-- <td>: {{$datas[0]->trbo_tgldoc}}</td>--}}
        {{-- </tr>--}}
        {{-- <tr style="line-height: 10px">--}}
        {{-- <td>PO</td>--}}
        {{-- <td>: NO. {{$datas[0]->trbo_nopo}}</td>--}}
        {{-- <td>TANGGAL</td>--}}
        {{-- <td>: {{$datas[0]->trbo_tglpo}}</td>--}}
        {{-- </tr>--}}
        {{-- <tr style="line-height: 10px">--}}
        {{-- <td>FAKTUR</td>--}}
        {{-- <td>: NO. {{$datas[0]->trbo_nofaktur}}</td>--}}
        {{-- <td>TANGGAL</td>--}}
        {{-- <td>: {{$datas[0]->trbo_tglfaktur}}</td>--}}
        {{-- </tr>--}}
        {{-- <tr style="line-height: 10px">--}}
        {{-- <td>SUPPLIER</td>--}}
        {{-- <td>: {{$datas[0]->supplier}}</td>--}}
        {{-- </tr>--}}
        {{-- <tr style="line-height: 10px">--}}
        {{-- <td>T.O.P</td>--}}
        {{-- <td>: {{$datas[0]->sup_top}} HARI</td>--}}
        {{-- </tr>--}}
        {{-- </table>--}}
        {{-- </div>--}}
    </header>

    <main>
        <p style="color: white">{{$no = 0}}</p>
        @for($i=0; $i < sizeof($datas); $i++) @if($i==0 || $datas[$i]->trbo_nodoc != $datas[$i-1] ->trbo_nodoc)
            @if($i != 0)
            @php
            $no = 0;
            @endphp
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
                        <td style="text-align: right;">{{$re_print}}</td>
                    </tr>
                </table>
            </div>

            <table class="table table-bordered table-responsive">
                <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
                    <tr>
                        <th rowspan="2" style="width: 20px; text-align: center">NO</th>
                        <th rowspan="2" style="width: 30px; text-align: center">PLU</th>
                        <th rowspan="2" style="width: 60px !important; text-align: center">NAMA BARANG</th>
                        <th rowspan="2" style="width: 30px; text-align: center">KEMASAN</th>
                        <th colspan="2" style="width: 50px; text-align: center">KWANTUM</th>
                        <th colspan="2" style="width: 50px; text-align: center">-- BONUS --</th>
                        <th rowspan="2" style="width: 30px; text-align: center">HARGA BELI</th>
                        <th colspan="2" style="width: 50px; text-align: center">-- POTONGAN --</th>
                        <th rowspan="2" style="width: 20px; text-align: center">PPN</th>
                        <th rowspan="2" style="width: 20px; text-align: center">PPN BEBAS</th>
                        <th rowspan="2" style="width: 20px; text-align: center">PPN DITANGGUNG PEMERINTAH</th>
                        <th rowspan="2" style="width: 20px; text-align: center">BM</th>
                        <th rowspan="2" style="width: 20px; text-align: center">BOTOL</th>
                        <th rowspan="2" style="width: 20px; text-align: center">TOTAL</th>
                    </tr>
                    <tr>
                        <th style="width: 30px; text-align: center">BESAR</th>
                        <th style="width: 30px; text-align: center">KECIL</th>
                        <th style="width: 30px; text-align: center">1</th>
                        <th style="width: 30px; text-align: center">2</th>
                        <th style="width: 30px; text-align: center">1</th>
                        <th style="width: 30px; text-align: center">2</th>
                    </tr>
                </thead>
                <tbody style="border-bottom: 1px solid black">
                    {{$totalDisc3 = 0, $totalDisc4 = 0, $totalPtg1 = 0, $totalPtg2 = 0, $totalPPN = 0, $totalPPNBebas = 0, $totalPPNPemerintah = 0, $totalBM = 0, $totalBTL = 0, $grandTotal = 0}}
                    @for($j=$i; $j< sizeof($datas); $j++) <tr>
                        <td style="width: 20px; text-align: center">{{$no = $no+1}}</td>
                        <td style="width: 30px; text-align: center">{{$datas[$j]->trbo_prdcd}}</td>
                        <td style="width: 60px; text-align: center">{{$datas[$j]->prd_deskripsipanjang}}</td>
                        <td style="width: 30px; text-align: center">{{$datas[$j]->kemasan}}</td>
                        <td style="width: 30px; text-align: center">{{$datas[$j]->qtyk}}</td>
                        <td style="width: 30px; text-align: center">{{$datas[$j]->qty}}</td>
                        <td style="width: 30px; text-align: center">{{$datas[$j]->trbo_qtybonus1}}</td>
                        <td style="width: 30px; text-align: center">{{$datas[$j]->trbo_qtybonus2}}</td>
                        <td style="width: 30px; text-align: center">{{number_format( $datas[$j]->trbo_hrgsatuan ,2,',','.')}}</td>
                        <td style="width: 30px; text-align: center">{{number_format( $datas[$j]->ptg1 ,2,',','.')}}</td>
                        <td style="width: 30px; text-align: center">{{number_format( $datas[$j]->ptg2 ,2,',','.')}}</td>
                        <td style="width: 20px; text-align: center">{{number_format( $datas[$j]->ppn ,2,',','.')}}</td>
                        <td style="width: 20px; text-align: center">{{number_format( $datas[$j]->ppn_bebas ,2,',','.')}}</td>
                        <td style="width: 20px; text-align: center">{{number_format( $datas[$j]->ppn_pemerintah ,2,',','.')}}</td>
                        <td style="width: 20px; text-align: center">{{number_format( $datas[$j]->trbo_ppnbmrph ,2,',','.')}}</td>
                        <td style="width: 20px; text-align: center">{{number_format( $datas[$j]->trbo_ppnbtlrph ,2,',','.')}}</td>
                        <td style="width: 20px; text-align: center">{{number_format( $datas[$j]->total ,2,',','.')}}</td>
                        <tr>
                            <td colspan="3"></td>
                            <td style="width: 30px; text-align: center">DISC 3</td>
                            <td style="width: 30px; text-align: center">{{number_format($datas[$j]->trbo_rphdisc3,2,',','.')}}</td>
                            <td style="width: 30px; text-align: center">DISC 4</td>
                            <td style="width: 30px; text-align: center">{{number_format($datas[$j]->trbo_rphdisc4,2,',','.')}}</td>
                            <td colspan="3"></td>
                        </tr>
                        </tr>
                        {{$totalDisc3 = $totalDisc3 + $datas[$j]->trbo_rphdisc3}}
                        {{$totalDisc4 = $totalDisc4 + $datas[$j]->trbo_rphdisc4}}
                        {{$totalPtg1 = $totalPtg1 + $datas[$j]->ptg1}}
                        {{$totalPtg2 = $totalPtg2 + $datas[$j]->ptg2}}
                        {{$totalPPN = $totalPPN + $datas[$j]->ppn}}
                        {{$totalPPNBebas = $totalPPNBebas + $datas[$j]->ppn_bebas}}
                        {{$totalPPNPemerintah = $totalPPNPemerintah + $datas[$j]->ppn_pemerintah}}
                        {{$totalBM = $totalBM + $datas[$j]->trbo_ppnbmrph}}
                        {{$totalBTL = $totalBTL + $datas[$j]->trbo_ppnbtlrph}}
                        {{$grandTotal = $grandTotal + $datas[$j]->total}}
                        @if($j == sizeof($datas)-1 || $datas[$j]->trbo_nodoc != $datas[$j+1]->trbo_nodoc)
                        <tr>
                            <td colspan="17" style="border-bottom: 1px black solid"></td>
                        </tr>
                        <tr style="padding-top: 50px !important;">
                            <td colspan="3" style="text-align: center">**TOTAL KESELURUHAN</td>
                            <td style="width: 30px; text-align: center">TOTAL DISC 3</td>
                            <td style="width: 30px; text-align: center">{{number_format($totalDisc3 ,2,',','.')}}</td>
                            <td style="width: 30px; text-align: center">TOTAL DISC 4</td>
                            <td style="width: 30px;  text-align: center">{{number_format($totalDisc4 ,2,',','.')}}</td>
                            <td colspan="2"></td>
                            <td style="width: 30px;  text-align: center">{{number_format($totalPtg1 ,2,',','.')}}</td>
                            <td style="width: 30px;  text-align: center">{{number_format($totalPtg2 ,2,',','.')}}</td>
                            <td style="width: 30px;  text-align: center">{{number_format($totalPPN ,2,',','.')}}</td>
                            <td style="width: 30px;  text-align: center">{{number_format($totalPPNBebas ,2,',','.')}}</td>
                            <td style="width: 30px;  text-align: center">{{number_format($totalPPNPemerintah ,2,',','.')}}</td>
                            <td style="width: 30px;  text-align: center">{{number_format($totalBM ,2,',','.')}}</td>
                            <td style="width: 30px;  text-align: center">{{number_format($totalBTL ,2,',','.')}}</td>
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
        <div style="margin-top: -20px; line-height: 0.1px !important;">
            <p>-</p>
            <p>-</p>
        </div>
        <div style="margin-top: -100px; margin-left: 620px; line-height: 0.1px !important;">
            <p>TGL : {{ date("d-M-y  H:i:s") }}</p>
            <p>PRG : IGR_BO_CTBTBLIST</p>
        </div>
        <div style="line-height: 0.1 !important; margin-top: -50px">
            <h2 style="text-align: center">** EDIT LIST PENERIMAAN BARANG **</h2>
        </div>
        {{-- <div>--}}
        {{-- <table>--}}
        {{-- <tr style="line-height: 10px">--}}
        {{-- <td>NOMOR TRN</td>--}}
        {{-- <td>: -</td>--}}
        {{-- </tr>--}}
        {{-- <tr style="line-height: 10px">--}}
        {{-- <td>TANGGAL</td>--}}
        {{-- <td>: -</td>--}}
        {{-- </tr>--}}
        {{-- <tr style="line-height: 10px">--}}
        {{-- <td>PO</td>--}}
        {{-- <td>: NO. -</td>--}}
        {{-- <td>TANGGAL</td>--}}
        {{-- <td>: -</td>--}}
        {{-- </tr>--}}
        {{-- <tr style="line-height: 10px">--}}
        {{-- <td>FAKTUR</td>--}}
        {{-- <td>: NO. -</td>--}}
        {{-- <td>TANGGAL</td>--}}
        {{-- <td>: -</td>--}}
        {{-- </tr>--}}
        {{-- <tr style="line-height: 10px">--}}
        {{-- <td>SUPPLIER</td>--}}
        {{-- <td>: -</td>--}}
        {{-- </tr>--}}
        {{-- <tr style="line-height: 10px">--}}
        {{-- <td>T.O.P</td>--}}
        {{-- <td>: - HARI</td>--}}
        {{-- </tr>--}}
        {{-- </table>--}}
        {{-- </div>--}}
    </header>

    <main>
        <p style="color: white"></p>
                <table>
                    <tr style="line-height: 10px">
                        <td>NOMOR TRN</td>
                        <td>: -</td>
                    </tr>
                    <tr style="line-height: 10px">
                        <td>TANGGAL</td>
                        <td>: -</td>
                    </tr>
                    <tr style="line-height: 10px">
                        <td>PO</td>
                        <td>: NO. -</td>
                        <td>TANGGAL</td>
                        <td>: -</td>
                    </tr>
                    <tr style="line-height: 10px">
                        <td>FAKTUR</td>
                        <td>: NO. -</td>
                        <td>TANGGAL</td>
                        <td>: -</td>
                    </tr>
                    <tr style="line-height: 10px">
                        <td>SUPPLIER</td>
                        <td>: -</td>
                    </tr>
                    <tr style="line-height: 10px">
                        <td>T.O.P</td>
                        <td>: - HARI</td>
                        <td style="text-align: right;"></td>
                    </tr>
                </table>
            </div>

            <table class="table table-bordered table-responsive">
                <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
                    <tr>
                        <th rowspan="2" style="width: 20px; text-align: center">NO</th>
                        <th rowspan="2" style="width: 30px; text-align: center">PLU</th>
                        <th rowspan="2" style="width: 60px !important; text-align: center">NAMA BARANG</th>
                        <th rowspan="2" style="width: 30px; text-align: center">KEMASAN</th>
                        <th colspan="2" style="width: 50px; text-align: center">KWANTUM</th>
                        <th colspan="2" style="width: 50px; text-align: center">-- BONUS --</th>
                        <th rowspan="2" style="width: 30px; text-align: center">HARGA BELI</th>
                        <th colspan="2" style="width: 50px; text-align: center">-- POTONGAN --</th>
                        <th rowspan="2" style="width: 20px; text-align: center">PPN</th>
                        <th rowspan="2" style="width: 20px; text-align: center">PPN BEBAS</th>
                        <th rowspan="2" style="width: 20px; text-align: center">PPN DITANGGUNG PEMERINTAH</th>
                        <th rowspan="2" style="width: 20px; text-align: center">BM</th>
                        <th rowspan="2" style="width: 20px; text-align: center">BOTOL</th>
                        <th rowspan="2" style="width: 20px; text-align: center">TOTAL</th>
                    </tr>
                    <tr>
                        <th style="width: 30px; text-align: center">BESAR</th>
                        <th style="width: 30px; text-align: center">KECIL</th>
                        <th style="width: 30px; text-align: center">1</th>
                        <th style="width: 30px; text-align: center">2</th>
                        <th style="width: 30px; text-align: center">1</th>
                        <th style="width: 30px; text-align: center">2</th>
                    </tr>
                </thead>
                <tbody style="border-bottom: 1px solid black">
                    @for($j=$i; $j< 1; $j++) <tr>
                        <td style="width: 20px; text-align: center">-</td>
                        <td style="width: 30px; text-align: center">-</td>
                        <td style="width: 60px; text-align: center">-</td>
                        <td style="width: 30px; text-align: center">-</td>
                        <td style="width: 30px; text-align: center">-</td>
                        <td style="width: 30px; text-align: center">-</td>
                        <td style="width: 30px; text-align: center">-</td>
                        <td style="width: 30px; text-align: center">-</td>
                        <td style="width: 30px; text-align: center">-</td>
                        <td style="width: 30px; text-align: center">-</td>
                        <td style="width: 30px; text-align: center">-</td>
                        <td style="width: 20px; text-align: center">-</td>
                        <td style="width: 20px; text-align: center">-</td>
                        <td style="width: 20px; text-align: center">-</td>
                        <td style="width: 20px; text-align: center">-</td>
                        <td style="width: 20px; text-align: center">-</td>
                        <td style="width: 20px; text-align: center">-</td>
                        <tr>
                            <td colspan="3"></td>
                            <td style="width: 30px; text-align: center">DISC 3</td>
                            <td style="width: 30px; text-align: center">-</td>
                            <td style="width: 30px; text-align: center">DISC 4</td>
                            <td style="width: 30px; text-align: center">-</td>
                            <td colspan="3"></td>
                        </tr>
                        </tr>
                        <tr>
                            <td colspan="17" style="border-bottom: 1px black solid"></td>
                        </tr>
                        @break
                        @endfor
                </tbody>
            </table>
            <p style="text-align: right">*** AKHIR LAPORAN ***</p>
    </main>

    @endif

</body>

</html>