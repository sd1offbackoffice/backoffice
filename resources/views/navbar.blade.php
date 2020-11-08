<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- CSS -->
    {{--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">--}}

    {{-- JS --}}
    <script src={{asset('/js/jquery.js')}}></script>
    <script src="{{asset('/js/jquery-ui.js')}}"></script>
    <script src={{asset('/js/bootstrap.bundle.js')}}></script>
    <script src={{asset('/js/moment.min.js')}}></script>
    <script src={{asset('/js/sweetalert.js')}}></script>
    <script src={{asset('/js/datatables.js')}}></script>
    <script src="{{asset('/js/bootstrap-select.min.js')}}"></script>
    {{--<script src={{asset('/js/datatables_bootstrap.js')}}></script>--}}
    <script src={{asset('/js/script.js')}}></script>
    <script src={{asset('/js/boostable.js')}}></script>
    <script src={{asset('/js/sticktable.js')}}></script>

    <link rel="stylesheet" href="{{ asset('/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href={{ asset('css/bootstrap.min.css') }} rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-select.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/jquery-ui.css') }}">
    <link rel="stylesheet" href={{ asset('css/datatables.css') }} rel="stylesheet">
    <link rel="stylesheet" href={{ asset('css/datatables_bootstrap.css') }} rel="stylesheet">
    <link rel="stylesheet" href={{ asset('css/sticktable.css') }}  rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/stylee.css') }}" >


    <title>IAS - @yield('title')</title>
</head>
<body>
<div id="menu_area" class="menu-area">
    <div class="container">
        <div class="row">
            <nav class="navbar navbar-light navbar-expand-lg mainmenu">
                <a class="navbar-brand" href="{{url("/")}}"> <img src="{{asset('image/Indogrosir_logo.jpg')}}"
                                                                  width=100px"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Master</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a href="{{url("/mstaktifallhrgjual/index")}}">Aktifkan Harga Jual All Item</a></li>
                                <li><a href="{{url("/mstaktifhrgjual/index")}}">Aktifkan Harga Jual Per Item</a></li>
                                <li><a href="{{url("/mstinformasihistoryproduct/index")}}">Informasi dan History
                                        Product</a></li>
                                <li><a href="{{url("/mstapproval/index")}}">Master Approval</a></li>
                                <li><a href="{{url("/mstbarang/index")}}">Master Barang</a></li>
                                <li><a href="{{url("/mstbarcode/index")}}">Master Barcode</a></li>
                                <li><a href="{{url("/mstcabang/index")}}">Master Cabang</a></li>
                                <li><a href="{{url("/mstdepartement/index")}}">Master Departement</a></li>
                                <li><a href="{{url("/mstdivisi/index")}}">Master Divisi</a></li>
                                <li><a href="{{url("/msthargabeli/index")}}">Master Harga Beli</a></li>
                                <li><a href="{{url("/mstharilibur/index")}}">Master Hari Libur</a></li>
                                <li><a href="{{url("/mstjenisitem/index")}}">Master Jenis Item</a></li>
                                <li><a href="{{url("/mstkategoribarang/index")}}">Master Kategori Barang</a></li>
                                <li><a href="{{url("/mstkategoritoko/index")}}">Master Kategori Toko</a></li>
                                <li><a href="{{url("/mstkubikasiplano/index")}}">Master Kubikasi Plano</a></li>
                                <li><a href="{{url("/mstlokasi/index")}}">Master Lokasi</a></li>
                                <li><a href="{{url("/mstmember/index")}}">Master Member</a></li>
                                <li><a href="{{url("/mstomi/index")}}">Master OMI</a></li>
                                <li><a href="{{url("/mstoutlet/index")}}">Master Outlet</a></li>
                                <li><a href="{{url("/mstperusahaan/index")}}">Master Perusahaan</a></li>
                                <li><a href="{{url("/mstsuboutlet/index")}}">Master Sub Outlet</a></li>
                                <li><a href="{{url("/mstsupplier/index")}}">Master Supplier</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Back Office</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li class="dropdown">
                                    <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                       data-toggle="dropdown" aria-haspopup="true"
                                       aria-expanded="false">PB</a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a href="{{url("/bocetakpb/index")}}">Cetak PB</a></li>
                                        <li><a href="{{url("/bocetaktolakanpb/index")}}">Cetak Tolakan PB</a></li>
                                        <li><a href="{{url("/bomaxpalet/index")}}">Item Maxpalet Untuk PB</a></li>
                                        <li><a href="{{url("/bokkei/index")}}">Kertas Kerja Estimasi Kebutuhan Toko
                                                IGR</a></li>
                                        <li><a href="{{url("/bopbotomatis/index")}}">PB Otomatis</a></li>
                                        <li><a href="{{url("/bopbmanual/index")}}">PB Manual</a></li>
                                        <li><a href="{{url("/boreorderpbgo/index")}}">Reorder PB GO</a></li>
                                        <li><a href="{{url("/bokirimkkei/index")}}">Upload dan Monitoring KKEI Toko
                                                IGR</a></li>
                                        <li><a href="{{url("/boutilitypbigr/index")}}">Utility PB IGR</a></li>
                                        <li><a href="{{url("/bo/transaksi/pengeluaran/input/index")}}">Transaksi -
                                                Pengeluaran - Input</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                       data-toggle="dropdown" aria-haspopup="true"
                                       aria-expanded="false">Transaksi</a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                               data-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false">Pemusnahan</a>
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <li><a href="{{url("/bo/transaksi/pemusnahan/brgrusak/index")}}">Barang Rusak</a></li>
                                                <li><a href="{{url("/bo/transaksi/pemusnahan/bapemusnahan/index")}}">Berita Acara Pemusnahan</a></li>
                                                <li><a href="{{url("/bo/transaksi/pemusnahan/bapbatal/index")}}">Pembatalan BA Pemusnahan</a></li>
                                                <li><a href="{{url("/bo/transaksi/pemusnahan/inquerybapb/index")}}">Inquery BA Pemusnahan</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                               data-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false">Barang Hilang</a>
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <li><a href="{{url("/bo/transaksi/brghilang/input/index")}}">Input</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                               data-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false">Penyesuaian</a>
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <li><a href="{{url("/bo/transaksi/penyesuaian/input/index")}}">Input</a></li>
                                                <li><a href="{{url("/bo/transaksi/penyesuaian/cetak")}}">Cetak</a></li>
                                                <li><a href="{{url("/bo/transaksi/penyesuaian/inquerympp")}}">Inquery MPP</a></li>
                                                <li><a href="{{url("/bo/transaksi/penyesuaian/pembatalanmpp")}}">Pembatalan MPP</a></li>
                                                <li><a href="{{url("/bo/transaksi/penyesuaian/perubahanplu")}}">Perubahan PLU</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                               data-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false">Pengeluaran</a>
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <li><a href="{{url("/bo/transaksi/pengeluaran/input")}}">Input</a></li>
                                                <li><a href="{{url("/bo/transaksi/pengeluaran/cetak")}}">Cetak Surat Jalan</a></li>
                                                <li><a href="{{url("/bo/transaksi/pengeluaran/batal")}}">Batal Surat Jalan</a></li>
                                                <li><a href="{{url("/bo/transaksi/pengeluaran/inquery")}}">Inquery Surat Jalan</a></li>
                                                <li><a href="{{url("/bo/transaksi/pengeluaran/sj-packlist")}}">Transaksi SJ Packlist</a></li>
                                                <li><a href="{{url("/bo/transaksi/pengeluaran/cetak-sj-packlist")}}">Cetak SJ Packlist</a></li>
                                                <li><a href="{{url("/bo/transaksi/pengeluaran/transfer-sj")}}">Transfer Surat Jalan</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                               data-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false">Pengiriman ke Cabang</a>
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <li><a href="{{url("/bo/transaksi/kirimcabang/input")}}">Input</a></li>
                                                <li><a href="{{url("/bo/transaksi/kirimcabang/cetak")}}">Cetak Surat Jalan</a></li>
                                                <li><a href="{{url("/bo/transaksi/kirimcabang/batal")}}">Batal Surat Jalan</a></li>
                                                <li><a href="{{url("/bo/transaksi/kirimcabang/inquery")}}">Inquery Surat Jalan</a></li>
                                                <li><a href="{{url("/bo/transaksi/kirimcabang/sj-packlist")}}">Transaksi SJ Packlist</a></li>
                                                <li><a href="{{url("/bo/transaksi/kirimcabang/cetak-sj-packlist")}}">Cetak SJ Packlist</a></li>
                                                <li><a href="{{url("/bo/transaksi/kirimcabang/transfer-sj")}}">Transfer Surat Jalan</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                               data-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false">Penerimaan</a>
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <li><a href="{{url("/bo/transaksi/penerimaan/input/index")}}">Input</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Inquiry</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a href="{{url("/inqprodsupp/index")}}">Inquiry Produk Per Supplier</a></li>
                                <li><a href="{{url("/inqsupprod/index")}}">Inquiry Supplier Per Produk</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administration</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a href="{{url("/admuser/index")}}">User</a></li>
                            </ul>
                        </li>
                        <li class="dropdown" style="position: relative; left: 400px;">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">{{$_SESSION['usid']}}</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a href="{{url("/logout")}}">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>

{{--<div class="container mt-5">--}}
{{--<div class="row justify-content-center">--}}
{{--<div class="col-sm-10">--}}
{{--<div class="tableFixedHeader" style="height: 300px !important;">--}}
{{--<table class="table table-hover" style="height: 250px">--}}
{{--<thead style="background-color: rgb(42, 133, 190); color: whitesmoke;">--}}
{{--<tr>--}}
{{--<th scope="col">#</th>--}}
{{--<th scope="col">First</th>--}}
{{--<th scope="col">Last</th>--}}
{{--<th scope="col">Handle</th>--}}
{{--</tr>--}}
{{--</thead>--}}
{{--<tbody>--}}
{{--@for($i =0 ; $i< 50; $i++)--}}
{{--<tr>--}}
{{--<td scope="row">{{$i}}</td>--}}
{{--<td>Mark</td>--}}
{{--<td>Otto</td>--}}
{{--<td>@mdo</td>--}}
{{--</tr>--}}
{{--@endfor--}}
{{--</tbody>--}}
{{--</table>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}

{{--<div class="container mt-5">--}}
{{--<div class="row justify-content-center">--}}
{{--<div class="col-sm-10">--}}
{{--<table id="example" class="display" style="width:100%">--}}
{{--<thead style="background-color: rgb(42, 133, 190); color: white">--}}
{{--<tr>--}}
{{--<th>Name</th>--}}
{{--<th>Position</th>--}}
{{--<th>Office</th>--}}
{{--<th>Age</th>--}}
{{--<th>Start date</th>--}}
{{--<th>Salary</th>--}}
{{--</tr>--}}
{{--</thead>--}}
{{--<tbody>--}}
{{--@for($i =0 ; $i< 50; $i++)--}}
{{--<tr>--}}
{{--<td>Tiger Nixon</td>--}}
{{--<td>System Architect</td>--}}
{{--<td>Edinburgh</td>--}}
{{--<td>{{$i}}</td>--}}
{{--<td>2011/04/25</td>--}}
{{--<td>$320,800</td>--}}
{{--</tr>--}}
{{--@endfor--}}
{{--</tbody>--}}
{{--</table>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}



<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->

{{--</body>--}}
{{--</html>--}}
{{----}}
<main class="py-4">
    @yield('content')

    {{--NAVBAR--}}
    <div class="modal fade" id="modal-loader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" style="vertical-align: middle;" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--NAVBAR--}}

</main>


</body>

{{--<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>--}}
{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>--}}
{{--<script src={{asset('/js/jquery.js')}}></script>--}}
{{--<script src={{asset('/js/bootstrap.bundle.js')}}></script>--}}
{{--<script src={{asset('/js/moment.min.js')}}></script>--}}
{{--<script src={{asset('/js/script.js')}}></script>--}}
</html>
<style>
    .tableFixedHeader th {
        background: rgb(42, 133, 190);
        color: white
    }

    .menu-area {
        background: #0079C2
    }

    .dropdown-menu {
        padding: 0;
        margin: 0;
        border: 0 solid transition !important;
        border: 0 solid rgba(0, 0, 0, .15);
        border-radius: 0;
        -webkit-box-shadow: none !important;
        box-shadow: none !important
    }

    .mainmenu a,
    .navbar-default .navbar-nav > li > a,
    .mainmenu ul li a,
    .navbar-expand-lg .navbar-nav .nav-link {
        color: #fff;
        font-size: 16px;
        text-transform: capitalize;
        padding: 12px 15px;
        font-family: 'Roboto', sans-serif;
        display: block !important;
    }

    /* .mainmenu .active a,
    .mainmenu .active a:focus,
    .mainmenu .active a:hover,
    .mainmenu li a:hover,
    .mainmenu li a:focus,
    .navbar-default .navbar-nav>.show>a,
    .navbar-default .navbar-nav>.show>a:focus,
    .navbar-default .navbar-nav>.show>a:hover {
        color: #fff;
        background: red;
        outline: 0;
    } */

    /*==========Sub Menu=v==========*/
    .mainmenu .collapse ul > li:hover > a {
        background: #1E88E5;
    }

    .mainmenu .collapse ul ul > li:hover > a,
    .navbar-default .navbar-nav .show .dropdown-menu > li > a:focus,
    .navbar-default .navbar-nav .show .dropdown-menu > li > a:hover {
        background: #1E88E5;
    }

    .mainmenu .collapse ul ul ul > li:hover > a {
        background: #1E88E5;
    }

    .mainmenu .collapse ul ul,
    .mainmenu .collapse ul ul.dropdown-menu {
        background: rgb(63, 148, 201);
        /* background: #0079C2; */
    }

    .mainmenu .collapse ul ul ul,
    .mainmenu .collapse ul ul ul.dropdown-menu {
        background: rgb(63, 148, 201);
        /* background: #1E88E5 */
    }

    .mainmenu .collapse ul ul ul ul,
    .mainmenu .collapse ul ul ul ul.dropdown-menu {
        /*background: red*/
         background: rgb(63, 148, 201);
    }

    /******************************Drop-down menu work on hover**********************************/
    .mainmenu {
        background: none;
        border: 0 solid;
        margin: 0;
        padding: 0;
        min-height: 20px;
        width: 100%;
    }

    @media only screen and (min-width: 767px) {
        .mainmenu .collapse ul li:hover > ul {
            display: block
        }

        .mainmenu .collapse ul ul {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 250px;
            display: none
        }

        /*******/
        .mainmenu .collapse ul ul li {
            position: relative
        }

        .mainmenu .collapse ul ul li:hover > ul {
            display: block
        }

        .mainmenu .collapse ul ul ul {
            position: absolute;
            top: 0;
            left: 100%;
            min-width: 250px;
            display: none
        }

        /*******/
        .mainmenu .collapse ul ul ul li {
            position: relative
        }

        .mainmenu .collapse ul ul ul li:hover ul {
            display: block
        }

        .mainmenu .collapse ul ul ul ul {
            position: absolute;
            top: 0;
            /*left: -100%;*/ /*Dikomen supaya submenu ketiga muncul sebelah kanan, bukan dikiri*/
            min-width: 250px;
            display: none;
            z-index: 1
        }

    }

    @media only screen and (max-width: 767px) {
        .navbar-nav .show .dropdown-menu .dropdown-menu > li > a {
            padding: 16px 15px 16px 35px
        }

        .navbar-nav .show .dropdown-menu .dropdown-menu .dropdown-menu > li > a {
            padding: 16px 15px 16px 45px
        }
    }

    /*paging button datatables*/
    .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        color: #333333 !important;
        border: 1px solid #0b3559;
        background-color: #8cc2f1;
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #8cc2f1), color-stop(100%, #1a7dd4));
        /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top, #8cc2f1 0%, #1a7dd4 100%);
        /* Chrome10+,Safari5.1+ */
        background: -moz-linear-gradient(top, #8cc2f1 0%, #1a7dd4 100%);
        /* FF3.6+ */
        background: -ms-linear-gradient(top, #8cc2f1 0%, #1a7dd4 100%);
        /* IE10+ */
        background: -o-linear-gradient(top, #8cc2f1 0%, #1a7dd4 100%);
        /* Opera 11.10+ */
        background: linear-gradient(to bottom, #8cc2f1 0%, #1a7dd4 100%);
        /* W3C */
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        color: white !important;
        border: 1px solid #1e8de8;
        background-color: #a0cff5;
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #a0cff5), color-stop(100%, #1e8de8));
        /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top, #a0cff5 0%, #1e8de8 100%);
        /* Chrome10+,Safari5.1+ */
        background: -moz-linear-gradient(top, #a0cff5 0%, #1e8de8 100%);
        /* FF3.6+ */
        background: -ms-linear-gradient(top, #a0cff5 0%, #1e8de8 100%);
        /* IE10+ */
        background: -o-linear-gradient(top, #a0cff5 0%, #1e8de8 100%);
        /* Opera 11.10+ */
        background: linear-gradient(to bottom, #a0cff5 0%, #1e8de8 100%);
        /* W3C */
    }
</style>
{{--<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"--}}
        {{--integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"--}}
        {{--crossorigin="anonymous"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"--}}
        {{--integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"--}}
        {{--crossorigin="anonymous"></script>--}}
{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"--}}
        {{--integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"--}}
        {{--crossorigin="anonymous"></script>--}}
{{--<script src={{asset('/js/datatables.js')}}></script>--}}

<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });

    (function ($) {
        $('.dropdown-menu a.dropdown-toggle').on('click', function (e) {
            if (!$(this).next().hasClass('show')) {
                $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
            }
            var $subMenu = $(this).next(".dropdown-menu");
            $subMenu.toggleClass('show');

            $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
                $('.dropdown-submenu .show').removeClass("show");
            });

            return false;
        });
    })(jQuery)
</script>


