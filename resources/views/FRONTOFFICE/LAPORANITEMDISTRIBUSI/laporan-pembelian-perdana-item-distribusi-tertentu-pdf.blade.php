@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Laporan Pembelian Perdana Item(s) Distribusi Tertentu
@endsection

@section('title')
    Laporan Pembelian Perdana Item(s) Distribusi Tertentu
@endsection

@section('subtitle')
    @php
    $bulanName = array(
    'JANUARI','FEBRURI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER'
    );
    @endphp
    {{ 'Periode : '. $bulanName[(int) substr($bulan,0,2)-1].' '.substr($bulan,3,4)}}<br>
@endsection

@section('content')

    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah right padding-right" rowspan="2">No.</th>
            <th class="tengah left" rowspan="2">Kode Member</th>
            <th class="tengah center" colspan="2">Struk Penjualan</th>
            <th class="tengah center" rowspan="2">PLU</th>
            <th class="tengah left " rowspan="2">Nama Barang</th>
            <th class="tengah left " rowspan="2">Satuan Jual<br>Terkecil**</th>
            <th class="tengah right " rowspan="2">Kuantitas<br>(Pcs.)</th>
            <th class="tengah right " rowspan="2">Harga Satuan</th>
            <th class="tengah right " rowspan="2">Total Nilai (Rp.)</th>
        </tr>
        <tr>
            <th class="tengah center">Nomor SP</th>
            <th class="tengah center">Tanggal SP</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="right padding-right">1</td>
            <td class="left">MM123456</td>
            <td class="center">ONL/AL/00001</td>
            <td class="center">1-jan-22</td>
            <td class="center">1283892</td>
            <td class="left ">adamkdmkamdadka</td>
            <td class="left ">Pcs</td>
            <td class="right ">50</td>
            <td class="right ">5000</td>
            <td class="right">50000</td>
        </tr>
        <tr>
            <th class="center" colspan="9">Total</th>
            <th class="right">50000</th>
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
