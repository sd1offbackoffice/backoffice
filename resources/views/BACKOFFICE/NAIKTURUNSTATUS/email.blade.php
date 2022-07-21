<html>

<head>
    <title>DKS BATAL TERBENTUK</title>
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

@if ($datas)

<body>
    <header>
        <div style="width: 100%; margin-top: -80px">
            <table style="line-height: 8px">
                <tbody>
                    <tr>
                        <td>PT Inti Cakrawala Citra</td>
                    </tr>
                    <tr>
                        <td><i>{{ Session::get('namacabang') }}</i></td>
                    </tr>
                </tbody>
            </table>
            <table style="line-height: 8px; margin-left: 550px; margin-top: -100px; width: 100%;">
                <tbody>
                    <tr>
                        <td><i>Tgl. Cetak</i><span style="display: inline-block; width: 25px;"></span>: {{Carbon::now()->format('d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td><i>Pkl. Cetak</i><span style="display: inline-block; width: 25px;"></span>: {{ Carbon::now()->timezone('Asia/Jakarta')->format('H:i:s') }}</td>
                    </tr>
                    <tr>
                        <td><i>User ID</i> <span style="display: inline-block; width: 34px;"></span>: {{Session::get('userid')}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="width: 100%; margin-left: 32.5%; padding-bottom: 25px">
            <table style="line-height: 8px !important; text-align: center;">
                <tbody>
                    <tr>
                        <td>LAPORAN TURUN STATUS</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </header>
    <table class="body" style="line-height: 10px;margin-top: 10px; width:100%;">
        <thead style="border-top: 1px solid black; border-bottom: 1px solid black">
            <tr style="text-align: center;">
                <th style="width:10px;">No.</th>
                <th style="width:20px;">PKMT</th>
                <th style="width:20px;">SALDO AKHIR</th>
                <th style="width:100px;">PRDCD</th>
                <th style="width:10px;">DESKRIPSI</th>
                <th style="width:10px;">LOKASI</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 0; $i < sizeof($datas); $i++) <tr style="text-align: center;">
                <td style="width:10px;">{{ $i + 1 }}</td>
                <td style="width:20px;">{{ $datas[$i]->pkm_pkmt }}</td>
                <td style="width:20px;">{{ $datas[$i]->st_saldoakhir }}</td>
                <td style="width:100px; text-align: left;">{{ $datas[$i]->st_prdcd }}</td>
                <td style="width:10px;">{{ $datas[$i]->rak }}</td>
                <td style="width:10px;">{{ $datas[$i]->prd_deskripsipanjang }}</td>
                </tr>
                @endfor
                <tr>
                    <td style="border-bottom: 1px black solid" colspan="6"></td>
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
                        <td>PT Inti Cakrawala Citra</td>
                    </tr>
                    <tr>
                        <td><i>-</i></td>
                    </tr>
                </tbody>
            </table>
            <table style="line-height: 8px; margin-left: 550px; margin-top: -100px; width: 100%;">
                <tbody>
                    <!-- <tr>
                        <td><i>Lampiran Memorandum No.</i> &nbsp; No. &nbsp; /CPS/22<span style="display: inline-block; width: 36.5px;"></span>: ..........</td>
                    </tr> -->
                    <tr>
                        <td><i>Tgl. Cetak</i><span style="display: inline-block; width: 25px;"></span>: -</td>
                    </tr>
                    <tr>
                        <td><i>Pkl. Cetak</i><span style="display: inline-block; width: 25px;"></span>: -</td>
                    </tr>
                    <tr>
                        <td><i>User ID</i> <span style="display: inline-block; width: 34px;"></span>: -</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="width: 100%; margin-left: 32.5%; padding-bottom: 25px">
            <table style="line-height: 8px !important; text-align: center;">
                <tbody>
                    <tr>
                        <td>LAPORAN TURUN STATUS</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </header>
    <table class="body" style="line-height: 10px;margin-top: 10px; width:100%;">
        <thead style="border-top: 1px solid black; border-bottom: 1px solid black">
            <tr style="text-align: center;">
                <th style="width:10px;">No.</th>
                <th style="width:20px;">PKMT</th>
                <th style="width:20px;">SALDO AKHIR</th>
                <th style="width:100px;">PRDCD</th>
                <th style="width:10px;">DESKRIPSI</th>
                <th style="width:10px;">LOKASI</th>
            </tr>
        </thead>
        <tbody>
            <tr style="text-align: center;">
                <td style="width:10px;"></td>
                <td style="width:20px;"></td>
                <td style="width:20px;"></td>
                <td style="width:100px; text-align: center;">Data Kosong</td>
                <td style="width:10px;"></td>
                <td style="width:10px;"></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px black solid" colspan="6"></td>
            </tr>
        </tbody>
    </table>
</body>
@endif

</html>