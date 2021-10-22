@extends('pdf-template')

@section('page_title')
    Laporan Rincian Transaksi Transfer - {{ $tanggal }}
@endsection

@section('title')
    ** LAPORAN RINCIAN TRANSAKSI TRANSFER **
@endsection

@section('subtitle')
    Tanggal : {{ $tanggal }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th></th>
            <th colspan="2">Member</th>
            <th></th>
            <th colspan="6">Nilai ( Rp. )</th>
            <th></th>
        </tr>
        <tr>
            <th class="right">No.</th>
            <th class="center">Kode</th>
            <th class="left">Nama Membber</th>
            <th class="left">Struk Penjualan</th>
            <th class="right" width="8%">Tran. Transfer</th>
            <th class="right" width="8%">R/K</th>
            <th class="right" width="8%">Tunai Fisik</th>
            <th class="right" width="8%">Voucher</th>
            <th class="right" width="8%">NK</th>
            <th class="right">Cashback</th>
            <th class="right">Keterangan</th>
        </tr>
        </thead>
        <tbody>
        @php
            $transfer = 0;
            $rk = 0;
            $tunai = 0;
            $voucher = 0;
            $nk = 0;
            $cb = 0;
            $i = 0;
        @endphp
        @if(!$data)
            <tr>
                <td colspan="11">Data tidak ditemukan</td>
            </tr>
        @endif
        @foreach($data as $d)
            @php
                $i++;
                $transfer += $d->rfr_transferamt;
                $rk += $d->rfr_nilairk;
                $tunai += $d->rfr_paymentrk;
                $voucher += $d->voucher;
                $nk += $d->nk;
                $cb += $d->cb;
            @endphp
            <tr>
                <td>{{ $i }}</td>
                <td class="left">{{ $d->rfr_kodemember }}</td>
                <td class="left">{{ $d->cus_namamember }}</td>
                <td class="left">{{ $d->kassa }}</td>
                <td class="right">{{ number_format($d->rfr_transferamt, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->rfr_nilairk, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->rfr_paymentrk, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->voucher, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->nk, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->cb, 0, '.', ',') }}</td>
                <td>{{ $d->rfr_attr1 }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4" class="right">TOTAL :</td>
            <td class="right">{{ number_format($transfer, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($rk, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tunai, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($voucher, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($nk, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($cb, 0, '.', ',') }}</td>
            <td></td>
        </tr>
        </tfoot>
    </table>
@endsection
