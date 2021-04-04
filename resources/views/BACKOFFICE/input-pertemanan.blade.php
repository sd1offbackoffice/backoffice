@extends('navbar')

@section('title','BO | INPUT PERTEMANAN')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body pt-0">
                        <fieldset class="card border-secondary mt-0">
                            <legend  class="w-auto ml-3">INPUT PLU</legend>
                            <div class="card-body py-0">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-1 col-form-label text-right">PLU</label>
                                    <div class="col-sm-3 buttonInside">
                                        <input type="text" class="form-control text-left" id="prdcd">
                                        <button id="btn_departement" type="button" class="btn btn-primary btn-lov p-0" onclick="showLovPrdcd()">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-1 text-right col-form-label  text-right pl-0">Deskripsi</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control text-left" id="desk" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-1 text-right col-form-label">Satuan</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-left" id="satuan" disabled>
                                    </div>
                                    <div class="col-sm-4"></div>
                                    <label for="prdcd" class="col-sm-3 text-right col-form-label">Max qty(CTN) / palet</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-center" id="maxqty" disabled>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="card border-secondary mt-0" id="data-field">
                            <legend  class="w-auto ml-3">INFO</legend>
                            <div class="card-body pt-0">
                                <div class="row form-group mb-0">
                                    <label for="prdcd" class="col-sm-2 text-center col-form-label pr-1">Kode Rak</label>
                                    <label for="prdcd" class="col-sm-2 text-center pl-0 pr-0 col-form-label">Kode Subrak</label>
                                    <label for="prdcd" class="col-sm-1 text-center pl-0 pr-0 col-form-label">Tipe Rak</label>
                                    <label for="prdcd" class="col-sm-2 text-center col-form-label pr-1">Shelving</label>
                                    <label for="prdcd" class="col-sm-1 text-center col-form-label pl-0 pr-0">No. Urut</label>
                                    <label for="prdcd" class="col-sm-1 text-center col-form-label pl-0 pr-0">Qty (pcs)</label>
                                    <label for="prdcd" class="col-sm-2 text-center col-form-label pl-0 pr-0">Expired Date</label>
                                </div>
                                <div class="scrollable-field" id="lokasi">
                                    @for($i=0;$i<4;$i++)
                                        <div class="row form-group">
                                            <div class="col-sm-2 pr-1 pl-1">
                                                <input type="text" class="form-control text-center" disabled>
                                            </div>
                                            <div class="col-sm-2 pr-1 pl-1">
                                                <input type="text" class="form-control text-center" disabled>
                                            </div>
                                            <div class="col-sm-1 pr-1 pl-1">
                                                <input type="text" class="form-control text-center" disabled>
                                            </div>
                                            <div class="col-sm-2 pr-1 pl-1">
                                                <input type="text" class="form-control text-center" disabled>
                                            </div>
                                            <div class="col-sm-1 pr-1 pl-1">
                                                <input type="text" class="form-control text-center" disabled>
                                            </div>
                                            <div class="col-sm-1 pr-1 pl-1">
                                                <input type="text" class="form-control text-center" disabled>
                                            </div>
                                            <div class="col-sm-2 pr-1 pl-1">
                                                <input type="text" class="form-control text-center" disabled>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="card border-secondary mt-0" id="data-field">
                            <legend  class="w-auto ml-3">PERTEMANAN</legend>
                            <div class="card-body pt-0">
                                <div class="col-sm-6">
                                    <div class="row form-group mb-0">
                                        <div class="col-sm-2"></div>
                                        <label for="prdcd" class="col-sm-2 text-center col-form-label pr-4">No</label>
                                        <label for="prdcd" class="col-sm-4 text-center pr-5 col-form-label">Kode Rak</label>
                                        <label for="prdcd" class="col-sm-4 text-center pr-5 col-form-label plano-subrak">Sub Rak</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="scrollable-field col-sm-6" id="plano">
                                        @for($i=0;$i<6;$i++)
                                            <div class="row form-group">
                                                <div class="col-sm-2">
                                                    <button class="btn btn-danger">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="col-sm-2 pr-1 pl-1">
                                                    <input type="text" class="form-control text-center" disabled>
                                                </div>
                                                <div class="col-sm-4 pr-1 pl-1">
                                                    <input type="text" class="form-control text-center" disabled>
                                                </div>
                                                <div class="col-sm-4 pr-1 pl-1">
                                                    <input type="text" class="form-control text-center" disabled>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row form-group">
                                            <div class="col-sm-2"></div>
                                            <button class="btn btn-primary col-sm-3" onclick="showModalAdd()">TAMBAH</button>
                                            <div class="col-sm-2"></div>
                                            <button class="btn btn-primary col-sm-3" onclick="showModalTukar()">TUKAR</button>
                                            <div class="col-sm-2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="modal fade" id="m_prdcd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_prdcd">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>Satuan</th>
                                        <th>PLU</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="m_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label  text-right pl-0">No Urut</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-left" id="add_nourut" disabled>
                            </div>
                            <div class="col-sm-1" id="nourut_loading">
                                <h4><i class="text-primary fas fa-spinner fa-spin"></i></h4>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 col-form-label text-right">Kode Rak</label>
                            <div class="col-sm-3 buttonInside">
                                <input type="text" class="form-control text-left" id="add_koderak">
                                <button id="btn_departement" type="button" class="btn btn-primary btn-lov p-0" onclick="showLovRak()">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group" id="add_field_subrak">
                            <label class="col-sm-3 col-form-label text-right">Kode Sub Rak</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control text-left" id="add_subrak">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <button class="btn btn-danger col-sm-2" onclick="$('#m_add').modal('hide')">BATAL</button>
                            <div class="col-sm-1"></div>
                            <button class="btn btn-success col-sm-2" onclick="addPlano()">TAMBAH</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="m_koderak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_koderak">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Kode Rak</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="m_subrak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_subrak">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Kode Rak</th>
                                        <th>Sub Rak</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="m_tukar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-1 col-form-label text-right">Plano</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="tukarA">
                                    <option value="-">- Pilih plano -</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-4 col-form-label text-center">dengan</label>
                        </div>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-1 col-form-label text-right">Plano</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="tukarB">
                                    <option value="-">- Pilih plano -</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <button class="btn btn-danger col-sm-2" onclick="$('#m_tukar').modal('hide')">BATAL</button>
                            <div class="col-sm-1"></div>
                            <button class="btn btn-success col-sm-2" onclick="tukarPlano()">TUKAR</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #edece9;
            /*background-color: #ECF2F4  !important;*/
            overflow-y: hidden;
        }
        label {
            color: #232443;
            font-weight: bold;
        }
        .cardForm {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .row_lov:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 400px;
            overflow-y: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        .clicked, .row-detail:hover{
            background-color: grey !important;
            color: white;
        }

        .scrollable-field{
            max-height: 200px;
            overflow-y: scroll;
            overflow-x: hidden;
        }
    </style>

    <script>
        var isSubrak = true;
        var plano = [];

        $(document).ready(function(){
            $('#prdcd').focus();
        });

        function showLovPrdcd(){
            $('#m_prdcd').modal('show');

            if(!$.fn.DataTable.isDataTable('#table_prdcd')){
                getPRDCD();
            }
        }

        function getPRDCD(){
            $('#table_prdcd').DataTable({
                "ajax": '{{ url()->current().'/get-lov-prdcd' }}',
                "columns": [
                    {data: 'desk', name: 'desk'},
                    {data: 'satuan', name: 'satuan'},
                    {data: 'plu', name: 'plu'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(0)').addClass('text-left');
                    $(row).addClass('row-prdcd').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    // $('#btn_prdcd').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-prdcd', function (e) {
                        $('#prdcd').val($(this).find('td:eq(2)').html());
                        $('#desk').val($(this).find('td:eq(0)').html().replace(/&amp;/g, '&'));
                        $('#satuan').val($(this).find('td:eq(1)').html());

                        $('#m_prdcd').modal('hide');

                        getData();
                    });
                }
            });
        }

        $('#prdcd').on('keypress',function(event){
            if(event.which == 13){
                $('#prdcd').val(('0000000' + $('#prdcd').val()).substr(-7));

                getData();
            }
        })

        function getData(){
            $.ajax({
                url: '{{ url()->current() }}/get-data',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    prdcd: $('#prdcd').val()
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    isSubrak = response.isSubrak;

                    getLovKodeRak();

                    $('#desk').val(response.plu.desk);
                    $('#satuan').val(response.plu.satuan);
                    $('#maxqty').val(response.maxqty);

                    lokasi = response.lokasi;
                    $('#lokasi').html('');
                    for(i=0;i<lokasi.length;i++){
                        fillLokasi(lokasi[i],i);
                    }
                    for(i=0;i<4-lokasi.length;i++){
                        generateLokasiDummy();
                    }

                    plano = response.plano;
                    $('#plano').html('');
                    for(i=0;i<plano.length;i++){
                        fillPlano(plano[i],i);
                    }
                    for(i=0;i<4-plano.length;i++){
                        generatePlanoDummy();
                    }

                    isSubrak ? $('.plano-subrak').show() : $('.plano-subrak').hide();

                    fillTukarPlano('tukarA','tukarB',plano);
                    fillTukarPlano('tukarB','tukarA',plano);
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {
                        $('#prdcd').select();

                        $('#desk').val('');
                        $('#satuan').val('');
                        $('#maxqty').val('');

                        $('#lokasi').html('');
                        for(i=0;i<4;i++){
                            generateLokasiDummy();
                        }

                        plano = [];
                        $('#plano').html('');
                        for(i=0;i<4;i++){
                            generatePlanoDummy();
                        }

                        fillTukarPlano('tukarA','tukarB',plano);
                        fillTukarPlano('tukarB','tukarA',plano);
                    });
                }
            });
        }

        function fillLokasi(data, row){
            $('#lokasi').append(
                `<div class="row form-group">
                <div class="col-sm-2 pr-1 pl-1">
                    <input type="text" class="form-control text-center" id="rak${row}" value="${data.lks_koderak}" disabled>
                </div>
                <div class="col-sm-2 pr-1 pl-1">
                    <input type="text" class="form-control text-center" id="subrak{${row}" value="${data.lks_kodesubrak}" disabled>
                </div>
                <div class="col-sm-1 pr-1 pl-1">
                    <input type="text" class="form-control text-center" id="tipe${row}" value="${data.lks_tiperak}" disabled>
                </div>
                <div class="col-sm-2 pr-1 pl-1">
                    <input type="text" class="form-control text-center" id="shelving${row}" value="${data.lks_shelvingrak}" disabled>
                </div>
                <div class="col-sm-1 pr-1 pl-1">
                    <input type="text" class="form-control text-center" id="nourut${row}" value="${data.lks_nourut}" disabled>
                </div>
                <div class="col-sm-1 pr-1 pl-1">
                    <input type="text" class="form-control text-center" id="qty${row}" value="${data.lks_qty}" disabled>
                </div>
                <div class="col-sm-2 pr-1 pl-1">
                    <input type="text" class="form-control text-center" id="expdate${row}" value="${data.lks_expdate}" disabled>
                </div>
            </div>`
            );
        }

        function generateLokasiDummy(){
            $('#lokasi').append(
                `<div class="row form-group">
                    <div class="col-sm-2 pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled>
                    </div>
                    <div class="col-sm-2 pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled>
                    </div>
                    <div class="col-sm-1 pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled>
                    </div>
                    <div class="col-sm-2 pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled>
                    </div>
                    <div class="col-sm-1 pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled>
                    </div>
                    <div class="col-sm-1 pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled>
                    </div>
                    <div class="col-sm-2 pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled>
                    </div>
                </div>`
            );
        }

        function fillPlano(data, row){
            $('#plano').append(
                `<div class="row form-group" id="plano_${row}">
                    <div class="col-sm-2">
                        <button class="btn btn-danger" onclick="deletePlano('${row}','${data.pla_koderak}', '${data.pla_subrak}')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="col-sm-2 pr-1 pl-1">
                        <input type="text" class="form-control text-center" id="pla_nourut${row}" value="${data.pla_nourut}" disabled>
                    </div>
                    <div class="col-sm-4 pr-1 pl-1">
                        <input type="text" class="form-control text-center" id="pla_koderak${row}" value="${data.pla_koderak}" disabled>
                    </div>
                    <div class="col-sm-4 pr-1 pl-1">
                        <input type="text" class="form-control text-center plano-subrak" id="pla_subrak${row}" value="${nvl(data.pla_subrak, '')}" disabled>
                    </div>
                </div>`
            );
        }

        function generatePlanoDummy(){
            $('#plano').append(
                `<div class="row form-group">
                    <div class="col-sm-2">
                        <button class="btn btn-danger">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="col-sm-2 pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled>
                    </div>
                    <div class="col-sm-4 pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled>
                    </div>
                    <div class="col-sm-4 pr-1 pl-1">
                        <input type="text" class="form-control text-center plano-subrak" disabled>
                    </div>
                </div>`
            );
        }

        function deletePlano(row, koderak, subrak){
            swal({
                title: `Yakin ingin menghapus data pada PLU ${$('#prdcd').val()} [ ${koderak} ${ isSubrak ? ' - '+subrak : ''}]`,
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((ok) => {
                if(ok){
                    $.ajax({
                        url: '{{ url()->current() }}/delete-plano',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            prdcd: $('#prdcd').val(),
                            koderak: koderak,
                            subrak: subrak
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            swal({
                                title: response.title,
                                icon: 'success'
                            }).then(() => {
                                getData();
                            })
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            swal({
                                title: error.responseJSON.title,
                                text: error.responseJSON.message,
                                icon: 'error',
                            });
                        }
                    });
                }
            });
        }

        function showModalAdd(){
            $('#m_add input').val('');

            isSubrak ? $('#add_field_subrak').show() : $('#add_field_subrak').hide();


            getLastNumber();
            $('#m_add').modal('show');

            $('#add_koderak').focus();
        }

        function getLastNumber(){
            $.ajax({
                url: '{{ url()->current() }}/get-last-number',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    prdcd: $('#prdcd').val()
                },
                beforeSend: function () {
                    $('#nourut_loading').show();
                },
                success: function (response) {
                    $('#nourut_loading').hide();
                    $('#add_nourut').val(response);
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    });
                }
            });
        }

        function addPlano(){
            swal({
                title: 'Yakin ingin menambahkan data pertemanan untuk PLU '+$('#prdcd').val()+' ?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((ok) => {
                $.ajax({
                    url: '{{ url()->current() }}/add-plano',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        prdcd: $('#prdcd').val(),
                        nourut: $('#add_nourut').val(),
                        koderak: $('#add_koderak').val(),
                        subrak: $('#add_subrak').val(),
                        isSubrak: isSubrak
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        swal({
                            title: response.title,
                            icon: 'success'
                        }).then(() => {
                            $('#m_add').modal('hide');
                            getData();
                        });
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        swal({
                            title: error.responseJSON.title,
                            text: error.responseJSON.message,
                            icon: 'error',
                        });
                    }
                });
            });
        }

        function showLovRak(){
            $(isSubrak ? '#m_subrak' : '#m_koderak').modal('show');
        }

        function getLovKodeRak(){
            if(isSubrak){
                if($.fn.DataTable.isDataTable('#table_subrak')){
                    $('#table_subrak').DataTable().destroy();
                    $("#table_subrak tbody [role='row']").remove();
                }

                $('#table_subrak').DataTable({
                    "ajax": {
                        url: '{{ url()->current().'/get-lov-kode-rak' }}',
                        data: {
                            prdcd: $('#prdcd').val(),
                            isSubrak: isSubrak
                        }
                    },
                    "columns": [
                        {data: 'lks_koderak', name: 'lks_koderak'},
                        {data: 'lks_kodesubrak', name: 'lks_kodesubrak'},
                    ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "createdRow": function (row, data, dataIndex) {
                        $(row).find(':eq(0)').addClass('text-left');
                        $(row).addClass('row-subrak').css({'cursor': 'pointer'});
                    },
                    "order" : [],
                    "initComplete": function(){
                        $(document).on('click', '.row-subrak', function (e) {
                            $('#add_koderak').val($(this).find('td:eq(0)').html());
                            $('#add_subrak').val($(this).find('td:eq(1)').html());

                            $('#m_subrak').modal('hide');
                        });
                    }
                });
            }
            else{
                if($.fn.DataTable.isDataTable('#table_koderak')){
                    $('#table_koderak').DataTable().destroy();
                    $("#table_koderak tbody [role='row']").remove();
                }

                $('#table_koderak').DataTable({
                    "ajax": {
                        url: '{{ url()->current().'/get-lov-kode-rak' }}',
                        data: {
                            prdcd: $('#prdcd').val(),
                            isSubrak: isSubrak
                        }
                    },
                    "columns": [
                        {data: 'lks_koderak', name: 'lks_koderak'},
                    ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "createdRow": function (row, data, dataIndex) {
                        $(row).find(':eq(0)').addClass('text-left');
                        $(row).addClass('row-koderak').css({'cursor': 'pointer'});
                    },
                    "order" : [],
                    "initComplete": function(){
                        $(document).on('click', '.row-koderak', function (e) {
                            $('#add_koderak').val($(this).find('td:eq(0)').html());

                            $('#m_koderak').modal('hide');
                        });
                    }
                });
            }
        }

        function showModalTukar(){
            $('#m_tukar').modal('show');

            $('#m_tukar select').val('-');
        }

        function fillTukarPlano(id1, id2){
            $('#'+id1).html('-');

            $('#'+id1).append(`<option value="-" disabled selected>- Pilih plano -</option>`);
            for(i=0;i<plano.length;i++){
                if($('#'+id2).val() != plano[i].pla_nourut){
                    $('#'+id1).append(
                        `<option value="${i}">${plano[i].pla_nourut} - ${plano[i].pla_koderak} ${ isSubrak ? '- '+plano[i].pla_subrak : '' }</option>`
                    );
                }
            }
        }

        function tukarPlano(){
            if(!$('#tukarA').val() || !$('#tukarB').val()){
                swal({
                    title: 'Data pertemanan yang dipilih belum lengkap!',
                    icon: 'warning'
                });
            }
            else if($('#tukarA').val() == $('#tukarB').val()){
                swal({
                    title: 'Data pertemanan yang dipilih sama!',
                    icon: 'warning'
                });
            }
            else{
                swal({
                    title: 'Yakin ingin menukar data pertemanan untuk PLU '+$('#prdcd').val()+' ?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((ok) => {
                    $.ajax({
                        url: '{{ url()->current() }}/swap-plano',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            prdcd: $('#prdcd').val(),
                            plano1: plano[$('#tukarA').val()],
                            plano2: plano[$('#tukarB').val()]
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            swal({
                                title: response.title,
                                icon: 'success'
                            }).then(() => {
                                $('#m_tukar').modal('hide');
                                getData();
                            });
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            swal({
                                title: error.responseJSON.title,
                                text: error.responseJSON.message,
                                icon: 'error',
                            });
                        }
                    });
                });
            }
        }
    </script>
@endsection
