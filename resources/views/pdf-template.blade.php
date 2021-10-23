<!DOCTYPE html>
<html>
<head>
    <title>@yield('page_title')</title>
</head>
<body>

<header>
    <div style="float:left; margin-top: 0px; line-height: 8px !important;">
        <p>
            {{ $perusahaan->prs_namaperusahaan }}
        </p>
        <p>
            {{ $perusahaan->prs_namacabang }}
        </p>
        @yield('header_left')
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>
            Tgl. Cetak : {{ date("d/m/Y") }}
        </p>
        <p>
            Jam Cetak : {{ date('H:i:s') }}
        </p>
        <p>
            <i>User ID</i> : {{ $_SESSION['usid'] }}
        </p>
        <p>
            Hal. :
        </p>
    </div>
    <div>
        <p style="font-weight:bold;font-size:14px;text-align: center;margin: 0;padding: 0">
            @yield('title')
        </p>
        <p style="text-align: center;margin: 0;padding: 0">
            @yield('subtitle')
        </p>
    </div>
</header>



<main>
    @yield('content')
</main>

<footer>
    <p class="right" style="font-size: @yield('table_font_size','10px')">@yield('footer','** Akhir dari laporan **')</p>
</footer>

<br>
</body>
<style>
    @page {
        /*margin: 25px 20px;*/
        /*size: 1071pt 792pt;*/
        size: @yield('paper_size','595pt 842pt');
        /*size: 842pt 638pt;*/
    }
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 3cm;
    }
    body {
        margin-top: 80px;
        margin-bottom: 10px;
        font-size: 9px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 400;
        line-height: @yield('body_line_height','1.8'); /* 1.25 */
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
    tbody{
        text-align: center;
    }
    tfoot{
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }

    .keterangan{
        text-align: left;
    }
    .table{
        width: 100%;
        font-size: @yield('table_font_size','10px');
        white-space: nowrap;
        color: #212529;
        /*padding-top: 20px;*/
        /*margin-top: 25px;*/
    }
    .table-ttd{
        width: 100%;
        font-size: 9px;
        /*white-space: nowrap;*/
        color: #212529;
        /*padding-top: 20px;*/
        /*margin-top: 25px;*/
    }
    .table tbody td {
        /*font-size: 6px;*/
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

    .table tbody td.padding-right, .table thead th.padding-right{
        padding-right: 10px !important;
    }

    .center{
        text-align: center;
    }

    .left{
        text-align: left;
    }

    .right{
        text-align: right;
    }

    .page-break {
        page-break-before: always;
    }

    .page-break-avoid{
        page-break-inside: avoid;
    }

    .table-header td{
        white-space: nowrap;
    }

    .tengah{
        vertical-align: middle !important;
    }

    .blank-row {
        line-height: 70px!important;
        color: white;
    }

    .bold td{
        font-weight: bold;
    }

    .top-bottom{
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }

    .nowrap{
        white-space: nowrap;
    }

    @yield('custom_style')
</style>
</html>
