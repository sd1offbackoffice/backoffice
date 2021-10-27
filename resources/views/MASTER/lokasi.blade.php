@extends('navbar')
@section('title','MASTER | MASTER LOKASI')
@section('content')


    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12 pl-5 pr-5">
                <div class="card border-dark">
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <label for="lks_koderak" class="col-sm-1 col-form-label">KODE RAK</label>
                            <div class="col-sm-1 buttonInside">
                                <input maxlength="10" type="text" class="form-control" id="lks_koderak">
                                <button id="btn-lov" type="button" class="btn btn-lov btn-primary p-0" data-toggle="modal" data-target="#m_lov_rak">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <label for="lks_kodesubrak" class="col-sm-1 col-form-label">SUB RAK</label>
                            <div class="col-sm-1">
                                <input maxlength="10" type="text" class="form-control" id="lks_kodesubrak">
                            </div>
                        </div>
                        <div class="row">
                            <label for="lks_tiperak" class="col-sm-1 col-form-label">TIPE RAK</label>
                            <div class="col-sm-1">
                                <input maxlength="10" type="text" class="form-control" id="lks_tiperak">
                            </div>
                        </div>
                        <div class="row">
                            <label for="lks_shelvingrak" class="col-sm-1 col-form-label">SHELVING</label>
                            <div class="col-sm-1">
                                <input maxlength="10" type="text" class="form-control" id="lks_shelvingrak">
                            </div>
                            <div class="col-sm-4"></div>
                            <label for="jumlahitem" class="col-sm-1 col-form-label">JUMLAH ITEM</label>
                            <div class="col-sm-1">
                                <input disabled maxlength="10" type="text" class="form-control" id="jumlahitem">
                            </div>
                        </div>
                        <br>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12 pr-0 pl-0 overflow-auto" style="height: 30vh">

                                    <table onclick="cursorTableChanger(this)" id="table-all" class="table table-sm table-bordered m-1 mb-4">
                                        <thead>
                                            <tr class="text-center no-border">
                                                <th rowspan="2" width="3%"></th>
                                                <th rowspan="2" width="3%">NO</th>
                                                <th rowspan="2" width="3%">D - B</th>
                                                <th rowspan="2" width="3%">A - B</th>
                                                <th rowspan="2" width="6%">PLU</th>
                                                <th rowspan="2" width="3%">JENIS</th>
                                                <th rowspan="2" width="25%">DESKRIPSI</th>
                                                <th rowspan="2" width="5%">SATUAN</th>
                                                <th rowspan="2" width="5%">NO ID</th>
                                                <th colspan="3">DIMENSI</th>
                                                <th colspan="3">T I R</th>
                                                <th colspan="2">DISPLAY</th>
                                                <th rowspan="2" width="5%">PKM</th>
                                                <th rowspan="2">QTY<br>(PCS)</th>
                                                <th rowspan="2">MIN PCT<br>(%)</th>
                                                <th rowspan="2">MIN PCT<br>(PCS)</th>
                                                <th rowspan="2">MAX PLANO<br>(PCS)</th>
                                            </tr>
                                            <tr class="text-center">
                                                <th width="4%">P</th>
                                                <th width="4%">L</th>
                                                <th width="4%">T</th>
                                                <th width="3%">K - K</th>
                                                <th width="3%">D - B</th>
                                                <th width="3%">A - B</th>
                                                <th width="3%">MIN</th>
                                                <th width="3%">MAX</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @for($i=0;$i<8;$i++)
                                        <tr onclick="cursorRowChanger(this)" class="text-center" id="row_{{ $i }}">
                                            <td width="3%">
                                                <button onclick="deleteRow({{ $i }})" class="col-sm btn btn-danger btn-delete">X</button>
                                            </td>
                                            <td width="3%"><input type="text" class="form-control lks_nourut"></td>
                                            <td width="3%"><input type="text" class="form-control"></td>
                                            <td width="3%"><input type="text" class="form-control"></td>
                                            <td width="6%">
                                                <div class="buttonInside">
                                                    <input type="text" class="form-control lks_prdcd" maxlength="7">
                                                    <button style="display: none" type="button" class="btn btn-primary btn-lov p-0 btn-lov-plu" data-toggle="modal" data-target="#m_lov_plu"><i class="fas fa-question"></i> </button>
                                                </div>
                                            </td>
                                            <td width="3%"><input disabled type="text" class="form-control"></td>
                                            <td width="25%"><input disabled type="text" class="desk form-control"></td>
                                            <td width="5%"><input disabled type="text" class="form-control"></td>
                                            <td width="5%"><input type="text" class="form-control"></td>
                                            <td width="4%"><input disabled type="text" class="form-control"></td>
                                            <td width="4%"><input disabled type="text" class="form-control"></td>
                                            <td width="4%"><input disabled type="text" class="form-control"></td>
                                            <td width="3%"><input type="text" class="form-control"></td>
                                            <td width="3%"><input type="text" class="form-control"></td>
                                            <td width="3%"><input type="text" class="form-control"></td>
                                            <td width="3%"><input disabled type="text" class="form-control"></td>
                                            <td width="3%"><input type="text" class="form-control"></td>
                                            <td width="5%"><input disabled type="text" class="form-control"></td>
                                            <td width="4%"><input disabled type="text" class="form-control"></td>
                                            <td width="4%"><input type="text" class="form-control"></td>
                                            <td width="4%"><input disabled type="text" class="form-control"></td>
                                            <td width="5%"><input type="text" class="form-control"></td>
                                        </tr>
                                        @endfor
                                        </tbody>
                                    </table>
{{--                                blyat--}}
                                    <table onclick="cursorTableChanger(this)" id="table-s" class="table table-sm table-bordered m-1 mb-4 text-center align-middle">
                                        <thead>
                                        <tr>
                                            <th class="align-middle" width="3%"></th>
                                            <th class="align-middle" width="3%">NO</th>
                                            <th class="align-middle" width="5%">D - B</th>
                                            <th class="align-middle" width="5%">A - B</th>
                                            <th class="align-middle" width="10%">PLU</th>
                                            <th class="align-middle" width="10%">JENIS</th>
                                            <th class="align-middle" width="30%">DESKRIPSI</th>
                                            <th class="align-middle" width="7%">SATUAN</th>
                                            <th class="align-middle" width="7%">QTY (pcs)</th>
                                            <th class="align-middle" width="10%">EXPIRED DATE</th>
                                            <th class="align-middle" width="10%">MAX PALET (CTN)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
{{--                                        karena hidden diawal tidak perlu diisi diawal, akan di isi melalui script--}}
                                        </tbody>
                                    </table>
                                <hr>
                            </div>
                        </div>
                        {{--Untuk mengetahui last modified dari program lokasi dengan melihat last modified dari file blade/controller--}}
                        {{--Last Edited--}}
                        <div class="float-right">
                            <?php
                            $viewPath = 'MASTER\lokasi.blade.php';
                            $controllerPath = 'MASTER\lokasiController.php';
                            if (file_exists(resource_path('views\\'.$viewPath))){
                                if(file_exists(app_path('Http\Controllers\\'.$controllerPath))){
                                    if(date ("F d Y H:i:s", filemtime(app_path('Http\Controllers\\'.$controllerPath))) > date ("F d Y H:i:s", filemtime(resource_path('views\\'.$viewPath)))){
                                        echo "Last Edited: ".date ("d-m-Y", filemtime(app_path('Http\Controllers\MASTER\lokasiController.php')));
                                    }else{
                                        echo "Last Edited: ".date ("d-m-Y", filemtime(resource_path('views\MASTER\lokasi.blade.php')));
                                    }
                                }else{
                                    echo "Last Edited: ".date ("d-m-Y", filemtime(resource_path('views\MASTER\lokasi.blade.php')));
                                }
                            }else{
                                echo 'Last Edited not found';
                            }
                            ?>
                        </div>

                        <br>

                        <ul class="nav nav-tabs custom-color" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="btn-tambah" data-toggle="tab" href="#p_tambah">TAMBAH</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="btn-noid" data-toggle="tab" href="#p_input_noid">INPUT NO ID</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="p_tambah" class="container-fluid tab-pane active pl-0 pr-0">
                                <div class="card-body ">
                                    <div class="row text-right">
                                        <div class="col-sm-12 overflow-auto">
                                            <table onclick="cursorTableChanger(this)" id="table-tambah" class="table table-sm table-bordered m-1 mb-4 text-center align-middle">
                                                <thead>
                                                    <tr>
                                                        <th width="3%">NO</th>
                                                        <th width="3%">D - B</th>
                                                        <th width="3%">A - B</th>
                                                        <th width="5%">PLU</th>
                                                        <th width="3%">JENIS</th>
                                                        <th width="27%">DESKRIPSI</th>
                                                        <th width="6%">SATUAN</th>
                                                        <th width="5%">NO ID</th>
                                                        <th width="4%">P</th>
                                                        <th width="4%">L</th>
                                                        <th width="4%">T</th>
                                                        <th width="4%">K - K</th>
                                                        <th width="4%">D - B</th>
                                                        <th width="4%">A - B</th>
                                                        <th width="4%">MINDIS</th>
                                                        <th width="4%">MAXDIS</th>
                                                        <th width="4%">PKM</th>
                                                        <th width="4%">MIN PCT</th>
                                                        <th width="6%">MAX PLANO</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="row_tambah">
                                                        <td><input type="text" class="form-control lks_nourut"></td>
                                                        <td><input type="text" class="form-control lks_depanbelakang"></td>
                                                        <td><input type="text" class="form-control lks_atasbawah"></td>
                                                        <td>
                                                            <div class="buttonInside">
                                                                <input type="text" class="form-control t_lks_prdcd" maxlength="7">
                                                                <button style="display: none" type="button" class="btn btn-lov-plu p-0 btn-lov" data-toggle="modal" data-target="#m_lov_plu"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                                                            </div>
                                                        </td>
                                                        <td><input type="text" class="form-control lks_jenisrak"></td>
                                                        <td><input type="text" class="form-control desk"></td>
                                                        <td><input type="text" class="form-control satuan"></td>
                                                        <td><input type="text" class="form-control t_lks_noid"></td>
                                                        <td><input type="text" class="form-control lks_dimensipanjangproduk"></td>
                                                        <td><input type="text" class="form-control lks_dimensilebarproduk"></td>
                                                        <td><input type="text" class="form-control lks_dimensitinggiproduk"></td>
                                                        <td><input type="text" class="form-control lks_tirkirikanan"></td>
                                                        <td><input type="text" class="form-control lks_tirdepanbelakang"></td>
                                                        <td><input type="text" class="form-control lks_tiratasbawah"></td>
                                                        <td><input type="text" class="form-control lks_mindisplay"></td>
                                                        <td><input type="text" class="form-control lks_maxdisplay"></td>
                                                        <td><input type="text" class="form-control pkm"></td>
                                                        <td><input type="text" class="form-control lks_minpct"></td>
                                                        <td><input type="text" class="form-control lks_maxplano"></td>
                                                    </tr>
{{--                                                    <tr class="d-flex">--}}
{{--                                                        <td width="9%"></td>--}}
{{--                                                        <td width="92%">--}}
{{--                                                            <div class="custom-control custom-checkbox text-left cb_delete">--}}
{{--                                                                <input type="checkbox" class="custom-control-input" id="cb_delete">--}}
{{--                                                                <label class="custom-control-label" for="cb_delete">DELETE PLU</label>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
                                                </tbody>
                                            </table>
{{--                                            tambahan tabel untuk koderak S--}}
                                            <table onclick="cursorTableChanger(this)" id="table-tambah-s" class="table table-sm table-bordered m-1 mb-4 text-center align-middle" hidden>
                                                <thead>
                                                <tr>
                                                    <th width="10%">NO.</th>
                                                    <th width="20%">Jenis Rak</th>
                                                    <th width="30%">MAX PALET</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><input min="1" type="number" class="form-control s_nourut"></td>
                                                    <td><input type="text" class="form-control s_jnsrak"></td>
                                                    <td><input min="0" type="number" class="form-control s_maxpalet"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                </div>
                                    {{--                                            <p class="float-left">Flag Delete PLU hanya berlaku untuk Storage Toko</p> maksudnya??--}}
                                    <button id="btn-tambah" class="btn btn-info float-right" onclick="tambah()">TAMBAH</button>
                                    {{--<button class="btn btn-success">SIMPAN</button>--}}
                                </div>
                            </div>
                            <div id="p_input_noid" class="container-fluid tab-pane pl-0 pr-0 fix-height">
                                <div class="card-body ">
                                    <div class="row text-right">
                                        <div class="col-sm-4"></div>
                                        <div class="col-sm-4">
                                            <button id="btn-input-noid" class="col-sm btn btn-success" data-toggle="modal" data-target="#m_input_noid">ENTRY MASTER NO ID DPD</button>
                                        </div>
                                        <div class="col-sm-4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id=m_input_noid tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Entry Master DPD</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <fieldset class="card border-secondary">
                            <legend  class="w-auto ml-5">ENTRY MASTER NO ID DPD</legend>
                            <div class="card-body shadow-lg cardForm">
                                <div class="row">
                                    <label for="periode" class="col-sm-3 col-form-label">NOMOR ID DPD</label>
                                    <div class="col-sm-3">
                                        <input maxlength="5" type="text" class="form-control" id="dpd_noid">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="periode" class="col-sm-3 col-form-label">KODE RAK</label>
                                    <div class="col-sm-3">
                                        <input maxlength="10" type="text" class="form-control" id="dpd_koderak">
                                    </div>
                                    <div class="col-sm-1 p-0">
                                        <button type="button" id="btn-lov" class="btn p-0 float-left btn-lov" data-toggle="modal" data-target="#m_lov_rak"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="periode" class="col-sm-3 col-form-label">KODE SUB RAK</label>
                                    <div class="col-sm-3">
                                        <input maxlength="10" type="text" class="form-control" id="dpd_kodesubrak">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="periode" class="col-sm-3 col-form-label">TIPE RAK</label>
                                    <div class="col-sm-3">
                                        <input maxlength="10" type="text" class="form-control" id="dpd_tiperak">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="periode" class="col-sm-3 col-form-label">SHELVING</label>
                                    <div class="col-sm-3">
                                        <input maxlength="10" type="text" class="form-control" id="dpd_shelvingrak">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="periode" class="col-sm-3 col-form-label">NOMOR URUT</label>
                                    <div class="col-sm-3">
                                        <input maxlength="10" type="text" class="form-control" id="dpd_nourut">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-3">
                                        <button id="btn_delete_dpd" class="col-sm btn btn-danger btn-delete" onclick="delete_dpd()">DELETE</button>
                                    </div>
                                    <div class="col-sm-3">
                                        <button id="btn_save_dpd" class="col-sm btn btn-success" onclick="save_dpd()">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_rak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Master Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_rak">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>RAK</th>
                                        <th>SUB RAK</th>
                                        <th>TIPE</th>
                                        <th>SHELV</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_plu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm" id="table_lov_plu">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <td>PLU</td>
                                        <td>Deskripsi</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
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
        .fix-height{
            height: 230px;
        }

        input{
            text-transform: uppercase;
        }
        input:focus {
            box-shadow: 0 0 2px 2px #3d94db;
        }

    </style>

    <script>
        //ini cursor untuk mengetahui ditable dan row mana tombol tambah plu ditekan
        let cursorIdTable = "table-all";
        let cursorRow = 0;

        function cursorTableChanger(theThis){
            cursorIdTable = theThis.id;
        }
        function cursorRowChanger(theThis){
            if(cursorIdTable === "table-all"){
                cursorRow = theThis.rowIndex-2;
            }else if(cursorIdTable === "table-s"){
                cursorRow = theThis.rowIndex-1;
            }else{
                cursorRow = 0;
            }
        }

        function noTwoDigit(number) { //convertToRupiah namun tanpa 2 digit di belakang
            if (!number)
                return '0';
            else
                number = parseFloat(number).toFixed(0);
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        $(document).ready(function (){
            $('#table-s').hide(); //hide table-s
            $('#lks_koderak').select(); //auto-fokus ke kode rak
            loadNmr(''); //memanggil fungsi mengisi datatables rak
            loadPlu(''); //memanggil fungsi mengisi datatables plu
        });

        function loadNmr(value){
            let tableNmr = $('#table_lov_rak').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/getlokasi' }}',
                    "data" : {
                        'value' : value
                    },
                },
                "columns": [
                    {data: 'lks_koderak', name: 'lks_koderak'},
                    {data: 'lks_kodesubrak', name: 'lks_kodesubrak'},
                    {data: 'lks_tiperak', name: 'lks_tiperak'},
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
                    $(row).addClass('modalRowRak');
                },
                "order": []
            });

            $('#table_lov_rak_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableNmr.destroy();
                    loadNmr(val);
                }
            })
        }
        $(document).on('click', '.modalRowRak', function () {
            let currentButton = $(this);
            lov_rak_select(currentButton); // mengirim kumpulan data pada row yang ditekan
            $('#m_lov_rak').modal('hide');
        });

        function loadPlu(value){
            let tablePlu = $('#table_lov_plu').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/getplu' }}',
                    "data" : {
                        'value' : value
                    },
                },
                "columns": [
                    {data: 'prd_prdcd', name: 'prd_prdcd'},
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
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
                    $(row).addClass('modalRowPlu');
                },
                "order": []
            });

            $('#table_lov_plu_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tablePlu.destroy();
                    loadPlu(val);
                }
            })
        }
        $(document).on('click', '.modalRowPlu', function () {
            let currentButton = $(this);
            // lov_plu_select(plu); not working function
            choosePlu(currentButton);
            $('#m_lov_plu').modal('hide');
        });

        //fungsi memilih plu
        function choosePlu(val){
            $('#modal-loader').modal('hide');
            $('#m_lov_plu').modal('hide');

            // if($('#modal-loader').is(':visible'))
            //     $('#modal-loader').modal('toggle');
            //
            // if($('#m_lov_plu').is(':visible'))
            //     $('#m_lov_plu').modal('toggle');

            if(cursorIdTable === "table-all"){
                if($('#table-all .lks_prdcd')[cursorRow].value == ''){
                    $('#table-all .lks_prdcd')[cursorRow].value = val.children().first().text();
                    $('#table-all .desk')[cursorRow].value = val.children().first().next().text();
                }
            }else if(cursorIdTable === "table-s"){
                if($('#table-s .lks_prdcd')[cursorRow].value == ''){
                    if($('#table-s .mpt_maxqty')[cursorRow].value == null){
                        if($('#table-s .lks_prdcd')[cursorRow].value != null){
                            $('#table-s .lks_prdcd')[cursorRow].value = null;
                        }else{
                            $('#table-s .lks_prdcd')[cursorRow].value = val.children().first().text();
                        }
                    }

                    $('#table-s .desk')[cursorRow].value = val.children().first().next().text();
                }
            }else if(cursorIdTable === "table-tambah"){
                $('#table-tambah .t_lks_prdcd')[0].value = val.children().first().text();
            }
        }


        //fungsi enter kode rak, kode subrak, tiperak, dan shelving rak
        $('#lks_koderak').on('keypress',function(e){
            if(e.which == 13){
                $('#lks_kodesubrak').select();
            }
        });
        $('#lks_kodesubrak').on('keypress',function(e){
            if(e.which == 13){
                $('#lks_tiperak').select();
            }
        });
        $('#lks_tiperak').on('keypress',function(e){
            if(e.which == 13){
                $('#lks_shelvingrak').select();
            }
        });
        $('#lks_shelvingrak').on('keypress',function(e){
            if(e.which == 13){
                lov_rak_select('input');
            }
        });

        function lov_rak_select(row){ //fungsi memilih rak
            if(row == 'input' && ($('#lks_koderak').val() == '' || $('#lks_kodesubrak').val() == '' || $('#lks_tiperak').val() == '' || $('#lks_shelvingrak').val() == '')){
                swal({
                    title: 'Inputan tidak lengkap!',
                    icon: 'error'
                }).then(function(){
                    if($('#lks_koderak').val() == '')
                        $('#lks_koderak').select();
                    else if($('#lks_kodesubrak').val() == '')
                        $('#lks_kodesubrak').select();
                    else if($('#lks_tiperak').val() == '')
                        $('#lks_tiperak').select();
                    else if($('#lks_shelvingrak').val() == '')
                        $('#lks_shelvingrak').select();
                });
            }
            else{
                if(isDPD){
                    $('#dpd_koderak').val(row.children().first().text());
                    $('#dpd_kodesubrak').val(row.children().first().next().text());
                    $('#dpd_tiperak').val(row.children().first().next().next().text());
                    $('#dpd_shelvingrak').val(row.children().first().next().next().next().text());
                }
                else{
                    data = {};

                    if(row != 'input'){
                        //ambil data dari datatables rak
                        data['lks_koderak'] = row.children().first().text();
                        data['lks_kodesubrak'] = row.children().first().next().text();
                        data['lks_tiperak'] = row.children().first().next().next().text();
                        data['lks_shelvingrak'] = row.children().first().next().next().next().text();
                    }
                    else{
                        data['lks_koderak'] = $('#lks_koderak').val();
                        data['lks_kodesubrak'] =  $('#lks_kodesubrak').val();
                        data['lks_tiperak'] = $('#lks_tiperak').val();
                        data['lks_shelvingrak'] = $('#lks_shelvingrak').val();
                    }

                    $.ajax({
                        url: '{{ url()->current().'/lov_rak_select' }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {data},
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');
                            $('#m_lov_rak').modal('hide');

                            // if($('#modal-loader').is(':visible'))
                            //     $('#modal-loader').modal('toggle');
                            //
                            // if($('#m_lov_rak').is(':visible'))
                            //     $('#m_lov_rak').modal('toggle');

                            if(response.length == 0){
                                swal({
                                    title: 'Data tidak ditemukan!',
                                    icon: 'error'
                                }).then(function(){
                                    $('#lks_koderak').select();
                                })
                            }
                            else{
                                if(row != 'input'){
                                    $('#lks_koderak').val(data['lks_koderak']);
                                    $('#lks_kodesubrak').val(data['lks_kodesubrak']);
                                    $('#lks_tiperak').val(data['lks_tiperak']);
                                    $('#lks_shelvingrak').val(data['lks_shelvingrak']);
                                }

                                jumlahitem = 0;


                                if($('#lks_tiperak').val() == 'S'){
                                    cursorIdTable = "table-s";

                                    $('#table-all').hide();
                                    $('#table-tambah').prop('hidden',true);
                                    $('#table-s').show();
                                    $('#table-tambah-s').prop('hidden',false);
                                    $('#table-all tbody tr').remove();
                                    $('#table-s tbody tr').remove();


                                    for(i=0;i<response.length;i++){
                                        if(response[i].desk != null){
                                            jumlahitem++;
                                        }
                                        html =
                                            '<tr onclick="cursorRowChanger(this)" id="row_'+ i +'">' +
                                            '<td>' +
                                            '<button onclick="deleteRow('+ i +')" class="col-sm btn btn-danger btn-delete">X</button>' +
                                            '</td>' +
                                            '<td><input type="text" class="form-control lks_nourut" value="'+ nvl(response[i].lks_nourut,'') +'"></td>' +
                                            '<td><input type="text" class="form-control lks_depanbelakang" value="'+ nvl(response[i].lks_depanbelakang,'') +'"></td>' +
                                            '<td><input type="text" class="form-control lks_atasbawah" value="'+ nvl(response[i].lks_atasbawah,'') +'"></td>' +
                                            '<td>' +
                                            '<div class="buttonInside">' +
                                            '<input readonly type="text" class="form-control lks_prdcd" maxlength="7" value="'+ nvl(response[i].lks_prdcd,'') +'">' +
                                            '<button style="display: none" type="button" class="btn btn-primary btn-lov p-0 btn-lov-plu" data-toggle="modal" data-target="#m_lov_plu"><i class="fas fa-question"></i> </button>' +
                                            '</div>' +
                                            '</td>' +
                                            '<td><input type="text" class="form-control lks_jenisrak" value="'+ nvl(response[i].lks_jenisrak,'') +'"></td>' +
                                            '<td><input type="text" class="form-control desk" value="'+ nvl(response[i].desk,'') +'"></td>' +
                                            '<td><input type="text" class="form-control satuan" value="'+ nvl(response[i].satuan,'') +'"></td>' +
                                            '<td><input type="text" class="form-control lks_minqty" value="'+ nvl(response[i].lks_qty,'') +'"></td>' +
                                            '<td><input type="text" class="form-control lks_expdate" value="'+ formatDate(response[i].lks_expdate) +'"></td>' +
                                            '<td><input type="text" class="form-control mpt_maxqty" value="'+ nvl(response[i].mpt_maxqty,'') +'"></td>' +
                                            '</tr>';

                                        $('#table-s tbody').append(html);

                                        if(response[i].lks_prdcd == null){
                                            //$('#table-s .lks_prdcd')[i].setAttribute("readonly", true); //memasang attribut
                                            $('#table-s .lks_prdcd')[i].removeAttribute("readonly"); //menghapus attribut
                                        }

                                        if(response[i].lks_delete == 'Y'){
                                            $('#cb_delete_'+i).prop('checked',true); // da heck is dis?
                                        }
                                    }

                                    $('#table-s input').prop('disabled',true);
                                    $('#table-s .lks_nourut').prop('disabled', false);
                                    $('#table-s .lks_depanbelakang').prop('disabled',false);
                                    $('#table-s .lks_atasbawah').prop('disabled',false);

                                }
                                else{
                                    cursorIdTable = "table-all";

                                    $('#table-all').show();
                                    $('#table-tambah').prop('hidden',false);
                                    $('#table-s').hide();
                                    $('#table-tambah-s').prop('hidden',true);
                                    $('#table-s tbody tr').remove();
                                    $('#table-all tbody tr').remove();
                                    for(i=0;i<response.length;i++){
                                        if(response[i].desk != null){
                                            jumlahitem++;
                                        }

                                        mindisplay = response[i].lks_tirkirikanan * response[i].lks_tirdepanbelakang * response[i].lks_tiratasbawah;
                                        minpctqty = response[i].lks_minpct * response[i].lks_maxplano / 100;

                                        html =
                                            '<tr onclick="cursorRowChanger(this)" class="text-center" id="row_'+ i +'">' +
                                            '<td>' +
                                            '<button onclick="deleteRow('+ i +')" class="col-sm btn btn-danger btn-delete">X</button>' +
                                            '</td>' +
                                            '<td><input type="text" class="form-control lks_nourut" value="'+ nvl(response[i].lks_nourut,'') +'"></td>' +
                                            '<td><input type="text" class="form-control lks_depanbelakang" value="'+ nvl(response[i].lks_depanbelakang,'') +'"></td>' +
                                            '<td><input type="text" class="form-control lks_atasbawah" value="'+ nvl(response[i].lks_atasbawah,'') +'"></td>' +
                                            '<td>' +
                                            '<div class="buttonInside">' +
                                            '<input type="text" class="form-control lks_prdcd" maxlength="7" value="'+ nvl(response[i].lks_prdcd,'') +'">' +
                                            '<button style="display: none" type="button" class="btn btn-primary btn-lov p-0 btn-lov-plu" data-toggle="modal" data-target="#m_lov_plu"><i class="fas fa-question"></i> </button>' +
                                            '</div>' +
                                            '</td>' +
                                            '<td><input type="text" class="form-control lks_jenisrak" value="'+ nvl(response[i].lks_jenisrak,'') +'"></td>' +
                                            '<td><input type="text" class="form-control desk" value="'+ nvl(response[i].desk,'') +'"></td>' +
                                            '<td><input type="text" class="form-control satuan" value="'+ nvl(response[i].satuan,'') +'"></td>' +
                                            '<td><input type="text" class="form-control lks_noid" value="'+ nvl(response[i].lks_noid,'') +'"></td>' +
                                            '<td><input type="text" class="form-control lks_dimensipanjangproduk" value="'+ convertToRupiah(nvl(response[i].lks_dimensipanjangproduk,'')) +'"></td>' +
                                            '<td><input type="text" class="form-control lks_dimensilebarproduk" value="'+ convertToRupiah(nvl(response[i].lks_dimensilebarproduk,'')) +'"></td>' +
                                            '<td><input type="text" class="form-control lks_dimensitinggiproduk" value="'+ convertToRupiah(nvl(response[i].lks_dimensitinggiproduk,'')) +'"></td>' +
                                            '<td><input type="text" class="form-control lks_tirkirikanan" value="'+ nvl(response[i].lks_tirkirikanan,'') +'"></td>' +
                                            '<td><input type="text" class="form-control lks_tirdepanbelakang" value="'+ nvl(response[i].lks_tirdepanbelakang,'') +'"></td>' +
                                            '<td><input type="text" class="form-control lks_tiratasbawah" value="'+ nvl(response[i].lks_tiratasbawah,'') +'"></td>' +
                                            '<td><input type="text" class="form-control lks_mindisplay" value="'+ nvl(mindisplay,'')  +'"></td>' +
                                            '<td><input type="text" class="form-control lks_maxdisplay" value="'+ nvl(response[i].lks_maxdisplay,'') +'"></td>' +
                                            '<td><input type="text" class="form-control pkm" value="'+ noTwoDigit(nvl(response[i].pkm,'')) +'"></td>' +
                                            '<td><input type="text" class="form-control lks_qty" value="'+ nvl(response[i].lks_qty,'') +'"></td>' +
                                            '<td><input type="text" class="form-control lks_minpct" value="'+ nvl(response[i].lks_minpct,'') +'"></td>' +
                                            '<td><input type="text" class="form-control minpctqty" value="'+ nvl(minpctqty,'')  +'"></td>' +
                                            '<td><input type="text" class="form-control lks_maxplano" value="'+ nvl(response[i].lks_maxplano,'') +'"></td>' +
                                            '</tr>';

                                        $('#table-all').append(html);
                                    }

                                    $('.lks_prdcd').on('keypress',function(e){
                                        if(e.which == 13){
                                            lov_plu_select(convertPlu($(this).val()));
                                        }
                                    });

                                    $('.lks_noid').on('keypress',function(e){
                                        if(e.which == 13){
                                            noid_enter($(this).val());
                                        }
                                    });

                                    $('#table-all input').prop('disabled',true);

                                }

                                $('#jumlahitem').val(jumlahitem);

                                $('input').off('focus');
                                $('input').on('focus',function(){
                                    $(this).select();

                                    if(typeof $(this).parent().parent().attr('id') != 'undefined'){
                                        if($(this).parent().parent().attr('id').substr(0,3) == 'row')
                                            idrow = $(this).parent().parent().attr('id');
                                    }

                                    if($(this).hasClass('lks_prdcd') || $(this).hasClass('t_lks_prdcd')){
                                        $('.btn-lov-plu').hide();
                                        $(this).parent().find('.btn-lov-plu').show();
                                        idrow = $(this).parent().parent().parent().attr('id');
                                    }
                                    else{
                                        $('.btn-lov-plu').hide();
                                    }

                                    if($(this).hasClass('lks_prdcd')){
                                        tempprdcd = $(this).val();
                                    }
                                    else if($(this).hasClass('lks_noid')){
                                        tempnoid = $(this).val();
                                    }
                                });

                                $('.btn-lov-plu').hide();

                                if($('#m_lov_rak').is(':visible'))
                                    $('#m_lov_rak').modal('toggle');

                                if($('#lks_koderak').val().substr(0,3) == 'HDH' || $('#lks_koderak').val().substr(0,5) == 'DKLIK' || $('#lks_koderak').val().substr(0,5) == 'GTEMP'){
                                    $('.lks_prdcd').prop('disabled',false);

                                    if($('#lks_tiperak').val() != 'S'){
                                        $('#table-all .lks_nourut').prop('disabled',false);
                                        $('#table-all .lks_depanbelakang').prop('disabled',false);
                                        $('#table-all .lks_atasbawah').prop('disabled',false);
                                        $('#table-all .lks_tirkirikanan').prop('disabled',false);
                                        $('#table-all .lks_tirdepanbelakang').prop('disabled',false);
                                        $('#table-all .lkstiratasbawah').prop('disabled',false);
                                        $('#table-all .lks_maxdisplay').prop('disabled',false);
                                        $('#table-all .lks_minpct').prop('disabled',false);
                                        $('#table-all .lks_maxplano').prop('disabled',false);
                                        $('#p_tambah').show();
                                    }
                                    else{
                                        $('#table-all input').prop('disabled',true);
                                        $('#p_tambah').hide();
                                    }
                                }

                                //if($('#lks_koderak').val().substr(0,1) == 'P'){
                                if(true){ //selalu masuk if, untuk menyamakan dengan IAS
                                    $('#p_tambah input').prop('disabled',false);
                                    $('#table-tambah .lks_jenisrak').prop('disabled',true);
                                    $('#table-tambah .desk').prop('disabled',true);
                                    $('#table-tambah .satuan').prop('disabled',true);
                                    $('#table-tambah .lks_dimensipanjangproduk').prop('disabled',true);
                                    $('#table-tambah .lks_dimensilebarproduk').prop('disabled',true);
                                    $('#table-tambah .lks_dimensitinggiproduk').prop('disabled',true);
                                    $('#table-tambah .lks_mindisplay').prop('disabled',true);
                                    $('#table-tambah .pkm').prop('disabled',true);

                                    $('.lks_prdcd').each(function(){
                                        $(this).prop('disabled',false);
                                    });

                                    //tombol delete seharusnya tidak bisa kalau (TIPERAK <> 'S' AND (KODERAK LIKE 'R%' OR KODERAK LIKE 'O%')) segera perbaiki, lihat di trigger KEY-NEXT-ITEM
                                    if($('#lks_tiperak').val() != 'S' && ($('#lks_koderak').val().substr(0,1) == 'R' || $('#lks_koderak').val().substr(0,1) == 'O')){
                                        $('.btn-delete').prop('disabled',true);
                                    }
                                    else $('.btn-delete').prop('disabled',false);

                                }
                                else{
                                    $('#p_tambah input').prop('disabled',true);
                                    $('.lks_prdcd').each(function(){
                                        if($(this).val() != ''){
                                            $(this).prop('disabled',true);
                                        }
                                    });
                                    $('.btn-delete').prop('disabled',true);
                                }


                                $('.lks_prdcd').each(function(){
                                    $(this).parent().parent().parent().find('.lks_noid').prop('disabled',false);
                                });
                            }
                        }
                    });
                }
            }
        }

        trlovrak = $('#table_lov_rak tbody').html();
        trlovplu = $('#table_lov_plu tbody').html();
        idrow = '';
        tempprdcd = '';
        tempnoid = '';
        tempdpd = '';
        isDPD = false;

        nourutOk = false;
        dbOk = false;
        abOk = false;
        pluOk = false;
        noidOk = false;
        tirkkOk = false;
        tirdbOk = false;
        tirabOk = false;
        maxdisOk = false;
        minpctOk = false;
        maxplanoOk = false;


        $('#m_input_noid').on('shown.bs.modal',function(){
            isDPD = true;

            $('#dpd_koderak').val('');
            $('#dpd_kodesubrak').val('');
            $('#dpd_tiperak').val('');
            $('#dpd_shelvingrak').val('');
            $('#dpd_noid').val('');
            $('#dpd_nourut').val('');

            $('#dpd_noid').select();
        });

        $('#m_input_noid').on('hide.bs.modal',function() {
            isDPD = false;
        });

        $('input').parent().find('button').each(function(){
            $(this).hide();
        });

        $('#btn-lov').show();

        $('input').on('keypress',function(){
            $(this).val($(this).val().toUpperCase());
        });

        $('input').on('focus',function(){
            $(this).select();

            if($(this).hasClass('lks_prdcd') || $(this).hasClass('t_lks_prdcd')){
                $('.btn-lov-plu').hide();
                $(this).parent().find('.btn-lov-plu').show();
                idrow = $(this).parent().parent().parent().attr('id');
            }
            else{
                $('.btn-lov-plu').hide();
            }
        });

        // $('#table-all input').prop('disabled',true);

        $('.btn-lov').on('click',function(){
            idrow = $(this).parent().parent().parent().attr('id');
        });

        $('#m_lov_rak').on('shown.bs.modal',function(){
            $('#i_lov_rak').select();
        });

        $('#m_lov_plu').on('shown.bs.modal',function(){
            $('#i_lov_plu').select();
        });

        $('#m_lov_plu').on('hide.bs.modal',function(){
            $('.btn-lov-plu').hide();
        });



        $('#i_lov_rak').on('keypress',function(e){
            if(e.which == 13){
                if(this.value == ''){
                    $('#table_lov_rak tbody tr').remove();
                    $('#table_lov_rak').append(trlovrak);
                }
                else{
                    $.ajax({
                        url: '{{ url()->current().'/lov_rak_search' }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {koderak: this.value.toUpperCase()},
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            $('#table_lov_rak tbody tr').remove();

                            for(i=0;i<response.length;i++){
                                html = '<tr class="row_lov" id="row_lov_rak_'+i+'" onclick=lov_rak_select("'+i+'")><td class="lks_koderak">' + response[i].lks_koderak + '</td>' +
                                    '<td class="lks_kodesubrak">' + response[i].lks_kodesubrak + '</td>' +
                                    '<td class="lks_tiperak">' + response[i].lks_tiperak + '</td>' +
                                    '<td class="lks_shelvingrak">' + response[i].lks_shelvingrak + '</td></tr>';

                                $('#table_lov_rak').append(html);
                            }
                            $('#i_lov_rak').select();
                        }
                    });
                }
            }
        });

        $('#i_lov_plu').on('keypress',function(e){
            if(e.which == 13){
                if(this.value == ''){
                    $('#table_lov_plu tbody tr').remove();
                    $('#table_lov_plu').append(trlovplu);
                }
                else{
                    if($.isNumeric($(this).val())){
                        value = convertPlu($(this).val());
                    }
                    else value = $(this).val().toUpperCase();
                    $.ajax({
                        url: '{{ url()->current().'/lov_plu_search' }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {data: value},
                        beforeSend: function () {
                            $('#modal-loader').modal('hide');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            // console.log(response);
                            $('#table_lov_plu tbody tr').remove();

                            for(i=0;i<response.length;i++){
                                html = '<tr onclick=lov_plu_select("'+response[i].prd_prdcd+'") class="row_lov">' +
                                        '<td>'+response[i].prd_prdcd+'</td>' +
                                        '<td>'+response[i].prd_deskripsipanjang+'</td>' +
                                        '</tr>';

                                $('#table_lov_plu').append(html);

                                // console.log(html);
                            }
                            $('#i_lov_plu').select();
                        }
                    });
                }
            }
        });



        function lov_plu_select(value) {
            data = {};
            data['lks_koderak'] = $('#lks_koderak').val();
            data['lks_kodesubrak'] = $('#lks_kodesubrak').val();
            data['lks_tiperak'] = $('#lks_tiperak').val();
            data['lks_shelvingrak'] = $('#lks_shelvingrak').val();
            data['lks_qty'] = $('#'+idrow).find('.lks_qty').val();
            if(idrow == 'row_tambah')
                data['lks_noid'] = $('#'+idrow).find('.t_lks_noid').val();
            else data['lks_noid'] = $('#'+idrow).find('.lks_noid').val();
            data['lks_nourut'] = $('#'+idrow).find('.lks_nourut').val();
            data['lks_prdcd'] = value;

            // console.log(data);

            $.ajax({
                url: '{{ url()->current().'/lov_plu_select' }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {data},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    $('#m_lov_plu').modal('hide');

                    // console.log(response);

                    if(response.status == 'error'){
                        swal({
                            title: response.message,
                            icon: response.status,
                        }).then(function(){
                            $('#'+idrow).find('.lks_prdcd').val(tempprdcd);
                            if(idrow == 'row_tambah'){
                                $('#'+idrow).find('.t_lks_prdcd').select();
                            }
                            else $('#'+idrow).find('.lks_prdcd').select();
                        });

                        pluOk = false;
                    }
                    else{
                        $('#'+idrow).find('.desk').val(response.prd_deskripsipanjang);
                        $('#'+idrow).find('.satuan').val(response.satuan);
                        $('#'+idrow).find('.lks_dimensipanjangproduk').val(response.panjang);
                        $('#'+idrow).find('.lks_dimensilebarproduk').val(response.lebar);
                        $('#'+idrow).find('.lks_dimensitinggiproduk').val(response.tinggi);
                        $('#'+idrow).find('.pkm').val(response.pkm);
                        if(idrow != 'row_tambah'){
                            $('#'+idrow).find('.lks_depanbelakang').val('1');
                            $('#'+idrow).find('.lks_atasbawah').val('1');
                            $('#'+idrow).find('.lks_prdcd').val(value);
                        }
                        else{
                            $('#'+idrow).find('.t_lks_prdcd').val(value);
                            if($('#lks_tiperak').val().substr(0,1) != 'S'){
                                $('#'+idrow).find('.lks_minpct').val('30');
                                $('#'+idrow).find('.lks_maxplano').val($('#'+idrow).find('.lks_maxdisplay').val());
                            }
                            else{
                                if(response[1])
                                $('#table-s').find('.lks_maxpalet').val(response[1]);
                                $('#table-tambah').find('.lks_tirkirikanan').select();
                            }
                        }
                        $('#'+idrow).find('.lks_jenisrak').val(response[0]);

                        $('#'+idrow).find('.lks_noid').select();

                        pluOk = true;
                    }
                }
            });
        }

        function noid_enter(value){
            data = {};
            data['lks_koderak'] = $('#lks_koderak').val();
            data['lks_kodesubrak'] = $('#lks_kodesubrak').val();
            data['lks_tiperak'] = $('#lks_tiperak').val();
            data['lks_shelvingrak'] = $('#lks_shelvingrak').val();
            data['lks_qty'] = $('#'+idrow).find('.lks_qty').val();
            data['lks_noid'] = $('#'+idrow).find('.lks_noid').val();
            data['lks_nourut'] = $('#'+idrow).find('.lks_nourut').val();
            data['lks_prdcd'] = $('#'+idrow).find('.lks_prdcd').val();
            data['lks_noid'] = value.toUpperCase();
            data['lks_tempnoid'] = tempnoid;

            $.ajax({
                url: '{{ url()->current().'/noid_enter' }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {data},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    if(response.status == 'error'){
                        swal({
                            title: response.message,
                            icon: response.status,
                        }).then(function(){
                            $('#'+idrow).find('.lks_noid').val(tempnoid);
                            $('#'+idrow).find('.lks_noid').select();
                        });
                    }
                    else if(idrow == 'row_tambah'){
                        // noidOk = true;
                        // $('#row_tambah').find('.lks_tirkirikanan').select();
                    }
                    else{
                        $('#'+idrow).find('.lks_noid').focus();
                    }
                }
            });
        }

        $('#dpd_noid').on('keypress',function(e){
            if(e.which == 13){
                $.ajax({
                    url: '{{ url()->current().'/cek_dpd' }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {noid: $(this).val().toUpperCase()},
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        if(typeof response.dpd_noid === "undefined"){
                            tempdpd = '';

                            $('#dpd_koderak').val('');
                            $('#dpd_kodesubrak').val('');
                            $('#dpd_tiperak').val('');
                            $('#dpd_shelvingrak').val('');
                            $('#dpd_nourut').val('');

                            $('#dpd_koderak').select();
                            $('#btn_delete_dpd').prop('disabled',true);
                        }
                        else{
                            tempdpd = response;

                            $('#btn_delete_dpd').prop('disabled',false);
                            $('#dpd_koderak').val(response.dpd_koderak);
                            $('#dpd_kodesubrak').val(response.dpd_kodesubrak);
                            $('#dpd_tiperak').val(response.dpd_tiperak);
                            $('#dpd_shelvingrak').val(response.dpd_shelvingrak);
                            $('#dpd_noid').val(response.dpd_noid);
                            $('#dpd_nourut').val(response.dpd_nourut);

                            $('#dpd_koderak').select();
                        }
                    }
                });
            }
        });

        $('#dpd_koderak').on('keypress',function(e){
            if(e.which == 13){
                $('#dpd_kodesubrak').select();
            }
        });

        $('#dpd_kodesubrak').on('keypress',function(e){
            if(e.which == 13){
                $('#dpd_tiperak').select();
            }
        });

        $('#dpd_tiperak').on('keypress',function(e){
            if(e.which == 13){
                $('#dpd_shelvingrak').select();
            }
        });

        $('#dpd_shelvingrak').on('keypress',function(e){
            if(e.which == 13){
                $('#dpd_nourut').select();
            }
        });

        $('#dpd_nourut').on('keypress',function(e){
            if(e.which == 13){
                $("#btn_save_dpd").focus();
            }
        });

        function save_dpd(){
            data = {};
            data['dpd_noid']        = $('#dpd_noid').val();
            data['dpd_koderak']     = $('#dpd_koderak').val();
            data['dpd_kodesubrak']  = $('#dpd_kodesubrak').val();
            data['dpd_tiperak']     = $('#dpd_tiperak').val();
            data['dpd_shelvingrak'] = $('#dpd_shelvingrak').val();
            data['dpd_nourut']      = $('#dpd_nourut').val();
            data['tempdpd'] = tempdpd;

            //untuk mencegah ada value kosong dalam inputan
            titleEmpty = '';
            if(data['dpd_noid'] === '') {
                titleEmpty = 'Nomor ID DPD';
            }else if(data['dpd_koderak'] === ''){
                titleEmpty = 'Kode Rak';
            }else if(data['dpd_kodesubrak'] === ''){
                titleEmpty = 'Kode Sub Rak';
            }else if(data['dpd_tiperak'] === ''){
                titleEmpty = 'Tipe Rak';
            }else if(data['dpd_shelvingrak'] === ''){
                titleEmpty = 'Shelving';
            }else if(data['dpd_nourut'] === ''){
                titleEmpty = 'Nomor Urut';
            }
            if(titleEmpty !== ''){
                swal({
                    title: titleEmpty+' tidak boleh kosong!',
                    icon: 'warning',
                    dangerMode: true
                })
                return false;
            }else{
                $.ajax({
                    url: '{{ url()->current().'/save_dpd' }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {data},
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        swal({
                            title: response.message,
                            icon: response.status,
                        }).then(function(){
                            $('#dpd_koderak').val('');
                            $('#dpd_kodesubrak').val('');
                            $('#dpd_tiperak').val('');
                            $('#dpd_shelvingrak').val('');
                            $('#dpd_noid').val('');
                            $('#dpd_nourut').val('');

                            $('#m_input_noid').modal('hide');

                            var e = jQuery.Event("keypress");
                            e.which = 13; //choose the one you want
                            e.keyCode = 13;
                            $("#lks_shelvingrak").trigger(e);
                        });
                    },  error : function (err) {
                        $('#modal-loader').modal('hide');
                        console.log(err.responseJSON.message.substr(0,150));
                        alertError(err.statusText, err.responseJSON.message);
                    }
                });
            }
        }

        function delete_dpd(){
            swal({
                title: 'Hapus NOID?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then(function(confirm){
                if(confirm){
                    data = {};
                    data['dpd_koderak']     = $('#dpd_koderak').val();
                    data['dpd_kodesubrak']  = $('#dpd_kodesubrak').val();
                    data['dpd_tiperak']     = $('#dpd_tiperak').val();
                    data['dpd_shelvingrak'] = $('#dpd_shelvingrak').val();
                    data['dpd_noid']        = $('#dpd_noid').val();
                    data['dpd_nourut']      = $('#dpd_nourut').val();

                    $.ajax({
                        url: '{{ url()->current().'/delete_dpd' }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {data},
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            swal({
                                title: response.message,
                                icon: response.status,
                            }).then(function(){
                                $('#dpd_koderak').val('');
                                $('#dpd_kodesubrak').val('');
                                $('#dpd_tiperak').val('');
                                $('#dpd_shelvingrak').val('');
                                $('#dpd_noid').val('');
                                $('#dpd_nourut').val('');

                                $('#dpd_noid').select();
                            });
                        },  error : function (err) {
                            $('#modal-loader').modal('hide');
                            console.log(err.responseJSON.message.substr(0,150));
                            alertError(err.statusText, err.responseJSON.message);
                        }
                    });
                }
                else{
                    $('#dpd_noid').select();
                }
            })
        }

        function deleteRow(row){
            swal({
                title: 'Ingin menghapus data?',
                icon: 'warning',
                buttons: {
                    plu: "Hapus PLU",
                    lokasi: "Hapus Lokasi",
                    cancel: "Cancel",
                },
            }).then(function(click){
                if(parseInt($('#row_'+row).find('.lks_qty').val()) > 0){
                    swal({
                        title: 'Masih ada Quantity untuk PLU '+$('#row_'+row).find('.lks_prdcd').val(),
                        icon: 'error'
                    })
                }
                else{
                    data = {};
                    data['lks_koderak'] = $('#lks_koderak').val();
                    data['lks_kodesubrak'] = $('#lks_kodesubrak').val();
                    data['lks_tiperak'] = $('#lks_tiperak').val();
                    data['lks_shelvingrak'] = $('#lks_shelvingrak').val();
                    data['lks_nourut'] = $('#row_'+row).find('.lks_nourut').val();

                    if(click == 'plu'){
                        $.ajax({
                            url: '{{ url()->current().'/delete_plu' }}',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {data},
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                if(response.status == 'success'){
                                    $('#row_'+row).find('input').each(function(){
                                        if(!$(this).hasClass('lks_nourut'))
                                            $(this).val('');
                                    });
                                }

                                swal({
                                    title: response.message,
                                    icon: response.status,
                                }).then(function(){
                                    $('#modal-loader').modal('hide');
                                    var e = jQuery.Event("keypress");
                                    e.which = 13; //choose the one you want
                                    e.keyCode = 13;
                                    $("#lks_shelvingrak").trigger(e);
                                });
                            },  error : function (err) {
                                $('#modal-loader').modal('hide');
                                console.log(err.responseJSON.message.substr(0,150));
                                alertError(err.statusText, err.responseJSON.message);
                            }
                        });
                    }
                    else if(click == 'lokasi'){
                        $.ajax({
                            url: '{{ url()->current().'/delete_lokasi' }}',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {data},
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('hide');

                                if(response.status == 'success'){
                                    $('#row_'+row).remove();
                                }

                                swal({
                                    title: response.message,
                                    icon: response.status,
                                }).then(function(){
                                    $('#modal-loader').modal('hide');
                                    var e = jQuery.Event("keypress");
                                    e.which = 13; //choose the one you want
                                    e.keyCode = 13;
                                    $("#lks_shelvingrak").trigger(e);
                                });
                            },  error : function (err) {
                                $('#modal-loader').modal('hide');
                                console.log(err.responseJSON.message.substr(0,150));
                                alertError(err.statusText, err.responseJSON.message);
                            }
                        });
                    }
                }
            });
        }


        //pengecekan tambah
        $('#row_tambah').find('.lks_nourut').on('keypress',function(e) {
            value = $(this).val();

            if(e.which == 13) {
                cek_nourut(value);
            }
        });

        // $('#row_tambah').find('.lks_nourut').on('blur',function() {
        //     value = $(this).val();
        //     cek_nourut(value);
        // });

        function cek_nourut(value){
            title = '';

            if (value < 0 || value > parseInt($('#table-all').find('.lks_nourut').last().val()) + 1) {
                title = 'Nomor urut tidak valid!';
            }
            else {
                $('#table-all').find('.lks_nourut').each(function () {
                    if ($(this).val() == value) {
                        title = 'Nomor urut sudah dipakai untuk PLU '+$(this).parent().parent().find('.lks_prdcd').val()+'!';
                    }
                });
            }

            if(title != ''){
                nourutOk = false;
                swal({
                    title: title,
                    icon: 'error'
                }).then(function () {
                    $('#row_tambah').find('.lks_nourut').select();
                });
            }
            else{
                nourutOk = true;
                $('#row_tambah').find('.lks_depanbelakang').select();
            }
        }

        $('#row_tambah').find('.lks_depanbelakang').on('keypress',function(e) {
            value = $(this).val();
            if(e.which == 13) {
                cek_db(value);
            }
        });

        // $('#row_tambah').find('.lks_depanbelakang').on('blur',function() {
        //     value = $(this).val();
        //     cek_db(value);
        // });

        function cek_db(value){
            if(value < 0){
                dbOk = false;
                swal({
                    title: 'Inputan tidak valid!',
                    icon: 'error'
                }).then(function(){
                    $('#row_tambah').find('.lks_depanbelakang').select();
                });
            }
            else{
                dbOk = true;
                if(value == '')
                    $('#row_tambah').find('.lks_depanbelakang').val('1');

                $('#row_tambah').find('.lks_atasbawah').select();
            }
        }

        $('#row_tambah').find('.lks_atasbawah').on('keypress',function(e) {
            value = $(this).val();
            if(e.which == 13) {
                cek_ab(value);
            }
        });

        // $('#row_tambah').find('.lks_atasbawah').on('blur',function() {
        //     value = $(this).val();
        //     cek_ab(value);
        // });

        function cek_ab(value){
            if(value < 0){
                abOk = false;
                swal({
                    title: 'Inputan tidak valid!',
                    icon: 'error'
                }).then(function(){
                    $('#row_tambah').find('.lks_atasbawah').select();
                })
            }
            else{
                abOk = true;
                if(value == '')
                    $('#row_tambah').find('.lks_atasbawah').val('1');

                $('#row_tambah').find('.t_lks_prdcd').select();
            }
        }

        $('#row_tambah').find('.t_lks_prdcd').on('keypress',function(e){
            prdcd = convertPlu($(this).val());
            if(e.which == 13){
                cek_prdcd(prdcd);
            }
        });

        function cek_prdcd(prdcd){
            pluOk = true;
            $('#table-all').find('.lks_prdcd').each(function(){
                if($(this).val() == prdcd){
                    swal({
                        title: 'PLU sudah terdaftar!',
                        icon: 'error'
                    }).then(function(){
                        $('#row_tambah').find('.t_lks_prdcd').select();
                    });
                    pluOk = false;
                    return false;
                }
            });

            if(pluOk && $('#lks_tiperak').val().substr(0,1) != 'S') {
                $.ajax({
                    url: '{{ url()->current().'/cek_plu' }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        prdcd: prdcd,
                        koderak: $('#lks_koderak').val(),
                        kodesubrak: $('#lks_kodesubrak').val(),
                        tiperak: $('#lks_tiperak').val(),
                        shelving: $('#lks_shelvingrak').val(),
                        nourut: $('#lks_nourut').val()
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        data = response.data;

                        $('#table-tambah .lks_nourut').val(data.nourut);
                        $('#table-tambah .lks_jenisrak').val(data.jenisrak);
                        $('#table-tambah .t_lks_prdcd').val(data.prdcd);
                        $('#table-tambah .desk').val(data.deskripsi);
                        $('#table-tambah .satuan').val(data.satuan);
                        $('#table-tambah .lks_noid').val(data.noid);
                        $('#table-tambah .lks_dimensipanjangproduk').val(data.panjang);
                        $('#table-tambah .lks_dimensilebarproduk').val(data.lebar);
                        $('#table-tambah .lks_dimensitinggiproduk').val(data.tinggi);
                        $('#table-tambah .lks_pkm').val(data.pkm);

                        if($('#lks_tiperak').val() != 'S'){
                            $('#table-tambah .lks_tirkirikanan').select();
                        }
                        else{
                            $('#table-tambah-s .s_maxpalet').select();
                        }
                    },
                    error: function(error){
                        $('#modal-loader').modal('hide');
                        alertError(error.responseJSON.message, '');
                    }
                });
            }
        }

        $('#row_tambah').find('.t_lks_noid').on('keypress',function(e){
            $('#btn-noid').click();
            $('#btn-input-noid').focus();
        });

        $('#row_tambah').find('.lks_tirkirikanan').on('keypress',function(e) {
            value = $(this).val();
            if(e.which == 13) {
                cek_tkk(value);
            }
        });

        // $('#row_tambah').find('.lks_tirkirikanan').on('blur',function() {
        //     value = $(this).val();
        //     cek_tkk(value);
        // });

        function cek_tkk(value){
            if(value < 0){
                tirkkOk = false;
                swal({
                    title: 'Inputan tidak valid!',
                    icon: 'error'
                }).then(function(){
                    $('#row_tambah').find('.lks_tirkirikanan').select();
                })
            }
            else{
                if(value == '')
                    $('#row_tambah').find('.lks_tirkirikanan').select();
                else{
                    tirkkOk = true;
                    $('#row_tambah').find('.lks_tirdepanbelakang').select();
                }
            }
        }

        $('#row_tambah').find('.lks_tirdepanbelakang').on('keypress',function(e) {
            value = $(this).val();
            if(e.which == 13) {
                cek_tdb(value);
            }
        });

        // $('#row_tambah').find('.lks_tirdepanbelakang').on('blur',function() {
        //     value = $(this).val();
        //     cek_tdb(value);
        // });

        function cek_tdb(value){
            if(value < 0){
                tirdbOk = false;
                swal({
                    title: 'Inputan tidak valid!',
                    icon: 'error'
                }).then(function(){
                    $('#row_tambah').find('.lks_tirdepanbelakang').select();
                })
            }
            else{
                if(value == '')
                    $('#row_tambah').find('.lks_tirdepanbelakang').select();
                else{
                    tirdbOk = true;
                    $('#row_tambah').find('.lks_tiratasbawah').select();
                }
            }
        }

        $('#row_tambah').find('.lks_tiratasbawah').on('keypress',function(e) {
            value = $(this).val();
            if(e.which == 13) {
                cek_tab(value);
            }
        });

        // $('#row_tambah').find('.lks_tiratasbawah').on('blur',function() {
        //     value = $(this).val();
        //     cek_tab(value);
        // });

        function cek_tab(value){
            if(value < 0){
                tirabOk = false;
                swal({
                    title: 'Inputan tidak valid!',
                    icon: 'error'
                }).then(function(){
                    $('#row_tambah').find('.lks_tiratasbawah').select();
                })
            }
            else{
                if(value == '')
                    $('#row_tambah').find('.lks_tiratasbawah').select();
                else{
                    tirabOk = true;
                    $('#row_tambah').find('.lks_maxdisplay').select();

                    dis = parseInt($('#row_tambah').find('.lks_tirkirikanan').val()) * parseInt($('#row_tambah').find('.lks_tirdepanbelakang').val()) * parseInt($('#row_tambah').find('.lks_tiratasbawah').val());

                    $('#row_tambah').find('.lks_mindisplay').val(dis);
                    $('#row_tambah').find('.lks_maxdisplay').val(dis);
                    $('#row_tambah').find('.lks_maxplano').val(dis);
                }
            }
        }

        $('#row_tambah').find('.lks_maxdisplay').on('keypress',function(e) {
            value = $(this).val();
            if(e.which == 13) {
                cek_md(value);
            }
        });

        // $('#row_tambah').find('.lks_maxdisplay').on('blur',function() {
        //     value = $(this).val();
        //     cek_md(value);
        // });

        function cek_md(value){
            if(value < 0){
                maxdisOk = false;
                swal({
                    title: 'Inputan tidak valid!',
                    icon: 'error'
                }).then(function(){
                    $('#row_tambah').find('.lks_maxdisplay').select();
                });
            }
            else{
                if(value == '')
                    $('#row_tambah').find('.lks_maxdisplay').select();
                else{
                    maxdisOk = true;
                    $('#row_tambah').find('.lks_minpct').select();
                }
            }
        }

        $('#row_tambah').find('.lks_minpct').on('keypress',function(e) {
            value = $(this).val();
            if(e.which == 13) {
                cek_minpct(value);
            }
        });

        // $('#row_tambah').find('.lks_minpct').on('blur',function() {
        //     value = $(this).val();
        //     cek_minpct(value);
        // });

        function cek_minpct(value){
            if(value < 0){
                minpctOk = false;
                swal({
                    title: 'Inputan harus lebih dari nol!',
                    icon: 'error'
                }).then(function(){
                    $('#row_tambah').find('.lks_minpct').select();
                });
            }
            else{
                if(value == '')
                    $('#row_tambah').find('.lks_minpct').select();
                else{
                    minpctOk = true;
                    $('#row_tambah').find('.lks_maxplano').select();
                }
            }
        }

        $('#row_tambah').find('.lks_maxplano').on('keypress',function(e) {
            value = $(this).val();
            if(e.which == 13) {
                cek_maxplano(value);
            }
        });

        // $('#row_tambah').find('.lks_maxplano').on('blur',function() {
        //     value = $(this).val();
        //     cek_maxplano(value);
        // });

        function cek_maxplano(value){
            if(value < 0){
                maxplanoOk = false;
                swal({
                    title: 'Inputan harus lebih dari nol!',
                    icon: 'error'
                }).then(function(){
                    $('#row_tambah').find('.lks_maxplano').select();
                });
            }
            else{
                if(value == '')
                    $('#row_tambah').find('.lks_maxplano').select();
                else{
                    maxplanoOk = true;
                    $('#btn-tambah').focus();
                }
            }
        }

        function tambah(){
            cek_nourut();
            cek_db();
            cek_ab();
            cek_tkk();
            cek_tdb();
            cek_tab();
            cek_md();
            cek_minpct();
            cek_maxplano();
            // console.log('nourutOk : '+nourutOk);
            // console.log('dbOk : '+dbOk);
            // console.log('abOk : '+abOk);
            // console.log('pluOk : '+pluOk);
            // console.log('noidOk : '+noidOk);
            // console.log('tirkkOk : '+tirkkOk);
            // console.log('tirdbOk : '+tirdbOk);
            // console.log('tirabOk : '+tirabOk);
            // console.log('maxdisOk : '+maxdisOk);
            // console.log('minpctOk : '+minpctOk);
            // console.log('maxplanoOk : '+maxplanoOk);

            // if(nourutOk && dbOk && abOk && pluOk && noidOk && tirkkOk && tirdbOk && tirabOk && maxdisOk && minpctOk && maxplanoOk) {
            if(nourutOk && dbOk && abOk && pluOk && tirkkOk && tirdbOk && tirabOk && maxdisOk && minpctOk && maxplanoOk) {
                data = {};
                data['lks_koderak'] = $('#lks_koderak').val();
                data['lks_kodesubrak'] = $('#lks_kodesubrak').val();
                data['lks_tiperak'] = $('#lks_tiperak').val();
                data['lks_shelvingrak'] = $('#lks_shelvingrak').val();

                data['lks_prdcd'] = $('#table-tambah').find('.t_lks_prdcd').val();
                data['lks_nourut'] = $('#table-tambah').find('.lks_nourut').val();
                data['lks_depanbelakang'] = $('#table-tambah').find('.lks_depanbelakang').val();
                data['lks_atasbawah'] = $('#table-tambah').find('.lks_atasbawah').val();
                data['lks_tirkirikanan'] = $('#table-tambah').find('.lks_tirkirikanan').val();
                data['lks_tirdepanbelakang'] = $('#table-tambah').find('.lks_tirdepanbelakang').val();
                data['lks_tiratasbawah'] = $('#table-tambah').find('.lks_tiratasbawah').val();
                data['lks_maxdisplay'] = $('#table-tambah').find('.lks_maxdisplay').val();
                data['lks_noid'] = $('#table-tambah').find('.t_lks_noid').val();
                data['lks_minpct'] = $('#table-tambah').find('.lks_minpct').val();
                data['lks_maxplano'] = $('#table-tambah').find('.lks_maxplano').val();
                data['lks_jenisrak'] = $('#table-tambah').find('.lks_jenisrak').val();

                if($('#table-tambah').find('#cb_delete').is(':checked')){
                    data['lks_delete'] = 'Y';
                }
                else data['lks_delete'] = 'N';

                // console.log(data);

                $.ajax({
                    url: '{{ url()->current().'/tambah' }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {data},
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        swal({
                            title: response.message,
                            icon: response.status
                        }).then(function(){
                            $('#modal-loader').modal('hide');
                            $('#table-tambah input').val('');
                            // lov_rak_select('input');

                            var e = jQuery.Event("keypress");
                            e.which = 13; //choose the one you want
                            e.keyCode = 13;
                            $("#lks_shelvingrak").trigger(e);
                        })
                    },  error : function (err) {
                        $('#modal-loader').modal('hide');
                        console.log(err.responseJSON.message.substr(0,150));
                        alertError(err.statusText, err.responseJSON.message);
                    }
                });
            }
            else{
                swal({
                    title: 'Inputan tidak sesuai!',
                    icon: 'error'
                }).then(function(){
                    if(!nourutOk)
                        $('#table-tambah').find('.lks_nourut').select();
                    else if(!dbOk)
                        $('#table-tambah').find('.lks_depanbelakang').select();
                    else if(!abOk)
                        $('#table-tambah').find('.lks_atasbawah').select();
                    else if(!pluOk)
                        $('#table-tambah').find('.t_lks_prdcd').select();
                    else if(!noidOk)
                        $('#table-tambah').find('.lks_noid').select();
                    else if(!tirkkOk)
                        $('#table-tambah').find('.lks_tirkirikanan').select();
                    else if(!tirdbOk)
                        $('#table-tambah').find('.lks_tirdepanbelakang').select();
                    else if(!tirabOk)
                        $('#table-tambah').find('.lks_tiratasbawah').select();
                    else if(!maxdisOk)
                        $('#table-tambah').find('.lks_maxdisplay').select();
                    else if(!minpctOk)
                        $('#table-tambah').find('.lks_minpct').select();
                    else if(!maxplanoOk)
                        $('#table-tambah').find('.lks_maxplano').select();
                });
            }
        }
    </script>

@endsection
