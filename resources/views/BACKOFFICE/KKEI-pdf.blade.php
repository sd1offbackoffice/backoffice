@extends('html-template')

@section('table_font_size','7 px')

@section('paper_height','792pt')
@section('paper_width','1071pt')

@section('page_title')
    KERTAS KERJA ESTIMASI KEBUTUHAN TOKO IGR
@endsection

@section('title')
    ** KERTAS KERJA ESTIMASI KEBUTUHAN TOKO IGR **
@endsection

@section('subtitle')
    Periode : {{ $periode }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <td colspan="5"></td>
            <td colspan="4">--- Produk ---</td>
            <td></td>
            <td colspan="4">--- Kemasan (Karton) ---</td>
            <td colspan="3"></td>
            <td colspan="2">Sales 3 Bulan</td>
            <td colspan="5"></td>
            <td colspan="5">Breakdown PB</td>
            <td colspan="10"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td>Berat</td>
            <td colspan="4">Dimensi Produk</td>
            <td class="right">Berat</td>
            <td colspan="4">Dimensi Ctn Luar</td>
            <td class="right">Harga</td>
            <td></td>
            <td colspan="3">Terakhir</td>
            <td colspan="2">Avg Sales</td>
            <td>Saldo</td>
            <td>Estimasi</td>
            <td colspan="5">Minggu ke-</td>
            <td colspan="2">Buffer</td>
            <td>Saldo</td>
            <td colspan="2">Outstanding PO</td>
            <td colspan="5">Tanggal Kirim</td>
        </tr>
        <tr>
            <td>No.</td>
            <td>PL</td>
            <td>Nama Barang</td>
            <td>Satuan</td>
            <td class="right">Isi</td>
            <td class="right">(Kg)</td>
            <td class="right">P</td>
            <td class="right">L</td>
            <td class="right">T</td>
            <td class="right">Kubikasi</td>
            <td class="right">(Kg)</td>
            <td class="right">P</td>
            <td class="right">L</td>
            <td class="right">T</td>
            <td class="right">Kubikasi</td>
            <td class="right">Beli</td>
            <td class="right">Discount</td>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>Bulan</td>
            <td>Hari</td>
            <td>Awal</td>
            <td>Bulan</td>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td>LT</td>
            <td>SS</td>
            <td>Akhir</td>
            <td>Total</td>
            <td>Qty</td>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
        </tr>
        </thead>
        <tbody>
        @php
            $i = 0;
            $supplier = 'xxx';
            $kubik1 = 0;
            $kubik2 = 0;
            $kubik3 = 0;
            $kubik4 = 0;
            $kubik5 = 0;
        @endphp

        @foreach($data as $k)
            @php
                $i++;
                $kubik1 += $k->kke_kubik1;
                $kubik2 += $k->kke_kubik2;
                $kubik3 += $k->kke_kubik3;
                $kubik4 += $k->kke_kubik4;
                $kubik5 += $k->kke_kubik5;
            @endphp
            @php
                if($supplier != $k->kke_kdsup){
                    $supplier = $k->kke_kdsup;
            @endphp
            <tr>
                <td colspan="39" class="left"><strong>Supplier : {{ $k->kke_kdsup }}  -  {{ $k->kke_nmsup }}</strong></td>
            </tr>
            @php
                }
            @endphp
            <tr style="text-align: right">
                <td class="center">{{ $i }}</td>
                <td class="center">{{ $k->kke_prdcd }}</td>
                <td style="text-align: left">{{ substr($k->prd_deskripsipendek,0,21) }}</td>
                <td class="center">{{ $k->kke_unit }}</td>
                <td>{{ $k->kke_frac }}</td>
                <td>{{ number_format((float)$k->kke_beratproduk, 2, '.', '') }}</td>
                <td>{{ $k->kke_panjangprod }}</td>
                <td>{{ $k->kke_lebarprod }}</td>
                <td>{{ $k->kke_tinggiprod }}</td>
                <td>{{ number_format((float)$k->kke_kubikasiprod, 2, '.', '') }}</td>
                <td>{{ number_format($k->kke_beratkmsn, 2) }}</td>
                <td>{{ number_format($k->kke_panjangkmsn) }}</td>
                <td>{{ number_format($k->kke_lebarkmsn) }}</td>
                <td>{{ number_format($k->kke_tinggikmsn) }}</td>
                <td>{{ number_format((float)$k->kke_kubikasikmsn, 2, '.', '') }}</td>
                <td>{{ number_format($k->kke_hargabeli) }}</td>
                <td>{{ number_format($k->kke_discount) }}</td>
                <td>{{ number_format($k->kke_sales01) }}</td>
                <td>{{ number_format($k->kke_sales02) }}</td>
                <td>{{ number_format($k->kke_sales03) }}</td>
                <td>{{ number_format($k->kke_avgbln) }}</td>
                <td>{{ number_format($k->kke_avghari) }}</td>
                <td>{{ number_format($k->kke_saldoawal) }}</td>
                <td>{{ number_format($k->kke_estimasi) }}</td>
                <td>{{ number_format($k->kke_breakpb01) }}</td>
                <td>{{ number_format($k->kke_breakpb02) }}</td>
                <td>{{ number_format($k->kke_breakpb03) }}</td>
                <td>{{ number_format($k->kke_breakpb04) }}</td>
                <td>{{ number_format($k->kke_breakpb05) }}</td>
                <td>{{ number_format($k->kke_bufferlt) }}</td>
                <td>{{ number_format($k->kke_bufferss) }}</td>
                <td>{{ number_format($k->kke_saldoakhir) }}</td>
                <td>{{ number_format($k->kke_outpototal) }}</td>
                <td>{{ number_format($k->kke_outpoqty) }}</td>
                <td>{{ $k->kke_tglkirim01 ? \Carbon\Carbon::createFromFormat('Y-m-d',substr($k->kke_tglkirim01,0,10))->format('d/m/Y') : '' }}</td>
                <td>{{ $k->kke_tglkirim02 ? \Carbon\Carbon::createFromFormat('Y-m-d',substr($k->kke_tglkirim02,0,10))->format('d/m/Y') : '' }}</td>
                <td>{{ $k->kke_tglkirim03 ? \Carbon\Carbon::createFromFormat('Y-m-d',substr($k->kke_tglkirim03,0,10))->format('d/m/Y') : '' }}</td>
                <td>{{ $k->kke_tglkirim04 ? \Carbon\Carbon::createFromFormat('Y-m-d',substr($k->kke_tglkirim04,0,10))->format('d/m/Y') : '' }}</td>
                <td>{{ $k->kke_tglkirim05 ? \Carbon\Carbon::createFromFormat('Y-m-d',substr($k->kke_tglkirim05,0,10))->format('d/m/Y') : '' }}</td>
            </tr>


        @endforeach
            <tr style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black">
                <td colspan="23" class="left"><strong>Kebutuhan Kontainer :</strong><br>20 Feet</td>
                <td>Total</td>
                <td>{{ $kubik1 }}</td>
                <td>{{ $kubik2 }}</td>
                <td>{{ $kubik3 }}</td>
                <td>{{ $kubik4 }}</td>
                <td>{{ $kubik5 }}</td>
                <td colspan="10"></td>
            </tr>
        </tbody>
        <tfoot>

        </tfoot>
    </table>

    <table width="100%">
        <tbody>
            <tr>
                <td width="20%"><strong></strong></td>
                <td width="66%"></td>
                <td width="7%">Disetujui</td>
                <td width="7%">Dibuat</td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>NB :</td>
            </tr>
            <tr>
                <td>1 Kubikase = 30 m3, 1 Tonase = 22</td>
            </tr>
            <tr>
                <td>Toleransi Kubikase & Tonase adalah 5%</td>
                <td></td>
                <td>Store Mgr</td>
                <td>Store Jr. Mgr</td>
            </tr>
        </tbody>
    </table>
@endsection
