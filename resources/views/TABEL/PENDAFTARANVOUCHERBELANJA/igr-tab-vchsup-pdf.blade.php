@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN REGISTER PPR
@endsection

@section('title')
    ** TABEL PENDAFTARAN VOUCHER SUPPLIER **
@endsection

{{--@section('paper_width')--}}
{{--    842--}}
{{--@endsection--}}

{{--@section('paper_size')--}}
{{--    842pt  595pt--}}
{{--@endsection--}}
@section('content')

    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah center">SINGKATAN<br>SUPPLIER</th>
            <th class="tengah center">NILAI VOUCHER</th>
            <th class="tengah center">TGL MULAI</th>
            <th class="tengah center">TGL AKHIR</th>
            <th class="tengah center">MAX VOUCHER</th>
            <th class="tengah center">MIN STRUK</th>
            <th class="tengah center">JOIN PROMO</th>
            <th class="tengah center">KETERANGAN</th>
        </tr>
        </thead>
        <tbody>
        @if(sizeof($data)!=0)
            @for($i = 0; $i < sizeof($data); $i++)
                <tr>
                    <td class="left">{{$data[$i]->vcs_namasupplier}}</td>
                    <td class="right padding-right">{{number_format($data[$i]->vcs_nilaivoucher, 0,".",",")}}</td>
                    <td class="left">{{date('d/m/Y',strtotime(substr($data[$i]->vcs_tglmulai,0,10)))}}</td>
                    <td class="left">{{date('d/m/Y',strtotime(substr($data[$i]->vcs_tglakhir,0,10)))}}</td>
                    <td class="right">{{number_format($data[$i]->vcs_maxvoucher, 0,".",",")}}</td>
                    <td class="right padding-right">{{number_format($data[$i]->vcs_minstruk, 0,".",",")}}</td>
                    <td class="left">{{$data[$i]->vcs_joinpromo}}</td>
                    <td class="left">{{$data[$i]->vcs_keterangan}}</td>
                </tr>
            @endfor
        @else
            <tr>
                <td colspan="12">TIDAK ADA DATA</td>
            </tr>
        @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>

@endsection
