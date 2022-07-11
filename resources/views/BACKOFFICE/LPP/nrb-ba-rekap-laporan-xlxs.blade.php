@php
    $total_dpp     = 0;
    $total_3persen = 0;
    $total_ppn     = 0;
    $total_nilai   = 0;
@endphp

<table class="table table-bordered table-responsive">
    <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
    <tr style="text-align: center;">
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="left">No.</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" colspan="2" align="center">----NRB Proforma----</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="left">TOKO IDM</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" colspan="2" align="center">----Dok Retur----</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right">DPP</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right">3%</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right">PPN</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right">Nilai</th>
    </tr>
    <tr style="text-align: center;">
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left">No.</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left">Tgl</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left">No.</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left">Tgl</th>
    </tr>
    </thead>
    <tbody>
    @for($i=0;$i<count($data);$i++)
        <tr>
            <td align="left">{{ $data[$i]->nomor }}</td>
            <td align="left">{{ $data[$i]->bth_nonrb }}</td>
            <td align="left">{{ date('d/m/Y',strtotime(substr($data[$i]->bth_tglnrb,0,10)))  }}</td>
            <td align="left">{{ $data[$i]->tko_kodeomi}}</td>
            <td align="left">{{ $data[$i]->bth_nodoc    }}</td>
            <td align="left">{{ date('d/m/Y',strtotime(substr($data[$i]->bth_tgldoc,0,10)))   }}</td>
            <td align="right">{{ number_format($data[$i]->dpp      ,2)   }}</td>
            <td align="right">{{ number_format($data[$i]->tigapersen,2)  }}</td>
            <td align="right">{{ number_format($data[$i]->btd_ppn  ,2)   }}</td>
            <td align="right">{{ number_format($data[$i]->nilai    ,2)}}</td>
        </tr>
        @php
            $total_dpp        += $data[$i]->dpp;
            $total_3persen    += $data[$i]->tigapersen;
            $total_ppn        += $data[$i]->btd_ppn;
            $total_nilai      += $data[$i]->nilai;
        @endphp
    @endfor
    </tbody>
    <tfoot style="border-top:solid 1px ">
    <tr>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right" colspan="6"><strong>TOTAL NILAI BA</strong></th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">{{ number_format($total_dpp    ,2) }}</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">{{ number_format($total_3persen,2) }}</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">{{ number_format($total_ppn    ,2) }}</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">{{ number_format($total_nilai  ,2) }}</th>
    </tr>
    </tfoot>
</table>
