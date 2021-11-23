@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    FAKTUR PAJAK STANDAR
@endsection

@section('title')
    ** FAKTUR PAJAK STANDAR **
@endsection

@section('subtitle')
    TANGGAL : {{ $tanggal }}<br>
    KODE MEMBER : {{ $kodemember }}
@endsection

@if(count($data) > 0)
    @section('header_left')
        NO. FP : {{ $data[0]->no_fp }}<br><br>
        NO. INV : {{ $data[0]->fkt_station }}.{{ $data[0]->fkt_kasir }}.{{ $data[0]->fkt_notransaksi }}*<br><br>
    @endsection

    @section('header_optional')
        <p class="left">
            CUSTOMER<br>
            {{ $data[0]->nama_cust }}<br>
            {{ $data[0]->almt_c_1 }}<br>
            {{ $data[0]->almt_c_2 }}<br>
            NPWP : {{ $data[0]->npwp_cust }}<br>
            NPPKP : {{ $data[0]->nppkp }}
        </p>
    @endsection
@endif

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th width="5%" class="right padding-right">No</th>
            <th width="50%" class="left padding-left">DESKRIPSI</th>
            <th width="15%" class="right">QTY</th>
            <th width="15%" class="right">HARGA SATUAN</th>
            <th width="15%" class="right">TOTAL</th>
        </tr>
        </thead>
        <tbody>
        @php $no = 1; @endphp
        @foreach($data as $d)
            <tr>
                <td width="5%" class="right padding-right">{{ $no++ }}</td>
                <td width="50%" class="left padding-left">{{ $d->nama_brg }}</td>
                <td width="15%" class="right">{{ $d->kuantitas }}</td>
                <td width="15%" class="right">{{ number_format($d->hrg_satuan, 0, '.', ',') }}</td>
                <td width="15%" class="right">{{ number_format($d->jumlah, 0, '.', ',') }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection

@section('ttd')
    <table style="width: 100%; font-weight: bold" class="table-ttd page-break-avoid">
        <tr>
            <td width="75%"></td>
            <td class="center">{{ $perusahaan->prs_namawilayah }}, {{ $data[0]->tgl_fp }}</td>
        </tr>
        <tr class="blank-row">
            <td colspan="2">.</td>
        </tr>
        <tr>
            <td width="75%"></td>
            <td class="center">{{ $nama }}</td>
        </tr>
        <tr>
            <td width="75%"></td>
            <td class="center">{{ $jabatan }}</td>
        </tr>
    </table>
@endsection
