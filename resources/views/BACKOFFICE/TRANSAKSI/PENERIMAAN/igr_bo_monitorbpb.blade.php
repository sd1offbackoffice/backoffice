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
                <p style="margin-top: -5px"> PRG : IGR031B  </p>
            </div>
            <div style="line-height: 0.3 !important; text-align: center !important;">
                <p style="text-align: center">** MONITORING BUKTI PENERIMAAN BARANG **</p>
            </div>
        </header>
    </header>

    <main>
        @php
            $no = 0;
            $grant_total = 0;
        @endphp

        @for($i = 0; $i < sizeof($datas); $i++)
{{--        @for($i = 0; $i < 50; $i++)--}}
            @if($i == 0 || $datas[$i]->nomor != $datas[$i-1]->nomor)
                @if($i!=0)
                    <div class="page-break"></div>
                @endif
                <div style="width: 48%; margin-top: -20px">
                    <table style="line-height: 8px !important;">
                        <tbody>
                        <tr>
                            <td>NOMOR</td>
                            <td>: {{$datas[$i]->nomor}}</td>
                        </tr>
                        <tr>
                            <td>TANGGAL</td>
                            <td>: {{date('d-m-y', strtotime($datas[$i]->mstd_tgldoc))}}</td>
                        </tr>
                        <tr>
                            <td>PO</td>
                            <td>: NO {{$datas[$i]->mstd_nopo}}</td>
                            <td style="text-align: right" colspan="4">TANGGAL</td>
                            <td>: {{date('d-m-y', strtotime($datas[$i]->mstd_tglpo))}}</td>
                        </tr>
                        <tr>
                            <td>FAKTUR</td>
                            <td>: {{$datas[$i]->mstd_nofaktur}}</td>
                            <td style="text-align: right" colspan="4">TANGGAL</td>
                            <td>: {{date('d-m-y', strtotime($datas[$i]->mstd_tglfaktur))}}</td>
                        </tr>
                        <tr>
                            <td>T.O.P</td>
                            <td>: {{$datas[$i]->mstd_cterm}} HARI</td>
                        </tr>
                        <tr>
                            <td style="text-align: right" >JATUH TEMPO</td>
                            <td>: {{date('d-m-y', strtotime($datas[$i]->jth_tempo))}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div style="width: 50%;margin-left: 50%; margin-top: -100px">
                    <div style="margin-top: 0px">
                        <table style="line-height: 8px !important;">
                            <tbody>
                            <tr>
                                <td>SUPPLIER</td>
                                <td>: {{$datas[$i]->supplier}}</td>
                            </tr>
                            <tr>
                                <td>N.P.W.P</td>
                                <td>: {{$datas[$i]->sup_npwp}}</td>
                            </tr>
                            <tr>
                                <td>ALAMAT</td>
                                <td>: {{$datas[$i]->sup_alamatsupplier1}} - {{$datas[$i]->sup_alamatsupplier2}} - {{$datas[$i]->sup_kotasupplier3}}</td>
                            </tr>
                            <tr>
                                <td>TELP</td>
                                <td>: {{$datas[$i]->sup_telpsupplier}}</td>
                            </tr>
                            <tr>
                                <td>C.PERSON</td>
                                <td>: {{$datas[$i]->sup_contactperson}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                    <table class="table table-bordered table-responsive" style="margin-top: 25px">
                        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
                        <tr style="text-align: center;">
                            <th rowspan="2" style="width: 20px">NO</th>
                            <th rowspan="2" style="width: 40px">PLU</th>
                            <th rowspan="2" style="width: 120px">NAMA BARANG</th>
                            <th rowspan="2" style="width: 30px">BKP</th>
                            <th rowspan="2" style="width: 60px">KEMASAN</th>
                            <th colspan="2" style="width: 60px">* KWANTUM *</th>
                            <th colspan="2" style="width: 60px">* BONUS *</th>
                            <th rowspan="2" style="width: 50px; text-align: right">H.P.P</th>
                            <th rowspan="2" style="width: 50px; text-align: right">TOTAL</th>
                            <th rowspan="2" style="width: 50px; text-align: center">HPP RATA2</th>
                            <th rowspan="2" style="width: 50px; text-align: right">HRG JUAL</th>
                            <th colspan="2" style="width: 60px">*** MARGIN ***</th>
                            <th rowspan="2" style="width: 40px;">TAG</th>
                        </tr>
                        <tr>
                            <th style="width: 30px">BESAR</th>
                            <th style="width: 30px">KECIL</th>
                            <th style="width: 30px">1</th>
                            <th style="width: 30px">2</th>
                            <th style="width: 30px">SID</th>
                            <th style="width: 30px">AKTUAL</th>
                        </tr>
                        </thead>
                        <tbody style="border-bottom: 1px solid black">
                        @for($j = $i ; $j < sizeof($datas); $j++)
                            <tr>
                                <td>{{$no = $no+1}}</td>
                                <td style="text-align: center">{{$datas[$j]->mstd_prdcd}}</td>
                                <td>{{$datas[$j]->prd_deskripsipanjang}}</td>
                                <td style="text-align: center">{{$datas[$j]->mstd_bkp}}</td>
                                <td style="text-align: center">{{$datas[$j]->satuan}}</td>
                                <td style="text-align: center">{{$datas[$j]->qty}}</td>
                                <td style="text-align: center">{{$datas[$j]->qtyk}}</td>
                                <td style="text-align: center">{{$datas[$j]->mstd_qtybonus1}}</td>
                                <td style="text-align: center">{{$datas[$j]->mstd_qtybonus2}}</td>
                                <td style="text-align: right">{{number_format($datas[$j]->nlcost ,2,',','.')}}</td>
                                <td style="text-align: right">{{number_format($datas[$j]->namt ,2,',','.')}}</td>
                                <td style="text-align: right">{{number_format($datas[$j]->mstd_avgcost ,2,',','.')}}</td>
                                <td style="text-align: right">{{number_format($datas[$j]->prd_hrgjual ,2,',','.')}}</td>
                                <td>{{$datas[$j]->prd_markupstandard}}</td>
                                <td>{{number_format($datas[$j]->nmargin_aktual ,2,',','.')}}</td>
                                <td>{{$datas[$j]->prd_kodetag}}</td>

                                @php
                                    $grant_total = $grant_total + $datas[$j]->namt;
                                @endphp
                            </tr>
                            @if($j == sizeof($datas)-1 || $datas[$j]->nomor != $datas[$j+1]->nomor)
                                <tr>
                                    <td colspan="9">TOTAL SELURUHNYA :</td>
                                    <td style="text-align: right">{{number_format($grant_total ,2,',','.')}}</td>
                                </tr>
                                @break
                            @endif
                        @endfor
                        </tbody>
                    </table>
            @endif
        @endfor
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
            <p> PRG : IGR031B  </p>
        </div>
        <div style="line-height: 0.3 !important; text-align: center !important;">
            <p style="text-align: center">** MONITORING BUKTI PENERIMAAN BARANG **</p>
        </div>
    </header>

    <div style="width: 48%; margin-top: -20px">
        <table style="line-height: 8px !important;">
            <tbody>
            <tr>
                <td>NOMOR</td>
                <td>: ...</td>
            </tr>
            <tr>
                <td>TANGGAL</td>
                <td>: ...</td>
            </tr>
            <tr>
                <td>PO</td>
                <td>: NO...</td>
                <td style="text-align: right" colspan="4">TANGGAL</td>
                <td>: ...</td>
            </tr>
            <tr>
                <td>FAKTUR</td>
                <td>: ...</td>
                <td style="text-align: right" colspan="4">TANGGAL</td>
                <td>: ...</td>
            </tr>
            <tr>
                <td>T.O.P</td>
                <td>: ...</td>
            </tr>
            <tr>
                <td style="text-align: right" >JATUH TEMPO</td>
                <td>: ...</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div style="width: 50%;margin-left: 50%; margin-top: -100px">
        <div style="margin-top: -10px">
            <table style="line-height: 8px !important;">
                <tbody>
                <tr>
                    <td>SUPPLIER</td>
                    <td>: ...</td>
                </tr>
                <tr>
                    <td>N.P.W.P</td>
                    <td>: ...</td>
                </tr>
                <tr>
                    <td>ALAMAT</td>
                    <td>: ...</td>
                </tr>
                <tr>
                    <td>TELP</td>
                    <td>:...</td>
                </tr>
                <tr>
                    <td>C.PERSON</td>
                    <td>: ...</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <main>
        <div style="width: 48%; margin-top: -20px">
            <table style="line-height: 8px !important;">
                <tbody>
                <tr>
                    <td>NOMOR</td>
                    <td>: ...</td>
                </tr>
                <tr>
                    <td>TANGGAL</td>
                    <td>: ...</td>
                </tr>
                <tr>
                    <td>PO</td>
                    <td>: NO...</td>
                    <td style="text-align: right" colspan="4">TANGGAL</td>
                    <td>: ...</td>
                </tr>
                <tr>
                    <td>FAKTUR</td>
                    <td>: ...</td>
                    <td style="text-align: right" colspan="4">TANGGAL</td>
                    <td>: ...</td>
                </tr>
                <tr>
                    <td>T.O.P</td>
                    <td>: ...</td>
                </tr>
                <tr>
                    <td style="text-align: right" >JATUH TEMPO</td>
                    <td>: ...</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="width: 50%;margin-left: 50%; margin-top: -100px">
            <div style="margin-top: -10px">
                <table style="line-height: 8px !important;">
                    <tbody>
                    <tr>
                        <td>SUPPLIER</td>
                        <td>: ...</td>
                    </tr>
                    <tr>
                        <td>N.P.W.P</td>
                        <td>: ...</td>
                    </tr>
                    <tr>
                        <td>ALAMAT</td>
                        <td>: ...</td>
                    </tr>
                    <tr>
                        <td>TELP</td>
                        <td>:...</td>
                    </tr>
                    <tr>
                        <td>C.PERSON</td>
                        <td>: ...</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <table class="table table-bordered table-responsive" style="">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr style="text-align: center;">
                <th rowspan="2" style="width: 30px">NO</th>
                <th rowspan="2" style="width: 40px">PLU</th>
                <th rowspan="2" style="width: 120px">NAMA BARANG</th>
                <th rowspan="2" style="width: 70px">KEMASAN</th>
                <th colspan="2" style="width: 60px">* KWANTUM *</th>
                <th colspan="2" style="width: 60px">* BONUS *</th>
                <th rowspan="2" style="width: 50px; text-align: right">H.P.P</th>
                <th rowspan="2" style="width: 50px; text-align: right">TOTAL</th>
                <th rowspan="2" style="width: 50px; text-align: center">HPP RATA2</th>
                <th rowspan="2" style="width: 50px; text-align: right">HRG JUAL</th>
                <th colspan="2" style="width: 60px">*** MARGIN ***</th>
                <th rowspan="2" style="width: 40px;">TAG</th>
            </tr>
            <tr>
                <th style="width: 30px">BESAR</th>
                <th style="width: 30px">KECIL</th>
                <th style="width: 30px">1</th>
                <th style="width: 30px">2</th>
                <th style="width: 30px">SID</th>
                <th style="width: 30px">AKTUAL</th>
            </tr>
            </thead>
            <tbody style="border-bottom: 1px solid black">
            <tr>
                <td colspan="15" style="text-align: center">** No Data **</td>
            </tr>
            </tbody>
        </table>
        <p style="text-align: right"> ** Akhir Dari Laporan ** </p>
    </main>

@endif

</body>
</html>
