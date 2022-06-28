{{--@extends('html-template')--}}

{{--@section('table_font_size','9 px')--}}

{{--@section('page_title')--}}
{{--    LAPORAN TRANSAKSI PENUKARAN BARANG--}}
{{--@endsection--}}

{{--@section('title')--}}
{{--    LAPORAN TRANSAKSI PENUKARAN BARANG--}}
{{--@endsection--}}

{{-- @section('subtitle')
Periode : {{ $tgl1 }} - {{ $tgl2 }}
@endsection --}}
{{--@section('custom_style')--}}
{{-- <style>
    .grid-container {
        display: grid;
        grid-template-columns: auto auto auto;
        background-color: white;
        padding: 10px;
    }
    .grid-item {
        background-color: rgba(255, 255, 255, 0.8);
        border: 1px solid black;
        padding: 20px;
        font-size: 30px;
        text-align: center;
    }

</style> --}}
{{--@endsection--}}

{{--@section('content')--}}

{{--        <div class="grid-container" style="display: inline-grid; row-gap: 10px; column-gap: 10px;">--}}
{{--            @foreach ($data as $d)--}}
{{--            @php--}}
{{--                $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();--}}
{{--                if ($d->mstd_unit != 'PCS') {--}}
{{--                    $totalPrint = intval($d->mstd_qty / $d->mstd_frac);--}}
{{--                } else {--}}
{{--                    $totalPrint = $d->mstd_qty;--}}
{{--                }--}}
{{--            @endphp--}}
{{--                @for ($i = 0; $i < $totalPrint; $i++)--}}
{{--                    <div class="grid-item tengah">--}}
{{--                        <img style="max-width: 250px;" src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($d->mstd_prdcd, $generatorPNG::TYPE_CODE_128)) }}">--}}
{{--                        <p class="left">PLU &nbsp;: {{ $d->mstd_prdcd }}</p>--}}
{{--                        <p class="left">UNIT/FRRAC &nbsp;: {{ $d->mstd_unit }}/{{ $d->mstd_frac }}</p>--}}
{{--                        <p class="left">DESKRIPSI &nbsp;: {{ $d->prd_deskripsipanjang }}</p>--}}
{{--                    </div>--}}
{{--                    @if($i == $totalPrint)--}}
{{--                        <div class="pagebreak"></div>--}}
{{--                    @endif--}}
{{--                @endfor--}}
{{--            @endforeach--}}


{{--        </div>--}}
{{-- 
        <div class="grid-container">
            @foreach ($data as $d)
                @php
                    $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
                    if ($d->mstd_unit != 'PCS') {
                        $totalPrint = intval($d->mstd_qty / $d->mstd_frac);
                    } else {
                        $totalPrint = $d->mstd_qty;
                    }
                @endphp
                @for ($i = 0; $i < $totalPrint; $i++)
                    <div class="grid-item">
                        <img style="max-width: 250px;" src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($d->mstd_prdcd, $generatorPNG::TYPE_CODE_128)) }}">
                        <p class="left">PLU &nbsp;: {{ $d->mstd_prdcd }}</p>
                        <p class="left">UNIT/FRAC &nbsp;: {{ $d->mstd_unit }}/{{ $d->mstd_frac }}</p>
                        <p class="left">DESKRIPSI &nbsp;: {{ $d->prd_deskripsipanjang }}</p>
                    </div>
                    @if($i == $totalPrint)
                        <div class="pagebreak"></div>
                    @endif
                @endfor
            @endforeach


        </div> --}}
{{--@endsection--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BARCODE PUTIH</title>
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto;
            background-color: white;
            padding: 10px;
        }
        .grid-item {
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid black;
            padding: 20px;
            font-size: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="grid-container">
        @foreach ($data as $d)
            @php
                $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
                if ($d->mstd_unit != 'PCS') {
                    $totalPrint = intval($d->mstd_qty / $d->mstd_frac);
                } else {
                    $totalPrint = $d->mstd_qty;
                }
            @endphp
            @for ($i = 0; $i < $totalPrint; $i++)
                <div class="grid-item">
                    <img style="max-width: 250px;" src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($d->mstd_prdcd, $generatorPNG::TYPE_CODE_128)) }}">
                    <p class="left">PLU &nbsp;: {{ $d->mstd_prdcd }}</p>
                    <p class="left">UNIT/FRAC &nbsp;: {{ $d->mstd_unit }}/{{ $d->mstd_frac }}</p>
                    <p class="left">DESKRIPSI &nbsp;: {{ $d->prd_deskripsipanjang }}</p>
                </div>
                @if($i == $totalPrint)
                    <div class="pagebreak"></div>
                @endif
            @endfor
        @endforeach
    </div>
</body>
</html>
