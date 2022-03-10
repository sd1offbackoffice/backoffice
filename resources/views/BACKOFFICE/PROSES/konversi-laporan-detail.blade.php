@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Daftar Penyesuaian Persediaan Konversi Perishable
@endsection

@section('title')
    DAFTAR PENYESUAIAN PERSEDIAAN<br>KONVERSI PERISHABLE
@endsection

@section('content')
    @php
        $tempTgl = null;
        $tempKat = null;
        $tempDep = null;
        $tempDiv = null;
        $totKat = 0;
        $totDep = 0;
        $totDiv = 0;
    @endphp
    @foreach($data as $d)
        @if($tempTgl != $d->msth_tgldoc)
            @if($tempTgl != null)
                </tbody>
            </table>
            <div class="page-break"></div>
            @endif
            @php $tempTgl = $d->msth_tgldoc; @endphp
            <table class="table table-borderless table-header">
                <thead>
                <tr>
                    <th>
                        Tanggal
                    </th>
                    <th>
                        : {{ $d->msth_tgldoc }}
                    </th>
                    <th width="50%"></th>
                    <th>RINCIAN PRODUK PER DIVISI / DEPARTEMEN / KATEGORI</th>
                </tr>
                </thead>
            </table>
            <table class="table">
                <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
                <tr>
                    <th colspan="2" width="10%">---------------- BAPB ----------------</th>
                    <th class="tengah" rowspan="2" width="5%">PLU</th>
                    <th class="tengah" rowspan="2" width="15%">NAMA BARANG</th>
                    <th class="tengah padding-left" rowspan="2" width="5%">KEMASAN</th>
                    <th class="tengah padding-left right" rowspan="2" width="10%">HARGA SATUAN</th>
                    <th class="tengah padding-left right" rowspan="2" width="10%">KUANTUM</th>
                    <th class="tengah padding-left right" rowspan="2" width="10%">TOTAL NILAI</th>
                    <th class="tengah padding-left" rowspan="2" width="35%">KETERANGAN</th>
                </tr>
                <tr>
                    <th>NOMOR</th>
                    <th>TANGGAL</th>
                </tr>
                </thead>
                <tbody>
        @endif
        @if($tempKat != $d->prd_kodekategoribarang || $tempDep != $d->prd_kodedepartement || $tempDiv != $d->prd_kodedivisi)
            @if($tempKat != null && $tempDep != null && $tempDiv != null)
                @if($tempKat != $d->prd_kodekategoribarang)
                    <tr>
                        <td class="left" colspan="2">SUBTOTAL KATEGORI : {{ $d->prd_kodekategoribarang }}</td>
                        <td colspan="5"></td>
                        <td class="right">{{ number_format($totKat,2) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="left" colspan="2">SUBTOTAL DEPARTEMENT : {{ $d->prd_kodedepartement }}</td>
                        <td colspan="5"></td>
                        <td class="right">{{ number_format($totDep,2) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="left" colspan="2">SUBTOTAL DIVISI : {{ $d->prd_kodedivisi }}</td>
                        <td colspan="5"></td>
                        <td class="right">{{ number_format($totDiv,2) }}</td>
                        <td></td>
                    </tr>
                    @php
                        $totKat = 0;
                        $totDep = 0;
                        $totDiv = 0;
                    @endphp
                @elseif($tempDep != $d->prd_kodedepartement)
                    <tr>
                        <td class="left" colspan="2">SUBTOTAL DEPARTEMENT : {{ $d->prd_kodedepartement }}</td>
                        <td colspan="5"></td>
                        <td class="right">{{ number_format($totDep,2) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="left" colspan="2">SUBTOTAL DIVISI : {{ $d->prd_kodedivisi }}</td>
                        <td colspan="5"></td>
                        <td class="right">{{ number_format($totDiv,2) }}</td>
                        <td></td>
                    </tr>
                    @php
                        $totDep = 0;
                        $totDiv = 0;
                    @endphp
                @else
                    <tr>
                        <td class="left" colspan="2">SUBTOTAL DIVISI : {{ $d->prd_kodedivisi }}</td>
                        <td colspan="5"></td>
                        <td class="right">{{ number_format($totDiv,2) }}</td>
                        <td></td>
                    </tr>
                    @php
                        $totDiv = 0;
                    @endphp
                @endif
            @endif
            @php
                $tempKat = $d->prd_kodekategoribarang;
                $tempDep = $d->prd_kodedepartement;
                $tempDiv = $d->prd_kodedivisi;
            @endphp
            <tr>
                <td class="left">DIVISI</td>
                <td class="left">: {{ $d->prd_kodedivisi }} - {{ $d->div_namadivisi }}</td>
                <td colspan="7"></td>
            </tr>
            <tr>
                <td class="left">DEPARTEMEN</td>
                <td class="left">: {{ $d->prd_kodedepartement }} - {{ $d->dep_namadepartement }}</td>
                <td colspan="7"></td><td></td>
            </tr>
            <tr>
                <td class="left">KATEGORI</td>
                <td class="left">: {{ $d->prd_kodekategoribarang }} - {{ $d->kat_namakategori }}</td>
                <td colspan="7"></td>
            </tr>
        @endif

        <tr>
            <td>{{ $d->msth_nodoc }}</td>
            <td>{{ $d->msth_tgldoc }}</td>
            <td>{{ $d->plu }}</td>
            <td class="left">{{ $d->barang }}</td>
            <td>{{ $d->kemasan }}</td>
            <td class="right">{{ $d->harga }}</td>
            <td class="right">{{ $d->qty }}</td>
            <td class="right">{{ number_format($d->total,2) }}</td>
            <td>{{ $d->keterangan }}</td>
        </tr>

        @php
            $totKat += $d->total;
            $totDep += $d->total;
            $totDiv += $d->total;
        @endphp
    @endforeach
        <tr>
            <td class="left" colspan="2">SUBTOTAL KATEGORI : {{ $d->prd_kodekategoribarang }}</td>
            <td colspan="5"></td>
            <td class="right">{{ number_format($totKat,2) }}</td>
            <td></td>
        </tr>
        <tr>
            <td class="left" colspan="2">SUBTOTAL DEPARTEMENT : {{ $d->prd_kodedepartement }}</td>
            <td colspan="5"></td>
            <td class="right">{{ number_format($totDep,2) }}</td>
            <td></td>
        </tr>
        <tr>
            <td class="left" colspan="2">SUBTOTAL DIVISI : {{ $d->prd_kodedivisi }}</td>
            <td colspan="5"></td>
            <td class="right">{{ number_format($totDiv,2) }}</td>
            <td></td>
        </tr>
        </tbody>
    </table>
@endsection

@section('contents')
    <table class="table table-borderless table-header">
        <thead>
        <tr>
            <th>
                Tanggal
            </th>
            <th>
                : {{ $data[0]->msth_tgldoc }}
            </th>
            <th width="50%"></th>
            <th>RINCIAN PRODUK PER DIVISI / DEPARTEMEN / KATEGORI</th>
        </tr>
        </thead>
    </table>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th colspan="2" width="10%">---------------- BAPB ----------------</th>
            <th class="tengah" rowspan="2" width="5%">PLU</th>
            <th class="tengah" rowspan="2" width="15%">NAMA BARANG</th>
            <th class="tengah" rowspan="2" width="5%">KEMASAN</th>
            <th class="tengah right" rowspan="2" width="10%">HARGA SATUAN</th>
            <th class="tengah right" rowspan="2" width="10%">KUANTUM</th>
            <th class="tengah right" rowspan="2" width="10%">TOTAL NILAI</th>
            <th class="tengah" rowspan="2" width="35%">KETERANGAN</th>
        </tr>
        <tr>
            <th>NOMOR</th>
            <th>TANGGAL</th>
        </tr>
        </thead>
        <tbody>
        @php $div = ''; $dep = ''; $kat = ''; $print = false; @endphp
        @for($i=0;$i<count($data);$i++)
            @php $d = $data[$i]; @endphp
            @if($div != $d->prd_kodedivisi || $dep != $d->prd_kodedepartement || $kat != $d->prd_kodekategoribarang)
                @php
                    $div = $d->prd_kodedivisi;
                    $dep = $d->prd_kodedepartement;
                    $kat = $d->prd_kodekategoribarang;
                @endphp
                <tr>
                    <td class="left">DIVISI</td>
                    <td class="left">: {{ $d->prd_kodedivisi }} - {{ $d->div_namadivisi }}</td>
                    <td colspan="7"></td>
                </tr>
                <tr>
                    <td class="left">DEPARTEMEN</td>
                    <td class="left">: {{ $d->prd_kodedepartement }} - {{ $d->dep_namadepartement }}</td>
                    <td colspan="7"></td><td></td>
                </tr>
                <tr>
                    <td class="left">KATEGORI</td>
                    <td class="left">: {{ $d->prd_kodekategoribarang }} - {{ $d->kat_namakategori }}</td>
                    <td colspan="7"></td>
                </tr>
            @endif
            <tr>
                <td>{{ $d->msth_nodoc }}</td>
                <td>{{ $d->msth_tgldoc }}</td>
                <td>{{ $d->plu }}</td>
                <td class="left">{{ $d->barang }}</td>
                <td>{{ $d->kemasan }}</td>
                <td class="right">{{ $d->harga }}</td>
                <td class="right">{{ $d->qty }}</td>
                <td class="right">{{ number_format($d->total,2) }}</td>
                <td>{{ $d->keterangan }}</td>
            </tr>
            @php $j = $i; @endphp
            @if(++$j < count($data))
                @if($div != $data[$j]->prd_kodedivisi || $dep != $data[$j]->prd_kodedepartement || $kat != $data[$j]->prd_kodekategoribarang)
                    @php $print = false; @endphp
                    <tr>
                        <td class="left" colspan="2">SUBTOTAL DEPARTEMENT : {{ $d->prd_kodedepartement }}</td>
                        <td class="right">{{ number_format($d->total,2) }}</td>
                    </tr>
                    <tr>
                        <td class="left" colspan="2">SUBTOTAL DIVISI : {{ $d->prd_kodedivisi }}</td>
                        <td class="right">{{ number_format($d->total,2) }}</td>
                    </tr>
                @endif
            @endif
        @endfor
        <tr>
            <td class="left" colspan="2">SUBTOTAL KATEGORI : {{ $d->prd_kodekategoribarang }}</td>
            <td colspan="5"></td>
            {{--<td class="right">{{ number_format($d->total,2) }}</td>--}}
            <td class="right">0.00</td>
            <td></td>
        </tr>
        <tr>
            <td class="left" colspan="2">SUBTOTAL DEPARTEMENT : {{ $d->prd_kodedepartement }}</td>
            <td colspan="5"></td>
            {{--<td class="right">{{ number_format($d->total,2) }}</td>--}}
            <td class="right">0.00</td>
            <td></td>
        </tr>
        <tr>
            <td class="left" colspan="2">SUBTOTAL DIVISI : {{ $d->prd_kodedivisi }}</td>
            <td colspan="5"></td>
            {{--<td class="right">{{ number_format($d->total,2) }}</td>--}}
            <td class="right">0.00</td>
            <td></td>
        </tr>
        </tbody>
        <tfoot style="text-align: center">
        <tr>
            <td class="left" colspan="2">TOTAL SELURUHNYA</td>
            <td colspan="5"></td>
            {{--<td class="right">{{ number_format($d->total,2) }}</td>--}}
            <td class="right">0.00</td>
            <td></td>
        </tr>
        </tfoot>
    </table>
@endsection
