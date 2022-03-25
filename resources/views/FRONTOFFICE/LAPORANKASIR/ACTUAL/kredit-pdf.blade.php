@extends('pdf-template')

@section('paper_width','842pt')
@section('paper_height','638pt')


@section('table_font_size','7 px')

@section('page_title')
    Perincian Kredit - {{ $tanggal }}
@endsection

@section('title')
    ** PERINCIAN KREDIT **
@endsection

@section('subtitle')
    Tanggal : {{ $tanggal }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="right">Transaksi</th>
            <th class="left">&nbsp;&nbsp;&nbsp;&nbsp;Member</th>
            <th class="left">Nama</th>
            <th colspan="4" class="left">Alamat</th>
            <th class="right">Kredit</th>
            <th class="left">&nbsp;&nbsp;&nbsp;&nbsp;Kasir</th>
            <th class="left">Stat</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total = 0;
        @endphp
        @if(!$data)
            <tr>
                <td colspan="10">Data tidak ditemukan</td>
            </tr>
        @endif
        @foreach($data as $i => $d)
            @php
                $total += $d->kredit;
            @endphp
            <tr>
                @if($i === array_key_first($data))
                    <td class="left">SALES</td>
                @else <td class="left"></td>
                @endif
                <td class="left">&nbsp;&nbsp;&nbsp;&nbsp;{{ $d->trpt_cus_kodemember }}</td>
                <td class="left">{{ $d->cus_namamember }}</td>
                <td class="left">{{ $d->cus_alamatmember1 }}</td>
                <td class="left">&nbsp;&nbsp;{{ $d->cus_alamatmember2 }}</td>
                <td class="center">{{ $d->cus_alamatmember3 }}</td>
                <td class="left">&nbsp;&nbsp;&nbsp;&nbsp;{{ $d->cus_alamatmember4 }}</td>
                <td class="right">{{ number_format($d->kredit, 0, '.', ',') }}</td>
                <td class="left">&nbsp;&nbsp;&nbsp;&nbsp;{{ $d->kasir }}</td>
                <td class="left">{{ $d->stat }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="7" class="left" style="border-top: 1px solid black"><strong>TOTAL SALES</strong></td>
            <td class="right" style="border-top: 1px solid black"><strong>{{ number_format($total, 0, '.', ',') }}</strong></td>
            <td colspan="2" class="left" style="border-top: 1px solid black"></td>
        </tr>
        </tfoot>
    </table>
@endsection
