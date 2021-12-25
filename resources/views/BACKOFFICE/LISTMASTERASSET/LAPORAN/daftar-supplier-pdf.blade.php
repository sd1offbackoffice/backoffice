@extends('html-template')

@section('table_font_size','7px')

@section('paper_size','842pt 595pt')
@section('paper_height','595pt')
@section('paper_width','842pt')

@section('page_title')
    DAFTAR SUPPLIER
@endsection

@section('title')
    ** DAFTAR SUPPLIER **
@endsection

@section('subtitle')

@endsection

@php
    $counter         = 0;
@endphp
@section('content')

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr>
                <th style="vertical-align: middle; text-align: left">KODE&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">NAMA SUPPLIER&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">NPWP&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">S.K. PENGUKUHAN&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">TGL S.K.P&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">ALAMAT&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">TERM&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">CONTACT PERSON&nbsp;&nbsp;&nbsp;&nbsp;</th>
            </tr>
        </thead>
        <tbody style="text-align: center; vertical-align: middle">
        @for($i=0;$i<sizeof($data);$i++)
            <tr>
                <td style="text-align: left">{{$data[$i]->sup_kodesupplier}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->sup_namasupplier}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->sup_npwp}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->sup_nosk}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <?php
                $date = new DateTime($data[$i]->sup_tglsk);
                $strip = $date->format('d-m-Y');
                ?>
                <td style="text-align: left">{{$strip}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->alamat}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->sup_top}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->sup_contactperson}}</td>
            </tr>
            @php
                 $counter++;
            @endphp
        @endfor
        </tbody>
    </table>
    <p style="font-weight: bold">TOTAL&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$counter}} SUPPLIER</p>
@endsection
