@extends('html-template')

@if($jnskertas == 'K')
    @section('paper_size', '595pt 442pt')
@endif

@section('table_font_size','7 px')

@section('page_title')
    {{ strtoupper($data1[0]->judul) }}
@endsection

@section('title')
    NOTA PENGELUARAN BARANG
@endsection

@section('subtitle')
    {{ strtoupper($data1[0]->judul) }}
@endsection

@section('header_left')
    <p>
        <b>{{ $data1[0]->status }}</b>
    </p>
@endsection

@section('custom_style')
    header {
        height: 6cm;
    }
@endsection

@section('content')
    @for($a=0;$a<count($arrData);$a++)
        @php $arr = $arrData[$a]; @endphp
        <table class="table">
            <thead>
            <tr>
                <th class="right">SUPPLIER : </th>
                <th class="left padding-left" colspan="3">{{ $arr['detail'][0]->namas }}</th>
                <th class="right">ALAMAT : </th>
                <th class="left padding-left" colspan="3">{{ $arr['detail'][0]->sup_alamatsupplier1 }}</th>
            </tr>
            <tr>
                <th class="right">NPWP : </th>
                <th class="left padding-left" colspan="3">{{ $arr['detail'][0]->sup_npwp }}</th>
                <th></th>
                <th class="left padding-left" colspan="3">
                    {{ $arr['detail'][0]->sup_alamatsupplier2.' '.$arr['detail'][0]->sup_kotasupplier3 }}
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="right">NOMOR :</td>
                <td class="left padding-left">{{ $arr['head'][0]->nodoc }}</td>
                <td class="right">TGL NPB :</td>
                <td class="left padding-left">{{ $arr['head'][0]->nodoc }}</td>
                <td class="right">TELP :</td>
                <td class="left padding-left">{{ $arr['detail'][0]->sup_telpsupplier }}</td>
                <td class="right">CONTACT PERSON :</td>
                <td class="left padding-left">{{ $arr['detail'][0]->sup_contactperson }}</td>
            </tr>
            @for($h=0;$h<count($arr['head']);$h++)
                <tr>
                    <td class="right">@if($h == 0) FAKTUR PAJAK : @endif</td>
                    <td class="left padding-left">{{ $arr['head'][$h]->nofp }}</td>
                    <td class="right">@if($h == 0) TGL FP : @endif</td>
                    <td class="left padding-left">{{ $arr['head'][$h]->mstd_date3 }}</td>
                    @if(++$h < count($arr['head']))
                        <td class="right">@if($h == 1) FAKTUR PAJAK : @endif</td>
                        <td class="left padding-left">{{ $arr['head'][$h]->nofp }}</td>
                        <td class="right">@if($h == 1) TGL FP : @endif</td>
                        <td class="left padding-left">{{ $arr['head'][$h]->mstd_date3 }}</td>
                    @endif
                </tr>
            @endfor
            </tbody>
        </table>
{{--        <div style="float:left; margin-top: 0px; line-height: 8px !important;">--}}
{{--            @foreach($arr['head'] as $head)--}}
{{--                <p>--}}
{{--                    NOMOR : {{ $head->nodoc }}<br>--}}
{{--                    TGL NPB : {{ substr($head->msth_tgldoc,0,10) }}<br>--}}
{{--                    FAKTUR PAJAK : {{ $head->nofp }}<br>--}}
{{--                    TGL FP : {{ substr($head->mstd_date3,0,10) }}--}}
{{--                </p>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--        <div style="float:right; margin-top: 0px; line-height: 8px !important;">--}}

{{--        </div>--}}

        <table class="table">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">PLU</th>
                <th rowspan="2">NAMA BARANG</th>
                <th rowspan="2">KEMASAN</th>
                <th colspan="2">KWANTUM</th>
                <th rowspan="2">HARGA<br>SATUAN</th>
                <th rowspan="2">TOTAL NILAI</th>
                <th rowspan="2">NO. REF <br> BTB</th>
                <th rowspan="2">KETERANGAN</th>
            </tr>
            <tr>
                <th>BESAR</th>
                <th>KECIL</th>
            </tr>
            </thead>
            <tbody>
            @php
                $gross = 0;
                $potongan = 0;
                $ppn = 0;
                $total = 0;
                $i=1;
            @endphp

            @foreach($arr['detail'] as $d)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $d->mstd_prdcd }}</td>
                    <td class="left">{{ $d->prd_deskripsipanjang}}</td>
                    <td>{{ $d->mstd_unit }}</td>
                    <td class="right">{{ $d->ctn }}</td>
                    <td class="right">{{ $d->pcs }}</td>
                    <td class="right">{{ number_format(round($d->mstd_hrgsatuan), 0, '.', ',') }}</td>
                    <td class="right">{{ number_format(round($d->mstd_gross), 0, '.', ',') }}</td>
                    <td class="right">{{ $d->mstd_noref3 }}</td>
                    <td>{{ $d->mstd_keterangan }}</td>
                </tr>
                @php
                    $i++;
                    $total += $d->total;
                    $gross += $d->mstd_gross;
                    $potongan += $d->mstd_discrph;
                    $ppn += $d->mstd_ppnrph;
                @endphp
            @endforeach


            </tbody>
            <tfoot>
            <tr>
                <td colspan="6"></td>
                <td style="font-weight: bold">TOTAL HARGA BELI</td>
                <td class="right">{{ number_format(round($gross), 0, '.', ',') }}</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="6"></td>
                <td style="font-weight: bold">TOTAL POTONGAN</td>
                <td class="right">{{ number_format(round($potongan), 0, '.', ',') }}</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="6"></td>
                <td style="font-weight: bold">TOTAL PPN</td>
                <td class="right">{{ number_format(round($ppn), 0, '.', ',') }}</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="6"></td>
                <td style="font-weight: bold">TOTAL SELURUHNYA</td>
                <td class="right">{{ number_format(round($total), 0, '.', ',') }}</td>
                <td></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
        <br>
{{--        <table class="table" border="1">--}}
{{--            <thead>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            <tr style="border-top: 1px solid black;border-bottom: 1px solid black;">--}}
{{--                <td class="left" colspan="3">&nbsp; DIBUAT <br><br><br></td>--}}
{{--                <td class="left" colspan="3">&nbsp; MENYETUJUI :</td>--}}
{{--                <td colspan="4"></td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td class="left" colspan="3">&nbsp; ADMINISTRASI</td>--}}
{{--                <td class="left" colspan="3">&nbsp; KEPALA GUDANG</td>--}}
{{--                <td class="left" colspan="4">&nbsp; SUPPLIER</td>--}}
{{--            </tr>--}}
{{--            </tbody>--}}
{{--        </table>--}}
        <table style="width: 100%; font-weight: bold" class="table-ttd page-break-avoid">
            <tr>
                <td>DIBUAT</td>
                <td>MENYETUJUI</td>
                <td></td>
            </tr>
            <tr class="blank-row">
                <td colspan="5">.</td>
            </tr>
            <tr>
                <td class="overline">ADMINISTRASI</td>
                <td class="overline">KEPALA GUDANG</td>
                <td class="overline">SUPPLIER</td>
            </tr>
        </table>
        @if($a + 1 < count($arrData))
            <div class="page-break"></div>
        @endif
    @endfor
@endsection
