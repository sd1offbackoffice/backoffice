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
                                <select class="form-control" id="jenisLaporan" onchange="JenisLaporanChange()">
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

                    <div class="d-flex justify-content-end">
                        <button id="Cetak" class="btn btn-success col-sm-3" type="button" onclick="Cetak()">CETAK LAPORAN</button>
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
                    <input type="text" id="minDep" name="min">
                    <input type="text" id="maxDep" name="max">
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

    <script>
        let cursor = '';
        let tableDivisi;
        let tableDepartemen;
        let tableKategori;

        $(document).ready(function () {
            getModalDivisi();
            getModalDepartemen();
            getModalKategori();
        });

        function JenisLaporanChange(){
            $('.subMenu').prop("hidden",true)
            switch ($('#jenisLaporan').val()){
                case '1':
                    $('#menu1').prop("hidden",false)
                    break;
                case '2':
                    $('#menu2').prop("hidden",false)
                    break;
            }
        }

        function Cetak(){
            switch ($('#jenisLaporan').val()){
                case '1':
                    alert('cetak laporan 1');
                    break;
                case '2':
                    alert('cetak laporan 2');
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
                    let val = parseFloat( data[2] ) || 0; // use data for the val column, [2] maksudnya kolom ke 2, yaitu kode_div
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
                    let val = parseFloat( data[2] ) || 0; // use data for the val column, [2] maksudnya kolom ke 2, yaitu kode_div
                    //filter on table modalDept
                    if ( ( isNaN( min ) && isNaN( max ) ) ||
                        ( isNaN( min ) && val <= max ) ||
                        ( min <= val   && isNaN( max ) ) ||
                        ( min <= val   && val <= max ) )
                    {
                        return true;
                    }
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

        //ONCLICK MODAL
        //ONCLICK DIVISI
        $(document).on('click', '.modalDivisi', function () {
            $('#divModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menu1"){
                Menu1Choose(currentButton);
            }else if(cursor.substr(0,5) === "menu2"){
                Menu2Choose(currentButton);
            }
        });
        //ONCLICK DEPARTEMEN
        $(document).on('click', '.modalDepartemen', function () {
            $('#depModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menu1"){
                Menu1Choose(currentButton);
            }else if(cursor.substr(0,5) === "menu2"){
                Menu2Choose(currentButton);
            }
        });
        //ONCLICK KATEGORI
        $(document).on('click', '.modalKategori', function () {
            $('#katModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menu1"){
                Menu1Choose(currentButton);
            }else if(cursor.substr(0,5) === "menu2"){
                Menu2Choose(currentButton);
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
            for(i=0;i<tableDepartemen.data().length;i++){
                if(tableDepartemen.row(i).data()['dep_kodedivisi'] >= parseInt( $('#minDep').val(), 10 ) && tableDepartemen.row(i).data()['dep_kodedivisi'] <= parseInt( $('#maxDep').val(), 10 )){
                    if(tableDepartemen.row(i).data()['dep_kodedepartement'] == val){
                        return i+1;
                    }
                }
            }
            return 0;
        }

        //Untuk periksa apakah kat ada
        function checkKatExist(val){
            for(i=0;i<tableKategori.data().length;i++){
                if(tableKategori.row(i).data()['kat_kodedepartement'] >= parseInt( $('#minKat').val(), 10 ) && tableKategori.row(i).data()['kat_kodedepartement'] <= parseInt( $('#maxKat').val(), 10 )){
                    if(tableKategori.row(i).data()['kat_kodekategori'] == val){
                        return i+1;
                    }
                }
            }
            return 0;
        }
    </script>
@endsection
