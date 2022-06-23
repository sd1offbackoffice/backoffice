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
        @php
            $no = 1;
            $total = 0;
            $tempKodeMember = 0;
        @endphp
        @for($i=0;$i<sizeof($data);$i++)
        <tr>
            @if($tempKodeMember != $data[$i]->cus_kodemember)
                <td class="right padding-right">{{$no}}.</td>
                <td class="left">{{$data[$i]->cus_kodemember}}</td>
                @php
                    $no++;
                    $tempKodeMember = $data[$i]->cus_kodemember;
                @endphp
            @else
                <td class="right padding-right"></td>
                <td class="left"></td>
            @endif
            <td class="center">{{$data[$i]->struk_penjualan}}</td>
            <td class="center">{{ date('d-M-Y',strtotime(substr($data[$i]->transaction_date,0,10))) }}</td>
            <td class="center">{{$data[$i]->trjd_prdcd}}</td>
            <td class="left ">{{$data[$i]->prd_deskripsipendek}}</td>
            <td class="center ">{{$data[$i]->prd_unit}}</td>
            <td class="right ">{{$data[$i]->trjd_quantity}}</td>
            <td class="right ">{{number_format($data[$i]->trjd_unitprice, 2, '.', ',')}}</td>
            <td class="right">{{number_format($data[$i]->total, 2, '.', ',')}}</td>
        </tr>
        @php
            $total += $data[$i]->total;
        @endphp
        @endfor
        <tr style="border-top: 1px solid black;border-bottom: 1px solid black">
            <th class="center" colspan="9">Total</th>
            <th class="right">{{number_format($total, 2, '.', ',')}}</th>
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
