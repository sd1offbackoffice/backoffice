@extends('pdf-template')

@section('page_title')
    Rincian Struk Titipan - {{ $tanggal }}
@endsection

@section('title')
    ** RINCIAN STRUK TITIPAN **
@endsection

@section('subtitle')
    Tanggal : {{ $tanggal }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left">No. Struk</th>
            <th colspan="2" class="left">Member Merah</th>
            <th class="right">Titipan</th>
        </tr>
        </thead>
        <tbody>
        @php

            @endphp
        @if(!$data)
            <tr>
                <td colspan="4">Data tidak ditemukan</td>
            </tr>
        @endif
        @foreach($data as $d)
            @php

                @endphp
            <tr>
                <td class="left">{{ $d->nostruk }}</td>
                <td class="left">{{ $d->dps_kodemember }}</td>
                <td class="left">{{ $d->cus_namamember }}</td>
                <td class="right">{{ number_format($d->dps_jumlahdeposit, 0, '.', ',') }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>

        </tfoot>
    </table>
@endsection
