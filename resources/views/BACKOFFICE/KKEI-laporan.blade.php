<!DOCTYPE html>
<html>
<head>
    <title>Laporan</title>
</head>
<body>
<!-- <a href="/getPdf"><button>Download PDF</button></a> -->
<header>
    <div style="float:left;">
        <table>
            <tr>
                <td>{{ $perusahaan->prs_namaperusahaan }}</td>
            </tr>
            <tr>
                <td>{{ $perusahaan->prs_namacabang }}</td>
            </tr>
            <tr>
                <td>{{ $perusahaan->prs_namaregional }}</td>
            </tr>
        </table>
        <?php
        $date=date_create('04/03/2020');
        ?>
    </div>
    <?php
    $datetime = new DateTime();
    $timezone = new DateTimeZone('Asia/Jakarta');
    $datetime->setTimezone($timezone);
    ?>
    <div style="float:right;clear:right;">
        <table>
            <tr>
                <td>TGL : {{ date("d-m-Y") }}</td>
                <td></td>
                <td>JAM : {{ $datetime->format('H:i:s') }}</td>
            </tr>
            <tr>
                <td>PRG : IGR_BO_KKEKEBTOKO</td>
                <td></td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <br>
    <div class="judul">
        <h2>** KERTAS KERJA ESTIMASI KEBUTUHAN TOKO IGR **<br>Periode : 03 Maret 2020</h2>
    </div>
</header>
<table class="table">
    <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
    <tr>
        <td colspan="5"></td>
        <td colspan="4">--- Produk ---</td>
        <td></td>
        <td colspan="4">--- Kemasan (Karton) ---</td>
        <td colspan="3"></td>
        <td colspan="2">Sales 3 Bulan</td>
        <td colspan="5"></td>
        <td colspan="5">Breakdown PB</td>
        <td colspan="10"></td>
    </tr>
    <tr>
        <td colspan="5"></td>
        <td>Berat</td>
        <td colspan="4">Dimensi Produk</td>
        <td>Berat</td>
        <td colspan="4">Dimensi Ctn Luar</td>
        <td>Harga</td>
        <td></td>
        <td colspan="3">Terakhir</td>
        <td colspan="2">Avg Sales</td>
        <td>Saldo</td>
        <td>Estimasi</td>
        <td colspan="5">Minggu ke-</td>
        <td colspan="2">Buffer</td>
        <td>Saldo</td>
        <td colspan="2">Outstanding PO</td>
        <td colspan="5">Tanggal Kirim</td>
    </tr>
    <tr>
        <td>No.</td>
        <td>PL</td>
        <td>Nama Barang</td>
        <td>Satuan</td>
        <td>Isi</td>
        <td>(Kg)</td>
        <td>P</td>
        <td>L</td>
        <td>T</td>
        <td>Kubikasi</td>
        <td>(Kg)</td>
        <td>P</td>
        <td>L</td>
        <td>T</td>
        <td>Kubikasi</td>
        <td>Beli</td>
        <td>Discount</td>
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>Bulan</td>
        <td>Hari</td>
        <td>Awal</td>
        <td>Bulan</td>
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>LT</td>
        <td>SS</td>
        <td>Akhir</td>
        <td>Total</td>
        <td>Qty</td>
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
    </tr>
    </thead>
    <tbody>
    @php
        $i = 0;
        $supplier = 'xxx';
    @endphp
    @foreach($data as $k)
        @php $i++; @endphp
        @php
            if($supplier != $k->kke_kdsup){
                $supplier = $k->kke_kdsup;
        @endphp
        <tr>
            <td colspan="39"><strong>Supplier : {{ $k->kke_kdsup }}  -  {{ $k->kke_nmsup }}</strong></td>
        </tr>
        @php
            }
        @endphp
        <tr style="text-align: right">
            <td class="center">{{ $i }}</td>
            <td class="center">{{ $k->kke_prdcd }}</td>
            <td style="text-align: left">{{ substr($k->kke_deskripsi,0,21) }}</td>
            <td class="center">{{ $k->kke_unit }}</td>
            <td>{{ $k->kke_frac }}</td>
            <td>{{ number_format((float)$k->kke_beratproduk, 2, '.', '') }}</td>
            <td>{{ $k->kke_panjangprod }}</td>
            <td>{{ $k->kke_lebarprod }}</td>
            <td>{{ $k->kke_tinggiprod }}</td>
            <td>{{ number_format((float)$k->kke_kubikasiprod, 2, '.', '') }}</td>
            <td>{{ $k->kke_beratkmsn }}</td>
            <td>{{ $k->kke_panjangkmsn }}</td>
            <td>{{ $k->kke_lebarkmsn }}</td>
            <td>{{ $k->kke_tinggikmsn }}</td>
            <td>{{ number_format((float)$k->kke_kubikasikmsn, 2, '.', '') }}</td>
            <td>{{ $k->kke_hargabeli }}</td>
            <td>{{ $k->kke_discount }}</td>
            <td>{{ $k->kke_sales01 }}</td>
            <td>{{ $k->kke_sales02 }}</td>
            <td>{{ $k->kke_sales03 }}</td>
            <td>{{ number_format((float)$k->kke_avgbln, 2, '.', '') }}</td>
            <td>{{ number_format((float)$k->kke_avghari, 2, '.', '') }}</td>
            <td>{{ $k->kke_saldoawal }}</td>
            <td>{{ $k->kke_estimasi }}</td>
            <td>{{ $k->kke_breakpb01 }}</td>
            <td>{{ $k->kke_breakpb02 }}</td>
            <td>{{ $k->kke_breakpb03 }}</td>
            <td>{{ $k->kke_breakpb04 }}</td>
            <td>{{ $k->kke_breakpb05 }}</td>
            <td>{{ $k->kke_bufferlt }}</td>
            <td>{{ $k->kke_bufferss }}</td>
            <td>{{ $k->kke_saldoakhir }}</td>
            <td>{{ $k->kke_outpototal }}</td>
            <td>{{ $k->kke_outpoqty }}</td>
            <td>{{ substr($k->kke_tglkirim01,0,10) }}</td>
            <td>{{ substr($k->kke_tglkirim02,0,10) }}</td>
            <td>{{ substr($k->kke_tglkirim03,0,10) }}</td>
            <td>{{ substr($k->kke_tglkirim04,0,10) }}</td>
            <td>{{ substr($k->kke_tglkirim05,0,10) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr style="text-align: right">
        <td colspan="23"></td>
        <td>Total</td>
        <td>{{ $data[0]->kke_kubik1 }}</td>
        <td>{{ $data[0]->kke_kubik2 }}</td>
        <td>{{ $data[0]->kke_kubik3 }}</td>
        <td>{{ $data[0]->kke_kubik4 }}</td>
        <td>{{ $data[0]->kke_kubik5 }}</td>
        <td colspan="10"></td>
    </tr>
    </tfoot>
</table>
<hr>
<strong>Kebutuhan Kontainer :</strong><br>
20 Feet<br>
<hr>
<div style="float:left">
    NB :<br>
    1 Kubikase = 30 m3, 1 Tonase = 22<br>
    Toleransi Kubikase & Tonase adalah 5%
</div>

<table style="float:right" class="table-ttd table-borderless">
    <tr>
        <td>Disetujui</td>
        <td>Dibuat</td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td class="ttd">Store Mgr</td>
        <td class="ttd">Store Jr. Mgr</td>
    </tr>
</table>

<br>
</body>
<style>
    @page {
        margin: 25px 25px;
        /*size: 1071pt 792pt;*/
    }

    header {
        position: fixed;
        top: -20px;
        left: 0px;
        right: 0px;
        bottom: 0px;
        margin: none;
    }
    body {
        font-size: 10px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        font-weight: 400;
        line-height: 1.5;
        margin-top: 70px;
        margin-bottom: 0px;
    }

    table{
        border-collapse: collapse;
    }
    tbody {
        display: table-row-group;
        vertical-align: middle;
        border-color: inherit;
    }
    tr {
        display: table-row;
        vertical-align: inherit;
        border-color: inherit;
    }
    td {
        display: table-cell;
    }
    thead{
        text-align: center;
    }
    .table{
        width: 100%;
        white-space: nowrap;
        color: #212529;
        /*padding-top: 20px;*/
        margin-top: 25px;
    }
    .table-ttd{
        width: 15%;
    }

    .table tbody td {
        vertical-align: top;
        /*border-top: 1px solid #dee2e6;*/
        padding: 0.20rem 0;
        width: auto;
    }

    .table th{
        vertical-align: top;
        padding: 0.20rem 0;
    }

    .judul, .table-borderless{
        text-align: center;
    }

    .table-borderless th, .table-borderless td {
        border: 0;
        padding: 0.50rem;
    }

    .center{
        text-align: center;
    }

</style>
</html>
