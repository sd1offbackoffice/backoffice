<!DOCTYPE html>
<html>
<head>
    <title>@yield('page_title')</title>
    <style>
        body{
            margin: 0;
        }

        .bg-white{
            background-color: white;
        }

        .bg-gray{
            background-color: rgb(82, 86, 89);
        }

        .content-wrapper{
            margin:auto;
            min-height: @yield('paper_height','842pt');
            width: @yield('paper_width','595pt');
            /*min-height: auto;*/
            /*width: auto;*/
            padding: 5% 4%;
        }

        table.report-container {
            page-break-after:always;
            width: 100%;
        }
        thead.report-header {
            display:table-header-group;
        }
        tfoot.report-footer {
            display:table-footer-group;
        }
        table.report-container div.article {
            page-break-inside: avoid;
        }

        .btn-print{
            float:right;
            color: #fff;
            background-color: #007bff;
            display: inline-block;
            font-weight: 400;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            height: 100%;
            cursor: pointer;
            border-radius: 5px;
        }

        @page {
            /*margin: 25px 20px;*/
            /*size: 1071pt 792pt;*/
            size: @yield('paper_width','595pt') @yield('paper_height','842pt');
        {{--            size: @yield('paper_width','auto') @yield('paper_height','auto');--}}
/*size: 842pt 638pt;*/
        }

        @media print{
            #buttonArea{
                display: none;
            }

            .content-wrapper{
                padding: 0;
            }
        }

        header {
            /*position: fixed;*/
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
        }
        body {
            /*margin-top: 80px;*/
            /*margin-bottom: 10px;*/
            font-size: 9px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-weight: 400;
            line-height: @yield('body_line_height','1.8'); /* 1.25 */

            counter-reset: page;
        }

        #pageNumber {
            page-break-before: always;
            counter-increment: page;
        }
        #pageNumber::after {
            content: counter(page);
        }

        .table tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        .table tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table td {
            display: table-cell;
        }
        .table thead{
            text-align: center;
        }
        .table tbody{
            text-align: center;
        }
        .table tfoot{
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

        .keterangan{
            text-align: left;
        }
        .table{
            border-collapse: collapse;
            width: 100%;
            font-size: @yield('table_font_size','10px') !important;
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

        .table tbody td.padding-right,tbody th.padding-right, .table thead th.padding-right, .table tfoot th.padding-right{
            padding-right: 10px !important;
        }

        .table tbody td.padding-left, .table thead th.padding-left, .table tfoot th.padding-left{
            padding-left: 10px !important;
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

        .bawah{
            vertical-align: bottom !important;
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

        .overline{
            text-decoration: overline;
        }

        @media print {
            .pagebreak { page-break-before: always; } /* page-break-after works, as well */
        }

        /* @yield('custom_style') */
    </style>

    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.min.css') }}"> --}}

    <script src={{asset('/js/jquery.js')}}></script>
    {{-- <script src="{{ asset('/js/bootstrap.bundle.js') }}"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <script>
        var oldPrintFunction = window.print;

        window.print = function () {
            var curURL = window.location.href;
            var title = $('title').html();
            history.replaceState(history.state, '', '/');
            $('title').html('.');
            oldPrintFunction();
            $('title').html(title);
            history.replaceState(history.state, '', curURL);
        };
    </script>


    <script>
        function demoFromHTML() {
            var pdf = new jsPDF();
            // source can be HTML-formatted string, or a reference
            // to an actual DOM element from which the text will be scraped.
            source = $('.content-wrapper');

            // we support special element handlers. Register them with jQuery-style
            // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
            // There is no support for any other type of selectors
            // (class, of compound) at this time.
            specialElementHandlers = {
                // element with id of "bypass" - jQuery style selector
                '#bypassme': function (element, renderer) {
                    // true = "handled elsewhere, bypass text extraction"
                    return true
                }
            };
            margins = {
                top: 40,
                bottom: 40,
                left: 40,
                right: 40,
                width: 842
            };
            // all coords and widths are in jsPDF instance's declared units
            // 'inches' in this case
            pdf.fromHTML(
                $('body')[0], // HTML string or DOM elem ref.
                margins.left, // x coord
                margins.top, { // y coord
                    'width': margins.width, // max width of content on PDF
                    'elementHandlers': specialElementHandlers
                },

                function (dispose) {
                    // dispose: object with X, Y of the last line add to the PDF
                    //          this allow the insertion of new lines after html
                    pdf.save('Test.pdf');
                }, margins
            );
        }
    </script>
</head>

<body class="bg-gray">
<div id="buttonArea" style="position: sticky; width: 100%; height: 50px; top: 0;">
    <button class="btn-print" onclick="javascript:demoFromHTML()">CETAK</button>
</div>
<div class="bg-white content-wrapper">
    <table class="report-container">
        <thead class="report-header">
        <tr>
            <th class="report-header-cell">
                <div class="header-info">
                    <div class="left" style="float:left; margin-top: 0px; line-height: 8px !important;">
                        <p>{{ $perusahaan->prs_namaperusahaan }}</p>
                        <p>{{ $perusahaan->prs_namacabang }}</p>
                        @yield('header_left')
                    </div>
                    <div class="left" style="float:right; margin-top: 0px; line-height: 8px !important;">
                        <p>
                            Tgl. Cetak : {{ date("d/m/Y") }}
                        </p>
                        <p>
                            Jam Cetak : {{ date('H:i:s') }}
                        </p>
                        <p>
                            <i>User ID</i> : {{ Session::get('usid') }}
                        </p>
                        @yield('header_right')
                    </div>
                    <div class="center">
                        <p style="font-weight:bold;font-size:14px;text-align: center;margin: 0;padding: 0">
                            @yield('title')
                        </p>
                        <p style="text-align: center;margin: 0;padding: 0">
                            @yield('subtitle')
                        </p>
                    </div>
                </div>
                <div class="center" style="clear:both">
                    @yield('header_optional')
                </div>
            </th>
        </tr>
        </thead>
        <tfoot class="report-footer">
        <tr>
            <td class="report-footer-cell">
                <div class="footer-info">
                    @yield('ttd')
                </div>
            </td>
        </tr>
        </tfoot>
        <tbody class="report-content">
        <tr>
            <td class="report-content-cell">
                <div class="main">
                    <div class="article">
                        <main>
                            @if(sizeof($data) == 0)
                                <h4 class="center">@yield('nodata','TIDAK ADA DATA')</h4>
                            @else
                                @yield('content')
                            @endif
                            <p class="right" style="border-top:1px solid black;font-size: @yield('table_font_size','10px')">@yield('footer','** Akhir dari laporan **')</p>

                        </main>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
