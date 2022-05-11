@extends('navbar')
@section('title','PKM | INQUERY TABEL GONDOLA')
@section('content')


    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-secondary">
                    <div class="card-body shadow-lg cardForm">
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">PLU</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left" id="plu">
                                        <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0 divisi1" data-toggle="modal" data-target="#m_lov_plu">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col-sm-5 pl-0">
                                        <input type="text" class="form-control" id="deskripsi" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Satuan</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="satuan" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Supplier</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="kodesupplier" disabled>
                                    </div>
                                    <div class="col-sm-5 pl-0">
                                        <input type="text" class="form-control" id="namasupplier" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Tanggal Mulai</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="tglawal" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Tanggal Akhir</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="tglakhir" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Jumlah Qty</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="qty" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button class="col-sm-1 btn btn-primary" id="btn-prev" onclick="changeDetail(false)"><<</button>
                                        <button class="col-sm-1 btn btn-primary" id="btn-next" onclick="changeDetail(true)">>></button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button class="col-sm-2 btn btn-primary pl-0" id="btn-prev" onclick="divisiDetail('prev')">CETAK</button>
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

        $(document).ready(function () {
            getModalData('');
            getData();
        })

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
                        $('#plu').val($(this).find('td:eq(1)').html());
                        $('#deskripsi').val($(this).find('td:eq(0)').html());
                        $('#satuan').val($(this).find('td:eq(2)').html());

                        $('#m_lov_plu').modal('hide');

                        getDataPLU();
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

        $('#plu').on('keypress',function(e){
            if(e.which == 13){
                getDataPLU();
            }
        });

        function getDataPLU(){
            {{--$.ajax({--}}
            {{--    url: '{{ url()->current() }}/get-data-plu',--}}
            {{--    type: 'GET',--}}
            {{--    headers: {--}}
            {{--        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
            {{--    },--}}
            {{--    data: {--}}
            {{--        plu: convertPlu($('#plu').val())--}}
            {{--    },--}}
            {{--    beforeSend: function () {--}}
            {{--        $('#modal-loader').modal('show');--}}
            {{--    },--}}
            {{--    success: function (response) {--}}
            {{--        $('#modal-loader').modal('hide');--}}

            {{--        $.each(response.alert, function(index, value){--}}
            {{--            swal({--}}
            {{--                title: value,--}}
            {{--                icon: 'error'--}}
            {{--            });--}}
            {{--        });--}}

            {{--        fillDetail(response.result);--}}
            {{--    },--}}
            {{--    error: function (error) {--}}
            {{--        $('#modal-loader').modal('hide');--}}
            {{--        // handle error--}}
            {{--        swal({--}}
            {{--            title: error.responseJSON.message,--}}
            {{--            icon: 'error'--}}
            {{--        }).then(() => {--}}
            {{--            $('input').val('');--}}
            {{--        });--}}
            {{--    }--}}
            {{--});--}}

            found = false;
            plu = convertPlu($('#plu').val());
            for(i=0;i<arrData.length;i++){
                if(plu == arrData[i].plu){
                    found = true;
                    index = i;
                    fillDetail(arrData[i]);
                    break;
                }
            }
            if(!found){
                swal({
                    title: 'PLU '+plu+' tidak ditemukan!',
                    icon: 'error'
                });
            }
        }

        function getData(){
            $.ajax({
                url: '{{ url()->current() }}/get-data',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    // $('#modal-loader').modal('show');
                },
                success: function (response) {
                    // $('#modal-loader').modal('hide');

                    arrData = response;
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    // handle error
                    swal({
                        title: error.responseJSON.message,
                        icon: 'error'
                    }).then(() => {
                        $('input').val('');
                    });
                }
            });
        }

        function fillDetail(data){
            $('#plu').val(data.plu);
            $('#deskripsi').val(data.deskripsi);
            $('#satuan').val(data.satuan);
            $('#kodesupplier').val(data.kodesupplier);
            $('#namasupplier').val(data.namasupplier);
            $('#tglawal').val(data.tglawal);
            $('#tglakhir').val(data.tglakhir);
            $('#qty').val(data.qty);
        }

        function changeDetail(next){
            if(arrData.length > 0) {
                if(next){
                    if(index < arrData.length - 1)
                        index++;
                    else{
                        swal({
                            title: 'Sudah pada akhir data!',
                            icon: 'warning'
                        });
                    }
                }
                else if(!next){
                    if(index > 0)
                        index--;
                    else{
                        swal({
                            title: 'Sudah pada awal data!',
                            icon: 'warning'
                        });
                    }
                }

                fillDetail(arrData[index]);
            }
        }
    </script>

@endsection
