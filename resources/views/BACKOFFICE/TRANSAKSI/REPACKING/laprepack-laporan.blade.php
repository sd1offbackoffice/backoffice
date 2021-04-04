<html>
<head>
    <title>LAPORAN-REPACKING</title>
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
        margin-top: 100px;
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
    <div style="margin-top: -40px; margin-left: 544px; line-height: 0.1px !important;">
        <span>TGL : &nbsp;&nbsp;&nbsp;&nbsp; {{$today}}</span><br>
    </div>
    <div style="margin-top: 13px; margin-left: 544px; line-height: 0.1px !important;">
        <span>JAM : &nbsp;&nbsp;&nbsp;&nbsp; {{$time}}</span>
    </div>
    <div style="margin-top: 0px; margin-left: 652px; line-height: 0.1px !important;">
        <span>PRG : &nbsp;&nbsp;&nbsp;&nbsp; {{$p_prog}}</span>
    </div>
    <div style="margin-top: 20px; line-height: 0.1 !important;">
        <h2 style="text-align: center">** LAPORAN REPACKING **</h2>
        <h4 style="text-align: center">TANGGAL : {{$p_tgl1}} S/D {{$p_tgl2}}</h4>
    </div>
</header>


    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
            <tr style="text-align: center; vertical-align: center">
                <th rowspan="2" style="width: 20px; border-right: 1px solid black">PLU</th>
                <th colspan="2" style="width: 115px; border-right: 1px solid black; border-bottom: 1px solid black">REPACKING</th>
                <th colspan="3" style="border-right: 1px solid black; border-bottom: 1px solid black">PREPACK</th>
                <th colspan="3" style="border-bottom: 1px solid black">REPACK</th>
            </tr>
            <tr style="text-align: center; vertical-align: center">
                <th style="border-right: 1px solid black">NOMOR</th>
                <th style="border-right: 1px solid black">TANGGAL</th>
                <th style="width: 50px; border-right: 1px solid black">PLU</th>
                <th style="width: 195px; border-right: 1px solid black">DESKRIPSI</th>
                <th style="width: 50px; border-right: 1px solid black">GROSS</th>
                <th style="width: 50px; border-right: 1px solid black">PLU</th>
                <th style="width: 195px; border-right: 1px solid black">DESKRIPSI</th>
                <th style="width: 50px">GROSS</th>
            </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black">
        <?php
        $counter = $datas[$i]->msth_nodoc;
        $reset = true;
        $number = 1;
        $subTotalP = 0;
        $subTotalR = 0;
        $totalP = 0;
        $totalR = 0;
        ?>
        @for($i = 0; $i<sizeof($datas); $i++)
            <?php
                if($counter != $datas[$i]->msth_nodoc){
                    ?>
                    <tr style="text-align: center; vertical-align: center">
                        <td colspan="4" style="border-bottom: 1px solid black; text-align: left !IMPORTANT;">SUB-TOTAL TANGGAL : {{$datas[$i-1]->tgldoc}}</td>
                        <td style="border-bottom: 1px solid black;"></td>
                        <td style="border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">{{$subTotalP}}</td>
                        <td style="border-bottom: 1px solid black;"></td>
                        <td style="border-bottom: 1px solid black;"></td>
                        <td style="border-left: 1px solid black; border-bottom: 1px solid black;">{{$subTotalR}}</td>
                    </tr>
                    <?php
                    $counter = $datas[$i]->msth_nodoc;
                    $reset = true;
                    $number = 1;
                    $totalP = $totalP + $subTotalP;
                    $totalR = $totalR + $subTotalR;
                    $subTotalP = 0;
                    $subTotalR = 0;
                }
            ?>
            @if($reset)
                <tr style="text-align: center; vertical-align: center">
                    <td style="border-bottom: 1px solid black; background-color: gray"></td>
                    <td style="border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black">{{$datas[$i]->msth_nodoc}}</td>
                    <td style="border-right: 1px solid black; border-bottom: 1px solid black">{{$datas[$i]->tgldoc}}</td>
                    <td style="border-bottom: 1px solid black; background-color: gray"></td>
                    <td style="border-bottom: 1px solid black; background-color: gray"></td>
                    <td style="border-right: 1px solid black; border-bottom: 1px solid black; background-color: gray"></td>
                    <td style="border-bottom: 1px solid black; background-color: gray"></td>
                    <td style="border-bottom: 1px solid black; background-color: gray"></td>
                    <td style="border-bottom: 1px solid black; background-color: gray"></td>
                </tr>
                <tr style="text-align: center; vertical-align: center">
                    <td style="border-right: 1px solid black; border-bottom: 1px solid black">{{$number}}</td>
                    <td style="border-bottom: 1px solid black"></td>
                    <td style="border-bottom: 1px solid black"></td>
                    <td style="border-left: 1px solid black; border-bottom: 1px solid black">{{$datas[$i]->prd_p}}</td>
                    <td style="border-left: 1px solid black; border-bottom: 1px solid black">{{$datas[$i]->desk_p}}</td>
                    <td style="border-left: 1px solid black; border-bottom: 1px solid black">{{$datas[$i]->gross_p}}</td>
                    <td style="border-left: 1px solid black; border-bottom: 1px solid black">{{$datas[$i]->prd_r}}</td>
                    <td style="border-left: 1px solid black; border-bottom: 1px solid black">{{$datas[$i]->desk_r}}</td>
                    <td style="border-left: 1px solid black; border-bottom: 1px solid black">{{$datas[$i]->gross_r}}</td>
                </tr>
                <?php
                    $reset = false;
                    $number++;
                    $subTotalP = $subTotalP + $datas[$i]->gross_p;
                    $subTotalR = $subTotalR + $datas[$i]->gross_r;
                ?>
            @else
                <tr style="text-align: center; vertical-align: center">
                    <td style="border-right: 1px solid black; border-bottom: 1px solid black">{{$number}}</td>
                    <td style="border-bottom: 1px solid black"></td>
                    <td style="border-bottom: 1px solid black"></td>
                    <td style="border-left: 1px solid black; border-bottom: 1px solid black">{{$datas[$i]->prd_p}}</td>
                    <td style="border-left: 1px solid black; border-bottom: 1px solid black">{{$datas[$i]->desk_p}}</td>
                    <td style="border-left: 1px solid black; border-bottom: 1px solid black">{{$datas[$i]->gross_p}}</td>
                    <td style="border-left: 1px solid black; border-bottom: 1px solid black">{{$datas[$i]->prd_r}}</td>
                    <td style="border-left: 1px solid black; border-bottom: 1px solid black">{{$datas[$i]->desk_r}}</td>
                    <td style="border-left: 1px solid black; border-bottom: 1px solid black">{{$datas[$i]->gross_r}}</td>
                </tr>
                <?php
                $number++;
                $subTotalP = $subTotalP + $datas[$i]->gross_p;
                $subTotalR = $subTotalR + $datas[$i]->gross_r;
                ?>
            @endif
            @if($i+1 == sizeof($datas))
                <?php
                $totalP = $totalP + $subTotalP;
                $totalR = $totalR + $subTotalR;
                ?>
                <tr style="text-align: center; vertical-align: center">
                    <td colspan="4" style="border-bottom: 1px solid black; text-align: left !IMPORTANT;">SUB-TOTAL TANGGAL : {{$datas[$i]->tgldoc}}</td>
                    <td style="border-bottom: 1px solid black;"></td>
                    <td style="border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">{{$subTotalP}}</td>
                    <td style="border-bottom: 1px solid black;"></td>
                    <td style="border-bottom: 1px solid black;"></td>
                    <td style="border-left: 1px solid black; border-bottom: 1px solid black;">{{$subTotalR}}</td>
                </tr>
                <tr style="text-align: center; vertical-align: center">
                    <td colspan="4" style="border-bottom: 1px solid black; text-align: left !IMPORTANT;">TOTAL SELURUHNYA : </td>
                    <td style="border-bottom: 1px solid black;"></td>
                    <td style="border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">{{$totalP}}</td>
                    <td style="border-bottom: 1px solid black;"></td>
                    <td style="border-bottom: 1px solid black;"></td>
                    <td style="border-left: 1px solid black; border-bottom: 1px solid black;">{{$totalR}}</td>
                </tr>
            @endif
        @endfor
        </tbody>
    </table>
    <hr>
    <p style="float: right">** AKHIR DARI LAPORAN **</p>

</body>

</html>
