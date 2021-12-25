@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN EVALUASI SALES MEMBER
@endsection

@section('title')
    ** LAPORAN EVALUASI SALES MEMBER **
@endsection

@section('subtitle')
    Tanggal {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('header_left')
    <p>ORDER BY : {{ $sort }}</p>
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th width="8%" class="center">Kode</th>
            <th width="28%" class="left">Member</th>
            <th width="8%" class="left padding-left">Kunj</th>
            <th width="8%" class="tengah center">Struk</th>
            <th width="8%" class="right">Produk</th>
            <th width="8%" class="right">Sales Gross</th>
            <th width="8%" class="right">Sales Net</th>
            <th width="8%" class="right">PPN</th>
            <th width="8%" class="right">Margin</th>
            <th width="8%" class="right">%</th>
        </tr>
        </thead>
        <tbody>
        @php $no = 1; @endphp
        @foreach($data as $d)
            <tr>
                <td width="8%" class="center">{{ $d->trjd_cus_kodemember }}</td>
                <td width="28%" class="left">{{ $d->cus_namamember }}</td>
                <td width="8%" class="left padding-left">{{ $d->kunj }}</td>
                <td width="8%" class="tengah center">{{ $d->struk }}</td>
                <td width="8%" class="right">{{ number_format($d->qty, 0, '.', ',') }}</td>
                <td width="8%" class="right">{{ number_format($d->salesgross, 0, '.', ',') }}</td>
                <td width="8%" class="right">{{ number_format($d->sales, 0, '.', ',') }}</td>
                <td width="8%" class="right">{{ number_format($d->sales * 0.1, 0, '.', ',') }}</td>
                <td width="8%" class="right">{{ number_format($d->margin, 0, '.', ',') }}</td>
                <td width="8%" class="right">{{ number_format($d->margin / $d->sales * 100, 2, '.', ',') }}%</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
