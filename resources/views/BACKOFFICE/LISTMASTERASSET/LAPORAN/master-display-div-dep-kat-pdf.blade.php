@extends('html-template')

@section('table_font_size','7px')

@section('page_title')
    MASTER DISPLAY
@endsection

@section('title')
    {{$title}}
@endsection

@section('subtitle')
    {{$perusahaan->prs_namawilayah}}
@endsection

@php
    function zeroDigit($angka){
        $digit = number_format($angka,0,'.',',');
        return $digit;
    }
    function twoDigit($angka){
        $digit = number_format($angka,2,'.',',');
        return $digit;
    }
    $divisi = '';
    $departemen = '';
    $kategori = '';
@endphp
@section('content')

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr>
                <th style="vertical-align: middle; text-align: left">PLU&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">DESKRIPSI&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">SATUAN&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">FACING&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">RAK&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">SUB RAK&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">SLV RAK&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">BAR&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">NO.ID&nbsp;&nbsp;&nbsp;&nbsp;</th>
            </tr>
        </thead>
        <tbody style="text-align: center; vertical-align: middle">
        @for($i=0;$i<sizeof($data);$i++)
            <tr>
                <td style="text-align: left">{{$data[$i]->prd_prdcd}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->prd_deskripsipanjang}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                @if($p_omi == 0)
                    @if($data[$i]->prc_pluomi != '' && $data[$i]->prc_group == 'O')
                        @if(!in_array($data[$i]->prc_kodetag, $forbidden_tag))
                            <td style="text-align: center">&nbsp;*&nbsp;</td>
                        @else
                            <td style="text-align: center">&nbsp;</td>
                        @endif
                    @else
                        <td style="text-align: center">&nbsp;</td>
                    @endif
                @else
                    <td style="text-align: center">&nbsp;</td>
                @endif
                <td style="text-align: left">{{$data[$i]->satuan}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->fmface}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->fmkrak}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->fmsrak}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->fmselv}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->fmnour}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->fmnoid}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
        @endfor
        </tbody>
    </table>
@endsection
