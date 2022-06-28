@extends('html-template')

@section('paper_width','842pt')
@section('paper_height','595pt')

@section('table_font_size','7 px')

@section('body_line_height','1.0')

@section('page_title')
    Laporan Sales Harian Kasir / Actual - {{ $tanggal }}
@endsection

@section('title')
    ** LAPORAN SALES HARIAN KASIR / ACTUAL **
@endsection

@section('subtitle')
    Tanggal : {{ $tanggal }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah left">No</th>
            <th class="tengah left">Kassa</th>
            <th class="tengah right">Sld. Awal</th>
            <th class="tengah right">Penjualan</th>
            <th class="tengah right">Potongan</th>
            <th class="tengah right">Rf.Pot</th>
            <th class="tengah right">Debit_UKM</th>
            <th class="tengah right">Krt.Kredit</th>
            <th class="tengah right">Krt.Debit</th>
            <th class="tengah right">Voucher</th>
            <th class="tengah right">Kredit</th>
            <th class="tengah right">RfdTunai</th>
            <th class="tengah right">RfdKredit</th>
            <th class="tengah right">Distr_Fee</th>
            <th class="tengah right">i-Saku</th>
            <th class="tengah right">Tunai</th>
            <th class="tengah right">Pot</th>
            <th class="tengah right">Tunai_BCA</th>
            <th class="tengah right">Tunai Fisik</th>
            <th class="tengah right">Ambil</th>
            <th class="tengah right">Varian</th>
            <th class="tengah right">Aktual</th>
            <th class="tengah right">Struk</th>
            <th class="tengah right">e-Pulsa</th>
        </tr>
        </thead>
        <tbody>
        @php
            $awal = 0;
            $penj = 0;
            $cb = 0;
            $rcb = 0;
            $debukm = 0;
            $kkredit = 0;
            $kdebit = 0;
            $voucher = 0;
            $kredit = 0;
            $refundtunai = 0;
            $refundkredit = 0;
            $distfee = 0;
            $nilai_in = 0;
            $tunai = 0;
            $pot = 0;
            $tunaibca = 0;
            $fisik = 0;
            $ambil = 0;
            $var = 0;
            $actual = 0;
            $struk = 0;
            $titip = 0;
            $no = 0;
        @endphp
        @foreach($data as $d)
            @php
                $awal += $d->awal;
                $penj += $d->penj;
                $cb += $d->cb;
                $rcb += $d->rcb;
                $debukm += $d->debukm;
                $kkredit += $d->kkredit;
                $kdebit += $d->kdebit;
                $voucher += $d->voucher;
                $kredit += $d->kredit;
                $refundtunai += $d->refundtunai;
                $refundkredit += $d->refundkredit;
                $distfee += $d->distfee;
                $nilai_in += $d->nilai_in;
                $tunai += $d->tunai - $d->cb;
                $pot += $d->pot;
                $tunaibca += $d->tunaibca;
                $fisik += $d->fisik;
                $ambil += $d->ambil;
                $var += $d->var;
                $actual += $d->actual;
                $struk += $d->struk;
                $titip += $d->titip;
                $no++;
            @endphp


            <tr>
                <td class="left">{{ $no }}</td>
                <td class="left">{{ $d->kassa }}</td>
                <td class="right">{{ number_format($d->awal, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->penj, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->cb, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->rcb, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->debukm, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->kkredit, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->kdebit, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->voucher, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->kredit, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->refundtunai, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->refundkredit, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->distfee, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->nilai_in, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->tunai - $d->cb, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->pot, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->tunaibca, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->fisik, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->ambil, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->var, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->actual, 0, '.', ',') }}</td>
                <td class="right">{{ $d->struk }}</td>
                <td class="right">{{ number_format($d->titip, 0, '.', ',') }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td class="left" colspan="2">TOTAL : </td>
            <td class="right">{{ number_format($awal, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($penj, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($cb, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($rcb, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($debukm, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($kkredit, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($kdebit, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($voucher, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($kredit, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($refundtunai, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($refundkredit, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($distfee, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($nilai_in, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tunai, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($pot, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tunaibca, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($fisik, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($ambil, 0, '.', ',') }}</td>
            <td class="right">@if($var < 0) ({{ abs($var) }}) @else {{ $var }} @endif</td>
            <td class="right">{{ number_format($actual, 0, '.', ',') }}</td>
            <td class="right">{{ $struk }}</td>
            <td class="right">{{ number_format($titip, 0, '.', ',') }}</td>
        </tr>
        </tfoot>
    </table>
    <br>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah" rowspan="2"></th>
            <th class="right tengah" rowspan="2">PENJ KOTOR</th>
            <th class="right tengah" rowspan="2">PPN</th>
{{--            <th class="right tengah" rowspan="2">PPN DIBEBASKAN</th>--}}
{{--            <th class="right tengah" rowspan="2">PPN DTP</th>--}}
            <th class="right tengah" rowspan="2">PENJ BERSIH</th>
            <th class="right tengah" rowspan="2">H.P.P RATA2</th>
            <th colspan="2">----- MARGIN -----</th>
        </tr>
        <tr>
            <th class="right">Rp.</th>
            <th class="right">%</th>
        </tr>
        </thead>
        <tbody>
        @if(!$data)
            <tr>
                <td colspan="7">Data tidak ditemukan</td>
            </tr>
        @endif
        @foreach($sums as $s)
            <tr>
                <td class="left">{{ $s->keterangan }}</td>
                <td class="right">{{ number_format($s->nilai, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($s->tax, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($s->net, 0, '.', ',') }}</td>
{{--                <td class="right">asdf</td>--}}
{{--                <td class="right">asdf</td>--}}
                <td class="right">{{ number_format($s->hpp, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($s->margin, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($s->pmargin, 2, '.', ',') }}%</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot></tfoot>
    </table>
    <p>
        KETERANGAN :<br>
        Varian = Aktual Struk - ( Tunai Fisik + Tunai Transfer + Saldo Awal - Ambil Drawer )<br>
        Tunai Fisik = Tunai * + Deposit E-Pulsa - Refund Tunai - Tunai BCA<br>
        * Nilai Tunai BCA termasuk dengan Cash Out I-Saku<br>
        * Nilai Tunai di luar pembayaran dengan Transfer Dana
    </p>
@endsection
