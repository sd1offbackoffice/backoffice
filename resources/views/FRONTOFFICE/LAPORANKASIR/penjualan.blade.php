@extends('navbar')
@section('title','LAPORAN PENJUALAN TUNAI')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
{{--                    <legend class="w-auto ml-5">Laporan Penjualan Tunai</legend>--}}
                    <div class="card-body shadow-lg cardForm">

{{--                        ### MAIN MENU ###   --}}
                            <br>
                        <div id="mainMenu">
                            <div class="row">
                                <label class="col-sm-3 text-right col-form-label">Jenis Laporan</label>
                                <div class="dropdown col-sm-6">
                                    <button class="btn btn-secondary dropdown-toggle col-sm-12" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <input readonly type="text" id="jenisLaporan" class="col-sm-11" value="">
                                    </button>
                                    <div id="dropDownList" class="dropdown-menu col-sm-11" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" onclick="changeInput(1)">LAPORAN PER KATEGORY</a>
                                        <a class="dropdown-item" onclick="changeInput(2)">LAPORAN PER DEPARTEMEN</a>
                                        <a class="dropdown-item" onclick="changeInput(3)">RINCIAN PRODUK PER DIVISI</a>
                                        <a class="dropdown-item" onclick="changeInput(4)">LAPORAN PER HARI</a>
                                        <a class="dropdown-item" onclick="changeInput(5)">LAPORAN PER KASIR</a>
                                    </div>
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
                                <legend class="w-auto ml-5">Laporan Penjualan Tunai</legend>
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
                                <legend class="w-auto ml-5">Laporan Per Departemen</legend>
                                <div class="row">
                                    <label class="col-sm-4 text-right font-weight-normal col-form-label">Periode tanggal :</label>

                                </div>
                                <br>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary btn-block col-sm-3" type="button" onclick="kembali()">BACK</button>
                                </div>
                                <br>
                            </fieldset>
                        </div>

{{--                        ### Menu 3 === Rincian Produk Per Divisi ###--}}
                        <div id="menu3" class="card-body shadow-lg cardForm" hidden>
                            <fieldset class="card border-dark">
                                <legend class="w-auto ml-5">Rincian Produk Per Divisi</legend>
                                <div class="row">
                                    <label class="col-sm-4 text-right font-weight-normal col-form-label">Periode tanggal :</label>

                                </div>
                                <br>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary btn-block col-sm-3" type="button" onclick="kembali()">BACK</button>
                                </div>
                                <br>
                            </fieldset>
                        </div>

{{--                        ### Menu 4 === Laporan Per Hari ###--}}
                        <div id="menu4" class="card-body shadow-lg cardForm" hidden>
                            <fieldset class="card border-dark">
                                <legend class="w-auto ml-5">Laporan Per Hari</legend>
                                <div class="row">
                                    <label class="col-sm-4 text-right font-weight-normal col-form-label">Periode tanggal :</label>

                                </div>
                                <br>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary btn-block col-sm-3" type="button" onclick="kembali()">BACK</button>
                                </div>
                                <br>
                            </fieldset>
                        </div>

{{--                        ### Menu 5 === Laporan Per Kasir ###--}}
                        <div id="menu5" class="card-body shadow-lg cardForm" hidden>
                            <fieldset class="card border-dark">
                                <legend class="w-auto ml-5">Laporan Per Kasir</legend>
                                <div class="row">
                                    <label class="col-sm-4 text-right font-weight-normal col-form-label">Periode tanggal :</label>

                                </div>
                                <br>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary btn-block col-sm-3" type="button" onclick="kembali()">BACK</button>
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
    <div class="modal fade" id="deptModal" tabindex="-1" role="dialog" aria-labelledby="divModal" aria-hidden="true">
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

    <style>
        #dropDownList{
            border: 2px black solid;
        }
        #dropDownList a{
            max-height:100px;/* you can change as you need it */
            overflow-y:auto;/* to get scroll */
        }
        #dropDownList:hover{
            cursor: pointer;
        }

        /*Jelek kalau hanya 1 kalender*/
        /*.calendar.right {*/
        /*    display: none !important;*/
        /*}*/
    </style>
    <script>
        //DATA YANG DILOAD SEWAKTU HALAMAN BARU DIBUKA
        let cursor = ''; // Berfungsi untuk mendeteksi tombol mana yang memanggil modal
        let tableDiv; //untuk menampung data modaldiv (untuk read aja), agar isi data table nya bisa dipakai difungsi lain
        let tableDept; //untuk menampung data modaldept (untuk read aja), agar isi data table nya bisa dipakai difungsi lain
        $(document).ready(function () {
            getModalDiv(); //Mengisi divModal
            getModalDept(); //Mengisi divModal
            // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change( function() {
                tableDept.draw();
            } );
        })

        /* Custom filtering function which will search data in column four between two values */
        //Custom Filtering untuk dept
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                let min = parseInt( $('#min').val(), 10 );
                let max = parseInt( $('#max').val(), 10 );
                let val = parseFloat( data[2] ) || 0; // use data for the val column, [22] maksudnya kolom ke 2, yaitu kode_div

                if ( ( isNaN( min ) && isNaN( max ) ) ||
                    ( isNaN( min ) && val <= max ) ||
                    ( min <= val   && isNaN( max ) ) ||
                    ( min <= val   && val <= max ) )
                {
                    return true;
                }
                return false;
            }
        );

        function getModalDiv(){
            tableDiv =  $('#tableModalDiv').DataTable({ //langsung $('#tableModalDiv').DataTable({}) juga bisa, tapi pakai tableDiv untuk membaca isi di fungsi lain
                "ajax": {
                    'url' : '{{ url()->current().'/getdiv' }}',
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
                columnDefs : [
                ],
                "order": []
            });
        }
        function getModalDept(){
            tableDept =  $('#tableModalDept').DataTable({ //langsung $('#tableModalDiv').DataTable({}) juga bisa, tapi pakai tableDiv untuk membaca isi di fungsi lain
                "ajax": {
                    'url' : '{{ url()->current().'/getdept' }}',
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
                columnDefs : [
                ],
                "order": []
            });
        }

        //    Function untuk onclick pada data modal DIV
        // IMPORTANT!!! ### BUTUH CURSOR UNTUK MENDETEKSI TOMBOL MANA YANG MEMANGGIL! ###
        $(document).on('click', '.modalRowDiv', function () {
            $('#divModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menu1"){
                chooseDivMenu1(currentButton);
            }
        });

        //    Function untuk onclick pada data modal DIV
        // IMPORTANT!!! ### BUTUH CURSOR UNTUK MENDETEKSI TOMBOL MANA YANG MEMANGGIL! ###
        $(document).on('click', '.modalRowDept', function () {
            $('#deptModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menu1"){
                chooseDeptMenu1(currentButton);
            }
        });

        function changeInput(val){
            // SEKEDAR INFO!!!
            // val == 1, then  "LAPORAN PER KATEGORY";
            // val == 2, then  "LAPORAN PER DEPARTEMEN";
            // val == 3, then  "RINCIAN PRODUK PER DIVISI";
            // val == 4, then  "LAPORAN PER HARI";
            // val == 5, then  "LAPORAN PER KASIR";
            switch (val){
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
            }
        }

        // fungsi pilih() dan kembali() merupakan fungsi navigasi antar menu
        function pilih(){
            if($('#jenisLaporan').val() == ''){
                swal('Warning', 'Belum ada yang dipilih!', 'warning');
            }else{
                switch ($('#jenisLaporan').val()){
                    case "LAPORAN PER KATEGORY" :
                        $('#mainMenu').prop("hidden",true);
                        $('#menu1').prop("hidden",false);
                        break;
                    case "LAPORAN PER DEPARTEMEN" :
                        $('#mainMenu').prop("hidden",true);
                        $('#menu2').prop("hidden",false);
                        break;
                    case "RINCIAN PRODUK PER DIVISI" :
                        $('#mainMenu').prop("hidden",true);
                        $('#menu3').prop("hidden",false);
                        break;
                    case "LAPORAN PER HARI" :
                        $('#mainMenu').prop("hidden",true);
                        $('#menu4').prop("hidden",false);
                        break;
                    case "LAPORAN PER KASIR" :
                        $('#mainMenu').prop("hidden",true);
                        $('#menu5').prop("hidden",false);
                        break;
                }
            }
        }
        function kembali(){
            if($('#menu1').is(":visible")){
                clearMenu1();
                $('#menu1').prop("hidden",true);
                $('#mainMenu').prop("hidden",false);
            }else if($('#menu2').is(":visible")){
                $('#menu2').prop("hidden",true);
                $('#mainMenu').prop("hidden",false);
            }
            else if($('#menu3').is(":visible")){
                $('#menu3').prop("hidden",true);
                $('#mainMenu').prop("hidden",false);
            }
            else if($('#menu4').is(":visible")){
                $('#menu4').prop("hidden",true);
                $('#mainMenu').prop("hidden",false);
            }
            else if($('#menu5').is(":visible")){
                $('#menu5').prop("hidden",true);
                $('#mainMenu').prop("hidden",false);
            }
        }

        //merubah format date range picker
        $(function() {
            $("#daterangepicker").daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
        });

        //-------------------- SCRIPT UNTUK ### MENU 1 ### --------------------
        //Menggerakkan cursor
        $("#menu1 :button").click(function(){
            cursor = this.id;
        });

        //fungsi date menu1
        $('#daterangepicker1').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function(start, end, label) { //untuk mendeteksi bila perubahan tidak dibulan yang sama ketika melakukan perubahan
            if(start.format('YYYY') !== end.format('YYYY') || start.format('MM') !== end.format('MM')){
                swal({
                    title:'Periode Bulan',
                    text: 'Bulan Periode Tanggal harus sama.',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#daterangepicker1').data('daterangepicker').setStartDate(start.format('DD/MM/YYYY'));
                    $('#daterangepicker1').data('daterangepicker').setEndDate(start.format('DD/MM/YYYY'));
                    $('#daterangepicker1').select();
                });
            }else{
                $('#yaTidakMenu1').focus(); //focus ke kolom berikutnya
            }
            //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        function isYT(evt){ //membatasi input untuk hanya boleh Y dan T, serta mendeteksi bila menekan tombol enter
            $('#yaTidakMenu1').keyup(function(){
                $(this).val($(this).val().toUpperCase());
            });
            let charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 121) // y kecil
                return 89; // Y besar

            if (charCode == 116) // t kecil
                return 84; //t besar

            if (charCode == 89 || charCode == 84)
                return true
            if (charCode == 13){
                khususElektronik();

                //Fokus ke kolom berikutnya
                if($('#yaTidakMenu1').val() == 'Y'){
                    $('#menu1divA1').focus();
                }else if($('#yaTidakMenu1').val() == 'T'){
                    $('#menu1divB1').focus();
                }

                return true
            }
            return false;
        }

        function khususElektronik(){ //untuk memperiksa apakah kolom khusus elektronik Y,T, atau kosong, lalu menampilkan div/dept sesuai input #yaTidakMenu1
            switch ($('#yaTidakMenu1').val()){
                case '':
                    $('#divA').prop("hidden",true);
                    $('#divB').prop("hidden",true);

                    $('#deptA').prop("hidden",true);
                    $('#deptB').prop("hidden",true);
                    break;
                case 'Y':
                    $('#divA').prop("hidden",false);
                    $('#divB').prop("hidden",true);

                    $('#deptA').prop("hidden",false);
                    $('#deptB').prop("hidden",true);
                    break;
                case 'T':
                    $('#divA').prop("hidden",true);
                    $('#divB').prop("hidden",false);

                    $('#deptA').prop("hidden",true);
                    $('#deptB').prop("hidden",false);
                    break;
            }
        }

        //Fungsi memilih div, dipanggil oleh onclick dari .modalRowDiv
        function chooseDivMenu1(val){
            let kodedivisi = val.children().first().text();
            //let namadivisi = currentButton.children().first().next().text(); //ga pakai, yang kepakai kodedivisi doang
            switch (cursor.substr(5,5)){
                case "A1div":
                    $('#menu1divA1').val(kodedivisi);
                    setTimeout(function() { //tidak tau kenapa harus 10milisecond baru bisa pindah focus
                        $('#menu1divA1').focus();
                    }, 10);

                    break;
                case "A2div":
                    $('#menu1divA2').val(kodedivisi);
                    setTimeout(function() {
                        $('#menu1divA2').focus();
                    }, 10);
                    break;
                case "A3div":
                    $('#menu1divA3').val(kodedivisi);
                    setTimeout(function() {
                        $('#menu1divA3').focus();
                    }, 10);
                    break;
                case "B1div":
                    $('#menu1divB1').val(kodedivisi);
                    setTimeout(function() {
                        $('#menu1divB1').focus();
                    }, 10);
                    break;
                case "B2div":
                    $('#menu1divB2').val(kodedivisi);
                    setTimeout(function() {
                        $('#menu1divB2').focus();
                    }, 10);
                    break;
            }
        }

        //Fungsi memilih dept, dipanggil oleh onclick dari .modalRowDept
        function chooseDeptMenu1(val){
            let kodedepartemen = val.children().first().text();
            //let namadepartemen = currentButton.children().first().next().text(); //ga pakai, yang kepakai kodedivisi doang
            switch (cursor.substr(5,6)){
                case "A1dept":
                    $('#menu1deptA1').val(kodedepartemen);
                    setTimeout(function() { //tidak tau kenapa harus 10milisecond baru bisa pindah focus
                        $('#menu1deptA1').focus();
                    }, 10);

                    break;
                case "A2dept":
                    $('#menu1deptA2').val(kodedepartemen);
                    setTimeout(function() {
                        $('#menu1deptA2').focus();
                    }, 10);
                    break;
                case "A3dept":
                    $('#menu1deptA3').val(kodedepartemen);
                    setTimeout(function() {
                        $('#menu1deptA3').focus();
                    }, 10);
                    break;
                case "A4dept":
                    $('#menu1deptA4').val(kodedepartemen);
                    setTimeout(function() {
                        $('#menu1deptA4').focus();
                    }, 10);
                    break;
                case "B1dept":
                    $('#menu1deptB1').val(kodedepartemen);
                    setTimeout(function() {
                        $('#menu1deptB1').focus();
                    }, 10);
                    break;
                case "B2dept":
                    $('#menu1deptB2').val(kodedepartemen);
                    setTimeout(function() {
                        $('#menu1deptB2').focus();
                    }, 10);
                    break;
            }
        }

        //Fungsi enter Input Div
        //Menu Div A
        $('#menu1divA1').on('keypress',function(e){
            if(e.which == 13){
                if($('#menu1divA1').val() == ''){
                    swal({
                        title:'Warning',
                        text: 'Data Divisi tidak boleh kosong!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1divA1').focus();
                    })
                    return false;
                }else if(!checkDivExist($('#menu1divA1').val())){
                    swal({
                        title:'Warning',
                        text: 'Data Divisi Salah!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1divA1').select();
                    })
                    return false;
                }else{
                    check3div();
                    $('#menu1divA2').focus();
                }
            }
        });
        $('#menu1divA2').on('keypress',function(e){
            if(e.which == 13){
                if($('#menu1divA2').val() == ''){
                    swal({
                        title:'Warning',
                        text: 'Data Divisi tidak boleh kosong!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1divA2').focus();
                    })
                    return false;
                }else if(!checkDivExist($('#menu1divA2').val())){
                    swal({
                        title:'Warning',
                        text: 'Data Divisi Salah!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1divA2').select();
                    })
                    return false;
                }else{
                    check3div();
                    $('#menu1divA3').focus();
                }
            }
        });
        $('#menu1divA3').on('keypress',function(e){
            if(e.which == 13){
                if($('#menu1divA3').val() == ''){
                    swal({
                        title:'Warning',
                        text: 'Data Divisi tidak boleh kosong!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1divA3').focus();
                    })
                    return false;
                }else if(!checkDivExist($('#menu1divA3').val())){
                    swal({
                        title:'Warning',
                        text: 'Data Divisi Salah!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1divA3').select();
                    })
                    return false;
                }else{
                    check3div();
                    if($('#menu1divA1').val() == '3' || $('#menu1divA2').val() == '3' || $('#menu1divA3').val() == '3'){
                        $('#menu1deptA1').focus();
                    }else{
                        $('#menu1Cetak').focus();
                    }
                }
            }
        });

        //Menu Div B
        $('#menu1divB1').on('keypress',function(e){
            if(e.which == 13){
                if($('#menu1divB1').val() == ''){
                    lowest = tableDiv.row(0).data()['div_kodedivisi'];
                    for(i=0;i<tableDiv.data().length;i++){
                        if(tableDiv.row(i).data()['div_kodedivisi'] < lowest){
                            lowest = tableDiv.row(i).data()['div_kodedivisi'];
                        }
                    }
                    $('#menu1divB1').val(lowest);
                    $('#min').val(lowest).change(); //isi filter min
                    $('#menu1divB2').focus();
                }else if(!checkDivExist($('#menu1divB1').val())){
                    swal({
                        title:'Warning',
                        text: 'Data Divisi Salah!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1divB1').select();
                    })
                    return false;
                }else{
                    $('#min').val($('#menu1divB1').val()).change(); //isi filter min
                    $('#menu1divB2').focus();
                }
            }
        });
        $('#menu1divB2').on('keypress',function(e){
            if(e.which == 13){
                if($('#menu1divB2').val() == ''){
                    highest = tableDiv.row(0).data()['div_kodedivisi'];
                    for(i=0;i<tableDiv.data().length;i++){
                        if(tableDiv.row(i).data()['div_kodedivisi'] > highest){
                            highest = tableDiv.row(i).data()['div_kodedivisi'];
                        }
                    }
                    $('#menu1divB2').val(highest);
                    $('#max').val(highest).change(); //isi filter max
                    $('#menu1deptB1').focus();
                }else if(!checkDivExist($('#menu1divB2').val())){
                    swal({
                        title:'Warning',
                        text: 'Data Divisi Salah!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1divB2').select();
                    })
                    return false;
                }else{
                    $('#max').val($('#menu1divB2').val()).change(); //isi filter max
                    $('#menu1deptB1').focus();
                }
            }
        });

        //Untuk periksa apakah div ada
        function checkDivExist(val){
            for(i=0;i<tableDiv.data().length;i++){
                if(tableDiv.row(i).data()['div_kodedivisi'] == val){
                    return true;
                }
            }
            return false;
        }

        //fungsi untuk periksa apakah ada div 3 dipilih dan enable input dept, dan disable bila tidak ada
        function check3div(){ //khusus menu 1 dan khusus elektronik
            if($('#menu1divA1').val() == '3' || $('#menu1divA2').val() == '3' || $('#menu1divA3').val() == '3'){
                //enable kolom input
                $('#menu1deptA1').prop('disabled',false);
                $('#menu1deptA2').prop('disabled',false);
                $('#menu1deptA3').prop('disabled',false);
                $('#menu1deptA4').prop('disabled',false);
                //enable button
                $('#menu1A1dept').prop('disabled',false);
                $('#menu1A2dept').prop('disabled',false);
                $('#menu1A3dept').prop('disabled',false);
                $('#menu1A4dept').prop('disabled',false);

                $('#min').val('3').change(); //isi filter min
                $('#max').val('3').change(); //isi filter max
            }else{
                //disable kolom input
                $('#menu1deptA1').prop('disabled',true);
                $('#menu1deptA2').prop('disabled',true);
                $('#menu1deptA3').prop('disabled',true);
                $('#menu1deptA4').prop('disabled',true);
                //disable button
                $('#menu1A1dept').prop('disabled',true);
                $('#menu1A2dept').prop('disabled',true);
                $('#menu1A3dept').prop('disabled',true);
                $('#menu1A4dept').prop('disabled',true);

                $('#min').val('').change(); //hapus filter min
                $('#max').val('').change(); //hapus filter max
            }
        }

        //Fungsi enter Input Dept
        //Menu Dept A
        $('#menu1deptA1').on('keypress',function(e){
            if(e.which == 13){
                if($('#menu1deptA1').val() == ''){
                    swal({
                        title:'Warning',
                        text: 'Data Departemen tidak boleh kosong bila salah satu divisi mengandung 3!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1deptA1').focus();
                    })
                    return false;
                }else if(!checkDeptExist($('#menu1deptA1').val())){
                    swal({
                        title:'Warning',
                        text: 'Data Departemen Salah!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1deptA1').select();
                    })
                    return false;
                }else{
                    $('#menu1deptA2').focus();
                }
            }
        });
        $('#menu1deptA2').on('keypress',function(e){
            if(e.which == 13){
                if($('#menu1deptA2').val() == ''){
                    swal({
                        title:'Warning',
                        text: 'Data Departemen tidak boleh kosong bila salah satu divisi mengandung 3!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1deptA2').focus();
                    })
                    return false;
                }else if(!checkDeptExist($('#menu1deptA2').val())){
                    swal({
                        title:'Warning',
                        text: 'Data Departemen Salah!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1deptA2').select();
                    })
                    return false;
                }else{
                    $('#menu1deptA3').focus();
                }
            }
        });
        $('#menu1deptA3').on('keypress',function(e){
            if(e.which == 13){
                if($('#menu1deptA3').val() == ''){
                    swal({
                        title:'Warning',
                        text: 'Data Departemen tidak boleh kosong bila salah satu divisi mengandung 3!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1deptA3').focus();
                    })
                    return false;
                }else if(!checkDeptExist($('#menu1deptA3').val())){
                    swal({
                        title:'Warning',
                        text: 'Data Departemen Salah!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1deptA3').select();
                    })
                    return false;
                }else{
                    $('#menu1deptA4').focus();
                }
            }
        });
        $('#menu1deptA4').on('keypress',function(e){
            if(e.which == 13){
                if($('#menu1deptA4').val() == ''){
                    swal({
                        title:'Warning',
                        text: 'Data Departemen tidak boleh kosong bila salah satu divisi mengandung 3!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1deptA4').focus();
                    })
                    return false;
                }else if(!checkDeptExist($('#menu1deptA4').val())){
                    swal({
                        title:'Warning',
                        text: 'Data Departemen Salah!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1deptA4').select();
                    })
                    return false;
                }else{
                    $('#menu1Cetak').focus();
                }
            }
        });

        $('#menu1deptB1').on('keypress',function(e){
            if(e.which == 13){
                if($('#menu1divB1').val() == '' || $('#menu1divB2').val() == ''){
                    swal({
                        title:'Warning',
                        text: 'Data Divisi ada yang Kosong!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1divB1').focus();
                    })
                    return false;
                }else if($('#menu1deptB1').val() == ''){
                    lowest = tableDept.row(0).data()['dep_kodedepartement'];
                    for(i=0;i<tableDept.data().length;i++){
                        if(tableDept.row(i).data()['dep_kodedepartement'] < lowest){
                            lowest = tableDept.row(i).data()['dep_kodedepartement'];
                        }
                    }
                    $('#menu1deptB1').val(lowest);
                    $('#menu1deptB2').focus();
                }else if(!checkDeptExist($('#menu1deptB1').val())){
                    swal({
                        title:'Warning',
                        text: 'Data Departemen Salah!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1deptB1').select();
                    })
                    return false;
                }else{
                    $('#menu1deptB2').focus();
                }
            }
        });

        $('#menu1deptB2').on('keypress',function(e){
            if(e.which == 13){
                if($('#menu1divB1').val() == '' || $('#menu1divB2').val() == ''){
                    swal({
                        title:'Warning',
                        text: 'Data Divisi ada yang Kosong!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1divB1').focus();
                    })
                    return false;
                }else if($('#menu1deptB2').val() == ''){
                    highest = tableDept.row(0).data()['dep_kodedepartement'];
                    for(i=0;i<tableDept.data().length;i++){
                        if(tableDept.row(i).data()['dep_kodedepartement'] > highest){
                            highest = tableDept.row(i).data()['dep_kodedepartement'];
                        }
                    }
                    $('#menu1deptB2').val(highest);
                    $('#menu1Cetak').focus();
                }else if(!checkDeptExist($('#menu1deptB2').val())){
                    swal({
                        title:'Warning',
                        text: 'Data Departemen Salah!',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1deptB2').select();
                    })
                    return false;
                }else{
                    $('#menu1Cetak').focus();
                }
            }
        });

        //Untuk periksa apakah dept ada
        function checkDeptExist(val){
            for(i=0;i<tableDept.data().length;i++){
                if(tableDept.row(i).data()['dep_kodedepartement'] == val){
                    return true;
                }
            }
            return false;
        }

        //fungsi cetak menu 1
        function cetakMenu1(){
            let date = $('#daterangepicker1').val();
            if(date == null || date == ""){
                swal('Periode tidak boleh kosong','','warning');
                return false;
            }
            let dateA = date.substr(0,10);
            let dateB = date.substr(13,10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');

            if($('#yaTidakMenu1').val() == ''){
                swal({
                    title:'Warning',
                    text: 'Input tidak boleh kosong!',
                    icon:'warning',
                }).then(function() {
                    $('#yaTidakMenu1').focus();
                })
                return false;
            }else if($('#yaTidakMenu1').val() == 'Y'){
                if($('#menu1divA1').val() == '' || $('#menu1divA2').val() == '' || $('#menu1divA3').val() == ''){
                    swal({
                        title:'Warning',
                        text: 'Divisi Tidak Boleh Kosong',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1divA3').focus();
                    })
                    return false;
                }else if($('#menu1divA1').val() == '3' || $('#menu1divA2').val() == '3' || $('#menu1divA3').val() == '3'){
                    if($('#menu1deptA1').val() == '' || $('#menu1deptA2').val() == '' || $('#menu1deptA3').val() == '' || $('#menu1deptA4').val() == ''){
                        swal({
                            title:'Warning',
                            text: 'Jika Divisi = 3 , Departemen Tidak Boleh Kosong !',
                            icon:'warning',
                        }).then(function() {
                            $('#menu1deptA1').focus();
                        })
                        return false;
                    }
                }
                //Periksa apakah data divisi ada di daftar nilai divisi atau tidak
                if(!checkDivExist($('#menu1divA1').val())){
                    swal({
                        title:'Warning',
                        text: 'Data divisi salah',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1divA1').select();
                    })
                    return false;
                }else if(!checkDivExist($('#menu1divA2').val())){
                    swal({
                        title:'Warning',
                        text: 'Data divisi salah',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1divA2').select();
                    })
                    return false;
                }else if(!checkDivExist($('#menu1divA3').val())){
                    swal({
                        title:'Warning',
                        text: 'Data divisi salah',
                        icon:'warning',
                    }).then(function() {
                        $('#menu1divA3').select();
                    })
                    return false;
                }else{
                    //Periksa apakah data departemen ada di daftar nilai departemen atau tidak bila ada if yang mengandung 3
                    if($('#menu1divA1').val() == '3' || $('#menu1divA2').val() == '3' || $('#menu1divA3').val() == '3'){
                        if(!checkDeptExist($('#menu1deptA1').val())){
                            swal({
                                title:'Warning',
                                text: 'Data departemen salah',
                                icon:'warning',
                            }).then(function() {
                                $('#menu1deptA1').select();
                            })
                            return false;
                        }else if(!checkDeptExist($('#menu1deptA2').val())){
                            swal({
                                title:'Warning',
                                text: 'Data departemen salah',
                                icon:'warning',
                            }).then(function() {
                                $('#menu1deptA2').select();
                            })
                            return false;
                        }else if(!checkDeptExist($('#menu1deptA3').val())){
                            swal({
                                title:'Warning',
                                text: 'Data departemen salah',
                                icon:'warning',
                            }).then(function() {
                                $('#menu1deptA3').select();
                            })
                            return false;
                        }else if(!checkDeptExist($('#menu1deptA4').val())){
                            swal({
                                title:'Warning',
                                text: 'Data departemen salah',
                                icon:'warning',
                            }).then(function() {
                                $('#menu1deptA4').select();
                            })
                            return false;
                        }
                    }
                }
            }else{
                if($('#menu1divB1').val() == '' || !checkDivExist($('#menu1divB1').val())){ //bila data div salah diubah jadi 1
                    $('#menu1divB1').val('1');
                }
                if($('#menu1divB2').val() == '' || !checkDivExist($('#menu1divB2').val())){ //bila data div salah diubah jadi divisi tertinggi
                    highest = tableDiv.row(0).data()['div_kodedivisi'];
                    for(i=0;i<tableDiv.data().length;i++){
                        if(tableDiv.row(i).data()['div_kodedivisi'] > highest){
                            highest = tableDiv.row(i).data()['div_kodedivisi'];
                        }
                    }
                    $('#menu1divB2').val(highest);
                }
                if($('#menu1deptB1').val() == '' || !checkDeptExist($('#menu1deptB1').val())){ //bila data dept salah diubah jadi 01
                    $('#menu1deptB1').val('01');
                }
                if($('#menu1deptB2').val() == '' || !checkDeptExist($('#menu1deptB2').val())){ //bila data dept salah diubah jadi departemen tertinggi
                    //$('#menu1deptB2').val('53');
                    highest = tableDept.row(0).data()['dep_kodedepartement'];
                    for(i=0;i<tableDept.data().length;i++){
                        if(tableDept.row(i).data()['dep_kodedepartement'] > highest){
                            highest = tableDept.row(i).data()['dep_kodedepartement'];
                        }
                    }
                    $('#menu1deptB2').val(highest);
                }
            }

            //kondisi untuk menampilkan qty/tidak lalu cetak
            let qty = 'T';
            if($('#yaTidakMenu1').val() == 'Y'){
                qty = 'Y';
                //cetak_lap_jual_kategory_y
                kembali();

            }else{
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
                        window.open(`{{ url()->current() }}/printdocument?date1=${dateA}&date2=${dateB}&qty=${qty}&dept1=${$('#menu1deptB1').val()}&dept2=${$('#menu1deptB2').val()}&div1=${$('#menu1divB1').val()}&div2=${$('#menu1divB2').val()}`, '_blank');
                        kembali();
                    });
            }
        }

        //Clear Input Menu 1
        function clearMenu1(){
            $('#menu1 input').val('');
            $('#daterangepicker1').data('daterangepicker').setStartDate(moment().format('DD/MM/YYYY'));
            $('#daterangepicker1').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));

            $('#divA input').prop('disabled',true);
            $('#divA button').prop('disabled',true);
            $('#deptA input').prop('disabled',true);
            $('#deptA button').prop('disabled',true);

            $('#divA').prop('hidden',true);
            $('#divB').prop('hidden',true);
            $('#deptA').prop('hidden',true);
            $('#deptB').prop('hidden',true);
        }

        //tips navigasi (Ctrl+F) ketik ### menu <menu mana yang mau di lihat> (Ex. ### menu 0
    </script>
@endsection
