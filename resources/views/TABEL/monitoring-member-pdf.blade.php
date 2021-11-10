@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Tabel Monitoring Member
@endsection

@section('title')
    ** TABEL MONITORING MEMBER **
@endsection

@section('subtitle')
    Kode Monitoring : {{ $monitoring->kode }} - {{ $monitoring->nama }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th width="5%" class="tengah">NO</th>
            <th width="10%" class="left">KODE MEMBER</th>
            <th width="40%" class="left padding-left">NAMA</th>
            <th width="40%" class="left" colspan="2">OUTLET</th>
            <th width="5%" class="tengah center">PKP</th>
        </tr>
        </thead>
        <tbody>
        @php $no = 1; @endphp
        @foreach($data as $d)
            <tr>
                <td width="5%" class="center">{{ substr('0000'.$no++, -4) }}</td>
                <td width="10%" class="center">{{ $d->mem_kodemember }}</td>
                <td width="40%" class="left padding-left">{{ $d->cus_namamember }}</td>
                <td width="40%" class="left">{{ $d->cus_kodeoutlet }} - {{ $d->out_namaoutlet }}</td>
                <td width="5%" class="center">{{ $d->cus_flagpkp }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
