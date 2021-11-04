@extends('navbar')
@section('title','LAPORAN PENJUALAN TUNAI')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
{{--                    <legend class="w-auto ml-5">Laporan Penjualan Tunai</legend>--}}
{{--                        ### MENU UTAMA ###   --}}
                            <br>
                        <div id="mainMenu">
                            <div class="row">
                                <label class="col-sm-3 text-right col-form-label">Jenis Laporan</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="jenisLaporan">
                                        <option>1. Daftar Produk</option>
                                        <option>2. Daftar Perubahan Harga Jual</option>
                                        <option>3. Daftar Margin Negatif</option>
                                        <option>4. Daftar Supplier</option>
                                        <option>5</option>
{{--                                        <option value="Z2">DAFTAR BARANG BAIK KE RUSAK</option>--}}
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary btn-block col-sm-3" type="button" onclick="pilih()">PILIH</button>
                            </div>
                            <br>
                        </div>

{{--                        ### Menu 1 === Laporan Per Kategory ###--}}
                        <div id="menu1" class="card-body shadow-lg cardForm" hidden>
                            <fieldset class="card border-dark">
                                <legend class="w-auto ml-5">Laporan Penjualan (Per Kategory)</legend>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Periode tanggal :</label>
                                    <input class="col-sm-4 text-center form-control" type="text" id="daterangepicker1">
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Khusus Elektronik :</label>
                                    <input class="col-sm-2 text-center form-control" type="text" id="yaTidakMenu1" onkeypress="return isYT(event)" maxlength="1"> {{--kalau mau tanpa perlu klik enter tambahkan aja onchange="khususElektronik()"--}}
                                    <label class="col-sm-2 text-left col-form-label">[Y]a/[T]idak :</label>
                                </div>

{{--                                BAGIAN DIVISI--}}
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Divisi :</label>
                                    <div id="divA" class="col-sm-8" hidden>
                                        <div class="row">
                                            <div class="col-sm-3 buttonInside">
                                                <input id="menu1divA1" class="form-control" type="text">
                                                <button id="menu1A1div" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                                        data-target="#divModal">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>
                                            <label class="col-sm-1 text-center col-form-label">,</label>
                                            <div class="col-sm-3 buttonInside">
                                                <input id="menu1divA2" class="form-control" type="text">
                                                <button id="menu1A2div" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                                        data-target="#divModal">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>
                                            <label class="col-sm-1 text-center col-form-label">,</label>
                                            <div class="col-sm-3 buttonInside">
                                                <input id="menu1divA3" class="form-control" type="text">
                                                <button id="menu1A3div" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                                        data-target="#divModal">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="divB" class="col-sm-8" hidden>
                                        <div class="row">
                                            <div class="col-sm-4 buttonInside">
                                                <input id="menu1divB1" class="form-control" type="text">
                                                <button id="menu1B1div" type="button" class="btn btn-lov p-0">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px" data-toggle="modal"
                                                         data-target="#divModal">
                                                </button>
                                            </div>
                                            <label class="col-sm-2 text-center col-form-label">s/d</label>
                                            <div class="col-sm-4 buttonInside">
                                                <input id="menu1divB2" class="form-control" type="text">
                                                <button id="menu1B2div" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                                        data-target="#divModal">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

{{--                                BAGIAN DEPARTEMEN--}}
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Departemen :</label>
                                    <div id="deptA" class="col-sm-8" hidden>
                                        <div class="row">
                                            <div class="col-sm-2 buttonInside">
                                                <input id="menu1deptA1" class="form-control" type="text" disabled>
                                                <button id="menu1A1dept" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                                        data-target="#deptModal" disabled>
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>
                                            <label class="col-sm-1 text-center col-form-label">,</label>
                                            <div class="col-sm-2 buttonInside">
                                                <input id="menu1deptA2" class="form-control" type="text" disabled>
                                                <button id="menu1A2dept" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                                        data-target="#deptModal" disabled>
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>
                                            <label class="col-sm-1 text-center col-form-label">,</label>
                                            <div class="col-sm-2 buttonInside">
                                                <input id="menu1deptA3" class="form-control" type="text" disabled>
                                                <button id="menu1A3dept" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                                        data-target="#deptModal" disabled>
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>
                                            <label class="col-sm-1 text-center col-form-label">,</label>
                                            <div class="col-sm-2 buttonInside">
                                                <input id="menu1deptA4" class="form-control" type="text" disabled>
                                                <button id="menu1A4dept" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                                        data-target="#deptModal" disabled>
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="deptB" class="col-sm-8" hidden>
                                        <div class="row">
                                            <div class="col-sm-4 buttonInside">
                                                <input id="menu1deptB1" class="form-control" type="text">
                                                <button id="menu1B1dept" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                                        data-target="#deptModal">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>
                                            <label class="col-sm-2 text-center col-form-label">s/d</label>
                                            <div class="col-sm-4 buttonInside">
                                                <input id="menu1deptB2" class="form-control" type="text">
                                                <button id="menu1B2dept" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                                        data-target="#deptModal">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                {{--Fungsi button bawah--}}
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary col-sm-3" type="button" onclick="kembali()">BACK</button>
                                    <button id="menu1Cetak" class="btn btn-success col-sm-3" type="button" onclick="cetakMenu1()">CETAK</button>
                                </div>
                                <br>
                            </fieldset>
                        </div>

{{--                        ### Menu 2 === Laporan Per Departemen ###--}}
                        <div id="menu2" class="card-body shadow-lg cardForm" hidden>
                            <fieldset class="card border-dark">
                                <legend class="w-auto ml-5">Laporan Penjualan (Per Departement)</legend>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Periode tanggal :</label>
                                    <input class="col-sm-4 text-center form-control" type="text" id="daterangepicker2">
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Khusus Export :</label>
                                    <input class="col-sm-2 text-center form-control" type="text" id="export" onkeypress="return isYTMenu2(event)" maxlength="1"> {{--kalau mau tanpa perlu klik enter tambahkan aja onchange="khususElektronik()"--}}
                                    <label class="col-sm-2 text-left col-form-label">[Y]a/[T]idak</label>
                                </div>
                                <br>
                                <div id="menu2Ext" hidden>
                                    <div class="row">
                                        <label class="col-sm-4 text-right col-form-label">Cetak untuk :</label>
                                        <div class="dropdown col-sm-4">
                                            <button class="btn btn-secondary dropdown-toggle col-sm-12" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <input readonly type="text" id="lstPrint" class="col-sm-11" value="">
                                                <input hidden type="text" id="lstPrintHidden" class="col-sm-11" value="">
                                            </button>
                                            <div id="dropDownList" class="dropdown-menu col-sm-11" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" onclick="lstPrint(1)">INDOGROSIR ALL [IGR + (OMI/IDM)]</a>
                                                <a class="dropdown-item" onclick="lstPrint(2)">INDOGROSIR [TANPA (OMI/IDM)]</a>
                                                <a class="dropdown-item" onclick="lstPrint(3)">OMI/IDM PER TOKO</a>
                                                <a class="dropdown-item" onclick="lstPrint(4)">OMI/IDM GABUNGAN ALL TOKO</a>
                                                <a class="dropdown-item" onclick="lstPrint(5)">GABUNGAN ALL TOKO OMI KHUSUS</a>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row" id="menu2Ext2" hidden>
                                        <label class="col-sm-4 text-right col-form-label">SBU :</label>
                                        <input class="col-sm-2 text-center form-control" type="text" id="sbu" onkeypress="return isOISMenu2(event)" maxlength="1">
                                        <label class="col-sm-4 text-left col-form-label">[O=OMI/I=Indomaret/S=Semua]</label>
                                    </div>
                                    <div class="row" id="menu2Ext3" hidden>
                                        <label class="col-sm-4 text-right col-form-label">Toko :</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input id="menu2TokoInput" class="form-control" type="text">
                                            <button id="menu2Toko" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                                    data-target="#tokoModal">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <label class="col-sm-4 text-left col-form-label">[kosong=semua]</label>
                                        <br>
                                        <div class="col-sm-4">{{--HANYA FILLER--}}</div>
                                        <input id="dis_omi" class="col-sm-4 form-control" type="text" disabled>
                                    </div>
                                    <br>
                                </div>
                                <br>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary col-sm-3" type="button" onclick="kembali()">BACK</button>
                                    <button id="menu2Cetak" class="btn btn-success col-sm-3" type="button" onclick="cetakMenu2()">CETAK</button>
                                </div>
                                <br>
                            </fieldset>
                        </div>

{{--                        ### Menu 3 === Rincian Produk Per Divisi ###--}}
                        <div id="menu3" class="card-body shadow-lg cardForm" hidden>
                            <fieldset class="card border-dark">
                                <legend class="w-auto ml-5">Rincian Penjualan (Produk Per Divisi)</legend>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Periode tanggal :</label>
                                    <input class="col-sm-4 text-center form-control" type="text" id="daterangepicker3">
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Divisi :</label>
                                    <div class="col-sm-3 buttonInside">
                                        <input id="menu3divA" class="form-control" type="text">
                                        <button id="menu3Adiv" type="button" class="btn btn-lov p-0">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px" data-toggle="modal"
                                                 data-target="#divModal">
                                        </button>
                                    </div>
                                    <input class="col-sm-4 text-center form-control" type="text" id="menu3divdisplay" disabled>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Departemen :</label>
                                    <div class="col-sm-3 buttonInside">
                                        <input id="menu3deptA" class="form-control" type="text" onfocus="menu3DivNotEmpty()">
                                        <button id="menu3Adept" type="button" class="btn btn-lov p-0" onclick="deptMenu3()">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                    <input class="col-sm-4 text-center form-control" type="text"id="menu3deptdisplay" disabled>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Kategory :</label>
                                    <div class="col-sm-3 buttonInside">
                                        <input id="menu3katA" class="form-control" type="text" onfocus="menu3DeptNotEmpty()">
                                        <button id="menu3Akat" type="button" class="btn btn-lov p-0" onclick="katMenu3()">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                    <input class="col-sm-4 text-center form-control" type="text"id="menu3katdisplay"  disabled>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Margin % :</label>
                                    <input class="col-sm-2 text-center form-control" type="text" id="menu3Margin1">
                                    <label class="col-sm-2 text-center col-form-label">s/d</label>
                                    <input class="col-sm-2 text-center form-control" type="text" id="menu3Margin2">
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Monitoring Prd :</label>
                                    <div class="col-sm-4 buttonInside">
                                        <input id="menu3monA" class="form-control" type="text">
                                        <button id="menu3Amon" type="button" class="btn btn-lov p-0">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px" data-toggle="modal"
                                                 data-target="#monModal">
                                        </button>
                                    </div>
                                </div>
                                <br>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary btn-block col-sm-3" type="button" onclick="kembali()">BACK</button>
                                    <button id="cetakMenu3" class="btn btn-success col-sm-3" type="button" onclick="cetakMenu3()">CETAK</button>
                                </div>
                                <br>
                            </fieldset>
                        </div>

{{--                        ### Menu 4 === Laporan Per Hari ###--}}
                        <div id="menu4" class="card-body shadow-lg cardForm" hidden>
                            <fieldset class="card border-dark">
                                <legend class="w-auto ml-5">Laporan Penjualan (Per Hari)</legend>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Periode tanggal :</label>
                                    <input class="col-sm-4 text-center form-control" type="text" id="daterangepicker4">
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Khusus Export :</label>
                                    <input class="col-sm-2 text-center form-control" type="text" id="yaTidakMenu4" onkeypress="return isYTMenu4(event)" maxlength="1"> {{--kalau mau tanpa perlu klik enter tambahkan aja onchange="khususElektronik()"--}}
                                    <label class="col-sm-2 text-left col-form-label">[Y]a/[T]idak :</label>
                                </div>
                                <br>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary btn-block col-sm-3" type="button" onclick="kembali()">BACK</button>
                                    <button id="cetakMenu4" class="btn btn-success col-sm-3" type="button" onclick="cetakMenu4()">CETAK</button>
                                </div>
                                <br>
                            </fieldset>
                        </div>

{{--                        ### Menu 5 === Laporan Per Kasir ###--}}
                        <div id="menu5" class="card-body shadow-lg cardForm" hidden>
                            <fieldset class="card border-dark">
                                <legend class="w-auto ml-5">Laporan Penjualan (Per Kasir)</legend>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Periode tanggal :</label>
                                    <input class="col-sm-4 text-center form-control" type="text" id="daterangepicker5">
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Kasir :</label>
                                    <input class="col-sm-2 text-center form-control" type="text" id="kasirMenu5" style="text-transform:uppercase"> {{-- text-transform hanya visual, nanti di script diconvert menjadi capital sebelum data di send --}}
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">No. Station :</label>
                                    <input class="col-sm-2 text-center form-control" type="text" id="stationMenu5" style="text-transform:uppercase"> {{-- text-transform hanya visual, nanti di script diconvert menjadi capital sebelum data di send--}}
                                </div>
                                <br>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary btn-block col-sm-3" type="button" onclick="kembali()">BACK</button>
                                    <button id="cetakMenu5" class="btn btn-success col-sm-3" type="button" onclick="cetakMenu5()">CETAK</button>
                                </div>
                                <br>
                            </fieldset>
                        </div>


                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    {{--Modal DIV--}}
    <div class="modal fade" id="divModal" tabindex="-1" role="dialog" aria-labelledby="divModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Divisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalDiv">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Divisi</th>
                                        <th>Nama Divisi</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    {{--Modal Departemen--}}
    <div class="modal fade" id="deptModal" tabindex="-1" role="dialog" aria-labelledby="katModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Departemen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--UNTUK FILTER DATA--}}
                <div hidden>
                    <input type="text" id="min" name="min">
                    <input type="text" id="max" name="max">
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalDept">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Departemen</th>
                                        <th>Nama Departemen</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    {{--Modal Toko--}}
    <div class="modal fade" id="tokoModal" tabindex="-1" role="dialog" aria-labelledby="tokoModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">SBU</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--UNTUK FILTER DATA--}}
                <div hidden>
                    <input type="text" id="jenisToko" name="jenisToko">
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalToko">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>SBU</th>
                                        <th>Kode Customer</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    {{--Modal Kategori--}}
    <div class="modal fade" id="katModal" tabindex="-1" role="dialog" aria-labelledby="katModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--UNTUK FILTER DATA--}}
                <div hidden>
                    <input type="text" id="minKat" name="minKat">
                    <input type="text" id="maxKat" name="maxKat">
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalKat">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Kategori</th>
                                        <th>Nama Kategori</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    {{--Modal Monitor--}}
    <div class="modal fade" id="monModal" tabindex="-1" role="dialog" aria-labelledby="monModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalMon">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Monitoring</th>
                                        <th>Nama Monitoring</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <style>
        #dropDownList:hover{
            cursor: pointer;
        }
    </style>
    <script>
        //-------------------- ### GLOBAL FUNCTION ### --------------------
        //-------------------- ### GLOBAL FUNCTION END ### --------------------

        //tips navigasi (Ctrl+F) ketik ### <menu mana yang mau di lihat> (Ex. ### menu 0)
        //tips navigasi menu khusus interface (Ctrl+F) ketik ### <menu mana yang mau di lihat> === (Ex. ### menu 0 ===)
        //tips navigasi menu khusus javascript (Ctrl+F) ketik ### <menu mana yang mau di lihat> ### (Ex. ### menu 0 ###)
    </script>
@endsection
