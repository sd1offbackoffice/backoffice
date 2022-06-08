@extends('html-template')

@section('table_font_size','9 px')

@section('page_title')
    LAPORAN TRANSAKSI PENUKARAN BARANG
@endsection

@section('title')
    LAPORAN TRANSAKSI PENUKARAN BARANG
@endsection

@section('subtitle')
Periode : {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr>
                <th class="tengah" rowspan="3">No.</th>
                <th class="tengah" colspan="3" rowspan="1">Barang Yang Ditukar</th>
                <th class="tengah" colspan="3" rowspan="1">Barang Pengganti</th>
                <th class="tengah" rowspan="3">No. Struk<br>Penukaran<br>Barang</th>
                <th class="tengah" rowspan="3">User ID<br>(Otorisasi)</th>
                <th class="tengah" rowspan="3">Alasan Penukaran</th>
            </tr>
            <tr>
                <th class="tengah center">PLU</th>
                <th class="tengah center">Deskripsi</th>
                <th class="tengah center">Qty.</th>
                <th class="tengah center">PLU</th>
                <th class="tengah center">Deskripsi</th>
                <th class="tengah center">Qty.</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1</td>

                <td>1356530</td>
                <td style="width: 5%;">asdasdsadasd</td>
                <td>130</td>

                <td>1356530</td>
                <td style="width: 5%;">asd</td>
                <td>200</td>
                
                <td>4359850</td>
                <td>DV6</td>
                <td>asdkljasdkljasdbkjfbvkjbvkjaksdhjh</td>
            </tr>
            <tr>
                <td>2</td>

                <td>1356530</td>
                <td style="width: 5%;">asdasdsadasd</td>
                <td>130</td>

                <td>1356530</td>
                <td style="width: 5%;">asdadsasdasdasdasdasdasdasdasdasdasdasd</td>
                <td>200</td>
                
                <td>4359850</td>
                <td>DV6</td>
                <td>asdkljasdkljasdbkjfbvkjbvkjaksdhjh</td>
            </tr>
        </tbody>
    </table>
@endsection
