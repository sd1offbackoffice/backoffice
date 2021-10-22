@extends('pdf-template')

@section('page_title')
    Laporan Pengisian Top Up Merchant Apps - {{ $tanggal }}
@endsection

@section('title')
    ** LAPORAN PENGISIAN TOP UP MERCHANT APPS **
@endsection

@section('subtitle')
    Tanggal : {{ $tanggal }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="right padding-right">No</th>
            <th class="left">Kasir</th>
            <th class="left">Kode Member</th>
            <th class="left">Nama Member</th>
            <th class="right">No. HP</th>
            <th class="right">Nilai Top Up</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total = 0;
            $no = 0;
        @endphp
        @if(!$data)
            <tr>
                <td colspan="5">Data tidak ditemukan</td>
            </tr>
        @endif
        @foreach($data as $d)
            @php
                $total += $d->dpp_jumlahdeposit;
                $no++;
            @endphp
            <tr>
                <td class="right padding-right">{{ $no }}</td>
                <td class="left">{{ $d->kasir }}</td>
                <td class="left">{{ $d->dpp_kodemember }}</td>
                <td class="left">{{ $d->cus_namamember }}</td>
                <td class="right">{{ $d->dpp_nohp }}</td>
                <td class="right">{{ number_format($d->dpp_jumlahdeposit, 0, '.', ',') }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="5" class="right">TOTAL :</td>
            <td class="right">{{ number_format($total, 0, '.', ',') }}</td>
        </tr>
        </tfoot>
    </table>
@endsection
