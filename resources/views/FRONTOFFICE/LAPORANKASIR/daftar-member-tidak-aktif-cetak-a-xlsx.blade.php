<?php
$tempoutlet = '';
$temparea = '';
$st_outlet = 0;
$st_area = 0;
$total = 0;
?>
<table class="table table-bordered table-responsive" style="border-collapse: collapse">
    <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
    <tr>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="right ">KODE</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="left">NO. KARTU</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="left">NAMA MEMBER</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="left">ALAMAT</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="right ">PKP</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="left">NPWP</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="right ">KREDIT LIMIT</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="left">TERM</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="left">TGL HABIS</th>
    </tr>
    </thead>
    <tbody style="border-bottom: 2px solid black;">
    @for($i = 0 ; $i < sizeof($data); $i++)
        @if($tempoutlet != $data[$i]->cus_kodeoutlet)
            <tr>
                <td align="left"><b>*** OUTLET </b></td>
                <td align="left"><b>: {{$data[$i]->cus_kodeoutlet}} - {{$data[$i]->out_namaoutlet}}</b></td>
            </tr>
            @php
                $tempoutlet=$data[$i]->cus_kodeoutlet;
            @endphp
        @endif
        @if($temparea != $data[$i]->cus_kodearea )
            <tr>
                <td align="left"><b>* AREA</b></td>
                <td align="left"><b>: {{$data[$i]->cus_kodearea}}</b></td>
            </tr>
            @php
                $temparea=$data[$i]->cus_kodearea;
            @endphp
        @endif
        <tr>
            <td align="right ">{{ $data[$i]->cus_kodemember }}</td>
            <td align="left">{{ $data[$i]->cus_nomorkartu }}</td>
            <td align="left">{{ $data[$i]->cus_namamember }}</td>
            <td align="left">{{ $data[$i]->cus_alamatmember1 }}</td>
            <td align="right ">{{ $data[$i]->cus_flagpkp }}</td>
            <td align="left">{{ $data[$i]->cus_npwp }}</td>
            <td align="right ">{{ $data[$i]->cus_creditlimit }}</td>
            <td align="left">{{ $data[$i]->cus_top }}</td>
            <td align="left">{{ date('d/m/Y',strtotime(substr($data[$i]->cus_tgl_registrasi,0,10))) }}</td>
        </tr>
        <tr>
            <td colspan="3" align="left"></td>
            <td align="left">{{ $data[$i]->cus_alamatmember2 }}</td>
            <td align="left">{{ $data[$i]->cus_tlpmember }}</td>
        </tr>
        @php
            $st_outlet++;
            $st_area++;
            $total++;
        @endphp
        @if(isset($data[$i+1]) && ($temparea != $data[$i+1]->cus_kodearea) || !(isset($data[$i+1])) )
            <tr>
                <th align="left">* SUB TOTAL AREA {{ $data[$i]->cus_kodearea }}</th>
                <th align="left">: {{ number_format($st_area, 0, '.', ',') }} ANGGOTA</th>
                <th colspan="7"></th>
            </tr>
            @php
                $st_area = 0;
            @endphp
        @endif
        @if( isset($data[$i+1]) && ($tempoutlet != $data[$i+1]->cus_kodeoutlet) || !(isset($data[$i+1])) )
            <tr>
                <th align="left">*** SUB TOTAL OUTLET {{ $data[$i]->cus_kodeoutlet }}</th>
                <th align="left">: {{ number_format($st_outlet, 0, '.', ',') }} ANGGOTA</th>
                <th colspan="7"></th>
            </tr>
    @php
        $st_outlet = 0;
    @endphp
    @endif
    @endfor
    </tbody>
    <tfoot>
        <tr>
            <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="left"> TOTAL</th>
            <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="left">: {{ number_format($total, 0, '.', ',') }} ANGGOTA</th>
            <th style="border-top: 1px solid black; border-bottom: 1px solid black;" colspan="7"></th>
        </tr>
    </tfoot>
</table>
