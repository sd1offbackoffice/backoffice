@extends('navbar')
@section('title','LAPORAN PENJUALAN TUNAI')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <fieldset class="card border-dark">
{{--                    <legend class="w-auto ml-5">Laporan Penjualan Tunai</legend>--}}
{{--                        ### MENU UTAMA ###   --}}
                        <br>
                    <div id="mainMenu">
                        <div class="row">
                            <label class="col-sm-3 text-right col-form-label">Jenis Laporan</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="jenisLaporan" onchange="jenisLaporanChange()">
                                    <option value="1">1. Daftar Produk</option>
                                    <option value="2">2. Daftar Perubahan Harga Jual</option>
                                    <option value="3">3. Daftar Margin Negatif</option>
                                    <option value="4">4. Daftar Supplier</option>
                                    <option value="5">5. Daftar Anggota / Member</option>
                                    <option value="6">6. Daftar Anggota / Type Outlet</option>
                                    <option value="7">7. Daftar Anggota / Member Baru</option>
                                    <option value="8">8. Daftar Anggota / Member Jatuh Tempo</option>
                                    <option value="9">9. Daftar Anggota /Member Expired</option>
                                    <option value="A">A. Daftar Harga Jual Baru</option>
                                    <option value="B">B. Daftar Perpanjangan Anggota / Member</option>
                                    <option value="C">C. Daftar Status Tag Bar Code</option>
                                    <option value="D">D. Master Display</option>
                                    <option value="E">E. Master Display DIV/DEPT/KATB</option>
                                    <option value="F">F. Daftar Margin Negatif VS MCG</option>
                                    <option value="G">G. Daftar Supplier By Hari Kunjungan</option>
{{--                                        <option value="Z2">DAFTAR BARANG BAIK KE RUSAK</option>--}}
                                </select>
                            </div>
                        </div>
                        <br><br>
                    </div>

                    {{--### Menu 1 === Daftar Produk ###--}}
                    <div id="menu1" class="subMenu card-body shadow-lg cardForm">
                        @include('BACKOFFICE.LISTMASTERASSET.daftar-produk')
                    </div>

                    {{--### Menu 2 === Daftar Perubahan Harga Jual ###--}}
                    <div id="menu2" class="subMenu card-body shadow-lg cardForm" hidden>
                        @include('BACKOFFICE.LISTMASTERASSET.daftar-perubahan-harga-jual')
                    </div>

                    {{--### Menu 3 === Daftar Margin Negatif ###--}}
                    <div id="menu3" class="subMenu card-body shadow-lg cardForm" hidden>
                        @include('BACKOFFICE.LISTMASTERASSET.daftar-margin-negatif')
                    </div>

                    {{--### Menu 4 === Daftar Supplier ###--}}
                    <div id="menu4" class="subMenu card-body shadow-lg cardForm" hidden>
                        @include('BACKOFFICE.LISTMASTERASSET.daftar-supplier')
                    </div>

                    {{--### Menu 5 === Daftar Anggota atau Member ###--}}
                    <div id="menu5" class="subMenu card-body shadow-lg cardForm" hidden>
                        @include('BACKOFFICE.LISTMASTERASSET.daftar-anggota-or-member')
                    </div>

                    {{--### Menu 6 === Daftar Anggota atau Type Outlet ###--}}
                    <div id="menu6" class="subMenu card-body shadow-lg cardForm" hidden>
                        @include('BACKOFFICE.LISTMASTERASSET.daftar-anggota-or-type-outlet')
                    </div>

                    {{--### Menu 7 === Daftar Anggota atau Member Baru ###--}}
                    <div id="menu7" class="subMenu card-body shadow-lg cardForm" hidden>
                        @include('BACKOFFICE.LISTMASTERASSET.daftar-anggota-or-member-baru')
                    </div>

                    {{--### Menu 8 === Daftar Anggota atau Member Jatuh Tempo ###--}}
                    <div id="menu8" class="subMenu card-body shadow-lg cardForm" hidden>
                        @include('BACKOFFICE.LISTMASTERASSET.daftar-anggota-or-member-jatuh-tempo')
                    </div>

                    {{--### Menu 9 === Daftar Anggota atau Member Expired ###--}}
                    <div id="menu9" class="subMenu card-body shadow-lg cardForm" hidden>
                        @include('BACKOFFICE.LISTMASTERASSET.daftar-anggota-or-member-expired')
                    </div>

                    {{--### Menu A === Daftar Harga Jual Baru ###--}}
                    <div id="menuA" class="subMenu card-body shadow-lg cardForm" hidden>
                        @include('BACKOFFICE.LISTMASTERASSET.daftar-harga-jual-baru')
                    </div>

                    {{--### Menu B === Daftar Perpanjangan Anggota atau Member ###--}}
                    <div id="menuB" class="subMenu card-body shadow-lg cardForm" hidden>
                        @include('BACKOFFICE.LISTMASTERASSET.daftar-perpanjangan-anggota-or-member')
                    </div>

                    {{--### Menu C === Daftar Status Tag Bar Code ###--}}
                    <div id="menuC" class="subMenu card-body shadow-lg cardForm" hidden>
                        @include('BACKOFFICE.LISTMASTERASSET.daftar-status-tag-bar-code')
                    </div>

                    {{--### Menu D === Master Display ###--}}
                    <div id="menuD" class="subMenu card-body shadow-lg cardForm" hidden>
                        @include('BACKOFFICE.LISTMASTERASSET.master-display')
                    </div>

                    {{--### Menu E === Master Display DIV/DEPT/KATB ###--}}
                    <div id="menuE" class="subMenu card-body shadow-lg cardForm" hidden>
                        @include('BACKOFFICE.LISTMASTERASSET.master-display-div-dept-katb')
                    </div>

                    {{--### Menu F === Daftar Margin Negatif VS MCG ### Note: Menurut Ias Lama, form ini sama dengan Margin Negatif--}}
                    <div id="menuF" class="subMenu card-body shadow-lg cardForm" hidden>
                        @include('BACKOFFICE.LISTMASTERASSET.daftar-margin-negatif-vs-mcg')
                    </div>

                    {{--### Menu G === Master Supplier By Hari Kunjungan ###--}}
                    <div id="menuG" class="subMenu card-body shadow-lg cardForm" hidden>
                        @include('BACKOFFICE.LISTMASTERASSET.daftar-supplier-by-hari-kunjungan')
                    </div>
                    <br>
                    <div class="d-flex justify-content-end">
                        <button id="Cetak" class="btn btn-success col-sm-3" type="button" onclick="cetak()">CETAK LAPORAN</button>
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
                    <h5 class="modal-title">Daftar Divisi</h5>
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
                                        <th>Nama Divisi</th>
                                        <th>Kode Divisi</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalDiv"></tbody>
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
    <div class="modal fade" id="depModal" tabindex="-1" role="dialog" aria-labelledby="depModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Departemen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--UNTUK FILTER DATA--}}
                <div hidden>
                    <input type="text" id="minDep" name="minDep">
                    <input type="text" id="maxDep" name="maxDep">
                </div>
                <div hidden>
                    <input type="text" id="filtererDep" name="filtererDep">
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalDep">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Nama Departemen</th>
                                        <th>Kode Departemen</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalDep"></tbody>
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
                    <h5 class="modal-title">Daftar Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--UNTUK FILTER DATA--}}
                <div hidden>
                    <input type="text" id="minKat" name="minKat">
                    <input type="text" id="maxKat" name="maxKat">
                </div>
                <div hidden>
                    <input type="text" id="filtererKat" name="filtererKat">
                    <input type="text" id="filtererKat_Dep" name="filtererKat_Dep">
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalKat">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Nama Kategori</th>
                                        <th>Kode Kategori</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalKat"></tbody>
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

    {{--Modal Supplier--}}
    <div class="modal fade" id="supModal" tabindex="-1" role="dialog" aria-labelledby="supModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalSup">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Nama Supplier</th>
                                        <th>Kode Supplier</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalSup"></tbody>
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

    {{--Modal Member--}}
    <div class="modal fade" id="memModal" tabindex="-1" role="dialog" aria-labelledby="memModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalMem">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Nama Member</th>
                                        <th>Kode Member</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalMem"></tbody>
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

    {{--Modal Member With Date--}}
    <div class="modal fade" id="memDateModal" tabindex="-1" role="dialog" aria-labelledby="memDateModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalMemDate">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Nama Member</th>
                                        <th>Kode Member</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalMemDate"></tbody>
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

    {{--Modal Outlet--}}
    <div class="modal fade" id="outletModal" tabindex="-1" role="dialog" aria-labelledby="outletModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Outlet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalOutlet">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Nama Outlet</th>
                                        <th>Kode Outlet</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalOutlet"></tbody>
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

    {{--Modal Sub-Outlet--}}
    <div class="modal fade" id="subOutletModal" tabindex="-1" role="dialog" aria-labelledby="subOutletModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Sub-Outlet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--UNTUK FILTER DATA--}}
                <div hidden>
                    <input type="text" id="outletFilterer" name="outletFilterer">
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalSubOutlet">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Nama Sub-Outlet</th>
                                        <th>Kode Sub-Outlet</th>
                                        <th>Kode Outlet</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalSubOutlet"></tbody>
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

    {{--Modal PLU--}}
    <div class="modal fade" id="pluModal" tabindex="-1" role="dialog" aria-labelledby="pluModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalPlu">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi Barang</th>
                                        <th>PLU</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalPlu"></tbody>
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

    {{--Modal PLU CUSTOM--}}
    <div class="modal fade" id="pluCustomModal" tabindex="-1" role="dialog" aria-labelledby="pluCustomModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalPluCustom">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi Barang</th>
                                        <th>PLU</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalPluCustom"></tbody>
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

    {{--Modal Rak--}}
    <div class="modal fade" id="rakModal" tabindex="-1" role="dialog" aria-labelledby="rakModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Rak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalRak">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Rak</th>
                                        <th>Kode Sub Rak</th>
                                        <th>Tipe Rak</th>
                                        <th>Shelving</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalRak"></tbody>
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

    <script>
        let cursor = '';
        let tableDivisi;
        let tableDepartemen;
        let tableKategori;
        let tableSupplier;
        let tableMember;
        let tableMemberDate;
        let tableOutlet;
        let tableSubOutlet;
        let tablePlu;
        let tablePluCustom;
        let tableRak;

        $(document).ready(function () {
            getModalDivisi();
            getModalDepartemen();
            getModalKategori();
            getModalSupplier();
            getModalMember('');
            getModalMemberDate();
            getModalOutlet();
            getModalSubOutlet();
            getModalPlu();
            getModalRak();
        });

        function jenisLaporanChange(){
            $('.subMenu').prop("hidden",true)
            clearAll();
            switch ($('#jenisLaporan').val()){
                case '1':
                    $('#menu1').prop("hidden",false)
                    break;
                case '2':
                    $('#menu2').prop("hidden",false)
                    break;
                case '3':
                    $('#menu3').prop("hidden",false)
                    break;
                case '4':
                    $('#menu4').prop("hidden",false)
                    break;
                case '5':
                    $('#menu5').prop("hidden",false)
                    break;
                case '6':
                    $('#menu6').prop("hidden",false)
                    break;
                case '7':
                    $('#menu7').prop("hidden",false)
                    break;
                case '8':
                    $('#menu8').prop("hidden",false)
                    break;
                case '9':
                    $('#menu9').prop("hidden",false)
                    break;
                case 'A':
                    $('#menuA').prop("hidden",false)
                    break;
                case 'B':
                    $('#menuB').prop("hidden",false)
                    break;
                case 'C':
                    $('#menuC').prop("hidden",false)
                    break;
                case 'D':
                    $('#menuD').prop("hidden",false)
                    break;
                case 'E':
                    $('#menuE').prop("hidden",false)
                    break;
                case 'F':
                    $('#menuF').prop("hidden",false)
                    break;
                case 'G':
                    $('#menuG').prop("hidden",false)
                    break;
            }
        }

        function clearAll(){
            menu1Clear();
            menu2Clear();
            menu3Clear();
            menu4Clear();
            menu5Clear();
            menu6Clear();
            menu7Clear();
            menu8Clear();
            menu9Clear();
            menuAClear();
            menuBClear();
            menuCClear();
            menuDClear();
            menuEClear();
            menuFClear();
            menuGClear();
        }

        function cetak(){
            switch ($('#jenisLaporan').val()){
                case '1':
                    menu1Cetak();
                    break;
                case '2':
                    menu2Cetak();
                    break;
                case '3':
                    menu3Cetak();
                    break;
                case '4':
                    menu4Cetak();
                    break;
                case '5':
                    menu5Cetak();
                    break;
                case '6':
                    menu5Cetak();
                    break;
                case '7':
                    menu7Cetak();
                    break;
                case '8':
                    menu8Cetak();
                    break;
                case '9':
                    menu9Cetak();
                    break;
                case 'A':
                    menuACetak();
                    break;
                case 'B':
                    menuACetak();
                    break;
                case 'C':
                    menuCCetak();
                    break;
                case 'D':
                    menuDCetak();
                    break;
                case 'E':
                    menuECetak();
                    break;
                case 'F':
                    menuFCetak();
                    break;
                case 'G':
                    menuGCetak();
                    break;
            }
        }

        // IMPORTANT!!! ### BUTUH CURSOR UNTUK MENDETEKSI TOMBOL MANA YANG MEMANGGIL! ###
        //Menggerakkan cursor
        $(":button").click(function(){
            cursor = this.id;
        });

        /* Custom filtering function which will search data in column four between two values */
        //Custom Filtering untuk dept
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {

                if ( settings.nTable.id === 'tableModalDiv' ) {
                    return true; //no filtering on modal div
                }

                if ( settings.nTable.id === 'tableModalDep' ) {
                    let min = parseInt( $('#minDep').val(), 10 );
                    let max = parseInt( $('#maxDep').val(), 10 );
                    let filter = parseInt( $('#filtererDep').val(), 10 );
                    let val = parseFloat( data[2] ) || 0; // use data for the val column, [2] maksudnya kolom ke 2, yaitu kode_div
                    let val2 = parseFloat( data[1] ) || 0;
                    //filter on table modalDept
                    if ( ( isNaN( min ) && isNaN( max ) ) ||
                        ( isNaN( min ) && val <= max ) ||
                        ( min <= val   && isNaN( max ) ) ||
                        ( min <= val   && val <= max ) )
                    {
                        return true;
                    }
                }
                if ( settings.nTable.id === 'tableModalKat' ) {
                    let min = parseInt( $('#minKat').val(), 10 );
                    let max = parseInt( $('#maxKat').val(), 10 );
                    let filter = parseInt( $('#filtererKat').val(), 10 ); //kodekategori
                    let filterDep = parseInt( $('#filtererKat_Dep').val(), 10 ); //kodedepartement
                    let val = parseFloat( data[2] ) || 0; // use data for the val column, [2] maksudnya kolom ke 2, yaitu kode_dep
                    let val2 = parseFloat( data[1] ) || 0;
                    //filter on table modalDept
                    if ( ( isNaN( min ) && isNaN( max ) ) ||
                        ( isNaN( min ) && val <= max ) ||
                        ( min <= val   && isNaN( max ) ) ||
                        ( min <= val   && val <= max ) )
                    {
                        return true;
                    }
                }
                if ( settings.nTable.id === 'tableModalSup' ) {
                    return true; //no filtering on modal Sup
                }
                if ( settings.nTable.id === 'tableModalMem' ) {
                    return true; //no filtering on modal Mem
                }
                if ( settings.nTable.id === 'tableModalMemDate' ) {
                    return true; //no filtering on modal Mem
                }
                if ( settings.nTable.id === 'tableModalOutlet' ) {
                    return true; //no filtering on modal Outlet
                }
                if ( settings.nTable.id === 'tableModalSubOutlet' ) {
                    let outlet = parseInt( $('#outletFilterer').val(), 10 );
                    let val = parseInt( ( data[2] ), 10 ); // use data for the val column, [2] maksudnya kolom ke 2, yaitu kode_div
                    //filter on table modalDept
                    if ( ( isNaN( outlet ) ) || ( val === outlet ) )
                    {
                        return true;
                    }
                }
                if ( settings.nTable.id === 'tableModalPlu' ) {
                    return true; //no filtering on modal Plu
                }
                if ( settings.nTable.id === 'tableModalPluCustom' ) {
                    return true; //no filtering on modal Plu
                }
                if ( settings.nTable.id === 'tableModalRak' ) {
                    return true; //no filtering on modal Rak
                }
                return false;
            }
        );
        $('#minDep, #maxDep').change( function() {
            tableDepartemen.draw();
        } );
        $('#minKat, #maxKat').change( function() {
            tableKategori.draw();
        } );
        $('#outletFilterer').change( function() {
            tableSubOutlet.draw();
        } );

        //MODAL-MODAL
        //MODAL DIVISI
        function getModalDivisi(){
            tableDivisi =  $('#tableModalDiv').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/get-lov-divisi' }}',
                },
                "columns": [
                    {data: 'div_namadivisi', name: 'div_namadivisi'},
                    {data: 'div_kodedivisi', name: 'div_kodedivisi'},
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
                    $(row).addClass('modalDivisi');
                },
                columnDefs : [
                ],
                "order": []
            });
        }
        //MODAL DEPARTEMEN
        function getModalDepartemen(){
            tableDepartemen =  $('#tableModalDep').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/get-lov-departemen' }}',
                },
                "columns": [
                    {data: 'dep_namadepartement', name: 'dep_namadepartement'},
                    {data: 'dep_kodedepartement', name: 'dep_kodedepartement'},
                    {data: 'dep_kodedivisi', name: 'dep_kodedivisi', visible: false},
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
                    $(row).addClass('modalDepartemen');
                },
                columnDefs : [
                ],
                "order": []
            });
        }
        //MODAL KATEGORI
        function getModalKategori(){
            tableKategori =  $('#tableModalKat').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/get-lov-kategori' }}',
                },
                "columns": [
                    {data: 'kat_namakategori', name: 'kat_namakategori'},
                    {data: 'kat_kodekategori', name: 'kat_kodekategori'},
                    {data: 'kat_kodedepartement', name: 'kat_kodedepartement', visible: false},
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
                    $(row).addClass('modalKategori');
                },
                columnDefs : [
                ],
                "order": []
            });
        }
        //MODAL SUPPLIER
        function getModalSupplier(){
            tableSupplier =  $('#tableModalSup').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/get-lov-supplier' }}',
                },
                "columns": [
                    {data: 'sup_namasupplier', name: 'sup_namasupplier'},
                    {data: 'sup_kodesupplier', name: 'sup_kodesupplier'},
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
                    $(row).addClass('modalSupplier');
                },
                columnDefs : [
                ],
                "order": []
            });
        }
        //MODAL MEMBER
        function getModalMember(value){
            tableMember =  $('#tableModalMem').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/get-lov-member' }}',
                    "data" : {
                        'value' : value
                    },
                },
                "columns": [
                    {data: 'cus_namamember', name: 'cus_namamember'},
                    {data: 'cus_kodemember', name: 'cus_kodemember'},
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
                    $(row).addClass('modalMember');
                },
                columnDefs : [
                ],
                "order": []
            });
            $('#tableModalMem_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableMember.destroy();
                    getModalMember(val);
                }
            })
        }
        //MODAL MEMBER WITH DATE
        function getModalMemberDate(date1, date2){
            if(date1 == null || date2 == null){
                date1 = moment().format('DD-MM-YYYY');
                date2 = moment().format('DD-MM-YYYY');
            }

            tableMemberDate =  $('#tableModalMemDate').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/get-lov-member-with-date' }}',
                    "data" : {
                        'dateA' : date1,
                        'dateB' : date2
                    },
                },
                "columns": [
                    {data: 'cus_namamember', name: 'cus_namamember'},
                    {data: 'cus_kodemember', name: 'cus_kodemember'},
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
                    $(row).addClass('modalMemberDate');
                },
                columnDefs : [
                ],
                "order": []
            });
        }
        //MODAL DIVISI
        function getModalOutlet(){
            tableOutlet =  $('#tableModalOutlet').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/get-lov-outlet' }}',
                },
                "columns": [
                    {data: 'out_namaoutlet', name: 'out_namaoutlet'},
                    {data: 'out_kodeoutlet', name: 'out_kodeoutlet'},
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
                    $(row).addClass('modalOutlet');
                },
                columnDefs : [
                ],
                "order": []
            });
        }
        //MODAL DIVISI
        function getModalSubOutlet(){
            tableSubOutlet =  $('#tableModalSubOutlet').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/get-lov-sub-outlet' }}',
                },
                "columns": [
                    {data: 'sub_namasuboutlet', name: 'sub_namasuboutlet'},
                    {data: 'sub_kodesuboutlet', name: 'sub_kodesuboutlet'},
                    {data: 'sub_kodeoutlet', name: 'sub_kodeoutlet'},
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
                    $(row).addClass('modalSubOutlet');
                },
                columnDefs : [
                ],
                "order": []
            });
        }
        //MODAL PLU
        function getModalPlu(value){
            tablePlu =  $('#tableModalPlu').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/get-lov-plu' }}',
                    "data" : {
                        'value' : value
                    },
                },
                "columns": [
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                    {data: 'prd_prdcd', name: 'prd_prdcd'},
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
                    $(row).addClass('modalPlu');
                },
                columnDefs : [
                ],
                "order": []
            });
            $('#tableModalPlu_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tablePlu.destroy();
                    getModalPlu(val);
                }
            })
        }
        //MODAL PLU CUSTOM
        function getModalPluCustom(div1,div2,dep1,dep2,kat1,kat2){
            if ( ! $.fn.DataTable.isDataTable( '#tableModalPluCustom' ) ) {
                tablePluCustom =  $('#tableModalPluCustom').DataTable({
                    "ajax": {
                        'url' : '{{ url()->current().'/get-lov-plu-custom' }}',
                        "data" : {
                            'div1' : div1,
                            'div2' : div2,
                            'dep1' : dep1,
                            'dep2' : dep2,
                            'kat1' : kat1,
                            'kat2' : kat2,
                        },
                    },
                    "columns": [
                        {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                        {data: 'prd_prdcd', name: 'prd_prdcd'},
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
                        $(row).addClass('modalPluCustom');
                    },
                    columnDefs : [
                    ],
                    "order": []
                });
            }else{
                tablePluCustom.destroy();
                getModalPluCustom(div1,div2,dep1,dep2,kat1,kat2);
            }
        }
        //MODAL RAK
        function getModalRak(){
            tableRak =  $('#tableModalRak').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/get-lov-rak' }}',
                },
                "columns": [
                    {data: 'lks_koderak', name: 'lks_koderak'},
                    {data: 'lks_tiperak', name: 'lks_tiperak'},
                    {data: 'lks_kodesubrak', name: 'lks_kodesubrak'},
                    {data: 'lks_shelvingrak', name: 'lks_shelvingrak'},
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
                    $(row).addClass('modalRak');
                },
                columnDefs : [
                ],
                "order": []
            });
        }

        //ONCLICK MODAL
        //ONCLICK DIVISI
        $(document).on('click', '.modalDivisi', function () {
            $('#divModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menu1"){
                menu1Choose(currentButton);
            }else if(cursor.substr(0,5) === "menu2"){
                menu2Choose(currentButton);
            }else if(cursor.substr(0,5) === "menu3"){
                menu3Choose(currentButton);
            }else if(cursor.substr(0,5) === "menuA"){
                menuAChoose(currentButton);
            }else if(cursor.substr(0,5) === "menuE"){
                menuEChoose(currentButton);
            }else if(cursor.substr(0,5) === "menuF"){
                menuFChoose(currentButton);
            }
        });
        //ONCLICK DEPARTEMEN
        $(document).on('click', '.modalDepartemen', function () {
            $('#depModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menu1"){
                menu1Choose(currentButton);
            }else if(cursor.substr(0,5) === "menu2"){
                menu2Choose(currentButton);
            }else if(cursor.substr(0,5) === "menu3"){
                menu3Choose(currentButton);
            }else if(cursor.substr(0,5) === "menuA"){
                menuAChoose(currentButton);
            }else if(cursor.substr(0,5) === "menuC"){
                menuCChoose(currentButton);
            }else if(cursor.substr(0,5) === "menuE"){
                menuEChoose(currentButton);
            }else if(cursor.substr(0,5) === "menuF"){
                menuFChoose(currentButton);
            }
        });
        //ONCLICK KATEGORI
        $(document).on('click', '.modalKategori', function () {
            $('#katModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menu1"){
                menu1Choose(currentButton);
            }else if(cursor.substr(0,5) === "menu2"){
                menu2Choose(currentButton);
            }else if(cursor.substr(0,5) === "menu3"){
                menu3Choose(currentButton);
            }else if(cursor.substr(0,5) === "menuA"){
                menuAChoose(currentButton);
            }else if(cursor.substr(0,5) === "menuC"){
                menuCChoose(currentButton);
            }else if(cursor.substr(0,5) === "menuE"){
                menuEChoose(currentButton);
            }else if(cursor.substr(0,5) === "menuF"){
                menuFChoose(currentButton);
            }
        });
        //ONCLICK SUPPLIER
        $(document).on('click', '.modalSupplier', function () {
            $('#supModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menu4") {
                menu4Choose(currentButton);
            }else if(cursor.substr(0,5) === "menuG") {
                menuGChoose(currentButton);
            }
        });
        //ONCLICK MEMBER
        $(document).on('click', '.modalMember', function () {
            $('#memModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menu5") {
                menu5Choose(currentButton);
            }else if(cursor.substr(0,5) === "menu6") {
                menu6Choose(currentButton);
            }else if(cursor.substr(0,5) === "menu9") {
                menu9Choose(currentButton);
            }
        });
        //ONCLICK MEMBER WITH DATE
        $(document).on('click', '.modalMemberDate', function () {
            $('#memDateModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menu7") {
                menu7Choose(currentButton);
            }else if(cursor.substr(0,5) === "menu8") {
                menu8Choose(currentButton);
            }else if(cursor.substr(0,5) === "menuB") {
                menuBChoose(currentButton);
            }
        });
        //ONCLICK OUTLET
        $(document).on('click', '.modalOutlet', function () {
            $('#outletModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menu5") {
                menu5Choose(currentButton);
            }else if(cursor.substr(0,5) === "menu6") {
                menu6Choose(currentButton);
            }
        });
        //ONCLICK SUB-OUTLET
        $(document).on('click', '.modalSubOutlet', function () {
            $('#subOutletModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menu5") {
                menu5Choose(currentButton);
            }
        });
        //ONCLICK PLU
        $(document).on('click', '.modalPlu', function () {
            $('#pluModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menuC") {
                menuCChoose(currentButton);
            }
        });
        //ONCLICK PLU CUSTOM
        $(document).on('click', '.modalPluCustom', function () {
            $('#pluCustomModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menuE") {
                menuEChoose(currentButton);
            }
        });
        //ONCLICK RAK
        $(document).on('click', '.modalRak', function () {
            $('#rakModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menuD"){
                menuDChoose(currentButton);
            }
        });

        //Untuk periksa apakah div ada
        function checkDivExist(val){
            for(i=0;i<tableDivisi.data().length;i++){
                if(tableDivisi.row(i).data()['div_kodedivisi'] == val){
                    return i+1;
                }
            }
            return 0;
        }

        //Untuk periksa apakah dep ada
        function checkDepExist(val){
            let min = 0;
            let max = tableDepartemen.data().length;

            if($('#minDep').val() != ''){
                min = parseInt( $('#minDep').val(), 10 );
            }
            if($('#maxDep').val() != ''){
                max = parseInt( $('#maxDep').val(), 10 );
            }
            for(i=0;i<tableDepartemen.data().length;i++){
                if(tableDepartemen.row(i).data()['dep_kodedivisi'] >= min && tableDepartemen.row(i).data()['dep_kodedivisi'] <= max){
                    if(tableDepartemen.row(i).data()['dep_kodedepartement'] == val){
                        return i+1;
                    }
                }
            }
            return 0;
        }

        //Untuk periksa apakah kat ada
        function checkKatExist(val, dep){
            let min = 0;
            let max = tableKategori.data().length;

            if($('#minKat').val() != ''){
                min = parseInt( $('#minKat').val(), 10 );
            }
            if($('#maxKat').val() != ''){
                max = parseInt( $('#maxKat').val(), 10 );
            }

            for(i=0;i<tableKategori.data().length;i++){
                if(tableKategori.row(i).data()['kat_kodedepartement'] >= min && tableKategori.row(i).data()['kat_kodedepartement'] <= max){
                    if(tableKategori.row(i).data()['kat_kodekategori'] == val){
                        return i+1;
                    }
                }
            }
            return 0;
        }

        //Untuk periksa apakah sup ada
        function checkSupExist(val){
            for(i=0;i<tableSupplier.data().length;i++){
                if(tableSupplier.row(i).data()['sup_kodesupplier'] == val){
                    return i+1;
                }
            }
            return 0;
        }

        //Untuk periksa apakah mem ada
        function checkMemExist(val){
            let result ="false";
            $.ajax({
                url: '{{ url()->current() }}/check-member',
                type: 'GET',
                async: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    value: val
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    result = response;
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: "ERROR",
                        text: "GAGAL CHECK MEMBER !!",
                        icon: 'error',
                    }).then(() => {

                    });
                }
            });
            return result;
        }

        //Untuk periksa apakah Member dalam rentang waktu ada
        function checkMemWithDateExist(val){
            for(i=0;i<tableMemberDate.data().length;i++){
                if(tableMemberDate.row(i).data()['cus_kodemember'] == val){
                    return i+1;
                }
            }
            return 0;
        }

        //Untuk periksa apakah outlet ada
        function checkOutletExist(val){
            for(i=0;i<tableOutlet.data().length;i++){
                if(tableOutlet.row(i).data()['out_kodeoutlet'] == val){
                    return i+1;
                }
            }
            return 0;
        }

        //Untuk periksa apakah sub-outlet ada
        function checkSubOutletExist(val){
            if($('#outletFilterer').val() == ''){
                for(i=0;i<tableSubOutlet.data().length;i++){
                    if(tableSubOutlet.row(i).data()['sub_kodesuboutlet'] == val){
                        return i+1;
                    }
                }
            }else{
                for(i=0;i<tableSubOutlet.data().length;i++){
                    if(tableSubOutlet.row(i).data()['sub_kodeoutlet'] == parseInt( $('#outletFilterer').val(), 10 )){
                        if(tableSubOutlet.row(i).data()['sub_kodesuboutlet'] == val){
                            return i+1;
                        }
                    }
                }
            }
            return 0;
        }

        //Untuk periksa apakah mem ada
        function checkPluExist(val){
            let result = "false";
            $.ajax({
                url: '{{ url()->current() }}/check-plu',
                type: 'GET',
                async: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    value: val
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    result = response;
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: "ERROR",
                        text: "GAGAL CHECK PLU !!",
                        icon: 'error',
                    }).then(() => {

                    });
                }
            });
            return result;
        }
    </script>
@endsection
