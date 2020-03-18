<html>
<head>
    <style>
        /**
            Set the margins of the page to 0, so the footer and the header
            can be of the full height and width !
         **/
        @page {
            margin: 25px 25px;
            size: 1071pt 792pt;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 70px;
            margin-bottom: 10px;
            font-size: 10px;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }
    </style>
</head>
<body>
<!-- Define header and footer blocks before your content -->
<header>
    <div style="float:left; margin-top: -20px; line-height: 5px !important;">
        <p>PT.INTI CAKRAWALA CITRA</p>
        <p>PT.INTI CAKRAWALA CITRA</p>
    </div>
    <div style="float:right; margin-top: -20px; line-height: 5px !important;">
        <p>PT.INTI CAKRAWALA CITRA</p>
        <p>PT.INTI CAKRAWALA CITRA</p>
    </div>
    <h2 style="text-align: center">LAPORAN PEMBENTUKAN M PLUS.I DAN M PLUS.O<br>Periode : </h2>
</header>

<main>
    <table class="table table-bordered table-responsive" style="">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th rowspan="3" style="width: 20px">NO</th>
            <th colspan="2" rowspan="1" style="width: 60px">PLU</th>
            <th rowspan="3" style="width: 200px">DESKRIPSI</th>
            <th colspan="2" rowspan="1">BULAN SEBELUMNYA</th>
            <th colspan="4" rowspan="1">BULAN BERJALAN</th>
            <th rowspan="3">AVG PB OMI</th>
            <th rowspan="3">TAG IGR</th>
            <th rowspan="3">TAG IDM</th>
            <th rowspan="3">QTY Frac IGR</th>
            <th rowspan="3">S/L Supp(%)</th>
            <th colspan="2" rowspan="1">MINOR/FRAC</th>
            <th rowspan="3">NAIK/TURUN MINOR</th>
            <th rowspan="3">KETERANGAN</th>
            <th colspan="3" rowspan="1">QTY M PLUS.I</th>
            <th colspan="3" rowspan="1">QTY M PLUS.0</th>
        </tr>
        <tr>
            <th rowspan="2">IDM</th>
            <th rowspan="2">IGR</th>
            <th rowspan="2">QTY KPH MEAN</th>
            <th rowspan="2">QTY MINOR</th>
            <th colspan="3" rowspan="1">QTY KPH MEAN</th>
            <th rowspan="2">QTY MINOR</th>
            <th rowspan="2">B-2</th>
            <th rowspan="2">B-1</th>
            <th rowspan="2">n*</th>
            <th rowspan="2">EXISTING</th>
            <th rowspan="2">USULAN</th>
            <th rowspan="2">EXISTING</th>
            <th rowspan="2">USULAN</th>
        </tr>
        <tr>
            <th>1x</th>
            <th>3x</th>
            <th>4x</th>
        </tr>
        </thead>
        <tbody>
        @for($i =0 ;$i< 150;$i++)
            <tr>
                <td>{{$i}}</td>
            </tr>
        @endfor
        </tbody>
    </table>
</main>
</body>
</html>
