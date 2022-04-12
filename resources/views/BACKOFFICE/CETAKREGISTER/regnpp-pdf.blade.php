@extends('html-template')

@section('paper_height',$ukuran == 'besar' ? '842pt': '442pt')

@section('table_font_size','7 px')

@section('page_title')
    Register Memo Penyesuaian Persediaan
@endsection

@section('title')
    ** REGISTER MEMO PENYESUAIAN PERSEDIAAN **
@endsection

@section('subtitle')
    {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah" rowspan="2">NO</th>
            <th colspan="2">---- MPP ----</th>
            <th colspan="2">---- REF ----</th>
            <th class="tengah" rowspan="2">TOTAL</th>
            <th class="tengah" rowspan="2">STATUS</th>
            <th class="tengah" rowspan="2">KETERANGAN</th>
            <th class="tengah" rowspan="2">STATUS BARANG</th>
        </tr>
        <tr>
            <th>NOMOR</th>
            <th>TANGGAL</th>
            <th>NOMOR</th>
            <th>TANGGAL</th>
        </tr>
        </thead>
        <tbody>
        @php
            $i = 1;
            $temp = '';
            $totalbaik = 0;
            $totalretur = 0;
            $totalrusak = 0;
            $totalall = 0;
        @endphp
        @foreach($data as $d)
            @if($temp != $d->msth_tgldoc)
                @if($temp != '')
                    <tr>
                        <td class="left" colspan="5">SUBTOTAL BARANG BAIK TANGGAL {{ $temp }}</td>
                        <td class="right">{{ number_format($subtotalbaik, 2, '.', ',') }}</td>
                        <td class=""></td>
                    </tr>
                    <tr>
                        <td class="left" colspan="5">SUBTOTAL BARANG RETUR TANGGAL {{ $temp }}</td>
                        <td class="right">{{ number_format($subtotalretur, 2, '.', ',') }}</td>
                        <td class=""></td>
                    </tr>
                    <tr>
                        <td class="left" colspan="5">SUBTOTAL BARANG RUSAK TANGGAL {{ $temp }}</td>
                        <td class="right">{{ number_format($subtotalrusak, 2, '.', ',') }}</td>
                        <td class=""></td>
                    </tr>
                @endif
                @php
                    $i = 1;
                    $temp = $d->msth_tgldoc;
                    $subtotalbaik = 0;
                    $subtotalretur = 0;
                    $subtotalrusak = 0;
                @endphp
                <tr>
                    <td class="left border-top" colspan="11">TANGGAL {{ $d->msth_tgldoc }}</td>
                </tr>
            @endif
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $d->msth_nodoc }}</td>
                <td>{{ $d->msth_tgldoc}}</td>
                <td class="tengah">{{ $d->msth_noref3}}</td>
                <td class="tengah">{{ $d->msth_tgref3 }}</td>
                <td class="right">{{ number_format($d->total, 2, '.', ',') }}</td>
                <td class="tengah">{{ $d->status }}</td>
                <td class="tengah">{{ $d->keterangan }}</td>
                <td class="tengah">{{ $d->sbrg }}</td>
            </tr>
            @php
                $i++;

                if($d->sbrg == 'BAIK'){
                    $subtotalbaik += $d->total;
                    $totalbaik += $d->total;
                }
                else if($d->sbrg == 'RETUR'){
                    $subtotalretur += $d->total;
                    $totalretur += $d->total;
                }
                else{
                    $subtotalrusak += $d->total;
                    $totalrusak += $d->total;
                }

                $totalall += $d->total;
            @endphp
        @endforeach
        <tr>
            <td class="left" colspan="5">SUBTOTAL BARANG BAIK TANGGAL {{ $temp }}</td>
            <td class="right">{{ number_format($subtotalbaik, 2, '.', ',') }}</td>
            <td class=""></td>
        </tr>
        <tr>
            <td class="left" colspan="5">SUBTOTAL BARANG RETUR TANGGAL {{ $temp }}</td>
            <td class="right">{{ number_format($subtotalretur, 2, '.', ',') }}</td>
            <td class=""></td>
        </tr>
        <tr>
            <td class="left" colspan="5">SUBTOTAL BARANG RUSAK TANGGAL {{ $temp }}</td>
            <td class="right">{{ number_format($subtotalrusak, 2, '.', ',') }}</td>
            <td class=""></td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td class="border-top left" colspan="5">TOTAL SELURUHNYA</td>
            <td class="border-top right">{{ number_format($totalall, 2, '.', ',') }}</td>
            <td class="border-top" colspan="3"></td>
        </tr>
        </tfoot>
    </table>
@endsection
