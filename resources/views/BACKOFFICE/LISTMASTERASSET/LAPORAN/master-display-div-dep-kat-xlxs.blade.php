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

<table class="table table-bordered table-responsive" style="border-collapse: collapse">
    <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
    <tr>
        <th style="border-bottom: 1px solid black;border-top: 1px solid black;font-weight:bold; vertical-align: middle; text-align: left">PLU&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th style="border-bottom: 1px solid black;border-top: 1px solid black;font-weight:bold; vertical-align: middle; text-align: left">DESKRIPSI&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th style="border-bottom: 1px solid black;border-top: 1px solid black;font-weight:bold; vertical-align: middle; text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th style="border-bottom: 1px solid black;border-top: 1px solid black;font-weight:bold; vertical-align: middle; text-align: left">SATUAN&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th style="border-bottom: 1px solid black;border-top: 1px solid black;font-weight:bold; vertical-align: middle; text-align: left">FACING&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th style="border-bottom: 1px solid black;border-top: 1px solid black;font-weight:bold; vertical-align: middle; text-align: left">RAK&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th style="border-bottom: 1px solid black;border-top: 1px solid black;font-weight:bold; vertical-align: middle; text-align: left">SUB RAK&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th style="border-bottom: 1px solid black;border-top: 1px solid black;font-weight:bold; vertical-align: middle; text-align: left">SLV RAK&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th style="border-bottom: 1px solid black;border-top: 1px solid black;font-weight:bold; vertical-align: middle; text-align: left">BAR&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th style="border-bottom: 1px solid black;border-top: 1px solid black;font-weight:bold; vertical-align: middle; text-align: left">NO.ID&nbsp;&nbsp;&nbsp;&nbsp;</th>
    </tr>
    </thead>
    <tbody style="text-align: center; vertical-align: middle">
    @for($i=0;$i<sizeof($data);$i++)
        @if($divisi != $data[$i]->div)
            <tr>
                <td colspan="10" style="text-align: left; font-weight: bold">DIVISI : {{$data[$i]->div}}</td>
            </tr>
            @php
                $divisi = $data[$i]->div;
            @endphp
        @endif
        @if($departemen != $data[$i]->dep)
            <tr>
                <td colspan="10" style="text-align: left; font-weight: bold">DEPARTEMEN : {{$data[$i]->dep}}</td>
            </tr>
            @php
                $departemen = $data[$i]->dep;
            @endphp
        @endif
        @if($kategori != $data[$i]->kat)
            <tr>
                <td colspan="10" style="text-align: left; font-weight: bold">KATEGORI : {{$data[$i]->kat}}</td>
            </tr>
            @php
                $kategori = $data[$i]->kat;
            @endphp
        @endif
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

