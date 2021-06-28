<html>
<head>
    <title>LAPORAN</title>
</head>
<style>
    /**
        Set the margins of the page to 0, so the footer and the header
        can be of the full height and width !
     **/
    @page {
        margin: 25px 10px;
        size: 900pt 595pt;

    }

    table {
        width: 100%;
    }

    /** Define now the real margins of every page in the PDF **/
    body {
        margin-top: 70px;
        margin-bottom: 10px;
        font-size: 8px;
        /*font-size: 9px;*/
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 400;
        line-height: 1.8;
        /*font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/
    }

    /** Define the header rules **/
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2cm;
    }

    .page-numbers:after {
        content: counter(page);
    }

    .page-break {
        page-break-after: always;
    }
</style>


<body>
<!-- Define header and footer blocks before your content -->
<?php
$i = 1;
$datetime = new DateTime();
$timezone = new DateTimeZone('Asia/Jakarta');
$datetime->setTimezone($timezone);
?>


<header>
    <div style="float:left; margin-top: -20px; line-height: 5px !important;">
        <p>{{$perusahaan->prs_namaperusahaan}}</p>
        <p>{{$perusahaan->prs_namacabang}}</p>
        <p>{{$perusahaan->prs_namawilayah}}</p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 5px !important;">
        <p>{{ date("d/m/y  H:i:s") }}</p>
        <p>REKONSILIASI SALDO AWAL VS SALDO AKHIR</p>
    </div>
    <div style="line-height: 0.1 !important; text-align: center !important;">
        <h2 style="">{{ $title }} </h2>
        <p style="font-size: 10px !important;">TANGGAL : {{$tgl1 }}
            s/d {{$tgl2 }}</p>
    </div>
</header>

<main>
    @php
        $tempdiv = '';
        $tempdep = '';
        $tempkat = '';

        $st_begbal_div='';
        $st_akhir_div ='';
        $st_begbal_dep='';
        $st_akhir_dep ='';
        $st_begbal_kat='';
        $st_akhir_kat ='';

        $total_begbal = '';
        $total_akhir = '';
    @endphp
    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th>PLU</th>
            <th colspan="3">DESKRIPSI</th>
            <th>DIV</th>
            <th>DEPT</th>
            <th>KATB</th>
            <th>SALDO AWAL</th>
            <th>SALDO AKHIR</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($datas);$i++)
            @if($tempdep != $datas[$i]->lpp_kodedepartemen)
                <tr>
                    <td class="left"><b>DIVISI</b></td>
                    <td class="left"><b>{{$datas[$i]->div_namadivisi}}</b></td>
                </tr>
                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left"><b>{{$datas[$i]->dep_namadepartement}}</b></td>
                </tr>
                <tr>
                    <td class="left"><b>KATEGORI BARANG :</b></td>
                    <td class="left"><b>{{$datas[$i]->kat_namakategori}}</b></td>
                </tr>
            @endif;
            <tr>
                <td align="left">{{ $datas[$i]->prdcd }}</td>
                <td colspan="3" align="left">{{ $datas[$i]->prd_deskripsipanjang }}</td>
                <td align="left">{{ $datas[$i]->div }}</td>
                <td align="left">{{ $datas[$i]->dept }}</td>
                <td align="left">{{ $datas[$i]->kat }}</td>
                <td align="left">{{ $datas[$i]->begbal_rp }}</td>
                <td align="left">{{ $datas[$i]->akhir_rp }}</td>
            </tr>
            @php
                $st_begbal_div     += $datas[$i]->begbal_rp;
                $st_akhir_div      += $datas[$i]->akhir_rp;

                $st_begbal_dep     += $datas[$i]->begbal_rp;
                $st_akhir_dep      += $datas[$i]->akhir_rp;

                $st_begbal_kat     += $datas[$i]->begbal_rp;
                $st_akhir_kat      += $datas[$i]->akhir_rp;

                $tempdiv = $datas[$i]->div_kodedivisi;
                $tempdep = $datas[$i]->dep_kodedep;
                $tempkat = $datas[$i]->kat_kodekat;

            @endphp
            @if( isset($datas[$i+1]->kat_kodekat) && $tempkat != $datas[$i+1]->kat_kodekat || !(isset($datas[$i+1]->kat_kodekat)) )
                <tr>
                    <td class="right">TOTAL KATEGORI</td>
                    <td class="left">{{ $datas[$i]->kat_kodekat }}</td>
                    <td class="left">{{ $st_begbal_kat }}</td>
                    <td class="left">{{ $st_akhir_kat }}</td>
                </tr>
                @php
                    $st_begbal_kat     =0;
                    $st_akhir_kat      =0;
                @endphp
            @endif
            @if( isset($datas[$i+1]->dept_kodedept) && $tempdept != $datas[$i+1]->dept_kodedept || !(isset($datas[$i+1]->dept_kodedept)) )
                <tr>
                    <td class="right">TOTAL DEPARTEMENT</td>
                    <td class="left">{{ $datas[$i]->dept_kodedept }}</td>
                    <td class="left">{{ $st_begbal_dept }}</td>
                    <td class="left">{{ $st_akhir_dept }}</td>
                </tr>
                @php
                    $st_begbal_dept     =0;
                    $st_akhir_dept      =0;
                @endphp
            @endif
            @if( isset($datas[$i+1]->div_kodediv) && $tempdiv != $datas[$i+1]->div_kodediv || !(isset($datas[$i+1]->div_kodediv)) )
                <tr>
                    <td class="right">TOTAL DIVISI</td>
                    <td class="left">{{ $datas[$i]->div_kodediv }}</td>
                    <td class="left">{{ $st_begbal_div }}</td>
                    <td class="left">{{ $st_akhir_div }}</td>
                </tr>
                @php
                    $st_begbal_div     =0;
                    $st_akhir_div      =0;
                @endphp
            @endif

        @endfor


        </tbody>
        <tfoot style="border-bottom: 1px solid black;border-top: 1px solid black;">
        <tr>
            <td class="right" colspan="5"><strong>TOTAL SEMUA</strong></td>
            <td class="right">{{ $total_begbal }}</td>
            <td class="right">{{ $total_akhir }}</td>
        </tr>
        </tfoot>
    </table>

    <p style="text-align: right"> ** Akhir Dari Laporan ** </p>

</main>
</body>
</html>
