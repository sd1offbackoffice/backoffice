@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    RINCIAN PENGGUNAAN REWARD POIN
@endsection

@section('title')
    REKAPITULASI MUTASI POINT REWARD
@endsection

@section('subtitle')
    {{substr($tgl1,0,10)}} s/d {{substr($tgl2,0,10)}}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th colspan="5"></th>
            <th colspan="2">---- Pemakaian ----</th>
            <th colspan="2"></th>
        </tr>
        <tr>
            <th class="left">MEMBER MERAH</th>
            <th class="left">ID. MEMBER</th>
            <th class="right">Saldo Awal</th>
            <th class="right">Perolehan Hadiah Struk Trn</th>
            <th class="right">Transfer Dari Kode Member Lama</th>
            <th class="right">Pembayaran Dengan Point</th>
            <th class="right">Produk Redeem Point</th>
            <th class="right">Transfer Dari Kode Member Baru</th>
            <th class="right">Saldo Akhir</th>
        </tr>
        </thead>
        <tbody>
        @php
            $sub_tkr = 0;
            $sub_rdm= 0;
            $sub_tot_tkr = 0;
            $total_tkr = 0;
            $total_rdm= 0;
            $total_tot_tkr = 0;
            $temptgl = '';
        @endphp

        @if(sizeof($data)!=0)
            @for($i=0;$i<count($data);$i++)
                <tr>
                    <td>{{ $data[$i]->cus_namamember }}</td>
                    <td>{{ $data[$i]->kdmbr }}</td>
                    <td>{{ number_format($data[$i]->saldo_awal_bulan, 0,".","," }}</td>
                    <td>{{ number_format($data[$i]->perolehanpoint, 0,".",","}}</td>
                    <td>{{ number_format($data[$i]->trf_kodelama, 0,".","," }}</td>
                    <td>{{ number_format($data[$i]->penukaranpoint, 0,".","," }}</td>
                    <td>{{ number_format($data[$i]->redeempoint, 0,".","," }}</td>
                    <td>{{ number_format($data[$i]->trf_kodebaru, 0,".","," }}</td>
                    <td>{{ number_format($data[$i]->saldo_akhir_bulan, 0,".","," }}</td>
                </tr>
            @endfor
        @else
            <tr>
                <td colspan="9">TIDAK ADA DATA</td>
            </tr>
        @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
