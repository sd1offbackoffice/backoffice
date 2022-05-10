<html>

<head>
    <title>LAPORAN</title>
</head>

<style>
    @page {
        margin: 130px 25px 25px 25px;
        size: 595pt 442pt;
    }

    .header {
        position: fixed;
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

<body>
    @if($datas)
    @php
    $no = 0;
    @endphp
    @for($i = 0; $i < sizeof($datas); $i++) @if($i==0 || $datas[$i]->msth_nodoc != $datas[$i-1]->msth_nodoc)
        @if($i != 0)
        @php
        $no = 0;
        @endphp
        <div class="page-break"></div>
        @endif
        <header>
            <div style="width: 48%">
                <div style="margin-top: -120px;">
                    <p>{{$datas[$i]->prs_namaperusahaan}}</p>
                    <p>{{$datas[$i]->prs_namacabang}}</p>
                </div>
                <div style="margin-top: -100px;margin-left: 150px !important;">
                    <p style="text-align: center">BUKTI PENERIMAAN BARANG</p>
                    <p style="text-align: center">{{$datas[$i]->judul}}</p>
                    <p style="text-align: center">No.: {{$datas[$i]->msth_nodoc}} Tgl: {{ date("d-M-y") }}</p>
                    @php
                    $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
                    @endphp

                    <img style="max-width: 250px;" src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($datas[$i]->msth_nodoc, $generatorPNG::TYPE_CODE_128)) }}">
                    <br>
                </div>
                <table style="line-height: 8px !important;">
                    <tbody>
                        <tr>
                            <td>No. PO</td>
                            <td>: {{$datas[$i]->msth_nopo}}</td>
                        </tr>
                        <tr>
                            <td style="text-align: right">Tgl.</td>
                            <td>
                                : {{($datas[$i]->msth_tglpo) ? substr($datas[$i]->msth_tglpo,0,10) : $datas[$i]->msth_tglpo}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="width: 50%;margin-left: 60%; margin-top: -120px">
                <div style="text-align: right;line-height: 0.1px !important; margin-right: 30px; margin-top: -120px">
                </div>
                <div style="margin-top: -10px">
                    <p style="margin-left: 55%;">{{ date("d-M-y  H:i:s") }}</p>
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
                                <td>T.O.P</td>
                                <td>: {{$datas[$i]->msth_cterm}} HARI</td>
                                <td colspan="4">Hal: {{$i + 1}}</td>
                            </tr>
                            <tr>
                                <td>No.SJ/F</td>
                                <td>: {{$datas[$i]->msth_nofaktur}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- <br>                    
                    <code style="font-size: 14px;">{{$datas[$i]->barcode}}</code> -->
                </div>
            </div>
        </header>
        <br>
        <table class="body" style="line-height: 10px;margin-top: 10px">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
                <tr style="text-align: center;">
                    <th style="width: 20px; text-align: left;"></th>
                    <th style="width: 265px; text-align: left;"></th>
                    <th style="width: 50px"></th>
                    <th style="width: 135px; text-align: right">Kuantitas</th>
                    <th style="width: 50px; text-align: center"></th>
                    <th style="width: 50px; text-align: center"></th>
                </tr>
                <tr style="text-align: center;">
                    <th rowspan="2" style="width: 20px; text-align: left;">NO</th>
                    <th rowspan="2" style="width: 265px; text-align: left;">PLU - DESKRIPSI</th>
                    <th rowspan="2" colspan="1" style="width: 50px">UNIT</th>
                    <th rowspan="2" colspan="1" style="width: 50px; text-align: center">QTY</th>
                    <th rowspan="2" colspan="1" style="width: 50px; text-align: center">FR</th>
                    <th rowspan="2" colspan="1" style="width: 50px; text-align: center">BONUS</th>
                    <th rowspan="2" colspan="1" style="width: 50px; text-align: center">KETERANGAN</th>
                </tr>
                <tr>
                    <th style="width: 50px; text-align: center"></th>
                    <th style="width: 50px; text-align: center"></th>
                    <th style="width: 50px; text-align: center"></th>
                    <th style="width: 50px; text-align: center"></th>
                    <th style="width: 50px; text-align: center"></th>
                    <th style="width: 100px"></th>
                </tr>
            </thead>
            <tbody>
                {{$tempTotalHrgBli = 0, $tempPotongan4 = 0, $tempPPNBtl = 0, $tempPPN = 0}}

                @for($j = $i ; $j < sizeof($datas); $j++) <tr>
                    <td style="width: 20px">{{$no = $no+1}}</td>
                    <td style="width: 260px">{{$datas[$j]->plu}}</td>
                    <td style="width: 50px; text-align: center">{{$datas[$j]->kemasan}}
                    </td>
                    <td style="width: 50px; text-align: center">{{$datas[$j]->qty}}
                    </td>
                    <td style="width: 50px; text-align: center">{{$datas[$j]->qtyk}}
                    </td>
                    <td style="width: 100px; text-align: center">{{($datas[$j]->bonus1 + $datas[$j]->bonus2)}}
                    </td>
                    <td style="width: 50px; text-align: center">{{$datas[$j]->keterangan}}</td>
                    </tr>
                    {{$tempTotalHrgBli = $tempTotalHrgBli + $datas[$j]->jumlah}}
                    {{$tempPotongan4 = $tempPotongan4 + $datas[$j]->disc4}}
                    {{$tempPPNBtl = $tempPPNBtl + $datas[$j]->mstd_ppnbtlrph}}
                    {{$tempPPN = $tempPPN + $datas[$j]->mstd_ppnrph}}

                    @if($j == sizeof($datas)-1 || $datas[$j]->msth_nodoc != $datas[$j+1]->msth_nodoc)
            </tbody>
        </table>
        <p style="border-bottom: 1px black solid" colspan="9"></p>
        <p>KETERANGAN : _
        </p>
        <table>
            <tbody>
                <tr>
                    <td style="border: 1px black solid; height: 60px; vertical-align: baseline; width: 240px; text-align: center;">
                        Pengirim,
                        <hr>
                        <div class="row align-items-center">
                            <div class="col-5" style="margin-top: 10px">
                                <img style="max-width: 125px;" src="../storage/signature_expedition/{{$ttd . '.png'}}"></img>
                            </div>
                        </div>
                    </td>
                    <td style="border: 1px black solid; height: 60px; vertical-align: baseline; width: 240px; text-align: center;">
                        Disetujui,
                        <hr>
                        <div class="row align-items-center">
                            <div class="col-5">
                                <img style="max-width: 120px; position: absolute; margin-left:25%; z-index: 0;" src="../storage/signature/srclerk.png"></img>
                                <img style="max-width: 150px; position: absolute; margin-left:65%; margin-top: 10%; z-index: 10;" src="../storage/stempel/{{$datas[$i]->prs_namacabang . '.png'}}"></img>
                            </div>
                        </div>
                    </td>
                    <td style="border: 1px black solid; height: 60px; vertical-align: baseline; width: 240px; text-align: center;">
                        Dicetak,
                        <hr>
                        <div class="row align-items-center">
                            <div class="col-5">
                                <img style="max-width: 120px; position: absolute; margin-left:25%; z-index: 0;" src="../storage/signature/clerk.png"></img>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px black solid; width: 240px; text-align: center;">
                        {{ strtoupper($signedby) }}
                    </td>
                    <td style="border: 1px black solid; width: 240px; text-align: center;">
                        {{ file_get_contents('../storage/names/srclerk.txt') }}
                    </td>
                    <td style="border: 1px black solid; width: 240px; text-align: center;">
                        {{ file_get_contents('../storage/names/clerk.txt') }}
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px black solid; width: 240px; text-align: center;">
                        Supplier/Expedisi
                    </td>
                    <td style="border: 1px black solid; width: 240px; text-align: center;">
                        Logistic Adm.Sr.Clerk
                    </td>
                    <td style="border: 1px black solid; width: 240px; text-align: center;">
                        Logistic Adm.Clerk
                    </td>
                </tr>
            </tbody>
        </table>
        <p>KETERANGAN : JANGKA WAKTU PENUKARAN FAKTUR PALING LAMBAT 3 BULAN SEJAK BARANG DITERIMA. <br>
            <span style="margin-left: 71px">APABILA LEWAT DARI WAKTU YANG DITENTUKAN TIDAK AKAN KAMI LAYANI</span>
        </p>
        @break
        @endif
        @endfor
        @endif
        @endfor
        @else
        <div class="header">
            <div style="width: 48%">
                <div>
                    <p>PT.INTI CAKRAWALA CITRA</p>
                </div>
                <div style="margin-top: -50px;margin-left: 50px">
                    <p style="text-align: center">BUKTI PENERIMAAN BARANG</p>
                    <p style="text-align: center">...</p>
                </div>
                <table style="line-height: 8px !important;">
                    <tbody>
                        <tr>
                            <td>No.BPB</td>
                            <td>: ...</td>
                            <td style="width: 15px"></td>
                            <td style="text-align: right">...</td>
                            <td style="width: 20px"></td>
                            <td>TANGGAL</td>
                            <td>: ...</td>
                        </tr>
                        <tr>
                            <td>No.PO</td>
                            <td>: ...</td>
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
                            <td style="text-align: right" colspan="4">JATUH TEMPO</td>
                            <td>: ...</td>
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
                                <td>: ...</td>
                            </tr>
                            <tr>
                                <td>ALAMAT</td>
                                <td>: ...</td>
                            </tr>
                            <tr>
                                <td>SUPPLIER</td>
                                <td>: ...</td>
                            </tr>
                            <tr>
                                <td>N.P.W.P</td>
                                <td>: ...</td>
                            </tr>
                            <tr>
                                <td>TELP</td>
                                <td>:...</td>
                            </tr>
                            <tr>
                                <td>...</td>
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
                <tr>
                    <td colspan="9" style="text-align: center">...</td>
                </tr>

                <tr>
                    <td style="border-bottom: 1px black solid" colspan="9"></td>
                </tr>
                <tr>
                    <td colspan="7"></td>
                    <td> TOTAL HARGA BELI</td>
                    <td style="text-align: right">...</td>
                </tr>
                <tr>
                    <td colspan="7"></td>
                    <td> TOTAL POTONGAN 4</td>
                    <td style="text-align: right">...</td>
                </tr>
                <tr>
                    <td colspan="7"></td>
                    <td> TOTAL PPN BOTOL</td>
                    <td style="text-align: right">...</td>
                </tr>
                <tr>
                    <td colspan="7"></td>
                    <td> TOTAL PPN</td>
                    <td style="border-bottom: 1px black solid; text-align: right">...</td>
                </tr>
                <tr>
                    <td colspan="7"></td>
                    <td> TOTAL SELURUHNYA</td>
                    <td style="text-align: right"> ...</td>
                </tr>
            </tbody>
        </table>
        <table>
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
            <span style="margin-left: 71px">APABILA LEWAT DARI WAKTU YANG DITENTUKAN TIDAK AKAN KAMI LAYANI</span>
        </p>
        @endif
</body>

</html>