@extends('pdf-template')

@section('table_font_size','12 px')

@section('page_title')
    Laporan Potongan Pada Sales Harian Kasir / Actual - {{ $tanggal }}
@endsection

@section('title')
    LAPORAN POTONGAN PADA SALES HARIAN KASIR / ACTUAL
@endsection

@section('subtitle')
    Tanggal : {{ $tanggal }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th width="8%" class="right padding-right">No</th>
            <th width="23%" class="left">Kassa</th>
            <th width="23%" class="right">Cashback</th>
            <th width="23%" class="right">NK</th>
            <th width="23%" class="right">Total</th>
        </tr>
        </thead>
        <tbody>
        @php
            $cashback = 0;
            $nk = 0;
            $total = 0;
            $no = 0;
        @endphp
        @if(!$data)
            <tr>
                <td colspan="4">Data tidak ditemukan</td>
            </tr>
        @endif
        @foreach($data as $d)
            @php
                $cashback += $d->cb;
                $nk += $d->nk;
                $total += $d->total;
                $no++;
            @endphp
            <tr>
                <td width="8%" class="right padding-right"">{{ $no }}</td>
                <td width="23%" class="left">{{ $d->js_cashierstation.' . '.$d->js_cashierid.' . '.$d->kassa }}</td>
                <td width="23%" class="right">{{ number_format($d->cb, 0, '.', ',') }}</td>
                <td width="23%" class="right">{{ number_format($d->nk, 0, '.', ',') }}</td>
                <td width="23%" class="right">{{ number_format($d->total, 0, '.', ',') }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2" class="right">TOTAL :</td>
            <td class="right">{{ number_format($cashback, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($nk, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($total, 0, '.', ',') }}</td>
        </tr>
        </tfoot>
    </table>
@endsection
