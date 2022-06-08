@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Listing Retur Item(s) Distribusi Tertentu
@endsection

@section('title')
    Listing Retur Item(s) Distribusi Tertentu
@endsection

@section('subtitle')
    Periode : 10 APRIL 2022
@endsection

@section('content')

    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah right padding-right" rowspan="2">No.</th>
            <th class="tengah center" rowspan="2">Kode Member</th>
            <th class="tengah center" colspan="2">Struk Penukaran Barang Distribusi (SPBD)</th>
            <th class="tengah center" colspan="2">Struk Penjualan (SP) Pengganti</th>
            <th class="tengah center " rowspan="2">Selisih antara Nilai (Rp.) SPBD<br>vs Nilai (Rp.) SPBD yang<br>digunakan</th>
        </tr>
        <tr>
            <th class="tengah center">No. SPBD</th>
            <th class="tengah center">Nilai (Rp.) SPBD</th>
            <th class="tengah center">No. SP</th>
            <th class="tengah center">Nilai (Rp.) SPBD yang<br>digunakan</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="right padding-right">1</td>
            <td class="center">MM123456</td>
            <td class="center">SPBD/KMY/13028</td>
            <td class="center">75000</td>
            <td class="center">SP123924</td>
            <td class="center">75000</td>
            <td class="center">0</td>
        </tr>
        <tr>
            <th class="center" colspan="2">Total</th>
            <th></th>
            <th class="center">50000</th>
            <th></th>
            <th class="center">50000</th>
            <th class="center">50000</th>
        </tr>
        </tbody>
        <tfooter>
            <tr>
                <th colspan="10" class="left" style="font-style: italic">* Laporan atas pembelian item(s) distribusi tertentu selama periode
                    penawaran
                </th>
            </tr>
            <tr>
                <th colspan="10" class="left" style="font-style: italic">** Berisi unit jual di Toko igr.</th>
            </tr>
        </tfooter>
    </table>
@endsection
