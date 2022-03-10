@extends('navbar')
@section('title','LAPORAN PENJUALAN TUNAI')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Laporan Penjualan Tunai</legend>
                    <div class="card-body shadow-lg cardForm">

                        {{--                        ### MENU UTAMA ###   --}}
                        <br>
                        <div id="mainMenu">
                            <div class="row">
                                <label class="col-sm-4 text-right col-form-label">Jenis Laporan</label>
                                <div class="dropdown col-sm-7">
                                    <button class="btn btn-secondary dropdown-toggle col-sm-12" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        <input readonly type="text" id="jenisLaporan" class="col-sm-11" value="">
                                    </button>
                                    <div id="dropDownList" class="dropdown-menu col-sm-11"
                                         aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" onclick="changeInput(1)">LAPORAN PER KATEGORY</a>
                                        <a class="dropdown-item" onclick="changeInput(2)">LAPORAN PER DEPARTEMEN</a>
                                        <a class="dropdown-item" onclick="changeInput(3)">RINCIAN PRODUK PER DIVISI</a>
                                        <a class="dropdown-item" onclick="changeInput(4)">LAPORAN PER HARI</a>
                                        <a class="dropdown-item" onclick="changeInput(5)">LAPORAN PER KASIR</a>
                                        <a class="dropdown-item" onclick="changeInput(6)">LPT DENGAN CASHBACK PER
                                            DEPARTEMENT</a>
                                    </div>
                                </div>
                                {{--                                <label class="col-sm-3 text-right col-form-label">Jenis Laporan</label>--}}
                                {{--                                <div class="col-sm-9">--}}
                                {{--                                    <select class="form-control" id="jenisLaporan">--}}
                                {{--                                        <option selected disabled>- silahkan pilih jenis Laporan -</option>--}}
                                {{--                                        <option onclick="changeInput(1)">LAPORAN PER KATEGORY</option>--}}
                                {{--                                        <option onclick="changeInput(2)">LAPORAN PER DEPARTEMEN</option>--}}
                                {{--                                        <option onclick="changeInput(3)">RINCIAN PRODUK PER DIVISI</option>--}}
                                {{--                                        <option onclick="changeInput(4)">LAPORAN PER HARI</option>--}}
                                {{--                                        <option onclick="changeInput(5)">LAPORAN PER KASIR</option>--}}
                                {{--                                        <option value="Z2">DAFTAR BARANG BAIK KE RUSAK</option>--}}
                                {{--                                    </select>--}}
                                {{--                                </div>--}}
                            </div>
                            <br>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary btn-block col-sm-3" type="button" onclick="pilih()">
                                    PILIH
                                </button>
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
                                    <input class="col-sm-2 text-center form-control" type="text" id="yaTidakMenu1"
                                           onkeypress="return isYT(event)"
                                           maxlength="1"> {{--kalau mau tanpa perlu klik enter tambahkan aja onchange="khususElektronik()"--}}
                                    <label class="col-sm-2 text-left col-form-label">[Y]a/[T]idak :</label>
                                </div>

                                {{--                                BAGIAN DIVISI--}}
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Divisi :</label>
                                    <div id="divA" class="col-sm-8" hidden>
                                        <div class="row">
                                            <div class="col-sm-3 buttonInside">
                                                <input id="menu1divA1" class="form-control" type="text">
                                                <button id="menu1A1div" type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal"
                                                        data-target="#divModal">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>
                                            <label class="col-sm-1 text-center col-form-label">,</label>
                                            <div class="col-sm-3 buttonInside">
                                                <input id="menu1divA2" class="form-control" type="text">
                                                <button id="menu1A2div" type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal"
                                                        data-target="#divModal">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>
                                            <label class="col-sm-1 text-center col-form-label">,</label>
                                            <div class="col-sm-3 buttonInside">
                                                <input id="menu1divA3" class="form-control" type="text">
                                                <button id="menu1A3div" type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal"
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
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px"
                                                         data-toggle="modal"
                                                         data-target="#divModal">
                                                </button>
                                            </div>
                                            <label class="col-sm-2 text-center col-form-label">s/d</label>
                                            <div class="col-sm-4 buttonInside">
                                                <input id="menu1divB2" class="form-control" type="text">
                                                <button id="menu1B2div" type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal"
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
                                                <button id="menu1A1dept" type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal"
                                                        data-target="#deptModal" disabled>
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>
                                            <label class="col-sm-1 text-center col-form-label">,</label>
                                            <div class="col-sm-2 buttonInside">
                                                <input id="menu1deptA2" class="form-control" type="text" disabled>
                                                <button id="menu1A2dept" type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal"
                                                        data-target="#deptModal" disabled>
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>
                                            <label class="col-sm-1 text-center col-form-label">,</label>
                                            <div class="col-sm-2 buttonInside">
                                                <input id="menu1deptA3" class="form-control" type="text" disabled>
                                                <button id="menu1A3dept" type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal"
                                                        data-target="#deptModal" disabled>
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>
                                            <label class="col-sm-1 text-center col-form-label">,</label>
                                            <div class="col-sm-2 buttonInside">
                                                <input id="menu1deptA4" class="form-control" type="text" disabled>
                                                <button id="menu1A4dept" type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal"
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
                                                <button id="menu1B1dept" type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal"
                                                        data-target="#deptModal">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </div>
                                            <label class="col-sm-2 text-center col-form-label">s/d</label>
                                            <div class="col-sm-4 buttonInside">
                                                <input id="menu1deptB2" class="form-control" type="text">
                                                <button id="menu1B2dept" type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal"
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
                                    <button class="btn btn-primary col-sm-3" type="button" onclick="kembali()">BACK
                                    </button>
                                    <button id="menu1Cetak" class="btn btn-success col-sm-3" type="button"
                                            onclick="cetakMenu1()">CETAK
                                    </button>
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
                                    <input class="col-sm-2 text-center form-control" type="text" id="export"
                                           onkeypress="return isYTMenu2(event)"
                                           maxlength="1"> {{--kalau mau tanpa perlu klik enter tambahkan aja onchange="khususElektronik()"--}}
                                    <label class="col-sm-2 text-left col-form-label">[Y]a/[T]idak</label>
                                </div>
                                <br>
                                <div id="menu2Ext" hidden>
                                    <div class="row">
                                        <label class="col-sm-4 text-right col-form-label">Cetak untuk :</label>
                                        <div class="dropdown col-sm-4">
                                            <button class="btn btn-secondary dropdown-toggle col-sm-12" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                <input readonly type="text" id="lstPrint" class="col-sm-11" value="">
                                                <input hidden type="text" id="lstPrintHidden" class="col-sm-11"
                                                       value="">
                                            </button>
                                            <div id="dropDownList" class="dropdown-menu col-sm-11"
                                                 aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" onclick="lstPrint(1)">INDOGROSIR ALL [IGR +
                                                    (OMI/IDM)]</a>
                                                <a class="dropdown-item" onclick="lstPrint(2)">INDOGROSIR [TANPA
                                                    (OMI/IDM)]</a>
                                                <a class="dropdown-item" onclick="lstPrint(3)">OMI/IDM PER TOKO</a>
                                                <a class="dropdown-item" onclick="lstPrint(4)">OMI/IDM GABUNGAN ALL
                                                    TOKO</a>
                                                <a class="dropdown-item" onclick="lstPrint(5)">GABUNGAN ALL TOKO OMI
                                                    KHUSUS</a>
                                            </div>
                                        </div>
                                        {{--                                        <label class="col-sm-4 text-right col-form-label">Cetak untuk :</label>--}}
                                        {{--                                        <div class="col-sm-4">--}}
                                        {{--                                            <select class="form-control" id="lstPrint">--}}
                                        {{--                                                <option selected disabled>- silahkan pilih jenis Laporan -</option>--}}
                                        {{--                                                <option onclick="lstPrint(1)">LAPORAN PER KATEGORY</option>--}}
                                        {{--                                                <option onclick="lstPrint(2)">LAPORAN PER DEPARTEMEN</option>--}}
                                        {{--                                                <option onclick="lstPrint(3)">RINCIAN PRODUK PER DIVISI</option>--}}
                                        {{--                                                <option onclick="lstPrint(4)">LAPORAN PER HARI</option>--}}
                                        {{--                                                <option onclick="lstPrint(5)">LAPORAN PER KASIR</option>--}}
                                        {{--                                            </select>--}}
                                        {{--                                        </div>--}}
                                        {{--                                        <input hidden type="text" id="lstPrintHidden" class="col-sm-11" value="">--}}
                                    </div>
                                    <br>
                                    <div class="row" id="menu2Ext2" hidden>
                                        <label class="col-sm-4 text-right col-form-label">SBU :</label>
                                        <input class="col-sm-2 text-center form-control" type="text" id="sbu"
                                               onkeypress="return isOISMenu2(event)" maxlength="1">
                                        <label
                                            class="col-sm-4 text-left col-form-label">[O=OMI/I=Indomaret/S=Semua]</label>
                                    </div>
                                    <div class="row" id="menu2Ext3" hidden>
                                        <label class="col-sm-4 text-right col-form-label">Toko :</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input id="menu2TokoInput" class="form-control" type="text">
                                            <button id="menu2Toko" type="button" class="btn btn-lov p-0"
                                                    data-toggle="modal"
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
                                    <button class="btn btn-primary col-sm-3" type="button" onclick="kembali()">BACK
                                    </button>
                                    <button id="menu2Cetak" class="btn btn-success col-sm-3" type="button"
                                            onclick="cetakMenu2()">CETAK
                                    </button>
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
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px"
                                                 data-toggle="modal"
                                                 data-target="#divModal">
                                        </button>
                                    </div>
                                    <input class="col-sm-4 text-center form-control" type="text" id="menu3divdisplay"
                                           disabled>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Departemen :</label>
                                    <div class="col-sm-3 buttonInside">
                                        <input id="menu3deptA" class="form-control" type="text"
                                               onfocus="menu3DivNotEmpty()">
                                        <button id="menu3Adept" type="button" class="btn btn-lov p-0"
                                                onclick="deptMenu3()">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                    <input class="col-sm-4 text-center form-control" type="text" id="menu3deptdisplay"
                                           disabled>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Kategory :</label>
                                    <div class="col-sm-3 buttonInside">
                                        <input id="menu3katA" class="form-control" type="text"
                                               onfocus="menu3DeptNotEmpty()">
                                        <button id="menu3Akat" type="button" class="btn btn-lov p-0"
                                                onclick="katMenu3()">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                    <input class="col-sm-4 text-center form-control" type="text" id="menu3katdisplay"
                                           disabled>
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
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px"
                                                 data-toggle="modal"
                                                 data-target="#monModal">
                                        </button>
                                    </div>
                                </div>
                                <br>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary btn-block col-sm-3" type="button"
                                            onclick="kembali()">BACK
                                    </button>
                                    <button id="cetakMenu3" class="btn btn-success col-sm-3" type="button"
                                            onclick="cetakMenu3()">CETAK
                                    </button>
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
                                    <input class="col-sm-2 text-center form-control" type="text" id="yaTidakMenu4"
                                           onkeypress="return isYTMenu4(event)"
                                           maxlength="1"> {{--kalau mau tanpa perlu klik enter tambahkan aja onchange="khususElektronik()"--}}
                                    <label class="col-sm-2 text-left col-form-label">[Y]a/[T]idak :</label>
                                </div>
                                <br>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary btn-block col-sm-3" type="button"
                                            onclick="kembali()">BACK
                                    </button>
                                    <button id="cetakMenu4" class="btn btn-success col-sm-3" type="button"
                                            onclick="cetakMenu4()">CETAK
                                    </button>
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
                                    <input class="col-sm-2 text-center form-control" type="text" id="kasirMenu5"
                                           style="text-transform:uppercase"> {{-- text-transform hanya visual, nanti di script diconvert menjadi capital sebelum data di send --}}
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">No. Station :</label>
                                    <input class="col-sm-2 text-center form-control" type="text" id="stationMenu5"
                                           style="text-transform:uppercase"> {{-- text-transform hanya visual, nanti di script diconvert menjadi capital sebelum data di send--}}
                                </div>
                                <br>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary btn-block col-sm-3" type="button"
                                            onclick="kembali()">BACK
                                    </button>
                                    <button id="cetakMenu5" class="btn btn-success col-sm-3" type="button"
                                            onclick="cetakMenu5()">CETAK
                                    </button>
                                </div>
                                <br>
                            </fieldset>
                        </div>

                        <div id="menu6" class="card-body shadow-lg cardForm" hidden>
                            <fieldset class="card border-dark">
                                <legend class="w-auto ml-5">Laporan Penjualan dengan Cashback (Per Departement)</legend>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Periode tanggal :</label>
                                    <input class="col-sm-6 text-center form-control" type="text" id="daterangepicker6">
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 text-right col-form-label">Cetak untuk :</label>
                                    <select class="form-control col-sm-6" id="cetak6">
                                        <option value="1">INDOGROSIR ALL [ IGR + (OMI/IDM)]</option>
                                        <option value="2">INDOGROSIR [ TANPA (OMI/IDM)]</option>
                                        <option value="3">(OMI/IDM) ONLY</option>
                                    </select>
                                </div>
                                <br>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary btn-block col-sm-3" type="button"
                                            onclick="kembali()">BACK
                                    </button>
                                    <button id="cetakMenu6" class="btn btn-success col-sm-3" type="button"
                                            onclick="cetakMenu6()">CETAK
                                    </button>
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
        #dropDownList {
            border: 2px black solid;
        }

        #dropDownList a {
            max-height: 100px; /* you can change as you need it */
            overflow-y: auto; /* to get scroll */
        }

        #dropDownList:hover {
            cursor: pointer;
        }

        /*Jelek kalau hanya 1 kalender*/
        /*.calendar.right {*/
        /*    display: none !important;*/
        /*}*/
    </style>
    <script>
        //-------------------- ### GLOBAL FUNCTION ### --------------------
        //DATA YANG DILOAD SEWAKTU HALAMAN BARU DIBUKA
        let cursor = ''; // Berfungsi untuk mendeteksi tombol mana yang memanggil modal
        let tableDiv; //untuk menampung data modaldiv (untuk read aja), agar isi data table nya bisa dipakai difungsi lain
        let tableDept; //untuk menampung data modaldept (untuk read aja), agar isi data table nya bisa dipakai difungsi lain
        let tableToko; //untuk menampung data modaldept (untuk read aja), agar isi data table nya bisa dipakai difungsi lain
        let tableKat; //untuk menampung data modalkat (untuk read aja), agar isi data table nya bisa dipakai difungsi lain
        let tableMon; //untuk menampung data modalmon (untuk read aja), agar isi data table nya bisa dipakai difungsi lain
        $(document).ready(function () {
            getModalDiv(); //Mengisi divModal
            getModalDept(); //Mengisi deptModal
            getModalToko(); //Mengisi tokoModal
            getModalKat(); //Mengisi katModal

            let date = $('#daterangepicker3').val();
            let dateA = date.substr(0, 10);
            let dateB = date.substr(13, 10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');
            getModalMon(dateA, dateB); //Mengisi monModal

            // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change(function () {
                tableDept.draw();
            });
            $('#jenisToko').change(function () {
                tableToko.draw();
            });
            $('#minKat, #maxKat').change(function () {
                tableKat.draw();
            });
        })

        /* Custom filtering function which will search data in column four between two values */
        //Custom Filtering untuk dept
        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {

                if (settings.nTable.id === 'tableModalDiv') {
                    return true; //no filtering on modal div
                }

                if (settings.nTable.id === 'tableModalDept') {
                    let min = parseInt($('#min').val(), 10);
                    let max = parseInt($('#max').val(), 10);
                    let val = parseFloat(data[2]) || 0; // use data for the val column, [2] maksudnya kolom ke 2, yaitu kode_div
                    //filter on table modalDept
                    if ((isNaN(min) && isNaN(max)) ||
                        (isNaN(min) && val <= max) ||
                        (min <= val && isNaN(max)) ||
                        (min <= val && val <= max)) {
                        return true;
                    }
                }

                if (settings.nTable.id === 'tableModalToko') {
                    let jenisToko = $('#jenisToko').val();
                    let val = data[4]; // use data for the val column, [4] maksudnya kolom ke 4, yaitu tko_kodesbu
                    //filter on tableToko
                    if (jenisToko == val) {
                        return true;
                    } else if (jenisToko == 'S') { //Bila 'S' maka menampilkan seluruh row
                        return true;
                    }
                }

                if (settings.nTable.id === 'tableModalKat') {
                    let min = parseInt($('#minKat').val(), 10);
                    let max = parseInt($('#maxKat').val(), 10);
                    let val = parseFloat(data[2]) || 0; // use data for the val column, [2] maksudnya kolom ke 2, yaitu kode_dept
                    //filter on table modalDept
                    if ((isNaN(min) && isNaN(max)) ||
                        (isNaN(min) && val <= max) ||
                        (min <= val && isNaN(max)) ||
                        (min <= val && val <= max)) {
                        return true;
                    }
                }

                if (settings.nTable.id === 'tableModalMon') {
                    return true; //no filtering on modal mon
                }
                return false;
            }
        );

        function getModalDiv() {
            tableDiv = $('#tableModalDiv').DataTable({ //langsung $('#tableModalDiv').DataTable({}) juga bisa, tapi pakai tableDiv untuk membaca isi di fungsi lain
                "ajax": {
                    'url': '{{ url()->current().'/getdiv' }}',
                },
                "columns": [
                    {data: 'div_kodedivisi', name: 'div_kodedivisi'},
                    {data: 'div_namadivisi', name: 'div_namadivisi'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalRowDiv');
                },
                columnDefs: [],
                "order": []
            });
        }

        function getModalDept() {
            tableDept = $('#tableModalDept').DataTable({ //langsung $('#tableModalDept').DataTable({}) juga bisa, tapi pakai tableDept untuk membaca isi di fungsi lain
                "ajax": {
                    'url': '{{ url()->current().'/getdept' }}',
                },
                "columns": [
                    {data: 'dep_kodedepartement', name: 'dep_kodedepartement'},
                    {data: 'dep_namadepartement', name: 'dep_namadepartement'},
                    {data: 'dep_kodedivisi', name: 'dep_kodedivisi', visible: false}, //hidden data, untuk memfilter data yang muncul
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalRowDept');
                },
                columnDefs: [],
                "order": []
            });
        }

        function getModalToko() {
            tableToko = $('#tableModalToko').DataTable({ //langsung $('#tableModalToko').DataTable({}) juga bisa, tapi pakai tableToko untuk membaca isi di fungsi lain
                "ajax": {
                    'url': '{{ url()->current().'/gettoko' }}',
                },
                "columns": [
                    {data: 'tko_kodeomi', name: 'tko_kodeomi'},
                    {data: 'tko_namaomi', name: 'tko_namaomi'},
                    {data: 'tko_namasbu', name: 'tko_namasbu'},
                    {data: 'tko_kodecustomer', name: 'tko_kodecustomer'},
                    {data: 'tko_kodesbu', name: 'tko_kodesbu', visible: false}, //hidden data, untuk memfilter data yang muncul
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalRowToko');
                },
                columnDefs: [],
                "order": []
            });
        }

        function getModalKat() {
            tableKat = $('#tableModalKat').DataTable({ //langsung $('#tableModalKat').DataTable({}) juga bisa, tapi pakai tableKat untuk membaca isi di fungsi lain
                "ajax": {
                    'url': '{{ url()->current().'/getkat' }}',
                },
                "columns": [
                    {data: 'kat_kodekategori', name: 'kat_kodekategori'},
                    {data: 'kat_namakategori', name: 'kat_namakategori'},
                    {data: 'kat_kodedepartement', name: 'kat_kodedepartement', visible: false}, //hidden data, untuk memfilter data yang muncul
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalRowKat');
                },
                columnDefs: [],
                "order": []
            });
        }

        function getModalMon(dateA, dateB) {
            tableMon = $('#tableModalMon').DataTable({ //langsung $('#tableModalKat').DataTable({}) juga bisa, tapi pakai tableKat untuk membaca isi di fungsi lain
                "ajax": {
                    'url': '{{ url()->current().'/getmon' }}',
                    "data": {
                        'date1': dateA,
                        'date2': dateB,
                    },
                },
                "columns": [
                    {data: 'mpl_kodemonitoring', name: 'mpl_kodemonitoring'},
                    {data: 'mpl_namamonitoring', name: 'mpl_namamonitoring'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalRowMon');
                },
                columnDefs: [],
                "order": []
            });
        }

        //    Function untuk onclick pada data modal DIV
        // IMPORTANT!!! ### BUTUH CURSOR UNTUK MENDETEKSI TOMBOL MANA YANG MEMANGGIL! ###
        $(document).on('click', '.modalRowDiv', function () {
            $('#divModal').modal('toggle');
            let currentButton = $(this);

            if (cursor.substr(0, 5) === "menu1") {
                chooseDivMenu1(currentButton);
            } else if (cursor.substr(0, 5) === "menu3") {
                chooseDivMenu3(currentButton);
            }
        });

        //    Function untuk onclick pada data modal Dept
        // IMPORTANT!!! ### BUTUH CURSOR UNTUK MENDETEKSI TOMBOL MANA YANG MEMANGGIL! ###
        $(document).on('click', '.modalRowDept', function () {
            $('#deptModal').modal('toggle');
            let currentButton = $(this);

            if (cursor.substr(0, 5) === "menu1") {
                chooseDeptMenu1(currentButton);
            } else if (cursor.substr(0, 5) === "menu3") {
                chooseDeptMenu3(currentButton);
            }
        });

        //    Function untuk onclick pada data modal Toko
        // IMPORTANT!!! ### BUTUH CURSOR UNTUK MENDETEKSI TOMBOL MANA YANG MEMANGGIL! ###
        $(document).on('click', '.modalRowToko', function () {
            $('#tokoModal').modal('toggle');
            let currentButton = $(this);

            if (cursor.substr(0, 5) === "menu2") {
                chooseTokoMenu2(currentButton);
            }
        });

        //    Function untuk onclick pada data modal Kat
        // IMPORTANT!!! ### BUTUH CURSOR UNTUK MENDETEKSI TOMBOL MANA YANG MEMANGGIL! ###
        $(document).on('click', '.modalRowKat', function () {
            $('#katModal').modal('toggle');
            let currentButton = $(this);

            if (cursor.substr(0, 5) === "menu3") {
                chooseKatMenu3(currentButton);
            }
        });

        //    Function untuk onclick pada data modal Kat
        // IMPORTANT!!! ### BUTUH CURSOR UNTUK MENDETEKSI TOMBOL MANA YANG MEMANGGIL! ###
        $(document).on('click', '.modalRowMon', function () {
            $('#monModal').modal('toggle');
            let currentButton = $(this);

            if (cursor.substr(0, 5) === "menu3") {
                chooseMonMenu3(currentButton);
            }
        });

        function kembali() {
            if ($('#menu1').is(":visible")) {
                clearMenu1();
                $('#menu1').prop("hidden", true);
                $('#mainMenu').prop("hidden", false);
            } else if ($('#menu2').is(":visible")) {
                clearMenu2();
                $('#menu2').prop("hidden", true);
                $('#mainMenu').prop("hidden", false);
            } else if ($('#menu3').is(":visible")) {
                clearMenu3();
                $('#menu3').prop("hidden", true);
                $('#mainMenu').prop("hidden", false);
            } else if ($('#menu4').is(":visible")) {
                clearMenu4();
                $('#menu4').prop("hidden", true);
                $('#mainMenu').prop("hidden", false);
            } else if ($('#menu5').is(":visible")) {
                clearMenu5();
                $('#menu5').prop("hidden", true);
                $('#mainMenu').prop("hidden", false);
            }
        }

        //Untuk periksa apakah div ada
        function checkDivExist(val) {
            for (i = 0; i < tableDiv.data().length; i++) {
                if (tableDiv.row(i).data()['div_kodedivisi'] == val) {
                    return true;
                }
            }
            return false;
        }

        //Untuk periksa apakah dept ada
        function checkDeptExist(val) {
            lowest = tableDept.row(tableDept.data().length - 1).data()['dep_kodedepartement'];
            for (i = 0; i < tableDept.data().length; i++) {
                if (tableDept.row(i).data()['dep_kodedepartement'] < lowest) {
                    if ($('#min').val() <= (tableDept.row(i).data()['dep_kodedivisi'])) {
                        lowest = i;
                    }
                }
            }
            highest = 0; //suka suka saya kasih angka berapa dong
            for (i = 0; i < tableDept.data().length; i++) {
                if (tableDept.row(i).data()['dep_kodedepartement'] > highest) {
                    if ($('#max').val() >= tableDept.row(i).data()['dep_kodedivisi']) {
                        highest = i;
                    }
                }
            }
            for (i = lowest; i <= highest; i++) {
                if (tableDept.row(i).data()['dep_kodedepartement'] == val) {
                    return true;
                }
            }
            return false;
        }

        //Untuk periksa apakah toko ada
        function checkTokoExist(val) {
            for (i = 0; i < tableToko.data().length; i++) {
                if (tableToko.row(i).data()['tko_kodeomi'] == val) {
                    if ($('#jenisToko').val() == tableToko.row(i).data()['tko_kodesbu']) {
                        return true;
                    }
                }
            }
            return false;
        }

        //Untuk periksa apakah kat ada
        function checkKatExist(val) {
            for (i = 0; i < tableKat.data().length; i++) {
                if (tableKat.row(i).data()['kat_kodekategori'] == val) {
                    if (tableKat.row(i).data()['kat_kodedepartement'] >= $('#minKat').val() && tableKat.row(i).data()['kat_kodedepartement'] <= $('#maxKat').val()) {
                        return true;
                    }
                }
            }
            return false;
        }

        //Untuk periksa apakah mon ada
        function checkMonExist(val) {
            for (i = 0; i < tableMon.data().length; i++) {
                if (tableMon.row(i).data()['mpl_kodemonitoring'] == val) {
                    return true;
                }
            }
            return false;
        }

        //-------------------- END OF ### GLOBAL FUNCTION ### --------------------

        //-------------------- SCRIPT UNTUK ### MENU MAIN ### --------------------

        function changeInput(val) {
            // SEKEDAR INFO!!!
            // val == 1, then  "LAPORAN PER KATEGORY";
            // val == 2, then  "LAPORAN PER DEPARTEMEN";
            // val == 3, then  "RINCIAN PRODUK PER DIVISI";
            // val == 4, then  "LAPORAN PER HARI";
            // val == 5, then  "LAPORAN PER KASIR";
            switch (val) {
                case 1 :
                    $('#jenisLaporan').val("LAPORAN PER KATEGORY");
                    break;
                case 2 :
                    $('#jenisLaporan').val("LAPORAN PER DEPARTEMEN");
                    break;
                case 3 :
                    $('#jenisLaporan').val("RINCIAN PRODUK PER DIVISI");
                    break;
                case 4 :
                    $('#jenisLaporan').val("LAPORAN PER HARI");
                    break;
                case 5 :
                    $('#jenisLaporan').val("LAPORAN PER KASIR");
                    break;
                case 6 :
                    $('#jenisLaporan').val("LPT DENGAN CASHBACK PER DEPARTEMENT");
                    break;
            }
        }

        // fungsi pilih() dan kembali() merupakan fungsi navigasi antar menu
        function pilih() {
            if ($('#jenisLaporan').val() == null) {
                swal('Warning', 'Belum ada yang dipilih!', 'warning');
            } else {
                switch ($('#jenisLaporan').val()) {
                    case "LAPORAN PER KATEGORY" :
                        $('#mainMenu').prop("hidden", true);
                        $('#menu1').prop("hidden", false);
                        break;
                    case "LAPORAN PER DEPARTEMEN" :
                        $('#mainMenu').prop("hidden", true);
                        $('#menu2').prop("hidden", false);
                        break;
                    case "RINCIAN PRODUK PER DIVISI" :
                        $('#mainMenu').prop("hidden", true);
                        $('#menu3').prop("hidden", false);
                        break;
                    case "LAPORAN PER HARI" :
                        $('#mainMenu').prop("hidden", true);
                        $('#menu4').prop("hidden", false);
                        break;
                    case "LAPORAN PER KASIR" :
                        $('#mainMenu').prop("hidden", true);
                        $('#menu5').prop("hidden", false);
                        break;
                    case "LPT DENGAN CASHBACK PER DEPARTEMENT" :
                        $('#mainMenu').prop("hidden", true);
                        $('#menu6').prop("hidden", false);
                        break;
                }
            }
        }

        //-------------------- END OF SCRIPT ### MENU MAIN ### --------------------

        ////merubah format date range picker Tidak pakai
        // $(function() {
        //     $("#daterangepicker").daterangepicker({
        //         locale: {
        //             format: 'DD/MM/YYYY'
        //         }
        //     });
        // });

        //-------------------- SCRIPT UNTUK ### MENU 1 ### --------------------
        //Menggerakkan cursor
        $("#menu1 :button").click(function () {
            cursor = this.id;
        });

        //fungsi date menu1
        $('#daterangepicker1').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function (start, end, label) { //untuk mendeteksi bila perubahan tidak dibulan yang sama ketika melakukan perubahan
            if (start.format('YYYY') !== end.format('YYYY') || start.format('MM') !== end.format('MM')) {
                swal({
                    title: 'Periode Bulan',
                    text: 'Bulan Periode Tanggal harus sama.',
                    icon: 'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#daterangepicker1').data('daterangepicker').setStartDate(start.format('DD/MM/YYYY'));
                    $('#daterangepicker1').data('daterangepicker').setEndDate(start.format('DD/MM/YYYY'));
                    $('#daterangepicker1').select();
                });
            } else {
                $('#yaTidakMenu1').focus(); //focus ke kolom berikutnya
            }
            //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        function isYT(evt) { //membatasi input untuk hanya boleh Y dan T, serta mendeteksi bila menekan tombol enter
            $('#yaTidakMenu1').keyup(function () {
                $(this).val($(this).val().toUpperCase());
            });
            let charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 121) // y kecil
                return 89; // Y besar

            if (charCode == 116) // t kecil
                return 84; //t besar

            if (charCode == 89 || charCode == 84)
                return true
            // if (charCode == 13){
            //     khususElektronik();
            //
            //     //Fokus ke kolom berikutnya
            //     if($('#yaTidakMenu1').val() == 'Y'){
            //         $('#menu1divA1').focus();
            //     }else if($('#yaTidakMenu1').val() == 'T'){
            //         $('#menu1divB1').focus();
            //     }
            //
            //     return true
            // }
            return false;
        }

        $('#yaTidakMenu1').on('keypress', function () {
            khususElektronik();
        });

        function khususElektronik() { //untuk memperiksa apakah kolom khusus elektronik Y,T, atau kosong, lalu menampilkan div/dept sesuai input #yaTidakMenu1
            switch ($('#yaTidakMenu1').val()) {
                case '':
                    $('#divA').prop("hidden", true);
                    $('#divB').prop("hidden", true);

                    $('#deptA').prop("hidden", true);
                    $('#deptB').prop("hidden", true);
                    break;
                case 'Y':
                    $('#divA').prop("hidden", false);
                    $('#divA').prop("disabled", false);
                    $('#divB').prop("hidden", true);

                    $('#deptA').prop("hidden", false);
                    $('#deptB').prop("hidden", true);
                    break;
                case 'T':
                    $('#divA').prop("hidden", true);
                    $('#divB').prop("hidden", false);

                    $('#deptA').prop("hidden", true);
                    $('#deptB').prop("hidden", false);
                    break;
            }
        }

        //Fungsi memilih div, dipanggil oleh onclick dari .modalRowDiv
        function chooseDivMenu1(val) {
            let kodedivisi = val.children().first().text();
            //let namadivisi = currentButton.children().first().next().text(); //ga pakai, yang kepakai kodedivisi doang
            switch (cursor.substr(5, 5)) {
                case "A1div":
                    $('#menu1divA1').val(kodedivisi);
                    setTimeout(function () { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                        $('#menu1divA1').focus();
                    }, 10);

                    break;
                case "A2div":
                    $('#menu1divA2').val(kodedivisi);
                    setTimeout(function () {
                        $('#menu1divA2').focus();
                    }, 10);
                    break;
                case "A3div":
                    $('#menu1divA3').val(kodedivisi);
                    setTimeout(function () {
                        $('#menu1divA3').focus();
                    }, 10);
                    break;
                case "B1div":
                    $('#menu1divB1').val(kodedivisi);
                    setTimeout(function () {
                        $('#menu1divB1').focus();
                    }, 10);
                    break;
                case "B2div":
                    $('#menu1divB2').val(kodedivisi);
                    setTimeout(function () {
                        $('#menu1divB2').focus();
                    }, 10);
                    break;
            }
        }

        //Fungsi memilih dept, dipanggil oleh onclick dari .modalRowDept
        function chooseDeptMenu1(val) {
            let kodedepartemen = val.children().first().text();
            //let namadepartemen = currentButton.children().first().next().text(); //ga pakai, yang kepakai kodedivisi doang
            switch (cursor.substr(5, 6)) {
                case "A1dept":
                    $('#menu1deptA1').val(kodedepartemen);
                    setTimeout(function () { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                        $('#menu1deptA1').focus();
                    }, 10);

                    break;
                case "A2dept":
                    $('#menu1deptA2').val(kodedepartemen);
                    setTimeout(function () {
                        $('#menu1deptA2').focus();
                    }, 10);
                    break;
                case "A3dept":
                    $('#menu1deptA3').val(kodedepartemen);
                    setTimeout(function () {
                        $('#menu1deptA3').focus();
                    }, 10);
                    break;
                case "A4dept":
                    $('#menu1deptA4').val(kodedepartemen);
                    setTimeout(function () {
                        $('#menu1deptA4').focus();
                    }, 10);
                    break;
                case "B1dept":
                    $('#menu1deptB1').val(kodedepartemen).change();
                    setTimeout(function () {
                        $('#menu1deptB1').focus();
                    }, 10);
                    break;
                case "B2dept":
                    $('#menu1deptB2').val(kodedepartemen).change();
                    setTimeout(function () {
                        $('#menu1deptB2').focus();
                    }, 10);
                    break;
            }
        }

        //Fungsi enter Input Div
        //Menu Div A
        $('#menu1divA1').on('keypress', function (e) {
            if (e.which == 13) {
                if ($('#menu1divA1').val() == '') {
                    swal({
                        title: 'Warning',
                        text: 'Data Divisi tidak boleh kosong!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1divA1').focus();
                    })
                    return false;
                } else if (!checkDivExist($('#menu1divA1').val())) {
                    swal({
                        title: 'Warning',
                        text: 'Data Divisi Salah!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1divA1').select();
                    })
                    return false;
                } else {
                    check3div();
                    $('#menu1divA2').focus();
                }
            }
        });
        $('#menu1divA1').on('change', function (e) {
            if (!checkDivExist($('#menu1divA1').val())) {
                swal({
                    title: 'Warning',
                    text: 'Data Divisi Salah!',
                    icon: 'warning',
                }).then(function () {
                    $('#menu1divA1').select();
                })
                return false;
            } else {
                check3div();
            }
        });
        $('#menu1divA2').on('keypress', function (e) {
            if (e.which == 13) {
                if ($('#menu1divA2').val() == '') {
                    swal({
                        title: 'Warning',
                        text: 'Data Divisi tidak boleh kosong!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1divA2').focus();
                    })
                    return false;
                } else if (!checkDivExist($('#menu1divA2').val())) {
                    swal({
                        title: 'Warning',
                        text: 'Data Divisi Salah!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1divA2').select();
                    })
                    return false;
                } else {
                    check3div();
                    $('#menu1divA3').focus();
                }
            }
        });
        $('#menu1divA2').on('change', function (e) {
            if (!checkDivExist($('#menu1divA2').val())) {
                swal({
                    title: 'Warning',
                    text: 'Data Divisi Salah!',
                    icon: 'warning',
                }).then(function () {
                    $('#menu1divA2').select();
                })
                return false;
            } else {
                check3div();
            }
        });
        $('#menu1divA3').on('keypress', function (e) {
            if (e.which == 13) {
                if ($('#menu1divA3').val() == '') {
                    swal({
                        title: 'Warning',
                        text: 'Data Divisi tidak boleh kosong!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1divA3').focus();
                    })
                    return false;
                } else if (!checkDivExist($('#menu1divA3').val())) {
                    swal({
                        title: 'Warning',
                        text: 'Data Divisi Salah!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1divA3').select();
                    })
                    return false;
                } else {
                    check3div();
                    if ($('#menu1divA1').val() == '3' || $('#menu1divA2').val() == '3' || $('#menu1divA3').val() == '3') {
                        $('#menu1deptA1').focus();
                    } else {
                        $('#menu1Cetak').focus();
                    }
                }
            }
        });
        $('#menu1divA3').on('change', function (e) {
            if (!checkDivExist($('#menu1divA3').val())) {
                swal({
                    title: 'Warning',
                    text: 'Data Divisi Salah!',
                    icon: 'warning',
                }).then(function () {
                    $('#menu1divA3').select();
                })
                return false;
            } else {
                check3div();
            }
        });

        //Menu Div B
        $('#menu1divB1').on('keypress', function (e) {
            if (e.which == 13) {
                if ($('#menu1divB1').val() == '') {
                    lowest = tableDiv.row(0).data()['div_kodedivisi'];
                    for (i = 0; i < tableDiv.data().length; i++) {
                        if (tableDiv.row(i).data()['div_kodedivisi'] < lowest) {
                            lowest = tableDiv.row(i).data()['div_kodedivisi'];
                        }
                    }
                    $('#menu1divB1').val(lowest);
                    $('#min').val(lowest).change(); //isi filter min
                    $('#menu1divB2').focus();
                } else if (!checkDivExist($('#menu1divB1').val())) {
                    swal({
                        title: 'Warning',
                        text: 'Data Divisi Salah!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1divB1').select();
                    })
                    return false;
                } else {
                    $('#min').val($('#menu1divB1').val()).change(); //isi filter min
                    $('#menu1divB2').focus();
                }
            }
        });
        $('#menu1divB1').on('change', function (e) {
            if (!checkDivExist($('#menu1divB1').val())) {
                swal({
                    title: 'Warning',
                    text: 'Data Divisi Salah!',
                    icon: 'warning',
                }).then(function () {
                    $('#menu1divB1').select();
                })
                return false;
            } else {
                $('#min').val($('#menu1divB1').val()).change(); //isi filter min
            }
        });
        $('#menu1divB2').on('keypress', function (e) {
            if (e.which == 13) {
                if ($('#menu1divB2').val() == '') {
                    highest = tableDiv.row(0).data()['div_kodedivisi'];
                    for (i = 0; i < tableDiv.data().length; i++) {
                        if (tableDiv.row(i).data()['div_kodedivisi'] > highest) {
                            highest = tableDiv.row(i).data()['div_kodedivisi'];
                        }
                    }
                    $('#menu1divB2').val(highest);
                    $('#max').val(highest).change(); //isi filter max
                    $('#menu1deptB1').focus();
                } else if (!checkDivExist($('#menu1divB2').val())) {
                    swal({
                        title: 'Warning',
                        text: 'Data Divisi Salah!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1divB2').select();
                    })
                    return false;
                } else {
                    $('#max').val($('#menu1divB2').val()).change(); //isi filter max
                    $('#menu1deptB1').focus();
                }
            }
        });
        $('#menu1divB2').on('change', function (e) {
            if (!checkDivExist($('#menu1divB2').val())) {
                swal({
                    title: 'Warning',
                    text: 'Data Divisi Salah!',
                    icon: 'warning',
                }).then(function () {
                    $('#menu1divB2').select();
                })
                return false;
            } else {
                $('#max').val($('#menu1divB2').val()).change(); //isi filter max
            }
        });

        //fungsi untuk periksa apakah ada div 3 dipilih dan enable input dept, dan disable bila tidak ada
        function check3div() { //khusus menu 1 dan khusus elektronik
            if ($('#menu1divA1').val() == '3' || $('#menu1divA2').val() == '3' || $('#menu1divA3').val() == '3') {
                //enable kolom input
                $('#menu1deptA1').prop('disabled', false);
                $('#menu1deptA2').prop('disabled', false);
                $('#menu1deptA3').prop('disabled', false);
                $('#menu1deptA4').prop('disabled', false);
                //enable button
                $('#menu1A1dept').prop('disabled', false);
                $('#menu1A2dept').prop('disabled', false);
                $('#menu1A3dept').prop('disabled', false);
                $('#menu1A4dept').prop('disabled', false);

                $('#min').val('3').change(); //isi filter min
                $('#max').val('3').change(); //isi filter max
            } else {
                //disable kolom input
                $('#menu1deptA1').prop('disabled', true);
                $('#menu1deptA2').prop('disabled', true);
                $('#menu1deptA3').prop('disabled', true);
                $('#menu1deptA4').prop('disabled', true);
                //disable button
                $('#menu1A1dept').prop('disabled', true);
                $('#menu1A2dept').prop('disabled', true);
                $('#menu1A3dept').prop('disabled', true);
                $('#menu1A4dept').prop('disabled', true);

                $('#min').val('').change(); //hapus filter min
                $('#max').val('').change(); //hapus filter max
            }
        }

        //Fungsi enter Input Dept
        //Menu Dept A
        $('#menu1deptA1').on('keypress', function (e) {
            if (e.which == 13) {
                if ($('#menu1deptA1').val() == '') {
                    swal({
                        title: 'Warning',
                        text: 'Data Departemen tidak boleh kosong bila salah satu divisi mengandung 3!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1deptA1').focus();
                    })
                    return false;
                } else if (!checkDeptExist($('#menu1deptA1').val())) {
                    swal({
                        title: 'Warning',
                        text: 'Data Departemen Salah!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1deptA1').select();
                    })
                    return false;
                } else {
                    $('#menu1deptA2').focus();
                }
            }
        });
        $('#menu1deptA1').on('change', function (e) {
            if (!checkDeptExist($('#menu1deptA1').val())) {
                swal({
                    title: 'Warning',
                    text: 'Data Departemen Salah!',
                    icon: 'warning',
                }).then(function () {
                    $('#menu1deptA1').select();
                })
                return false;
            }
        });
        $('#menu1deptA2').on('keypress', function (e) {
            if (e.which == 13) {
                if ($('#menu1deptA2').val() == '') {
                    swal({
                        title: 'Warning',
                        text: 'Data Departemen tidak boleh kosong bila salah satu divisi mengandung 3!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1deptA2').focus();
                    })
                    return false;
                } else if (!checkDeptExist($('#menu1deptA2').val())) {
                    swal({
                        title: 'Warning',
                        text: 'Data Departemen Salah!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1deptA2').select();
                    })
                    return false;
                } else {
                    $('#menu1deptA3').focus();
                }
            }
        });
        $('#menu1deptA2').on('change', function (e) {
            if (!checkDeptExist($('#menu1deptA2').val())) {
                swal({
                    title: 'Warning',
                    text: 'Data Departemen Salah!',
                    icon: 'warning',
                }).then(function () {
                    $('#menu1deptA2').select();
                })
                return false;
            }
        });
        $('#menu1deptA3').on('keypress', function (e) {
            if (e.which == 13) {
                if ($('#menu1deptA3').val() == '') {
                    swal({
                        title: 'Warning',
                        text: 'Data Departemen tidak boleh kosong bila salah satu divisi mengandung 3!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1deptA3').focus();
                    })
                    return false;
                } else if (!checkDeptExist($('#menu1deptA3').val())) {
                    swal({
                        title: 'Warning',
                        text: 'Data Departemen Salah!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1deptA3').select();
                    })
                    return false;
                } else {
                    $('#menu1deptA4').focus();
                }
            }
        });
        $('#menu1deptA3').on('change', function (e) {
            if (!checkDeptExist($('#menu1deptA3').val())) {
                swal({
                    title: 'Warning',
                    text: 'Data Departemen Salah!',
                    icon: 'warning',
                }).then(function () {
                    $('#menu1deptA3').select();
                })
                return false;
            }
        });
        $('#menu1deptA4').on('keypress', function (e) {
            if (e.which == 13) {
                if ($('#menu1deptA4').val() == '') {
                    swal({
                        title: 'Warning',
                        text: 'Data Departemen tidak boleh kosong bila salah satu divisi mengandung 3!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1deptA4').focus();
                    })
                    return false;
                } else if (!checkDeptExist($('#menu1deptA4').val())) {
                    swal({
                        title: 'Warning',
                        text: 'Data Departemen Salah!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1deptA4').select();
                    })
                    return false;
                } else {
                    $('#menu1Cetak').focus();
                }
            }
        });
        $('#menu1deptA4').on('change', function (e) {
            if (!checkDeptExist($('#menu1deptA4').val())) {
                swal({
                    title: 'Warning',
                    text: 'Data Departemen Salah!',
                    icon: 'warning',
                }).then(function () {
                    $('#menu1deptA4').select();
                })
                return false;
            }
        });

        //Menu Dept B
        $('#menu1deptB1').on('keypress', function (e) {
            if (e.which == 13) {
                if ($('#menu1divB1').val() == '' || $('#menu1divB2').val() == '') {
                    swal({
                        title: 'Warning',
                        text: 'Data Divisi ada yang Kosong!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1divB1').focus();
                    })
                    return false;
                } else if ($('#menu1deptB1').val() == '') {
                    lowest = tableDept.row(tableDept.data().length - 1).data()['dep_kodedepartement'];
                    for (i = 0; i < tableDept.data().length; i++) {
                        if (tableDept.row(i).data()['dep_kodedepartement'] < lowest) {
                            if ($('#min').val() <= (tableDept.row(i).data()['dep_kodedivisi'])) {
                                lowest = tableDept.row(i).data()['dep_kodedepartement'];
                            }
                        }
                    }
                    $('#menu1deptB1').val(lowest);
                    $('#menu1deptB2').focus();
                } else if (!checkDeptExist($('#menu1deptB1').val())) {
                    swal({
                        title: 'Warning',
                        text: 'Data Departemen Salah!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1deptB1').select();
                    })
                    return false;
                } else {
                    $('#menu1deptB2').focus();
                }
            }
        });
        $('#menu1deptB1').on('change', function (e) {
            if ($('#menu1divB1').val() == '' || $('#menu1divB2').val() == '') {
                swal({
                    title: 'Warning',
                    text: 'Data Divisi ada yang Kosong!',
                    icon: 'warning',
                }).then(function () {
                    $('#menu1deptB1').val('');
                    $('#menu1divB1').focus();
                })
                return false;
            } else if (!checkDeptExist($('#menu1deptB1').val())) {
                swal({
                    title: 'Warning',
                    text: 'Data Departemen Salah!',
                    icon: 'warning',
                }).then(function () {
                    $('#menu1deptB1').select();
                })
                return false;
            }
        });

        $('#menu1deptB2').on('keypress', function (e) {
            if (e.which == 13) {
                if ($('#menu1divB1').val() == '' || $('#menu1divB2').val() == '') {
                    swal({
                        title: 'Warning',
                        text: 'Data Divisi ada yang Kosong!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1divB1').focus();
                    })
                    return false;
                } else if ($('#menu1deptB2').val() == '') {
                    highest = 0; //suka suka saya kasih angka berapa dong
                    for (i = 0; i < tableDept.data().length; i++) {
                        if (tableDept.row(i).data()['dep_kodedepartement'] > highest) {
                            if ($('#max').val() >= tableDept.row(i).data()['dep_kodedivisi']) {
                                highest = tableDept.row(i).data()['dep_kodedepartement'];
                            }
                        }
                    }
                    $('#menu1deptB2').val(highest);
                    $('#menu1Cetak').focus();
                } else if (!checkDeptExist($('#menu1deptB2').val())) {
                    swal({
                        title: 'Warning',
                        text: 'Data Departemen Salah!',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1deptB2').select();
                    })
                    return false;
                } else {
                    $('#menu1Cetak').focus();
                }
            }
        });
        $('#menu1deptB2').on('change', function (e) {
            if ($('#menu1divB1').val() == '' || $('#menu1divB2').val() == '') {
                swal({
                    title: 'Warning',
                    text: 'Data Divisi ada yang Kosong!',
                    icon: 'warning',
                }).then(function () {
                    $('#menu1deptB2').val('');
                    $('#menu1divB1').focus();
                })
                return false;
            } else if (!checkDeptExist($('#menu1deptB2').val())) {
                swal({
                    title: 'Warning',
                    text: 'Data Departemen Salah!',
                    icon: 'warning',
                }).then(function () {
                    $('#menu1deptB2').select();
                })
                return false;
            } else {
                $('#menu1Cetak').focus();
            }
        });

        //fungsi cetak menu 1
        function cetakMenu1() {
            let date = $('#daterangepicker1').val();
            if (date == null || date == "") {
                swal('Periode tidak boleh kosong', '', 'warning');
                return false;
            }
            let dateA = date.substr(0, 10);
            let dateB = date.substr(13, 10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');

            if ($('#yaTidakMenu1').val() == '') {
                swal({
                    title: 'Warning',
                    text: 'Input tidak boleh kosong!',
                    icon: 'warning',
                }).then(function () {
                    $('#yaTidakMenu1').focus();
                })
                return false;
            } else if ($('#yaTidakMenu1').val() == 'Y') {
                if ($('#menu1divA1').val() == '' || $('#menu1divA2').val() == '' || $('#menu1divA3').val() == '') {
                    swal({
                        title: 'Warning',
                        text: 'Divisi Tidak Boleh Kosong',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1divA3').focus();
                    })
                    return false;
                } else if ($('#menu1divA1').val() == '3' || $('#menu1divA2').val() == '3' || $('#menu1divA3').val() == '3') {
                    if ($('#menu1deptA1').val() == '' || $('#menu1deptA2').val() == '' || $('#menu1deptA3').val() == '' || $('#menu1deptA4').val() == '') {
                        swal({
                            title: 'Warning',
                            text: 'Jika Divisi = 3 , Departemen Tidak Boleh Kosong !',
                            icon: 'warning',
                        }).then(function () {
                            $('#menu1deptA1').focus();
                        })
                        return false;
                    }
                }
                //Periksa apakah data divisi ada di daftar nilai divisi atau tidak
                if (!checkDivExist($('#menu1divA1').val())) {
                    swal({
                        title: 'Warning',
                        text: 'Data divisi salah',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1divA1').select();
                    })
                    return false;
                } else if (!checkDivExist($('#menu1divA2').val())) {
                    swal({
                        title: 'Warning',
                        text: 'Data divisi salah',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1divA2').select();
                    })
                    return false;
                } else if (!checkDivExist($('#menu1divA3').val())) {
                    swal({
                        title: 'Warning',
                        text: 'Data divisi salah',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu1divA3').select();
                    })
                    return false;
                } else {
                    //Periksa apakah data departemen ada di daftar nilai departemen atau tidak bila ada if yang mengandung 3
                    if ($('#menu1divA1').val() == '3' || $('#menu1divA2').val() == '3' || $('#menu1divA3').val() == '3') {
                        if (!checkDeptExist($('#menu1deptA1').val())) {
                            swal({
                                title: 'Warning',
                                text: 'Data departemen salah',
                                icon: 'warning',
                            }).then(function () {
                                $('#menu1deptA1').select();
                            })
                            return false;
                        } else if (!checkDeptExist($('#menu1deptA2').val())) {
                            swal({
                                title: 'Warning',
                                text: 'Data departemen salah',
                                icon: 'warning',
                            }).then(function () {
                                $('#menu1deptA2').select();
                            })
                            return false;
                        } else if (!checkDeptExist($('#menu1deptA3').val())) {
                            swal({
                                title: 'Warning',
                                text: 'Data departemen salah',
                                icon: 'warning',
                            }).then(function () {
                                $('#menu1deptA3').select();
                            })
                            return false;
                        } else if (!checkDeptExist($('#menu1deptA4').val())) {
                            swal({
                                title: 'Warning',
                                text: 'Data departemen salah',
                                icon: 'warning',
                            }).then(function () {
                                $('#menu1deptA4').select();
                            })
                            return false;
                        }
                    }
                }
            } else {
                if ($('#menu1divB1').val() == '' || !checkDivExist($('#menu1divB1').val())) { //bila data div salah diubah jadi 1
                    $('#menu1divB1').val('1');
                    $('#min').val('1').change();
                }
                if ($('#menu1divB2').val() == '' || !checkDivExist($('#menu1divB2').val())) { //bila data div salah diubah jadi divisi tertinggi
                    highest = tableDiv.row(0).data()['div_kodedivisi'];
                    for (i = 0; i < tableDiv.data().length; i++) {
                        if (tableDiv.row(i).data()['div_kodedivisi'] > highest) {
                            highest = tableDiv.row(i).data()['div_kodedivisi'];
                        }
                    }
                    $('#menu1divB2').val(highest);
                    $('#max').val(highest).change();
                }
                if ($('#menu1deptB1').val() == '' || !checkDeptExist($('#menu1deptB1').val())) { //bila data dept salah diubah jadi 01
                    lowest = tableDept.row(tableDept.data().length - 1).data()['dep_kodedepartement'];
                    for (i = 0; i < tableDept.data().length; i++) {
                        if (tableDept.row(i).data()['dep_kodedepartement'] < lowest) {
                            if ($('#min').val() <= (tableDept.row(i).data()['dep_kodedivisi'])) {
                                lowest = tableDept.row(i).data()['dep_kodedepartement'];
                            }
                        }
                    }
                    $('#menu1deptB1').val(lowest);
                }
                if ($('#menu1deptB2').val() == '' || !checkDeptExist($('#menu1deptB2').val())) { //bila data dept salah diubah jadi departemen tertinggi
                    //$('#menu1deptB2').val('53');
                    highest = 0; //suka suka saya kasih angka berapa dong
                    for (i = 0; i < tableDept.data().length; i++) {
                        if (tableDept.row(i).data()['dep_kodedepartement'] > highest) {
                            if ($('#max').val() >= tableDept.row(i).data()['dep_kodedivisi']) {
                                highest = tableDept.row(i).data()['dep_kodedepartement'];
                            }
                        }
                    }
                    $('#menu1deptB2').val(highest);
                }
            }

            //kondisi untuk menampilkan qty/tidak lalu cetak
            let qty = 'T';
            if ($('#yaTidakMenu1').val() == 'Y') {
                qty = 'Y';
                //cetak_lap_jual_kategory_y
                window.open(`{{ url()->current() }}/printdocumentmenu1?date1=${dateA}&date2=${dateB}&qty=${qty}&dept1=${$('#menu1deptA1').val()}&dept2=${$('#menu1deptA2').val()}&dept3=${$('#menu1deptA3').val()}&dept4=${$('#menu1deptA4').val()}&div1=${$('#menu1divA1').val()}&div2=${$('#menu1divA2').val()}&div3=${$('#menu1divA3').val()}&elek=Y`, '_blank');
                kembali();
            } else {
                //cetak_lap_jual_kategory_t
                swal("Qty untuk tiap-tiap Dept/Kategori ikut dicetak ?", {
                    buttons: {
                        ya: {
                            text: "Ya",
                            value: "Yes",
                        },
                        tidak: {
                            text: "Tidak",
                            value: "No",
                        },
                    },
                })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                qty = 'Y';
                                break;

                            case "No":
                                qty = 'T';
                                break;
                        }// bila tidak menekan salah satu tombol maka qty akan dianggap 'T' mengikuti nilai qty deklarasi awal

                        //cetak_lap_jual_kategory_t
                        window.open(`{{ url()->current() }}/printdocumentmenu1?date1=${dateA}&date2=${dateB}&qty=${qty}&dept1=${$('#menu1deptB1').val()}&dept2=${$('#menu1deptB2').val()}&div1=${$('#menu1divB1').val()}&div2=${$('#menu1divB2').val()}&elek=T`, '_blank');
                        kembali();
                    });
            }
        }

        //Clear Input Menu 1
        function clearMenu1() {
            $('#menu1 input').val('');
            $('#daterangepicker1').data('daterangepicker').setStartDate(moment().format('DD/MM/YYYY'));
            $('#daterangepicker1').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));

            //$('#divA input').prop('disabled',true);
            //$('#divA button').prop('disabled',true);
            $('#deptA input').prop('disabled', true);
            $('#deptA button').prop('disabled', true);

            $('#divA').prop('hidden', true);
            $('#divB').prop('hidden', true);
            $('#deptA').prop('hidden', true);
            $('#deptB').prop('hidden', true);

            $('#min').val('').change();
            $('#max').val('').change();
        }

        //-------------------- END OF SCRIPT ### MENU 1 ### --------------------

        //-------------------- SCRIPT UNTUK ### MENU 2 ### --------------------
        let menu2Grosir = '';
        let menu2UnitSBU = '';
        let menu2GrosirA = '';

        //Menggerakkan cursor
        $("#menu2 :button").click(function () {
            cursor = this.id;
        });

        //fungsi date menu2
        $('#daterangepicker2').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function (start, end, label) { //untuk mendeteksi bila perubahan tidak dibulan yang sama ketika melakukan perubahan
            if (start.format('YYYY') !== end.format('YYYY') || start.format('MM') !== end.format('MM')) {
                swal({
                    title: 'Periode Bulan',
                    text: 'Bulan Periode Tanggal harus sama.',
                    icon: 'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#daterangepicker2').data('daterangepicker').setStartDate(start.format('DD/MM/YYYY'));
                    $('#daterangepicker2').data('daterangepicker').setEndDate(start.format('DD/MM/YYYY'));
                    $('#daterangepicker2').select();
                });
            } else {
                $('#export').focus(); //focus ke kolom berikutnya
            }
            //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        function isYTMenu2(evt) { //membatasi input untuk hanya boleh Y dan T, serta mendeteksi bila menekan tombol enter
            $('#export').keyup(function () {
                $(this).val($(this).val().toUpperCase());
            });
            let charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 121) // y kecil
                return 89; // Y besar

            if (charCode == 116) // t kecil
                return 84; //t besar

            if (charCode == 89 || charCode == 84)
                return true
            if (charCode == 13) {
                $('#export').change();
                return true
            }
            return false;
        }

        $('#export').on('change', function () {
            if ($('#export').val() == 'Y') {
                menu2Grosir = 'T';
                menu2UnitSBU = 'F';
                menu2GrosirA = 'T';
                $('#menu2Ext').prop('hidden', true);
                $('#menu2Ext input').val('');
                $('#menu2Ext2').prop('hidden', true);
                $('#menu2Ext2 input').val('');
                $('#menu2Ext3').prop('hidden', true);
                $('#menu2Ext3 input').val('');
                $('#menu2Cetak').focus();
            } else {
                menu2Grosir = '';
                menu2UnitSBU = '';
                menu2GrosirA = '';
                $('#jenisToko').val('S').change();
                $('#menu2Ext').prop('hidden', false);
                $('#menu2Ext input').val('');
                $('#menu2Ext2').prop('hidden', true);
                $('#menu2Ext2 input').val('');
                $('#menu2Ext3').prop('hidden', true);
                $('#menu2Ext3 input').val('');
            }
        });

        function lstPrint(val) {
            // SEKEDAR INFO!!!
            // val == 1, then  "INDOGROSIR ALL [IGR + (OMI/IDM)]";
            // val == 2, then  "INDOGROSIR [TANPA (OMI/IDM)]";
            // val == 3, then  "OMI/IDM PER TOKO";
            // val == 4, then  "OMI/IDM GABUNGAN ALL TOKO";
            // val == 5, then  "GABUNGAN ALL TOKO OMI KHUSUS";
            switch (val) {
                case 1 :
                    menu2Grosir = 'T';
                    menu2UnitSBU = 'F';
                    menu2GrosirA = 'T';
                    $('#lstPrint').val("INDOGROSIR ALL [IGR + (OMI/IDM)]");
                    $('#lstPrintHidden').val("1");
                    $('#menu2Ext2').prop('hidden', true);
                    $('#menu2Ext3').prop('hidden', true);
                    $('#menu2Cetak').focus();
                    break;
                case 2 :
                    menu2Grosir = 'T';
                    menu2UnitSBU = 'F';
                    menu2GrosirA = 'F';
                    $('#lstPrint').val("INDOGROSIR [TANPA (OMI/IDM)]");
                    $('#lstPrintHidden').val("2");
                    $('#menu2Ext2').prop('hidden', true);
                    $('#menu2Ext3').prop('hidden', true);
                    $('#menu2Cetak').focus();
                    break;
                case 3 :
                    menu2Grosir = 'F';
                    menu2UnitSBU = 'T';
                    menu2GrosirA = 'F';
                    $('#lstPrint').val("OMI/IDM PER TOKO");
                    $('#lstPrintHidden').val("3");
                    $('#menu2Ext2').prop('hidden', false);
                    $('#menu2Ext3').prop('hidden', false);
                    break;
                case 4 :
                    menu2Grosir = 'F';
                    menu2UnitSBU = 'T';
                    menu2GrosirA = 'T';
                    $('#lstPrint').val("OMI/IDM GABUNGAN ALL TOKO");
                    $('#lstPrintHidden').val("4");
                    $('#menu2Ext2').prop('hidden', false);
                    $('#menu2Ext3').prop('hidden', true);
                    break;
                case 5 :
                    menu2Grosir = 'F';
                    menu2UnitSBU = 'T';
                    menu2GrosirA = 'T';
                    $('#lstPrint').val("GABUNGAN ALL TOKO OMI KHUSUS");
                    $('#lstPrintHidden').val("5");
                    $('#menu2Ext2').prop('hidden', true);
                    $('#menu2Ext3').prop('hidden', true);
                    break;
            }
        }

        function isOISMenu2(evt) { //membatasi input untuk hanya boleh O dan I dan S, serta mendeteksi bila menekan tombol enter
            $('#sbu').keyup(function () {
                $(this).val($(this).val().toUpperCase());
            });
            let charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 111) // o kecil
                return 79; // O besar

            if (charCode == 105) // i kecil
                return 73; //i besar

            if (charCode == 115) // s kecil
                return 83; //s besar

            if (charCode == 79 || charCode == 73 || charCode == 83)
                return true

            if (charCode == 13) {
                if ($('#sbu').val() == 'O' || $('#sbu').val() == 'I' || $('#sbu').val() == 'S') {
                    $('#jenisToko').val($('#sbu').val()).change(); //isi filter jenisToko
                    $('#menu2TokoInput').focus();
                    $('#menu2TokoInput').val('');
                    $('#dis_omi').val('');
                }
                return true
            }
            return false;
        }

        $('#sbu').on('change', function (e) {
            if ($('#sbu').val() == 'O' || $('#sbu').val() == 'I' || $('#sbu').val() == 'S') {
                $('#jenisToko').val($('#sbu').val()).change(); //isi filter jenisToko
                //$('#menu2TokoInput').focus();
                $('#menu2TokoInput').val('');
                $('#dis_omi').val('');
            }
        });

        function chooseTokoMenu2(val) {
            let kodeToko = val.children().first().text();
            $('#menu2TokoInput').val(kodeToko);
            setTimeout(function () { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                $('#menu2TokoInput').focus();
            }, 10);
        }

        $('#menu2TokoInput').on('keypress', function (e) {
            if (e.which == 13) {
                if ($('#menu2TokoInput').val() == '') {
                    $('#menu2TokoInput').val('SEMUA');
                    $('#dis_omi').val('SEMUA');
                    $('#menu2Cetak').focus();
                    return true;
                } else if (!checkTokoExist($('#menu2TokoInput').val())) {
                    swal({
                        title: 'Warning',
                        text: 'Kode Toko tidak sesuai',
                        icon: 'warning',
                    }).then(function () {
                        $('#menu2TokoInput').val('');
                        $('#dis_omi').val('');
                        $('#menu2TokoInput').focus();
                    })
                    return false;
                } else {
                    for (i = 0; i < tableToko.data().length; i++) {
                        if (tableToko.row(i).data()['tko_kodeomi'] == $('#menu2TokoInput').val()) {
                            $('#dis_omi').val(tableToko.row(i).data()['tko_namaomi'] + ' - ' + tableToko.row(i).data()['tko_kodecustomer']);
                            break;
                        }
                    }
                    $('#menu2Cetak').focus();
                }
            }
        });
        $('#menu2TokoInput').on('change', function (e) {
            if ($('#sbu').val() == '') {
                swal({
                    title: 'Warning',
                    text: 'Kode SBU masih kosong!',
                    icon: 'warning',
                }).then(function () {
                    $('#menu2TokoInput').val('');
                    $('#dis_omi').val('');
                    $('#menu2TokoInput').focus();
                })
                return false
            }
            if (!checkTokoExist($('#menu2TokoInput').val())) {
                swal({
                    title: 'Warning',
                    text: 'Kode Toko tidak sesuai',
                    icon: 'warning',
                }).then(function () {
                    $('#menu2TokoInput').val('');
                    $('#dis_omi').val('');
                    $('#menu2TokoInput').focus();
                })
                return false;
            } else {
                for (i = 0; i < tableToko.data().length; i++) {
                    if (tableToko.row(i).data()['tko_kodeomi'] == $('#menu2TokoInput').val()) {
                        $('#dis_omi').val(tableToko.row(i).data()['tko_namaomi'] + ' - ' + tableToko.row(i).data()['tko_kodecustomer']);
                        break;
                    }
                }
                $('#menu2Cetak').focus();
            }
        });

        function cetakMenu2() {
            let date = $('#daterangepicker2').val();
            if (date == null || date == "") {
                swal('Periode tidak boleh kosong', '', 'warning');
                return false;
            }
            let dateA = date.substr(0, 10);
            let dateB = date.substr(13, 10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');
            if ($('#export').val() != 'Y' && $('#export').val() != 'T') {
                swal({
                    title: 'Warning',
                    text: 'Khusus Export Y/T ?',
                    icon: 'warning',
                }).then(function () {
                    $('#export').focus();
                })
                return false;
            }
            if ($('#export').val() == 'T' && ($('#lstPrint').val() == '')) {
                swal({
                    title: 'Warning',
                    text: 'Inputan salah',
                    icon: 'warning',
                }).then(function () {
                    menu2Grosir = '';
                    menu2UnitSBU = '';
                    menu2GrosirA = '';
                    $('#lstPrint').focus();
                })
                return false;
            }
            if ($('#lstPrintHidden').val() == '3' || $('#lstPrintHidden').val() == '4' || $('#lstPrintHidden').val() == '5') {
                if ($('#lstPrintHidden').val() == '5') {
                    $('#sbu').val('O');
                }
                if ($('#sbu').val() != 'I' && $('#sbu').val() != 'O' && $('#sbu').val() != 'S') {
                    swal({
                        title: 'Warning',
                        text: 'Inputan salah',
                        icon: 'warning',
                    }).then(function () {
                        $('#sbu').focus();
                    })
                    $('#sbu').focus();
                    return false;
                } else if ($('#lstPrintHidden').val() == '4' || $('#lstPrintHidden').val() == '5') {
                    if ($('#sbu').val() == 'S') {
                        $('#menu2TokoInput').val('SEMUA');
                    } else if ($('#sbu').val() == 'I' || $('#sbu').val() == 'O') {
                        $('#menu2TokoInput').val('SEMUA');
                    }
                } else if ($('#lstPrintHidden').val() == '3' && $('#menu2TokoInput').val() == '') {
                    $('#jenisToko').val('S').change();
                    $('#menu2TokoInput').val('SEMUA');
                    $('#dis_omi').val('SEMUA');
                }
            }
            if (menu2Grosir == 'T') {
                //cetak_lap_jual_perdept
                window.open(`{{ url()->current() }}/printdocumentmenu2?date1=${dateA}&date2=${dateB}&export=${$('#export').val()}&grosira=${menu2GrosirA}&lst_print=${$('#lstPrint').val()}`, '_blank');
                clearMenu2();
                kembali();
            } else {
                //cetak_lap_jual_perdept_c
                if ($('#menu2TokoInput').val() == 'SEMUA') {
                    temptoko = 'z';
                } else {
                    temptoko = $('#menu2TokoInput').val();
                }

                //kondisi tempsbu(seharusnya :sbu kalau diprogram lama) dan khusus (:khusus di program lama) di jalankan disini
                if ($('#lstPrintHidden').val() == '3' || $('#lstPrintHidden').val() == '4' || $('#lstPrintHidden').val() == '5') {
                    if ($('#sbu').val() != 'S') {
                        tempsbu = $('#sbu').val();
                    } else {
                        tempsbu = 'z';
                    }

                    if ($('#lstPrintHidden').val() == '5') {
                        khusus = 'K';
                    } else {
                        khusus = 'z';
                    }
                }

                if ($('#lstPrintHidden').val() == '3') {
                    //perdept_d
                    window.open(`{{ url()->current() }}/printdocumentdmenu2?date1=${dateA}&date2=${dateB}&p_khusus=${khusus}&p_sbu=${tempsbu}&p_omi=${temptoko}&lst_print=${$('#lstPrint').val()}`, '_blank');
                } else {
                    //perdept_c
                    window.open(`{{ url()->current() }}/printdocumentcmenu2?date1=${dateA}&date2=${dateB}&p_khusus=${khusus}&p_sbu=${tempsbu}&p_omi=${temptoko}&lst_print=${$('#lstPrint').val()}`, '_blank');
                }
                clearMenu2();
                kembali();
            }
        }

        function clearMenu2() {
            $('#menu2 input').val('');
            $('#daterangepicker2').data('daterangepicker').setStartDate(moment().format('DD/MM/YYYY'));
            $('#daterangepicker2').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));

            $('#jenisToko').val('S').change();
            $('#menu2Ext').prop('hidden', true);
            $('#menu2Ext2').prop('hidden', true);
            $('#menu2Ext3').prop('hidden', true);
        }

        //-------------------- END OF SCRIPT ### MENU 2 ### --------------------

        //-------------------- SCRIPT UNTUK ### MENU 3 ### --------------------
        //Menggerakkan cursor
        $("#menu3 :button").click(function () {
            cursor = this.id;
        });

        //fungsi date menu3
        $('#daterangepicker3').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function (start, end, label) { //untuk mendeteksi bila perubahan tidak dibulan yang sama ketika melakukan perubahan
            if (start.format('YYYY') !== end.format('YYYY') || start.format('MM') !== end.format('MM')) {
                swal({
                    title: 'Periode Bulan',
                    text: 'Bulan Periode Tanggal harus sama.',
                    icon: 'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#daterangepicker3').data('daterangepicker').setStartDate(start.format('DD/MM/YYYY'));
                    $('#daterangepicker3').data('daterangepicker').setEndDate(start.format('DD/MM/YYYY'));
                    $('#daterangepicker3').select();
                });
            } else {
                $('#menu3divA').focus(); //focus ke kolom berikutnya
                let dateA = start.format('DD-MM-YYYY');
                let dateB = end.format('DD-MM-YYYY');
                tableMon.destroy();
                $('#menu3monA').val('');
                getModalMon(dateA, dateB);
            }
            //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        //BAGIAN DIV
        function chooseDivMenu3(val) {
            let kodedivisi = val.children().first().text();
            let namadivisi = val.children().first().next().text();
            $('#menu3divA').val(kodedivisi).change();
            $('#menu3divdisplay').val(namadivisi);
        }

        //Menggunakan on change untuk mengurangi bug
        $("#menu3divA").change(function () {
            $("#menu3divdisplay").val('');
            $("#menu3deptA").val('');
            $("#menu3deptdisplay").val('');
            $("#menu3katA").val('');
            $("#menu3katdisplay").val('');
            if ($("#menu3divA").val() == '') {
                $('#menu3divdisplay').val('');
                $("#min").val('').change();
                $("#max").val('').change();
            } else if (!checkDivExist($("#menu3divA").val())) {
                swal({
                    title: 'Kesalahan data',
                    text: 'Divisi tidak ditemukan',
                    icon: 'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $("#menu3divA").val('').focus();
                    $('#menu3divdisplay').val('');
                    $("#min").val('').change();
                    $("#max").val('').change();
                });
                return false;
            } else {
                for (i = 0; i < tableDiv.data().length; i++) {
                    if ($("#menu3divA").val() == tableDiv.row(i).data()['div_kodedivisi']) {
                        $('#menu3divdisplay').val(tableDiv.row(i).data()['div_namadivisi']);
                    }
                }

                $("#min").val($("#menu3divA").val()).change();
                $("#max").val($("#menu3divA").val()).change();
                $("#menu3deptA").focus();
            }
        });

        //BAGIAN DEPT
        function menu3DivNotEmpty() {
            if ($("#menu3divA").val() == '') {
                $("#menu3divA").focus();
                return false;
            } else {
                return true;
            }
        }

        function deptMenu3() {
            if (menu3DivNotEmpty()) {
                $('#deptModal').modal('toggle');
            } else {
                swal({
                    title: 'Kesalahan data',
                    text: 'Divisi masih kosong',
                    icon: 'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $("#menu3divA").focus();
                });
            }
        }

        function chooseDeptMenu3(val) {
            let kodedepartemen = val.children().first().text();
            let namadepartemen = val.children().first().next().text();
            $('#menu3deptA').val(kodedepartemen).change();
            $('#menu3deptdisplay').val(namadepartemen);
        }

        $("#menu3deptA").change(function () {
            $("#menu3deptdisplay").val('');
            $("#menu3katA").val('');
            $("#menu3katdisplay").val('');
            if ($("#menu3deptA").val() == '') {
                $('#menu3deptdisplay').val('');
                $("#minKat").val('').change();
                $("#maxKat").val('').change();
            } else if (!checkDeptExist($("#menu3deptA").val())) {
                swal({
                    title: 'Kesalahan data',
                    text: 'Departemen tidak ditemukan',
                    icon: 'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $("#menu3deptA").val('').focus();
                    $('#menu3deptdisplay').val('');
                    $("#minKat").val('').change();
                    $("#maxKat").val('').change();
                });
                return false;
            } else {
                for (i = 0; i < tableDept.data().length; i++) {
                    if (tableDept.row(i).data()['dep_kodedivisi'] >= $('#min').val() && tableDept.row(i).data()['dep_kodedivisi'] <= $('#max').val()) {
                        if ($("#menu3deptA").val() == tableDept.row(i).data()['dep_kodedepartement']) {
                            $('#menu3deptdisplay').val(tableDept.row(i).data()['dep_namadepartement']);
                        }
                    }
                }

                $("#minKat").val($("#menu3deptA").val()).change();
                $("#maxKat").val($("#menu3deptA").val()).change();
                $("#menu3katA").focus();
            }
        });

        //BAGIAN KAT
        function menu3DeptNotEmpty() {
            if ($("#menu3deptA").val() == '') {
                $("#menu3deptA").focus();
                return false;
            } else {
                return true;
            }
        }

        function katMenu3() {
            if (menu3DeptNotEmpty()) {
                $('#katModal').modal('toggle');
            } else {
                swal({
                    title: 'Kesalahan data',
                    text: 'Departemen masih kosong',
                    icon: 'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $("#menu3deptA").focus();
                });
            }
        }

        function chooseKatMenu3(val) {
            let kodekategori = val.children().first().text();
            let namakategori = val.children().first().next().text();
            $('#menu3katA').val(kodekategori).change();
            $('#menu3katdisplay').val(namakategori);
        }

        $("#menu3katA").change(function () {
            if ($("#menu3katA").val() == '') {
                $('#menu3katdisplay').val('');
            } else if (!checkKatExist($("#menu3katA").val())) {
                swal({
                    title: 'Kesalahan data',
                    text: 'Kategori tidak ditemukan',
                    icon: 'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $("#menu3katA").val('').focus();
                    $('#menu3katdisplay').val('');
                });
                return false;
            } else {
                for (i = 0; i < tableKat.data().length; i++) {
                    if (tableKat.row(i).data()['kat_kodedepartement'] >= $('#minKat').val() && tableKat.row(i).data()['kat_kodedepartement'] <= $('#maxKat').val()) {
                        if ($("#menu3katA").val() == tableKat.row(i).data()['kat_kodekategori']) {
                            $('#menu3katdisplay').val(tableKat.row(i).data()['kat_namakategori']);
                        }
                    }
                }
                $("#menu3Margin1").focus();
            }
        });

        //BAGIAN MON
        function chooseMonMenu3(val) {
            let kodemonitor = val.children().first().text();
            $('#menu3monA').val(kodemonitor).change();
        }

        $("#menu3monA").change(function () {
            if ($("#menu3monA").val() == '') {
                //do nothing
            } else if (!checkMonExist($("#menu3monA").val())) {
                swal({
                    title: 'Kesalahan data',
                    text: 'Monitor tidak ditemukan',
                    icon: 'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $("#menu3monA").val('').focus();
                });
                return false;
            } else {
                $("#cetakMenu3").focus();
            }
        });

        //CETAK
        function cetakMenu3() {
            //LIST VARIABEL YANG AKAN DIGUNAKAN
            let date = $('#daterangepicker3').val();
            if (date == null || date == "") {
                swal('Periode tidak boleh kosong', '', 'warning');
                return false;
            }
            let dateA = date.substr(0, 10);
            let dateB = date.substr(13, 10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');

            let margin1 = '';
            if ($('#menu3Margin1').val() == '') {
                $('#menu3Margin1').val('-9999.99');
                margin1 = -9999.99;
            } else {
                margin1 = $('#menu3Margin1').val();
            }

            let margin2 = '';
            if ($('#menu3Margin2').val() == '') {
                $('#menu3Margin2').val('9999.99');
                margin2 = 9999.99;
            } else {
                margin2 = $('#menu3Margin2').val();
            }

            let div = '';
            if ($('#menu3divA').val() == '') {
                div = 'SEMUA DIVISI';
            } else {
                div = $('#menu3divA').val();
            }

            let dept = '';
            if ($('#menu3deptA').val() == '') {
                dept = 'SEMUA DEPARTEMENT';
            } else {
                dept = $('#menu3deptA').val();
            }

            let kat = '';
            if ($('#menu3katA').val() == '') {
                kat = 'SEMUA KATEGORY';
            } else {
                kat = $('#menu3katA').val();
            }

            let mon = '';
            if ($('#menu3monA').val() == '') {
                mon = 'SEMUA MONITOR';
            } else {
                mon = $('#menu3monA').val();
            }
            let pluall = '';
            if (mon == 'SEMUA MONITOR') {
                pluall = 'Y'; //RPT_JUAL_DIVISI_PLUALL
            } else {
                pluall = 'N'; //RPT_JUAL_DIVISI
            }
            //END OF LIST VARIABEL
            window.open(`{{ url()->current() }}/printdocumentmenu3?date1=${dateA}&date2=${dateB}&div=${div}&dept=${dept}&kat=${kat}&margin1=${margin1}&margin2=${margin2}&mon=${mon}&pluall=${pluall}`, '_blank');
            kembali();
        }

        //Clear Input Menu 1
        function clearMenu3() {
            $('#menu3 input').val('').change();

            $('#daterangepicker3').data('daterangepicker').setStartDate(moment().format('DD/MM/YYYY'));
            $('#daterangepicker3').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));
            let date = $('#daterangepicker3').val();
            let dateA = date.substr(0, 10);
            let dateB = date.substr(13, 10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');
            tableMon.destroy();
            getModalMon(dateA, dateB); //Mengisi ulang monModal
        }

        //-------------------- END OF SCRIPT ### MENU 3 ### --------------------

        //-------------------- SCRIPT UNTUK ### MENU 4 ### --------------------
        //fungsi date menu4
        $('#daterangepicker4').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function (start, end, label) { //untuk mendeteksi bila perubahan tidak dibulan yang sama ketika melakukan perubahan
            if (start.format('YYYY') !== end.format('YYYY') || start.format('MM') !== end.format('MM')) {
                swal({
                    title: 'Periode Bulan',
                    text: 'Bulan Periode Tanggal harus sama.',
                    icon: 'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#daterangepicker4').data('daterangepicker').setStartDate(start.format('DD/MM/YYYY'));
                    $('#daterangepicker4').data('daterangepicker').setEndDate(start.format('DD/MM/YYYY'));
                    $('#daterangepicker4').select();
                });
            } else {
                $('#yaTidakMenu4').focus(); //focus ke kolom berikutnya
            }
            //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        function isYTMenu4(evt) { //membatasi input untuk hanya boleh Y dan T, serta mendeteksi bila menekan tombol enter
            $('#yaTidakMenu4').keyup(function () {
                $(this).val($(this).val().toUpperCase());
            });
            let charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 121) // y kecil
                return 89; // Y besar

            if (charCode == 116) // t kecil
                return 84; //t besar

            if (charCode == 89 || charCode == 84)
                return true

            return false;
        }

        function cetakMenu4() {
            let date = $('#daterangepicker4').val();
            if (date == null || date == "") {
                swal('Periode tidak boleh kosong', '', 'warning');
                return false;
            }
            let dateA = date.substr(0, 10);
            let dateB = date.substr(13, 10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');

            if ($('#yaTidakMenu4').val() == '') {
                swal({
                    title: 'Kesalahan data',
                    text: 'Khusus Export Y/T ?',
                    icon: 'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $("#yaTidakMenu4").focus();
                });
                return false;
            }

            window.open(`{{ url()->current() }}/printdocumentmenu4?date1=${dateA}&date2=${dateB}&ekspor=${$('#yaTidakMenu4').val()}`, '_blank');
            kembali();
        }

        function clearMenu4() {
            $('#menu4 input').val('');
            $('#daterangepicker4').data('daterangepicker').setStartDate(moment().format('DD/MM/YYYY'));
            $('#daterangepicker4').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));
        }

        //-------------------- END OF SCRIPT ### MENU 4 ### --------------------

        //-------------------- SCRIPT UNTUK ### MENU 5 ### --------------------
        //fungsi date menu4
        $('#daterangepicker5').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function (start, end, label) { //untuk mendeteksi bila perubahan tidak dibulan yang sama ketika melakukan perubahan
            if (start.format('YYYY') !== end.format('YYYY') || start.format('MM') !== end.format('MM')) {
                swal({
                    title: 'Periode Bulan',
                    text: 'Bulan Periode Tanggal harus sama.',
                    icon: 'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#daterangepicker5').data('daterangepicker').setStartDate(start.format('DD/MM/YYYY'));
                    $('#daterangepicker5').data('daterangepicker').setEndDate(start.format('DD/MM/YYYY'));
                    $('#daterangepicker5').select();
                });
            } else {
                $('#kasirMenu5').focus(); //focus ke kolom berikutnya
            }
            //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        function cetakMenu5() {
            let date = $('#daterangepicker5').val();
            if (date == null || date == "") {
                swal('Periode tidak boleh kosong', '', 'warning');
                return false;
            }
            let dateA = date.substr(0, 10);
            let dateB = date.substr(13, 10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');

            if ($('#kasirMenu5').val() == '') {
                swal({
                    title: 'Kesalahan data',
                    text: 'Kode Kasir Harus Di Isi !!',
                    icon: 'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $("#kasirMenu5").focus();
                });
                return false;
            }
            let kasir = ($('#kasirMenu5').val()).toUpperCase();
            if ($('#stationMenu5').val() == '') {
                swal({
                    title: 'Kesalahan data',
                    text: 'Kode Station Kasir Harus Di Isi !!',
                    icon: 'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $("#stationMenu5").focus();
                });
                return false;
            }
            let station = ($('#stationMenu5').val()).toUpperCase();
            window.open(`{{ url()->current() }}/printdocumentmenu5?date1=${dateA}&date2=${dateB}&kasir=${kasir}&station=${station}`, '_blank');
            kembali();
        }


        function clearMenu5() {
            $('#menu5 input').val('');
            $('#daterangepicker5').data('daterangepicker').setStartDate(moment().format('DD/MM/YYYY'));
            $('#daterangepicker5').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));
        }

        //-------------------- END OF SCRIPT ### MENU 5 ### --------------------

        //tips navigasi (Ctrl+F) ketik ### <menu mana yang mau di lihat> (Ex. ### menu 0)
        //tips navigasi menu khusus interface (Ctrl+F) ketik ### <menu mana yang mau di lihat> === (Ex. ### menu 0 ===)
        //tips navigasi menu khusus javascript (Ctrl+F) ketik ### <menu mana yang mau di lihat> ### (Ex. ### menu 0 ###)
        $('#daterangepicker6').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function (start, end, label) { //untuk mendeteksi bila perubahan tidak dibulan yang sama ketika melakukan perubahan
            if (start.format('YYYY') !== end.format('YYYY') || start.format('MM') !== end.format('MM')) {
                swal({
                    title: 'Periode Bulan',
                    text: 'Bulan Periode Tanggal harus sama.',
                    icon: 'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#daterangepicker6').data('daterangepicker').setStartDate(start.format('DD/MM/YYYY'));
                    $('#daterangepicker6').data('daterangepicker').setEndDate(start.format('DD/MM/YYYY'));
                    $('#daterangepicker6').select();
                });
            } else {
                $('#kasirMenu6').focus(); //focus ke kolom berikutnya
            }
            //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        function cetakMenu6() {
            let date = $('#daterangepicker6').val();
            if (date == null || date == "") {
                swal('Periode tidak boleh kosong', '', 'warning');
                return false;
            }
            let dateA = date.substr(0, 10);
            let dateB = date.substr(13, 10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');
            let cetak = $('#cetak6').val();

            window.open(`{{ url()->current() }}/printdocumentmenu6?date1=${dateA}&date2=${dateB}&cetak=${cetak}`, '_blank');
            kembali();
        }
    </script>
@endsection
