<table class="table table-bordered table-responsive" style="border-collapse: collapse">
    <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
    <tr>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="center" rowspan="3">PLU</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="right" rowspan="3">Qty.<br>Min Disp</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="right" rowspan="3">Qty.<br>Min Ord</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="right" rowspan="3">Avg Sales<br>3 bulan</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="center" colspan="9">Data 3 bulan terakhir</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="right" rowspan="3">PKM</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="center" rowspan="3">Kode<br>Supplier</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="right" rowspan="3">N</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="center" rowspan="3">Periode<br>proses</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="center" rowspan="3">Tgl edit PKM</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="center" colspan="3">Status Storage</th>
    </tr>
    <tr>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="center" colspan="3">Bulan ke-1</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="center" colspan="3">Bulan ke-2</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="center" colspan="3">Bulan ke-3</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="center" rowspan="2">Sebelum<br>proses<br>PKM</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="center" colspan="2">Setelah proses PKM</th>
    </tr>
    <tr>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="center">Bulan</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="right">Sales<br>(qty)</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="right">Hari</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="center">Bulan</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="right">Sales<br>(qty)</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="right">Hari</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="center">Bulan</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="right">Sales<br>(qty)</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="right">Hari</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="center">Usulan<br>(by program)</th>
        <th style="border-top: 1px solid black; border-bottom: 1px solid black;" align="center">Adjust<br>(by user)</th>
    </tr>
    </thead>
    <tbody style="border-bottom: 2px solid black;">
    @foreach($datas as $d)
        <tr>
            <td align="center">{{ $d->pkm_prdcd }}</td>
            <td align="right">{{ number_format($d->pkm_mindisplay) }}</td>
            <td align="right">{{ number_format($d->pkm_minorder) }}</td>
            <td align="right">{{ number_format($d->pkm_qtyaverage,2) }}</td>
            <td align="center">{{ $d->pkm_periode1 }}</td>
            <td align="right">{{ number_format($d->pkm_qty1) }}</td>
            <td align="right">{{ $d->pkm_hari1 }}</td>
            <td align="center">{{ $d->pkm_periode2 }}</td>
            <td align="right">{{ number_format($d->pkm_qty2) }}</td>
            <td align="right">{{ $d->pkm_hari2 }}</td>
            <td align="center">{{ $d->pkm_periode3 }}</td>
            <td align="right">{{ number_format($d->pkm_qty3) }}</td>
            <td align="right">{{ $d->pkm_hari3 }}</td>
            <td align="right">{{ number_format($d->pkm_pkmt) }}</td>
            <td align="center">{{ $d->pkm_kodesupplier }}</td>
            <td align="right">{{ $d->pkm_koefisien }}</td>
            <td align="center">{{ $d->pkm_periodeproses }}</td>
            <td align="center">{{ $d->pkm_edit }}</td>
            <td align="center">{{ $d->cp_laststatus }}</td>
            <td align="center">{{ $d->cp_status }}</td>
            <td align="center">{{ $d->cp_adjstatus }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    </tfoot>
</table>
