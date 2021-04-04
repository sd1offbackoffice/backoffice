<html>
<head>
    <style>
        @page {
            margin: 130px 25px 25px 25px;
            size: 595pt 442pt;
        }

        .header {
            position:fixed;
            top: -110px;
            left: 0px;
            right: 0px;
            height: 100px;
            line-height: 0.1px !important;
        }

        .sp {
            page-break-after: always;
        }

        .sp:last-child {
            page-break-after: never;
        }

        body {
            font-size: 9px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
@if($datas)
    @php
     $no = 0;
    @endphp
    @for($i = 0; $i < sizeof($datas); $i++)
        @if($i == 0 || $datas[$i]->msth_nodoc != $datas[$i-1] ->msth_nodoc)
            @if($i != 0)
                <div class="page-break"></div>
            @endif
            <div class="header">
                <div style="width: 48%">
                    <div>
                        <p>{{$datas[0]->prs_namaperusahaan}}</p>
                        <p>{{$datas[0]->prs_namacabang}}</p>
                    </div>
                    <div style="margin-top: -50px;margin-left: 50px">
                        <p style="text-align: center">BUKTI PENERIMAAN BARANG</p>
                        <p style="text-align: center">{{$datas[$i]->judul}}</p>
                    </div>
                    <table style="line-height: 8px !important;">
                        <tbody>
                        <tr>
                            <td>No.BPB</td>
                            <td>: {{$datas[$i]->msth_nodoc}}</td>
                            <td style="width: 15px"></td>
                            <td style="text-align: right">(REPRINT)</td>
                            <td style="width: 20px"></td>
                            <td>TANGGAL</td>
                            <td>
                                : {{($datas[$i]->msth_tgldoc) ? substr($datas[$i]->msth_tgldoc,0,10) : $datas[$i]->msth_tgldoc }}</td>
                        </tr>
                        <tr>
                            <td>No.PO</td>
                            <td>: {{$datas[$i]->msth_nopo}}</td>
                            <td style="text-align: right" colspan="4">TANGGAL</td>
                            <td>
                                : {{($datas[$i]->msth_tglpo) ? substr($datas[$i]->msth_tglpo,0,10) : $datas[$i]->msth_tglpo}}</td>
                        </tr>
                        <tr>
                            <td>FAKTUR</td>
                            <td>: {{$datas[$i]->msth_nofaktur}}</td>
                            <td style="text-align: right" colspan="4">TANGGAL</td>
                            <td>
                                : {{($datas[$i]->msth_tglfaktur) ? substr($datas[$i]->msth_tglfaktur,0,10) : $datas[$i]->msth_tglfaktur}}</td>
                        </tr>
                        <tr>
                            <td>T.O.P</td>
                            <td>: {{$datas[$i]->msth_cterm}} HARI</td>
                            <td style="text-align: right" colspan="4">JATUH TEMPO</td>
                            <td>
                                : {{($datas[$i]->tgljt) ? substr($datas[$i]->tgljt,0,10) : $datas[$i]->tgljt}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div style="width: 50%;margin-left: 50%; margin-top: -100px">
                    <div style="text-align: right;line-height: 0.1px !important; margin-right: 30px">
                        <p>{{ date("d-M-y  H:i:s") }}</p>
                    </div>
                    <div style="margin-top: -10px">
                        <table style="line-height: 8px !important;">
                            <tbody>
                            <tr>
                                <td>N.P.W.P</td>
                                <td>: {{$datas[$i]->prs_npwp}}</td>
                            </tr>
                            <tr>
                                <td>ALAMAT</td>
                                <td>: {{$datas[$i]->prs_alamat1}} - {{$datas[$i]->prs_alamat2}}
                                    - {{$datas[$i]->prs_alamat3}}</td>
                            </tr>
                            <tr>
                                <td>SUPPLIER</td>
                                <td>: {{$datas[$i]->supplier}}</td>
                            </tr>
                            <tr>
                                <td>N.P.W.P</td>
                                <td>: {{$datas[$i]->sup_npwp}}</td>
                            </tr>
                            <tr>
                                <td>TELP</td>
                                <td>: {{$datas[$i]->sup_telpsupplier}} / {{$datas[$i]->contact_person}}</td>
                            </tr>
                            <tr>
                                <td>{{$datas[$i]->barcode}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <table class="body" style="line-height: 10px;margin-top: 10px">
                <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
                <tr style="text-align: center;">
                    <th rowspan="2" style="width: 20px; text-align: left;">NO</th>
                    <th rowspan="2" style="width: 265px; text-align: left;">PLU - NAMA BARANG</th>
                    <th colspan="1" style="width: 50px">KEMASAN</th>
                    <th colspan="1" style="width: 50px; text-align: center">QTY</th>
                    <th colspan="1" style="width: 50px; text-align: center">FR</th>
                    <th colspan="1" style="width: 50px; text-align: center">HARGA SAT</th>
                    <th colspan="1" style="width: 50px; text-align: center">PPNBM</th>
                    <th colspan="1" style="width: 50px; text-align: center">BOTOL</th>
                    <th rowspan="2" style="width: 50px; text-align: left">JUMLAH</th>
                </tr>
                <tr>
                    <th style="width: 50px; text-align: center">DISC #1</th>
                    <th style="width: 50px; text-align: center">DISC #2</th>
                    <th style="width: 50px; text-align: center">DISC #3</th>
                    <th style="width: 50px; text-align: center">BONUS 1</th>
                    <th style="width: 50px; text-align: center">BONUS 2</th>
                    <th style="width: 100px">KETERANGAN</th>
                </tr>
                </thead>
                <tbody>
                {{$tempTotalHrgBli = 0, $tempPotongan4 = 0, $tempPPNBtl = 0, $tempPPN = 0}}

                @for($j = $i ; $j < sizeof($datas); $j++)
                    <tr>
                        <td style="width: 20px">{{$no = $no+1}}</td>
                        <td style="width: 265px">{{$datas[$j]->plu}}</td>
                        <td style="width: 50px; text-align: center">{{$datas[$j]->kemasan}}
                            <br/> {{$datas[$j]->disc1}}</td>
                        <td style="width: 50px; text-align: center">{{$datas[$j]->qty}}
                            <br/> {{$datas[$j]->disc2}}
                        </td>
                        <td style="width: 50px; text-align: center">{{$datas[$j]->qtyk}}
                            <br/>{{$datas[$j]->disc3}}
                        </td>
                        <td style="width: 50px; text-align: center">{{number_format($datas[$j]->mstd_hrgsatuan ,2,',','.')}}
                            <br/>{{$datas[$j]->bonus1}}</td>
                        <td style="width: 50px; text-align: center">{{number_format($datas[$j]->mstd_ppnbmrph ,2,',','.')}}
                            <br/>{{$datas[$j]->bonus2}}</td>
                        <td style="width: 100px; text-align: center">{{number_format($datas[$j]->mstd_ppnbtlrph ,2,',','.')}}
                            <br/>{{$datas[$j]->keterangan}}</td>
                        <td style="width: 50px; text-align: center">{{number_format($datas[$j]->jumlah ,2,',','.')}}</td>
                    </tr>

                        {{$tempTotalHrgBli = $tempTotalHrgBli + $datas[$j]->jumlah}}
                        {{$tempPotongan4 = $tempPotongan4 + $datas[$j]->disc4}}
                        {{$tempPPNBtl = $tempPPNBtl + $datas[$j]->mstd_ppnbtlrph}}
                        {{$tempPPN = $tempPPN + $datas[$j]->mstd_ppnrph}}

                    @if($j == sizeof($datas)-1 || $datas[$j]->msth_nodoc != $datas[$j+1]->msth_nodoc)
                        <tr>
                            <td style="border-bottom: 1px black solid" colspan="9"></td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                            <td> TOTAL HARGA BELI</td>
                            <td style="text-align: right">{{number_format($tempTotalHrgBli ,2,',','.')}}</td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                            <td> TOTAL POTONGAN 4</td>
                            <td style="text-align: right">{{number_format($tempPotongan4 ,2,',','.')}}</td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                            <td> TOTAL PPN BOTOL</td>
                            <td style="text-align: right">{{number_format($tempPPNBtl ,2,',','.')}}</td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                            <td> TOTAL PPN</td>
                            <td style="border-bottom: 1px black solid; text-align: right">{{number_format($tempPPN ,2,',','.')}}</td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                            <td> TOTAL SELURUHNYA</td>
                            <td style="text-align: right"> {{number_format(($tempTotalHrgBli + $tempPPNBtl + $tempPPN - $tempPotongan4) ,2,',','.')}}</td>
                        </tr>
                </tbody>
            </table>
            <table style="">
                <tbody>
                <tr>
                    <td style="border: 1px black solid; height: 60px; vertical-align: baseline; width: 240px">
                        ADMINISTRASI
                    </td>
                    <td style="border: 1px black solid; height: 60px; vertical-align: baseline; width: 240px">
                        KEPALA
                        GUDANG
                    </td>
                    <td style="border: 1px black solid; height: 60px; vertical-align: baseline; width: 240px">
                        SUPPLIER
                    </td>
                </tr>
                </tbody>
            </table>
            <p>KETERANGAN : JANGKA WAKTU PENUKARAN FAKTUR PALING LAMBAT 3 BULAN SEJAK BARANG DITERIMA. <br>
                <span
                    style="margin-left: 71px">APABILA LEWAT DARI WAKTU YANG DITENTUKAN TIDAK AKAN KAMI LAYANI</span>
            </p>

            @break
        @endif
                @endfor
        @endif
    @endfor
@else

    <main>
        <p>Kosong</p>
    </main>

@endif


</body>
</html>
