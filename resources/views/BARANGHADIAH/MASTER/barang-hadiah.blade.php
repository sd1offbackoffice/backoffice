@extends('navbar')
@section('title','Barang Berhadiah')
@section('content')

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <fieldset class="card">
                <legend class="w-auto ml-5">Master Barang Berhadiah</legend>
                <div class="card-body shadow-lg cardForm">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-body">     
                                <div class="form-horizontal">                                    

                                    <div class="form-group row">
                                        <label for="kodePLU" class="col-sm-2 col-form-label">Kode PLU</label>
                                        <div class="col-sm-10 row">
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="kodePLU" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" maxlength="7">
                                            </div>
                                            <div class="col-sm-4">
                                                <label></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <button onclick="" id="barang_berhadiah" type="button" class="btn btn-danger">
                                                    BARANG HADIAH
                                                </button>
                                            </div>
                                            
                                            <div class="col-sm-3">
                                                <button onclick="" id="master_produk" type="button" class="btn btn-warning" data-toggle="modal" data-target="#m_produk">
                                                   MASTER PRODUK
                                                </button>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="deskripsi" readonly disabled>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Kemasan</label>
                                        <div class="col-sm-10 row">
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control text-left" id="unit" readonly disabled> 
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="frac" readonly disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                                        <div class="col-lg-10 row">
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="status" readonly disabled>
                                            </div>

                                            <div class="col-sm-1">

                                            </div>

                                            <div class="col-sm-5 row">
                                                <label for="stock" class="col-form-label">Stock saat ini</label>
                                                <div class="col-sm-7 row">
                                                    <div class="col-sm-6">
                                                        <input type="text" id="stock" class="form-control">
                                                    </div>
                                                    <label for="stock" class="col-form-label">pcs</label>  
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <button onclick="edit()" id="2" type="button" class="btn btn-primary">
                                                    EDIT
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    

                                </div><!-- form-horizontal-->
                            </div><!-- form-body-->
            
                        </div> <!-- col-md-12 -->
                    </div> <!-- row -->
                </div> <!--card body-->
            </fieldset>
        </div>
    </div>
</div>

<div class="modal fade" id="m_produk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_produk">
                                    <thead>
                                    <tr>
                                        <th>PRD_PRCRD</th>
                                        <th>PRD_DESKRIPSIPENDEK</th>
                                        <th>PRD_UNIT</th>
                                        <th>PRD_FRAC</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_produk_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- <div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <fieldset class="card">
                <legend class="w-auto ml-5">Table Master Barang Berhadiah</legend>
                <div class="card-body shadow-lg cardForm">
                    <div class="row">

                    <table id="table_card_produk" class="table table-sm table-bordered mb-3 text-center">
                        <thead class="thColor">
                            <tr>
                                <th width="20%">Kode PLU</th>
                                <th width="40%">Deskripsi</th>
                                <th width="10%">Frac</th>
                                <th width="10%">Unit</th>
                                <th width="20%">Qty Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                      
                    </div> 
                </div> 
            </fieldset>
        </div>
    </div>
</div> -->

<div class="col">
    <fieldset class="card border-secondary">
        <legend class="w-auto ml-3">CABANG</legend>
        <div class="card-body" id="detailField">
            <table id="table_card_produk" class="table table-sm table-bordered mb-3 text-center">
                <thead class="thColor">
                    <tr>
                        <th width="20%">Kode PLU</th>
                        <th width="40%">Deskripsi</th>
                        <th width="10%">Frac</th>
                        <th width="10%">Unit</th>
                        <th width="20%">Qty Stok</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </fieldset>
</div>

<script>
    $(document).ready(function(){
        getProduk();
        getDataTable();

    });

    $('#kodePLU').keyup(function(event) {
        if (event.which === 13)
        {
            event.preventDefault();
            if($('#kodePLU').val() == '' )
            {
                swal('PLU tidak terdaftar di master barang', '', 'warning')
            }
            if($('#kodePLU').val().length != 7)
            {
                swal('Kode PLU harus terdiri dari 7 angka', '', 'warning')
            }
            else
            {
                swal({
                    title: 'PLU ini bukan termasuk barang hadiah, akan didaftar sebagai PLU Hadiah ? ',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then(function(ok){
                    if(ok){
                        ajaxSetup();
                        $.ajax({
                            url: '{{ url()->current().'/convert-barang-dagangan' }}',
                            type: 'post',
                            data: {
                                prd_prdcd: $('#kodePLU').val(),
                                prd_deskripsipendek: $('#deskripsi').val(),
                                prd_frac: $('#unit').val(),
                                prd_unit: $('#frac').val()
                            },
                            success: function (response) {
                                swal({
                                    title: response.title,
                                    text: response.message,
                                    icon: 'success'
                                });
                            }, error: function (error) {
                                swal({
                                    // title: 'There is error !',
                                    // text: 'Data already exist in Table Master Barang Hadiah !',
                                    // icon: 'error'
                                    title: error.responseJSON.title,
                                    text: error.responseJSON.message,
                                    icon: 'error'
                                });
                            }
                        })// ajax
                    }// if ok
                })
            }
            

        }// if
    });

    function getDataTable()
    {
        if ($.fn.DataTable.isDataTable('#table_card_produk')) {
            $('#table_card_produk').DataTable().destroy();
            $("#table_card_produk tbody tr").remove();
        }
        table_card_produk = $('#table_card_produk').DataTable({
            "ajax": {
                url: '{{ url()->current() }}/get-card-produk',
            },
            "columns": [
                {data: 'bprp_prdcd'},
                {data: 'bprp_ketpendek'},
                {data: 'bprp_frackonversi'},
                {data: 'bprp_unit'},
                {data: 'bprp_recordid'},
            ],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "createdRow": function (row, data, dataIndex) {
                $(row).addClass('row-card-produk').css({'cursor': 'pointer'});
                
            },
            "order": [],
            "scrollY" : "53vh",
            "scrollX" : false,
            "initComplete": function () {

                // $(document).on('click', '.row-card-produk', function (e) {
                //     $('.row-card-produk').removeAttr('style').css({'cursor': 'pointer'});
                //     $(this).css({"background-color": "#acacac","color": "white"});
                // });
            }
        });
    }

    function reset() {
        $('#kodePLU').val('');
        $('#kodemcg').val('');
        $('#namasupplier').val('');
    }

    function getProduk() {
        if ($.fn.DataTable.isDataTable('#table_produk')) {
            $('#table_produk').DataTable().destroy();
        }
        table_produk = $('#table_produk').DataTable({
            "ajax": {
                url: '{{ url()->current() }}/get-produk',
            },
            "columns": [
                {data: 'prd_prdcd'},
                {data: 'prd_deskripsipendek'},
                {data: 'prd_unit'},
                {data: 'prd_frac'},
            ],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "createdRow": function (row, data, dataIndex) {
                $(row).addClass('row-produk').css({'cursor': 'pointer'});
               
                
            },
            "order": [],
            "initComplete": function () {

                $(document).on('click', '.row-produk', function (e) {
                    // reset();
                    $('#kodePLU').val($(this).find('td:eq(0)').html());
                    $('#deskripsi').val($(this).find('td:eq(1)').html());
                    $('#unit').val($(this).find('td:eq(2)').html());
                    $('#frac').val($(this).find('td:eq(3)').html());
                    getDataProduk();
                    $('#m_produk').modal('hide');
                });
            }
        });
    }

    function getDataProduk() {
        ajaxSetup();
        $.ajax({
            url: '{{ url()->current().'/get-data-produk' }}',
            type: 'post',
            data: {
                prd_prdcd: $('#kodePLU').val(),
            },
            beforeSend: function () {
                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
            },
            success: function (result) {
               
                $('#modal-loader').modal('hide');
                $('#kodePLU').val(result.datas[0].prd_prdcd);
                $('#deskripsi').val(result.datas[0].prd_deskripsipendek);
                $('#unit').val(result.datas[0].prd_frac);
                $('#frac').val(result.datas[0].prd_unit);
                $('#status').val(result.datas[0].status);
            }, error: function (e) {
                swal('Error get data produk !!', '', 'warning');
            }
        })
    }

    function edit()
    {
        if($('#status').val() == 'BARANG DAGANGAN')
        {
            swal('Deskripsi Barang Dagangan Tidak Boleh Diubah !','','warning');
        }
    }
</script>

@endsection