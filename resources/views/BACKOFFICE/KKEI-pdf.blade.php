@extends('html-template')

@section('table_font_size','7 px')

@section('paper_height','792pt')
@section('paper_width','1071pt')

@section('page_title')
    @lang('KERTAS KERJA ESTIMASI KEBUTUHAN TOKO IGR')
@endsection

@section('title')
    @lang('** KERTAS KERJA ESTIMASI KEBUTUHAN TOKO IGR **')
@endsection

@section('subtitle')
    @lang('Periode :') {{ $periode }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <td colspan="5"></td>
            <td colspan="4">@lang('--- Produk ---')</td>
            <td></td>
            <td colspan="4">@lang('--- Kemasan (Karton) ---')</td>
            <td colspan="3"></td>
            <td colspan="2">@lang('Sales 3 Bulan')</td>
            <td colspan="5"></td>
            <td colspan="5">@lang('Breakdown PB')</td>
            <td colspan="10"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td>@lang('Berat')</td>
            <td colspan="4">@lang('Dimensi Produk')</td>
            <td class="right">@lang('Berat')</td>
            <td colspan="4">@lang('Dimensi Ctn Luar')</td>
            <td class="right">@lang('Harga')</td>
            <td></td>
            <td colspan="3">@lang('Terakhir')</td>
            <td colspan="2">@lang('Avg Sales')</td>
            <td>@lang('Saldo')</td>
            <td>@lang('Estimasi')</td>
            <td colspan="5">@lang('Minggu ke-')</td>
            <td colspan="2">@lang('Buffer')</td>
            <td>@lang('Saldo')</td>
            <td colspan="2">@lang('Outstanding PO')</td>
            <td colspan="5">@lang('Tanggal Kirim')</td>
        </tr>
        <tr>
            <td>@lang('No.')</td>
            <td>@lang('PL')</td>
            <td>@lang('Nama Barang')</td>
            <td>@lang('Satuan')</td>
            <td class="right">@lang('Isi')</td>
            <td class="right">@lang('(Kg)')</td>
            <td class="right">@lang('P')</td>
            <td class="right">@lang('L')</td>
            <td class="right">@lang('T')</td>
            <td class="right">@lang('Kubikasi')</td>
            <td class="right">@lang('(Kg)')</td>
            <td class="right">@lang('P')</td>
            <td class="right">@lang('L')</td>
            <td class="right">@lang('T')</td>
            <td class="right">@lang('Kubikasi')</td>
            <td class="right">@lang('Beli')</td>
            <td class="right">@lang('Discount')</td>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>@lang('Bulan')</td>
            <td>@lang('Hari')</td>
            <td>@lang('Awal')</td>
            <td>@lang('Bulan')</td>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td>@lang('LT')</td>
            <td>@lang('SS')</td>
            <td>@lang('Akhir')</td>
            <td>@lang('Total')</td>
            <td>@lang('Qty')</td>
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
                <td colspan="23" class="left"><strong>@lang('Kebutuhan Kontainer :')</strong><br>20 Feet</td>
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
                <td width="7%">@lang('Disetujui')</td>
                <td width="7%">@lang('Dibuat')</td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>NB :</td>
            </tr>
            <tr>
                <td>@lang('1 Kubikase = 30 m3, 1 Tonase = 22')</td>
            </tr>
            <tr>
                <td>@lang('Toleransi Kubikase & Tonase adalah 5%')</td>
                <td></td>
                <td>Store Mgr</td>
                <td>Store Jr. Mgr</td>
            </tr>
        </tbody>
    </table>
@endsection
