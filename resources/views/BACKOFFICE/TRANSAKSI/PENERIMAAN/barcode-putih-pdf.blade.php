@extends('html-template')

@section('table_font_size','9 px')

@section('page_title')
    LAPORAN TRANSAKSI PENUKARAN BARANG
@endsection

@section('title')
    LAPORAN TRANSAKSI PENUKARAN BARANG
@endsection

{{-- @section('subtitle')
Periode : {{ $tgl1 }} - {{ $tgl2 }}
@endsection --}}
@section('custom_style')
<style>
    

</style>
@endsection

@section('content')
        {{-- @foreach ($data as $d)
        
            <div class="tengah" style="width: 25%">
                <img style="max-width: 250px;" src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($d->mstd_prdcd, $generatorPNG::TYPE_CODE_128)) }}">
                <p class="left">PLU &nbsp;: {{ $d->mstd_prdcd }}</p>
                <p class="left">UNIT/FRRAC &nbsp;: {{ $d->mstd_unit }}/{{ $d->mstd_frac }}</p>
                <p class="left">DESKRIPSI &nbsp;: {{ $d->prd_deskripsipanjang }}</p>
            </div>
            
            @if($i != sizeof($data)-1)
                <div class="pagebreak"></div>
            @endif
        @endforeach --}}
        <div class="grid-container" style="display: inline-grid; row-gap: 10px; column-gap: 10px;">
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
                    <div class="grid-item tengah">
                        <img style="max-width: 250px;" src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($d->mstd_prdcd, $generatorPNG::TYPE_CODE_128)) }}">
                        <p class="left">PLU &nbsp;: {{ $d->mstd_prdcd }}</p>
                        <p class="left">UNIT/FRRAC &nbsp;: {{ $d->mstd_unit }}/{{ $d->mstd_frac }}</p>
                        <p class="left">DESKRIPSI &nbsp;: {{ $d->prd_deskripsipanjang }}</p>
                    </div>
                    @if($i == $totalPrint)
                        <div class="pagebreak"></div>
                    @endif
                @endfor                
            @endforeach
            
            {{-- @php
                $tempPlu = '';
            @endphp
            @for ($i = 0; $i < sizeof($data)-1; $i++)                
                @if ($data['mstd_prdcd'] != $tempPlu)
                    @php
                        $tempPlu = $data['mstd_prdcd']
                    @endphp
                @else
                    @php
                        $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
                        if ($data['mstd_unit'] != 'PCS') {
                            $totalPrint = Math.floor($data['mstd_qty'] / $data['mstd_frac'])
                        } else {
                            $totalPrint = $data['mstd_qty']
                        }
                    @endphp
                    @for ($j = 0; $j < $totalPrint; $j++)
                        <div class="grid-item tengah">
                            <img style="max-width: 250px;" src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($data['mstd_prdcd'], $generatorPNG::TYPE_CODE_128)) }}">
                            <p class="left">PLU &nbsp;: {{ $data['mstd_prdcd'] }}</p>
                            <p class="left">UNIT/FRAC &nbsp;: {{ $data['mstd_unit'] }}/{{ $data['mstd_frac'] }}</p>
                            <p class="left">DESKRIPSI &nbsp;: {{ $data['prd_deskripsipanjang'] }}</p>
                        </div>
                        @if($i == $totalPrint-1)
                            <div class="pagebreak"></div>
                        @endif
                    @endfor
                @endif
            @endfor --}}
        </div>    
@endsection