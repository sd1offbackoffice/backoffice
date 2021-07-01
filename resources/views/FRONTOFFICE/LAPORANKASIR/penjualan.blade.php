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
                                            <input id="menu1deptA1" class="col-sm-2 text-center form-control" type="text" disabled>
                                            <label class="col-sm-1 text-center col-form-label">,</label>
                                            <input id="menu1deptA2" class="col-sm-2 text-center form-control" type="text" disabled>
                                            <label class="col-sm-1 text-center col-form-label">,</label>
                                            <input id="menu1deptA3" class="col-sm-2 text-center form-control" type="text" disabled>
                                            <label class="col-sm-1 text-center col-form-label">,</label>
                                            <input id="menu1deptA4" class="col-sm-2 text-center form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div id="deptB" class="col-sm-8" hidden>
                                        <div class="row">
                                            <input id="deptB1" class="col-sm-4 text-center form-control" type="text">
                                            <label class="col-sm-2 text-center col-form-label">s/d</label>
                                            <input id="deptB2" class="col-sm-4 text-center form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary btn-block col-sm-3" type="button" onclick="kembali()">BACK</button>
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
        $(document).ready(function () {
            getModalDiv(); //Mengisi divModal
        })
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
        //    Function untuk onclick pada data modal DIV
        // IMPORTANT!!! ### BUTUH CURSOR UNTUK MENDETEKSI TOMBOL MANA YANG MEMANGGIL! ###
        $(document).on('click', '.modalRowDiv', function () {
            $('#divModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menu1"){
                chooseDivMenu1(currentButton);
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

        //-------------------- SCRIPT UNTUK MENU 1 --------------------
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
        //Fungsi enter Input Div
        $('#menu1divA1').on('keypress',function(e){
            if(e.which == 13){
                $('#menu1divA2').focus();
            }
        });
        $('#menu1divA2').on('keypress',function(e){
            if(e.which == 13){
                $('#menu1divA3').focus();
            }
        });
        $('#menu1divA3').on('keypress',function(e){
            if(e.which == 13){
                if($('#menu1divA1').val() == '3' || $('#menu1divA2').val() == '3' || $('#menu1divA3').val() == '3'){
                    $('#menu1deptA1').prop('disabled',false);
                    $('#menu1deptA2').prop('disabled',false);
                    $('#menu1deptA3').prop('disabled',false);
                    $('#menu1deptA4').prop('disabled',false);
                    $('#menu1deptA1').focus();
                }else{
                    $('#menu1deptA1').prop('disabled',true);
                    $('#menu1deptA2').prop('disabled',true);
                    $('#menu1deptA3').prop('disabled',true);
                    $('#menu1deptA4').prop('disabled',true);
                    //auto fokus ketombol cetak disini
                }
            }
        });

    </script>
@endsection
