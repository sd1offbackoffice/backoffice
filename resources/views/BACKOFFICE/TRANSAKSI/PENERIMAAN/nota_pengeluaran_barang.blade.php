<html>

<head>
    <title>NOTA PENGELUARAN BARANG</title>
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
@php
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
@endphp

@if ($data)

<body>
    <header>
        <div style="width: 100%; margin-top: -80px">
            <table style="line-height: 8px">
                <tbody>
                    <tr>
                        <td>PT INTI CAKRAWALA CITRA</td>
                    </tr>
                    <tr>
                        <td>NPWP: {{$data[0]->sup_npwp}}</td>
                    </tr>
                </tbody>
            </table>
            <table style="line-height: 8px; margin-left: 550px; margin-top: -100px; width: 100%;">
                <tbody>
                    <tr>
                        <td>INDOGROSIR {{ strtoupper(Session::get('namacabang')) }}</td>
                    </tr>
                    @if ($alamat)
                    <tr>
                        <td>{{ $alamat[0]->prs_alamat1 }} {{ $alamat[0]->prs_alamat2 }} {{ $alamat[0]->prs_alamat3 }}</td>
                    </tr>
                    @else
                    <tr>
                        <td>-</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div style="width: 100%; margin-left: 37.5%; padding-bottom: 25px">
            <table style="line-height: 8px !important; text-align: center;">
                <tbody>
                    <tr>
                        <td>NOTA PENGELUARAN BARANG <br> (RETUR PEMBELIAN)</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="width: 100%; padding-bottom: 15px">
            <table style="line-height: 8px !important; width: 100%;">
                <tbody>
                    <tr style="text-align: left;">
                        <td></td>
                        <td></td>
                        <td>SUPPLIER<span style="display: inline-block; width: 55px;"></span>: {{ $data[0]->hgb_kodesupplier }} - {{ $data[0]->sup_namasupplier }}</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td></td>
                        <td></td>
                        <td>NPWP<span style="display: inline-block; width: 73px;"></span>: {{ $data[0]->sup_npwp }}</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td></td>
                        <td></td>
                        <td style="width: 50%;">ALAMAT<span style="display: inline-block; width: 62px;"></span>: {{ $data[0]->sup_alamatsupplier1 }} {{ $data[0]->sup_alamatsupplier2 }} {{ $data[0]->sup_kotasupplier3 }}</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td></td>
                        <td></td>
                        <td>TELP<span style="display: inline-block; width: 77px;"></span>: {{ $data[0]->sup_telpsupplier }}</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td>NOMOR<span style="display: inline-block; width: 15px;"></span>: {{ $data[0]->krt_nobpb }}</td>
                        <td>TANGGAL NPB<span style="display: inline-block; width: 15px;"></span>: {{ Carbon::parse($data[0]->krt_tglbpb)->format('d-M-Y') }}</td>
                        <td>CONTACT PERSON<span style="display: inline-block; width: 16px;"></span>: {{ $data[0]->sup_contactperson }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </header>
    <table class="body" style="line-height: 10px; width:100%;">
        <thead style="border-top: 1px solid black; border-bottom: 1px solid black">
            <tr style="text-align: center;">
                <th rowspan="2" style="width:10px;">NO.</th>
                <th rowspan="2" style="width:20px;">PLU</th>
                <th rowspan="2" style="width:100px;">NAMA BARANG</th>
                <th rowspan="2" style="width:20px;">KEMASAN</th>
                <th colspan="2" style="width:10px;">KWANTUM</th>
                <th rowspan="2" style="width:30px;">HARGA SATUAN</th>
                <th rowspan="2" style="width:10px;">TOTAL NILAI</th>
                <th rowspan="2" style="width:10px;">NO. REF BTB</th>
                <th rowspan="2" style="width:10px;">KETERANGAN</th>
            </tr>
            <tr style="text-align: center;">
                <th style="width:10px;">BESAR</th>
                <th style="width:10px;">KECIL</th>
            </tr>
        </thead>
        <tbody>
            {{$total = 0}}
            @for($i = 0; $i < sizeof($data); $i++) <tr style="text-align: center;">
                <td style="width:10px;">{{$i+1}}</td>
                <td style="width:20px;">{{$data[$i]->krt_prdcd}}</td>
                <td style="width:100px;">{{$data[$i]->prd_deskripsipanjang}}</td>
                <td style="width:20px;">{{$data[$i]->prd_satuanbeli}}</td>
                <td style="width:20px;">{{ floor($data[$i]->mstd_qty / $data[$i]->mstd_frac) }}</td>
                <td style="width:20px;">{{ fmod($data[$i]->mstd_qty , $data[$i]->mstd_frac) }}</td>
                <td style="width:20px;">{{$data[$i]->hgb_hrgbeli}}</td>
                <td style="width:20px;">{{$data[$i]->mstd_gross}}</td>
                <td style="width:20px;">{{$data[$i]->mstd_docno2 ? $data[$i]->mstd_docno2 : '-'}}</td>
                <td style="width:20px;">{{$data[$i]->mstd_keterangan ? $data[$i]->mstd_keterangan : '-'}}</td>
                </tr>
                {{$total += $data[$i]->hgb_hrgbeli}}
                @endfor
                <tr>
                    <td style="border-bottom: 1px black solid" colspan="10"></td>
                </tr>
        </tbody>
    </table>

    <p>TOTAL SELURUHNYA : {{$total}}</p>
    <table>
        <tbody>
            <tr>
                <td style="border: 1px black solid; height: 60px; vertical-align: baseline; width: 240px; text-align: center;">
                    DIBUAT,
                    <hr>
                    <div class="row align-items-center">
                        <div class="col-5" style="margin-top: 10px">
                            <img style="max-width: 125px;" src="../storage/signature/clerk.png"></img>
                        </div>
                    </div>
                </td>
                <td style="border: 1px black solid; height: 60px; vertical-align: baseline; width: 240px; text-align: center;">
                    DISETUJUI,
                    <hr>
                    <div class="row align-items-center">
                        <div class="col-5">
                            <img style="max-width: 120px; position: absolute; margin-left:25%; z-index: 0;" src="../storage/signature/srclerk.png"></img>
                        </div>
                    </div>
                </td>
                <td style="border: 1px black solid; height: 60px; vertical-align: baseline; width: 240px; text-align: center;">
                    <br>
                    <hr>
                    <div class="row align-items-center">
                        <div class="col-5">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border: 1px black solid; width: 240px; text-align: center;">
                    {{ file_get_contents('../storage/names/clerk.txt') }}
                </td>
                <td style="border: 1px black solid; width: 240px; text-align: center;">
                    {{ file_get_contents('../storage/names/srclerk.txt') }}
                </td>
                <td style="border: 1px black solid; width: 240px; text-align: center;">
                    <br>
                </td>
            </tr>
            <tr>
                <td style="border: 1px black solid; width: 240px; text-align: center;">
                    ADMINISTRASI
                </td>
                <td style="border: 1px black solid; width: 240px; text-align: center;">
                    KEPALA GUDANG
                </td>
                <td style="border: 1px black solid; width: 240px; text-align: center;">
                    SUPPLIER
                </td>
            </tr>
        </tbody>
    </table>
</body>

@else

<body>
    <header>
        <div style="width: 100%; margin-top: -80px">
            <table style="line-height: 8px">
                <tbody>
                    <tr>
                        <td>PT INTI CAKRAWALA CITRA</td>
                    </tr>
                    <tr>
                        <td>NPWP: - </td>
                    </tr>
                </tbody>
            </table>
            <table style="line-height: 8px; margin-left: 550px; margin-top: -100px; width: 100%;">
                <tbody>
                    <tr>
                        <td>INDOGROSIR</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="width: 100%; margin-left: 37.5%; padding-bottom: 25px">
            <table style="line-height: 8px !important; text-align: center;">
                <tbody>
                    <tr>
                        <td>NOTA PENGELUARAN BARANG <br> (RETUR PEMBELIAN)</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="width: 100%; padding-bottom: 15px">
            <table style="line-height: 8px !important; width: 100%;">
                <tbody>
                    <tr style="text-align: left;">
                        <td></td>
                        <td></td>
                        <td>SUPPLIER<span style="display: inline-block; width: 55px;"></span>: - </td>
                    </tr>
                    <tr style="text-align: left;">
                        <td></td>
                        <td></td>
                        <td>NPWP<span style="display: inline-block; width: 73px;"></span>: - </td>
                    </tr>
                    <tr style="text-align: left;">
                        <td></td>
                        <td></td>
                        <td style="width: 50%;">ALAMAT<span style="display: inline-block; width: 62px;"></span>: - </td>
                    </tr>
                    <tr style="text-align: left;">
                        <td></td>
                        <td></td>
                        <td>TELP<span style="display: inline-block; width: 77px;"></span>: - </td>
                    </tr>
                    <tr style="text-align: left;">
                        <td>NOMOR<span style="display: inline-block; width: 15px;"></span>: - </td>
                        <td>TANGGAL NPB<span style="display: inline-block; width: 15px;"></span>: - </td>
                        <td>CONTACT PERSON<span style="display: inline-block; width: 16px;"></span>: - </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </header>
    <table class="body" style="line-height: 10px; width:100%;">
        <thead style="border-top: 1px solid black; border-bottom: 1px solid black">
            <tr style="text-align: center;">
                <th rowspan="2" style="width:10px;">NO.</th>
                <th rowspan="2" style="width:20px;">PLU</th>
                <th rowspan="2" style="width:100px;">NAMA BARANG</th>
                <th rowspan="2" style="width:20px;">KEMASAN</th>
                <th colspan="2" style="width:10px;">KWANTUM</th>
                <th rowspan="2" style="width:30px;">HARGA SATUAN</th>
                <th rowspan="2" style="width:10px;">TOTAL NILAI</th>
                <th rowspan="2" style="width:10px;">NO. REF BTB</th>
                <th rowspan="2" style="width:10px;">KETERANGAN</th>
            </tr>
            <tr style="text-align: center;">
                <th style="width:10px;">BESAR</th>
                <th style="width:10px;">KECIL</th>
            </tr>
        </thead>
        <tbody>
            <tr style="text-align: center;">
                <td style="width:10px;">-</td>
                <td style="width:20px;">-</td>
                <td style="width:100px;">-</td>
                <td style="width:20px;">-</td>
                <td style="width:20px;">-</td>
                <td style="width:20px;">-</td>
                <td style="width:20px;">-</td>
                <td style="width:20px;">-</td>
                <td style="width:20px;">-</td>
                <td style="width:20px;">-</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px black solid" colspan="10"></td>
            </tr>
        </tbody>
    </table>

    <p>TOTAL SELURUHNYA :</p>
    <table>
        <tbody>
            <tr>
                <td style="border: 1px black solid; height: 60px; vertical-align: baseline; width: 240px; text-align: center;">
                    DIBUAT,
                    <hr>
                    <div class="row align-items-center">
                        <div class="col-5" style="margin-top: 10px">
                        </div>
                    </div>
                </td>
                <td style="border: 1px black solid; height: 60px; vertical-align: baseline; width: 240px; text-align: center;">
                    DISETUJUI,
                    <hr>
                    <div class="row align-items-center">
                        <div class="col-5">
                        </div>
                    </div>
                </td>
                <td style="border: 1px black solid; height: 60px; vertical-align: baseline; width: 240px; text-align: center;">
                    <br>
                    <hr>
                    <div class="row align-items-center">
                        <div class="col-5">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border: 1px black solid; width: 240px; text-align: center;">
                    <br>
                </td>
                <td style="border: 1px black solid; width: 240px; text-align: center;">
                    <br>
                </td>
                <td style="border: 1px black solid; width: 240px; text-align: center;">
                    <br>
                </td>
            </tr>
            <tr>
                <td style="border: 1px black solid; width: 240px; text-align: center;">
                    ADMINISTRASI
                </td>
                <td style="border: 1px black solid; width: 240px; text-align: center;">
                    KEPALA GUDANG
                </td>
                <td style="border: 1px black solid; width: 240px; text-align: center;">
                    SUPPLIER
                </td>
            </tr>
        </tbody>
    </table>
</body>
@endif

</html>