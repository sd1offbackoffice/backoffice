@extends('html-template')

@section('table_font_size','7 px')

@section('paper_size',(count($arrTanggal)*30+612).'pt 595pt')
@section('paper_height','595pt')
@section('paper_width',(count($arrTanggal)*30+612).'pt')

@section('page_title')
    Stock Barang Kosong Per Periode DSI
@endsection

@section('title')
    ** STOCK BARANG KOSONG PER PERIODE DSI **
@endsection

@section('subtitle')
    Tanggal : {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('header_left')
    <p>MONITORING : {{ $monitoring }}</p>
@endsection

@section('content')
    <table class="table" border="1">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr>
                <th class="tengah center" rowspan="4">PRDCD</th>
                <th class="tengah center" rowspan="4">DESKRIPSI</th>
                <th class="tengah center" rowspan="4">FRAC</th>
                <th class="tengah center" rowspan="2" colspan="2">PO</th>
                <th class="tengah center" rowspan="2" colspan="2">BPB</th>
                <th class="tengah center" rowspan="4">SL</th>
                <th class="tengah center" rowspan="4">AVG</th>
                @for($i=0;$i<count($arrTahun);$i++)
                    <th class="tengah center" colspan="{{ $arrTahun[$i]->qty }}">{{ $arrTahun[$i]->tahun }}</th>
                @endfor
                <th class="tengah center" rowspan="2" colspan="4">EST. LOST SALES</th>
            </tr>
            <tr>
                @for($i=0;$i<count($arrBulan);$i++)
                    <th class="tengah center" colspan="{{ $arrBulan[$i]->qty }}">{{ $arrBulan[$i]->bulan }}</th>
                @endfor
            </tr>
            <tr>
                <th class="tengah" rowspan="2">FRQ</th>
                <th class="tengah" rowspan="2">QTY</th>
                <th class="tengah" rowspan="2">FRQ</th>
                <th class="tengah" rowspan="2">QTY</th>
                @for($i=0;$i<count($arrTanggal);$i++)
                    <th class="tengah center">{{ substr($arrTanggal[$i],0,2) }}</th>
                @endfor
                <th class="tengah" rowspan="2">AVG/DSI</th>
                <th class="tengah center" rowspan="2">QTY</th>
                <th class="tengah" rowspan="2">HRG JUAL</th>
                <th class="tengah" rowspan="2">RUPIAH</th>
            </tr>
            <tr>
                @for($i=0;$i<count($arrTanggal);$i++)
                    <th class="tengah center">QTY</th>
                @endfor
            </tr>
        </thead>
        <tbody>
        @foreach($data as $d)
            <tr>
                <td class="center">{{ $d['sth_prdcd'] }}</td>
                <td class="left">{{ $d['desk'] }}</td>
                <td class="center">{{ $d['frac'] }}</td>
                <td class="right">{{ number_format($d['frqpo'],0) }}</td>
                <td class="right">{{ number_format($d['qtypo'],0) }}</td>
                <td class="right">{{ number_format($d['frqbpb'],0) }}</td>
                <td class="right">{{ number_format($d['qtybpb'],0) }}</td>
                <td class="right">{{ number_format($d['sl'],0) }}</td>
                <td class="right">{{ number_format($d['v_avg_qty'],0) }}</td>
                @foreach($arrTanggal as $at)
                    <td class="right">{{ number_format($d[$at],0) }}</td>
                @endforeach
                <td class="right">{{ number_format($d['avgdsi'],0) }}</td>
                <td class="right">{{ number_format($d['qty'],0) }}</td>
                <td class="right">{{ number_format($d['hrgjual'],0) }}</td>
                <td class="right">{{ number_format($d['rupiah'],0) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
