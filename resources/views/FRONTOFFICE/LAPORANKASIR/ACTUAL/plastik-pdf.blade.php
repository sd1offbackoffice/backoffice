@extends('pdf-template')

@section('page_title')
    Laporan Pemakaian Kantong Plastik - {{ $tanggal }}
@endsection

@section('title')
    ** LAPORAN PEMAKAIAN KANTONG PLASTIK **
@endsection

@section('subtitle')
    Tanggal : {{ $tanggal }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left">No.</th>
            <th class="left">Cashier ID</th>
            <th class="left">Cashier Station</th>
            <th class="right">Qty</th>
            <th class="right">Nilai</th>
        </tr>
        </thead>
        <tbody>
        @php
            $qty = 0;
            $nilai = 0;
            $i = 0;
        @endphp
        @if(!$data)
            <tr>
                <td colspan="5">Data tidak ditemukan</td>
            </tr>
        @endif
        @foreach($data as $d)
            @php
                $i++;
                $qty += $d->pls_qty;
                $nilai += $d->pls_nominalamt;
            @endphp
            <tr>
                <td class="left">{{ $i }}</td>
                <td class="left">{{ $d->pls_kasir }}</td>
                <td class="left">{{ $d->pls_station }}</td>
                <td class="right">{{ number_format($d->pls_qty, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->pls_nominalamt, 0, '.', ',') }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3" class="right">TOTAL :</td>
            <td class="right">{{ number_format($qty, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($nilai, 0, '.', ',') }}</td>
        </tr>
        </tfoot>
    </table>
@endsection
