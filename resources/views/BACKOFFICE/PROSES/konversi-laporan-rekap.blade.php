@extends('html-template')

@section('table_font_size','7 px')

@section('paper_height','442pt')


@section('page_title')
    Daftar Penyesuaian Persediaan Konversi Perishable
@endsection

@section('title')
    DAFTAR PENYESUAIAN PERSEDIAAN<br>KONVERSI PERISHABLE
@endsection

@section('content')
    <table class="table table-borderless table-header">
        <thead>
        <tr>
            <th>
                Tanggal
            </th>
            <th>
                : {{ $data[0]->mstd_tgldoc }}
            </th>
            <th width="50%"></th>
            <th>RINGKASAN DIVISI / DEPARTEMEN / KATEGORI</th>
        </tr>
        </thead>
    </table>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left" width="10%">KODE</th>
            <th class="left" width="70%">NAMA KATEGORI</th>
            <th class="right" width="20%">TOTAL NILAI</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $d)
            <tr>
                <td class="left">DIVISI</td>
                <td class="left">: {{ $d->prd_kodedivisi }} - {{ $d->div_namadivisi }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="left">DEPARTEMEN</td>
                <td class="left">: {{ $d->prd_kodedepartement }} - {{ $d->dep_namadepartement }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="left">{{ $d->prd_kodekategoribarang }}</td>
                <td class="left">{{ $d->kat_namakategori }}</td>
                <td class="right">{{ number_format($d->total,2) }}</td>
            </tr>
            <tr>
                <td class="left" colspan="2">SUBTOTAL DEPARTEMENT : {{ $d->prd_kodedepartement }}</td>
                <td class="right">{{ number_format($d->total,2) }}</td>
            </tr>
            <tr>
                <td class="left" colspan="2">SUBTOTAL DIVISI : {{ $d->prd_kodedivisi }}</td>
                <td class="right">{{ number_format($d->total,2) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot style="text-align: center">
        <tr>
            <td class="left" colspan="2">TOTAL SELURUHNYA</td>
            <td class="right">{{ number_format($d->total,2) }}</td>
        </tr>
        </tfoot>
    </table>
@endsection
