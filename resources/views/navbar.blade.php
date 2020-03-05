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

    <link rel="stylesheet" href="{{ asset('/css/bootstrap-select.css') }}" />
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
    <div class="container">
        <a class="navbar-brand" href="{{url("/")}}">Report</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Master
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"> <!-- TARO URUT BERDASARKAN ABJAD-->
                        <a class="dropdown-item" href="{{url("/mstaktifhrgjual/index")}}">Aktifkan Harga Jual Per Item</a>
                        <a class="dropdown-item" href="{{url("/mstaktifallhrgjual/index")}}">Aktifkan Harga Jual All Item</a>
                        <a class="dropdown-item" href="{{url("/mstinformasihistoryproduct/index")}}">Informasi dan History Product</a>
                        <a class="dropdown-item" href="{{url("/inqprodsupp/index")}}">Inquiry Produk Per Supplier</a>
                        <a class="dropdown-item" href="{{url("/inqsupprod/index")}}">Inquiry Supplier Per Produk</a>
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
                        <a class="dropdown-item" href="{{url("/mstmember/index")}}">Master Member</a>
                        <a class="dropdown-item" href="{{url("/mstomi/index")}}">Master OMI</a>
                        <a class="dropdown-item" href="{{url("/mstoutlet/index")}}">Master Outlet</a>
                        <a class="dropdown-item" href="{{url("/mstperusahaan/index")}}">Master Perusahaan</a>
                        <a class="dropdown-item" href="{{url("/mstsuboutlet/index")}}">Master Sub Outlet</a>
                        <a class="dropdown-item" href="{{url("/mstsupplier/index")}}">Master Supplier</a>

                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Back Office
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"> <!-- TARO URUT BERDASARKAN ABJAD-->
                        <a class="dropdown-item" href="{{url("/bokkei/index")}}">Kertas Kerja Estimasi Kebutuhan Toko IGR</a>
                        <a class="dropdown-item" href="{{url("/bokirimkkei/index")}}">Upload dan Monitoring KKEI Toko IGR</a>
                    </div>
                </li>
            </div>

            <div class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <div class="dropdown-menu" aria-labelledby="user">
                        <a class="nav-item nav-link" href="/logout" id="Logout"> <i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </li>
            </div>
        </div>
    </div>
</nav>


<main class="py-4">
    @yield('content')
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
