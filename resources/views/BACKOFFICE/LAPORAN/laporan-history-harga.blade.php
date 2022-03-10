@extends('navbar')
@section('title','LAPORAN | LAPORAN HISTORY HARGA')
@section('content')


    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-secondary">
                    <div class="card-body shadow-lg cardForm">
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <div class="row form-group">
                                    <label for="tanggal" class="col-sm-2 text-right col-form-label">Tanggal</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control text-center" id="tanggal" placeholder="DD/MM/YYYY - DD/MM/YYYY" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Mulai PLU</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left" id="plu1">
                                        <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0 divisi1" onclick="showModalLovPLU('1')">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col-sm-5 pl-0">
                                        <input type="text" class="form-control" id="deskripsi1" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Sampai PLU</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left" id="plu2">
                                        <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0 divisi1" onclick="showModalLovPLU('2')">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col-sm-5 pl-0">
                                        <input type="text" class="form-control" id="deskripsi2" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm"></div>
                                    <div class="col-sm-3">
                                        <button class="col btn btn-primary" id="btn-print" onclick="print()">CETAK LAPORAN</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                {{--                <div class="form-group row">--}}
                {{--                    <div class="col-sm-12">--}}
                {{--                        <button class="btn btn-primary" id="btn-prev" onclick="divisi_detail('prev')">PREV</button>--}}
                {{--                        <button class="btn btn-primary" id="btn-next" onclick="divisi_detail('next')">NEXT</button>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_plu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV PLU</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-striped table-bordered" id="table_lov_plu">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>PLU</th>
                                        <th>Satuan</th>
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


    <script>
        var index = -1;
        var arrData = [];
        var currField = null;

        $(document).ready(function () {
            getModalData('');
        });

        $('#tanggal').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        function showModalLovPLU(field){
            $('#m_lov_plu').modal('show');

            currField = field;
        }

        $('#m_lov_plu').on('shown.bs.modal',function(){
            $('#table_lov_plu_filter input').val('');
            $('#table_lov_plu_filter input').select();
        });

        function getModalData(value){
            if ($.fn.DataTable.isDataTable('#table_lov_plu')) {
                $('#table_lov_plu').DataTable().destroy();
                $("#table_lov_plu tbody [role='row']").remove();
            }

            if(!$.isNumeric(value)){
                search = value.toUpperCase();
            }
            else search = value;

            $('#table_lov_plu').DataTable({
                "ajax": {
                    'url' : '{{ url()->current() }}/get-lov-plu',
                    "data" : {
                        'plu' : search
                    },
                },
                "columns": [
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                    {data: 'prd_prdcd', name: 'prd_prdcd'},
                    {data: 'satuan', name: 'satuan'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-plu');
                },
                "initComplete" : function(){
                    $('#table_lov_plu_filter input').val(value).select();

                    $(".row-plu").prop("onclick", null).off("click");

                    $(document).on('click', '.row-plu', function (e) {
                        getDataPLU($(this).find('td:eq(1)').html());

                        $('#m_lov_plu').modal('hide');
                    });
                }
            });

            $('#table_lov_plu_filter input').val(value);

            $('#table_lov_plu_filter input').off().on('keypress', function (e){
                if (e.which === 13) {
                    let val = $(this).val().toUpperCase();

                    getModalData(val);
                }
            });
        }

        $('#plu1').on('keypress',function(e){
            if(e.which == 13) {
                currField = 1;
                getDataPLU($(this).val());
            }
        });

        $('#plu2').on('keypress',function(e){
            if(e.which == 13){
                currField = 2;
                getDataPLU($(this).val());
            }
        });

        function getDataPLU(plu){
            if(convertPlu($('#plu1').val()) > convertPlu($('#plu2').val()) && $('#plu1').val() && $('#plu2').val()){
                swal({
                    title: currField == '1' ? 'PLU 1 lebih besar dari PLU 2' : 'PLU 2 lebih kecil dari PLU 1',
                    icon: 'error'
                }).then(()=>{
                    $('#plu'+currField).select();
                });
            }
            else{
                $.ajax({
                    url: '{{ url()->current() }}/get-data-plu',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        plu: convertPlu(plu)
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        $('#plu'+currField).val(response.prd_prdcd);
                        $('#deskripsi'+currField).val(response.prd_deskripsipanjang);

                        if(currField == '1'){
                            $('#plu2').select();
                        }
                        else $('#btn-print').focus();
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        // handle error
                        swal({
                            title: error.responseJSON.message,
                            icon: 'error'
                        }).then(() => {
                            $('#plu'+currField).select();
                            $('#deskripsi'+currField).val('');
                        });
                    }
                });
            }
        }

        function print(){
            if(!$('#plu1').val())
                $('#plu1').val(nvl(this.value, '0000000'));
            if(!$('#plu2').val())
                $('#plu2').val(nvl(this.value, '9999999'));

            swal({
                title: 'Yakin ingin mencetak laporan?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((ok) => {
                if(ok){
                    tanggal = $('#tanggal').val().split(' - ');

                    tgl1 = tanggal[0];
                    tgl2 = tanggal[1];

                    window.open(`{{ url()->current() }}/print?tgl1=${tgl1}&tgl2=${tgl2}&plu1=${$('#plu1').val()}&plu2=${$('#plu2').val()}`,'_blank');
                }
            });
        }
    </script>

@endsection
