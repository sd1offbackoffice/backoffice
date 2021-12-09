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
    $rak = '';
    $subrak = '';
    $tipe = '';
    $shelving = '';
@endphp
@section('content')

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr>
                <th rowspan="2" style="vertical-align: middle; text-align: left">NO.&nbsp;&nbsp;&nbsp;&nbsp;<br>RAK&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th colspan="3" style="vertical-align: middle; text-align: center">URUTAN</th>
                <th rowspan="2" style="vertical-align: middle; text-align: left">NO.&nbsp;&nbsp;&nbsp;&nbsp;<br>URUT&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th rowspan="2" style="vertical-align: middle; text-align: left">K-K&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th rowspan="2" style="vertical-align: middle; text-align: left">D-B&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th rowspan="2" style="vertical-align: middle; text-align: left">A-B&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th rowspan="2" style="vertical-align: middle; text-align: left">PLU&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th rowspan="2" style="vertical-align: middle; text-align: left">DESKRIPSI&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: center">&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: center">T</th>
                <th style="vertical-align: middle; text-align: center">I</th>
                <th style="vertical-align: middle; text-align: center">R</th>
                <th rowspan="2" style="vertical-align: middle; text-align: right">KAPA<br>&nbsp;&nbsp;&nbsp;&nbsp;SITAS</th>
                <th rowspan="2" style="vertical-align: middle; text-align: right">&nbsp;&nbsp;&nbsp;&nbsp;PKMT</th>
                <th rowspan="2" style="vertical-align: middle; text-align: right">MAX<br>&nbsp;&nbsp;&nbsp;&nbsp;DISP</th>
                <th rowspan="2" style="vertical-align: middle; text-align: right">MAX<br>&nbsp;&nbsp;&nbsp;&nbsp;PLANO</th>
                <th rowspan="2" style="vertical-align: middle; text-align: right">STOK<br>&nbsp;&nbsp;&nbsp;&nbsp;GUDANG</th>
                <th rowspan="2" style="vertical-align: middle; text-align: right">&nbsp;&nbsp;&nbsp;&nbsp;H.P.P</th>
                <th rowspan="2" style="vertical-align: middle; text-align: right">&nbsp;&nbsp;&nbsp;&nbsp;NO.<br>ID</th>
            </tr>
            <tr>
                <th>&nbsp;&nbsp;SUB&nbsp;&nbsp;</th>
                <th>&nbsp;&nbsp;TIPE&nbsp;&nbsp;</th>
                <th>&nbsp;&nbsp;SLV&nbsp;&nbsp;</th>
                <th>&nbsp;&nbsp;(K-K)&nbsp;&nbsp;</th>
                <th>&nbsp;&nbsp;(D-B)&nbsp;&nbsp;</th>
                <th>&nbsp;&nbsp;(A-B)&nbsp;&nbsp;</th>
            </tr>
        </thead>
        <tbody style="text-align: center; vertical-align: middle">
        @for($i=0;$i<sizeof($data);$i++)
            <tr>
                @if($rak != $data[$i]->fmkrak || $subrak != $data[$i]->fmsrak || $tipe != $data[$i]->fmtipe || $shelving != $data[$i]->fmselv)
                    <td style="text-align: left">{{$data[$i]->fmkrak}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: center">{{$data[$i]->fmsrak}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: center">{{$data[$i]->fmtipe}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: center">{{$data[$i]->fmselv}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    @php
                        $rak = $data[$i]->fmkrak;
                        $subrak = $data[$i]->fmsrak;
                        $tipe = $data[$i]->fmtipe;
                        $shelving = $data[$i]->fmselv;
                    @endphp
                @else
                    <td style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                @endif
                <td style="text-align: left">{{$data[$i]->fmnour}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->fmdpbl}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->fmatba}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->prd_kodedivisi}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->prd_prdcd}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->desc2}}&nbsp;&nbsp;&nbsp;&nbsp;</td>

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

                <td style="text-align: center">{{$data[$i]->fmface}}</td>
                <td style="text-align: center">{{$data[$i]->fmtrdb}}</td>
                <td style="text-align: center">{{$data[$i]->fmtrab}}</td>

                <td style="text-align: right">{{$data[$i]->kapasitas}}</td>
                <td style="text-align: right">{{$data[$i]->pkm_pkmt}}</td>
                <td style="text-align: right">{{$data[$i]->fmtotl}}</td>
                <td style="text-align: right">{{$data[$i]->lks_maxplano}}</td>
                <td style="text-align: right">{{zeroDigit($data[$i]->st_saldoakhir)}}</td>
                <td style="text-align: right">{{twoDigit($data[$i]->prd_avgcost)}}</td>
                <td style="text-align: right">{{$data[$i]->fmnoid}}</td>
            </tr>
        @endfor
        </tbody>
    </table>
@endsection
