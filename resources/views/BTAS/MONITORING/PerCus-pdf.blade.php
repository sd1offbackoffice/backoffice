<html>
<head>
    <title>LAPORAN-BARANG TITIPAN (PER CUSTOMER)</title>
</head>
<style>
    /**
        Set the margins of the page to 0, so the footer and the header
        can be of the full height and width !
     **/
    @page {
        margin: 25px 25px;
    }

    /** Define now the real margins of every page in the PDF **/
    body {
        margin-top: 80px;
        margin-bottom: 10px;
        font-size: 9px;
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
    table{
        border: 1px;
    }
    .page-break {
        page-break-after: always;
    }
    .page-numbers:after { content: counter(page); }
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
    <div style="margin-top: -20px; line-height: 0.1px !important;">
        <p>{{$datas[0]->prs_namaperusahaan}}</p>
        <p>{{$datas[0]->prs_namacabang}}</p>
    </div>
    <div style="margin-top: -500px; float: right; line-height: 0.1px !important;">
        <p>{{$datas[0]->info}}</p>
    </div>
    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">DAFTAR BARANG TITIPAN ( POSISI PER CUSTOMER )</h2>
    </div>
</header>


    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
            <tr style="text-align: center; vertical-align: center">
                <th style="width: 40px; border-right: 1px solid black; border-bottom: 1px solid black">No.</th>
                <th colspan="2" style="border-right: 1px solid black; border-bottom: 1px solid black; text-align: left">Customer</th>
                <th colspan="2" style="border-right: 1px solid black; border-bottom: 1px solid black; text-align: left">Struk</th>
                <th style="width: 100px;border-right: 1px solid black;border-bottom: 1px solid black">Penitipan</th>
                <th style="width: 100px;border-bottom: 1px solid black">Status</th>
            </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black; text-align: center; vertical-align: center">
        <?php
            $temp = '';
            $numbering = 1;
        ?>
            @for($i=0;$i<sizeof($datas);$i++)
                @if($temp != $datas[$i]->sjh_kodecustomer)
                    <tr>
                        <td style="border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$numbering}}</td>
                        <td style="width: 220px; text-align: left; border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$datas[$i]->cus_namamember}}</td>
                        <td style="width: 50px; text-align: left; border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$datas[$i]->sjh_kodecustomer}}</td>
                        <td style="width: 120px; text-align: left; border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$datas[$i]->sjh_tglstruk}}</td>
                        <td style="width: 80px; text-align: left; border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$datas[$i]->struk}}</td>
                        <td style="border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$datas[$i]->sjh_tglpenitipan}}</td>
                        <td style="border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$datas[$i]->status}}</td>
                    </tr>
                    <?php
                        $temp = $datas[$i]->sjh_kodecustomer;
                        $numbering++;
                    ?>
                @endif
                <tr>
                    <td></td>
                    <td style="width: 220px; text-align: left"> </td>
                    <td style="width: 50px;">{{$datas[$i]->trjd_seqno}}</td>
                    <td style="width: 120px; text-align: left">{{$datas[$i]->prd_deskripsipendek}}</td>
                    <td style="width: 80px; text-align: left">{{$datas[$i]->unit}}</td>
                    <td style="text-align: left">{{$datas[$i]->trjd_quantity}}</td>
                    <td style="text-align: left">{{$sisa[$i]}}</td>
                </tr>
            @endfor
        </tbody>
    </table>
    <hr>
    <p style="float: left; line-height: 0.1px !important;">{{$p_custinfo}}</p>
    <p style="float: right; margin-top: 0px; line-height: 0.1px !important;">-- akhir data</p>

</body>

</html>
