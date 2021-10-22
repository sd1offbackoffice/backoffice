@extends('pdf-template')

@section('page_title')
    Transaksi Virtual Untuk Kasir Online - {{ $tanggal }}
@endsection

@section('title')
    ** TRANSAKSI VIRTUAL UNTUK KASIR ONLINE **
@endsection

@section('subtitle')
    Tanggal : {{ $tanggal }}
@endsection

@section('custom_style')
    tfoot{
        border-bottom: 1px solid black;
    }
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th width="10%" class="right padding-right">No</th>
            <th width="30%" class="left">Tipe Transaksi</th>
            <th width="30%" class="right">Penjualan</th>
            <th width="30%" class="right">Fee</th>
        </tr>
        </thead>
        <tbody>
        @php
            $penjualan = 0;
            $fee = 0;
            $no = 0;
        @endphp
        @if(!$data)
            <tr>
                <td colspan="3">Data tidak ditemukan</td>
            </tr>
        @endif
        @foreach($data as $d)
            @php
                $penjualan += $d->ttl;
                $fee += $d->fee;
                $no++;
            @endphp
            <tr>
                <td width="10%" class="right padding-right">{{ $no }}</td>
                <td width="30%" class="left">{{ $d->vir_type }}</td>
                <td width="30%" class="right">{{ number_format($d->ttl, 0, '.', ',') }}</td>
                <td width="30%" class="right">{{ number_format($d->fee, 0, '.', ',') }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td class="right" colspan="2">TOTAL NILAI</td>
            <td class="right">{{ number_format($penjualan, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($fee, 0, '.', ',') }}</td>
        </tr>
        </tfoot>
    </table>
@endsection
