@extends('html-template')
@section('table_font_size','7 px')

@section('page_title')
    CETAK ULANG FAKTUR PAJAK
@endsection

@section('title')
    {{-- ** CETAK ULANG FAKTUR PAJAK ** --}}
@endsection

@section('subtitle')
    {{-- NPB: {{$npb1}} s/d {{$npb2}} --}}
@endsection

@section('content')
    @foreach ($data as $d)
    @php
        $nQty2 = floor($d->mstd_qty / $d->mstd_frac);
        $nQtyK = fmod($d->mstd_qty, $d->mstd_frac);

        if ($d->mstd_unit == "KG") {
            $nQty = ((($nQty2) * $d->mstd_frac) + ($nQtyK)) / $d->mstd_frac;
        } else {
            $nQty = (($nQty2) * $d->mstd_frac) + $nQtyK;
        }

        $nGross = $d->mstd_gross - $d->mstd_discrph;
        $nPrice = ($nGross / ($nQty2 * $d->mstd_frac + $nQtyK));
    @endphp
    <div style="display: flex; justify-content: end; margin-right: 20%">
        <p>{{ $d->mstd_date3 }}</p>
    </div>
    <div>
        <p>{{ $d->prs_namaperusahaan }}</p>
        <p>{{ $d->const_addr }}</p>
        <p>{{ $d->prs_npwp }}</p>
    </div>
    <br>
    <div>
        <p>{{ $d->sup_namanpwp }}</p>
        <p>{{ $d->addr_sup }}</p>
        <p>{{ $d->sup_npwp }}</p>
    </div>
    <table class="table">
        <thead>
            <th>Nama Produk</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Gross</th>
        </thead>
        <tbody>
            <tr>
                <td>{{ $d->prd_deskripsipanjang }}</td>
                <td>{{ number_format($nQty, 0) }}</td>
                <td>{{ number_format($nPrice, 0) }}</td>
                <td>{{ number_format($nGross, 0) }}</td>
            </tr>
        </tbody>
    </table>
    <div style="display: flex; justify-content: end; margin-top: 50%">
        <div class="row">
            <p>{{ number_format($nGross, 0) }}</p>
            <p>{{ number_format(floor($nGross * 0.1), 0) }}</p>
        </div>
    </div>
    <div style="display: flex; justify-content: start;">
        <div class="row">
            <p>No. NPB : {{ $d->msth_nodoc }}</p>
        </div>
    </div>
    <div style="display: flex; justify-content: end;">
        <div class="row">
            <p>{{ $d->prs_namawilayah }}, {{ date("d M Y") }}</p>
            <br>
            <p>{{ $ttd }}</p>
            <p>{{ $role1 }}</p>
        </div>
    </div>
    <div class="pagebreak"></div>
    @endforeach
@endsection