@extends('navbar')

@section('title','PENERIMAAN DARI CABANG | BATAL TRANSFER')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body">
                        <div class="row form-group">
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">Nomor SJ</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="nosj">
                                <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            <div class="col-sm-2">
                                <button class="col btn btn-primary" onclick="batal()">Batal Surat Jalan</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_trn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_lov_trn">
                                    <thead>
                                    <tr>
                                        <th>Nomor Dokumen</th>
                                        <th>Tanggal</th>
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

    <div class="modal fade" id="m_lov" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_lov">
                                    <thead>
                                    <tr>
                                        <th>Nomor Dokumen</th>
                                        <th>Tanggal</th>
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

    <style>
        body {
            background-color: #edece9;
            /*background-color: #ECF2F4  !important;*/
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .modal tbody tr:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .modal thead tr th{
            vertical-align: middle;
        }
    </style>

    <script>
        $(document).ready(function(){
            $('#table_lov').DataTable({
                "ajax": '{{ url()->current().'/get-data-lov' }}',
                "columns": [
                    {data: 'no', name: 'no'},
                    {data: 'tgl', name: 'tgl'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function(){
                    $('#btn_lov').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov', function (e) {
                        nosj = $(this).find('td:eq(0)').html();

                        $('#m_lov').modal('hide');

                        $('#nosj').val(nosj);
                    });
                }
            });
        });

        $('#nosj').on('keypress',function(e){
            if(e.which == 13){
                batal();
            }
        });

        function batal(){
            if($('#nosj').val() == ''){
                swal({
                    title: 'Nomor Surat Jalan belum dipilih!',
                    icon: 'warning'
                });
            }
            else{
                swal({
                    title: 'Yakin ingin membatalkan surat jalan '+$('#nosj').val()+' ?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }).then((ok) => {
                    if(ok){
                        $.ajax({
                            url: '{{ url()->current().'/batal' }}',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: { nosj: $('#nosj').val() },
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('hide');

                                swal({
                                    title: response.title,
                                    icon: response.status
                                }).then(() => {
                                    if(response.status == 'success'){

                                    }
                                    else{
                                        $('#nosj').select();
                                    }
                                });
                            },
                            error: function (error) {
                                $('#modal-loader').modal('hide');

                                swal('Terjadi kesalahan!','','error');
                            }
                        });
                    }
                })
            }
        }

    </script>

@endsection
