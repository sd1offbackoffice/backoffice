<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    {{--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">--}}
    <link href={{ asset('css/bootstrap.min.css') }} rel="stylesheet">
    <link href={{ asset('css/datatables.css') }} rel="stylesheet">
    {{--<link href={{ asset('css/datatables_bootstrap.css') }} rel="stylesheet">--}}
    <link href="{{ asset('css/stylee.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('/css/bootstrap-select.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/jquery-ui.css') }}">


    {{-- JS --}}
    <script src={{asset('/js/jquery.js')}}></script>
    <script src={{asset('/js/bootstrap.bundle.js')}}></script>
    <script src={{asset('/js/moment.min.js')}}></script>
    <script src={{asset('/js/sweetalert.js')}}></script>
    <script src={{asset('/js/datatables.js')}}></script>
    <script src="{{asset('/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/js/jquery-ui.js')}}"></script>
    {{--<script src={{asset('/js/datatables_bootstrap.js')}}></script>--}}
    <script src={{asset('/js/script.js')}}></script>

    <title>Migrasi IAS</title>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        {{--<div class="row justify-content-center">--}}
        {{--<div class="col-sm-11">--}}
        <a class="navbar-brand" href="{{url("/")}}">            <img src="{{asset('image/Indogrosir_logo.jpg')}}" width=100px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Master
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <!-- TARO URUT BERDASARKAN ABJAD-->
                        <a class="dropdown-item" href="{{url("/mstaktifallhrgjual/index")}}">Aktifkan Harga Jual All Item</a>
                        <a class="dropdown-item" href="{{url("/mstaktifhrgjual/index")}}">Aktifkan Harga Jual Per Item</a>
                        <a class="dropdown-item" href="{{url("/mstinformasihistoryproduct/index")}}">Informasi dan History Product</a>
                        <a class="dropdown-item" href="{{url("/mstapproval/index")}}">Master Approval</a>
                        <a class="dropdown-item" href="{{url("/mstbarang/index")}}">Master Barang</a>
                        <a class="dropdown-item" href="{{url("/mstbarcode/index")}}">Master Barcode</a>
                        <a class="dropdown-item" href="{{url("/mstcabang/index")}}">Master Cabang</a>
                        <a class="dropdown-item" href="{{url("/mstdepartement/index")}}">Master Departement</a>
                        <a class="dropdown-item" href="{{url("/mstdivisi/index")}}">Master Divisi</a>
                        <a class="dropdown-item" href="{{url("/msthargabeli/index")}}">Master Harga Beli</a>
                        <a class="dropdown-item" href="{{url("/mstharilibur/index")}}">Master Hari Libur</a>
                        <a class="dropdown-item" href="{{url("/mstjenisitem/index")}}">Master Jenis Item</a>
                        <a class="dropdown-item" href="{{url("/mstkategoribarang/index")}}">Master Kategori Barang</a>
                        <a class="dropdown-item" href="{{url("/mstkategoritoko/index")}}">Master Kategori Toko</a>
                        <a class="dropdown-item" href="{{url("/mstkubikasiplano/index")}}">Master Kubikasi Plano</a>
                        <a class="dropdown-item" href="{{url("/mstlokasi/index")}}">Master Lokasi</a>
                        <a class="dropdown-item" href="{{url("/mstmember/index")}}">Master Member</a>
                        <a class="dropdown-item" href="{{url("/mstomi/index")}}">Master OMI</a>
                        <a class="dropdown-item" href="{{url("/mstoutlet/index")}}">Master Outlet</a>
                        <a class="dropdown-item" href="{{url("/mstperusahaan/index")}}">Master Perusahaan</a>
                        <a class="dropdown-item" href="{{url("/mstsuboutlet/index")}}">Master Sub Outlet</a>
                        <a class="dropdown-item" href="{{url("/mstsupplier/index")}}">Master Supplier</a>

                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Back Office
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <!-- TARO URUT BERDASARKAN ABJAD-->
                        {{--<a class="dropdown-item" href="{{url("/bomaxpalet/index")}}">Item Maxpalet Untuk PB</a>--}}
                        {{--<a class="dropdown-item" href="{{url("/bokkei/index")}}">Kertas Kerja Estimasi Kebutuhan Toko--}}
                            {{--IGR</a>--}}
                        {{--<a class="dropdown-item" href="{{url("/bopbotomatis/index")}}">PB Otomatis</a>--}}
                        {{--<a class="dropdown-item" href="{{url("/bokirimkkei/index")}}">Upload dan Monitoring KKEI Toko--}}
                            {{--IGR</a>--}}
                        {{--<a class="dropdown-item" href="{{url("/boutilitypbigr/index")}}">Utility PB IGR</a>--}}

                        {{--<li class="dropdown-submenu">--}}
                            {{--<a href="">Mutli</a>--}}
                            {{--<ul class="dropdown-menu">--}}
                                {{--<li><a class="dropdown-1" href="#">cubmenu</a></li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}

                        <a class="nav-link dropdown-toggle text-center" href="#" id="navbarDropdownMenuLink1" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                            PB
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink1">
                            <a class="dropdown-item" href="{{url("/bocetakpb/index")}}">Cetak PB</a>
                            <a class="dropdown-item" href="{{url("/bocetaktolakanpb/index")}}">Cetak Tolakan PB</a>
                            <a class="dropdown-item" href="{{url("/bomaxpalet/index")}}">Item Maxpalet Untuk PB</a>
                            <a class="dropdown-item" href="{{url("/bokkei/index")}}">Kertas Kerja Estimasi Kebutuhan Toko
                                IGR</a>
                            <a class="dropdown-item" href="{{url("/bopbotomatis/index")}}">PB Otomatis</a>
                            <a class="dropdown-item" href="{{url("/bopbmanual/index")}}">PB Manual</a>
                            <a class="dropdown-item" href="{{url("/boreorderpbgo/index")}}">Reorder PB GO</a>
                            <a class="dropdown-item" href="{{url("/bokirimkkei/index")}}">Upload dan Monitoring KKEI Toko IGR</a>
                            <a class="dropdown-item" href="{{url("/boutilitypbigr/index")}}">Utility PB IGR</a>
                        </div>

                    </div>

                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Inquiry
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <!-- TARO URUT BERDASARKAN ABJAD-->
                        <a class="dropdown-item" href="{{url("/inqprodsupp/index")}}">Inquiry Produk Per Supplier</a>
                        <a class="dropdown-item" href="{{url("/inqsupprod/index")}}">Inquiry Supplier Per Produk</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Administration
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <!-- TARO URUT BERDASARKAN ABJAD-->
                        <a class="dropdown-item" href="{{url("/admuser/index")}}">User</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url("/testnewnav")}}" tabindex="-1">NAVBAR SEMANGAT JEFRI <3</a>
                </li>
            </div>
        </div>
        <div class="navbar-nav" style="margin-right: 200px;">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php
                    echo $_SESSION['usid'];
                    ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{url("/logout")}}">Logout</a>
                </div>
            </li>
        </div>
    </div>
</nav>


<main class="py-4">
    @yield('content')

    {{--NAVBAR--}}
    <div class="modal fade" id="modal-loader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" style="vertical-align: middle;" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="loader" id="loader"></div>
                            <div class="col-sm-12 text-center">
                                <label for="">LOADING...</label>
                            </div>
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
