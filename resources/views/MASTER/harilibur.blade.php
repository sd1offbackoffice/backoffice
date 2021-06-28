@extends('navbar')
@section('title','MASTER | MASTER HARI LIBUR')
@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body shadow-lg cardForm">
                        <table class="table table-sm table-hover table-bordered" id="tableHariLibur">
                            <thead class="theadDataTables">
                            <tr>
                                <th> TANGGAL</th>
                                <th >KETERANGAN</th>
                            </tr>
                            </thead>
                            <tbody  id="tbodyHariLibur">
                            </tbody>
                        </table>

                        <div class="form-group row mb-0 mt-3">
                            <label for="i_tgl" class="col-sm-2 col-form-label text-right">TANGGAL</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="i_tgl" placeholder="DD-MM-YYYY">
                            </div>
                            <label for="i_keterangan" class="col-sm-2 col-form-label text-right">KETERANGAN</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="i_keterangan" placeholder="...">
                            </div>
                        </div>
                        <div class="form-group row mb-0 mt-3 justify-content-center">
                            <div class="col-sm-2">
                                <button class="btn btn-primary btn-block" id="btn-save" onclick="clearField()">INSERT</button>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-primary btn-block" id="btn-save" onclick="saveHariLibur()">SAVE</button>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-danger btn-block" id="btn-delete" onclick="deleteHariLibur()">DELETE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        input{
            text-transform: uppercase;
        }
    </style>

    <script>
        let tablehariLibur;

        $(document).ready(function (){
            $('#i_tgl').datepicker({
                "dateFormat" : "dd-mm-yy"
            });
            tablehariLibur =  $('#tableHariLibur').DataTable();
            getHariLibur();
        });

        function getHariLibur(){
            tablehariLibur.destroy();
            tablehariLibur =  $('#tableHariLibur').DataTable({
                "ajax": '{{ url('mstharilibur/getharilibur') }}',
                "columns": [
                    {data: 'lib_tgllibur'},
                    {data: 'lib_keteranganlibur'},
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
                },
                "order": [],
                columnDefs : [
                    { targets : [0],
                        render : function (data, type, row) {
                            return formatDateCustom(data, 'dd-mm-yy');
                        }
                    }
                ]
            });

            $('#tableHariLibur_filter input').focus()
        }

        $(document).on('click', '.modalRow', function () {
            let tgl = $(this).find('td')[0]['innerHTML']
            let ket = $(this).find('td')[1]['innerHTML']

            inputToField(tgl,ket)
        } );

        function clearField(){
            $('#i_tgl').focus();
            $('#i_tgl').val('');
            $('#i_keterangan').val('');
        }

        function actionHariLibur(string) {
            let tgl = $('#i_tgl').val();
            let ket = $('#i_keterangan').val();

            if(!ket && !tgl){
                swal('MOHON MENGISI TANGGAL DAN KETERANGAN', '', 'warning');
            } else if (!tgl) {
                swal('MOHON MENGISI TANGGAL', '', 'warning')
            } else  if(!ket){
                swal('MOHON MENGISI KETERANGAN', '', 'warning')
            } else {
                ajaxSetup();
                $.ajax({
                    url: string,
                    type: 'post',
                    data: {tgllibur: tgl, ketlibur: ket},
                    beforeSend: function(){
                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function (result) {
                        if (result.kode === 1) {
                            swal(result.msg,'','success');
                            getHariLibur();

                        } else {
                            swal('ERROR', "Something's Error", 'error')
                        }

                        $('#i_tgl').val('');
                        $('#i_keterangan').val('');
                        $('#modal-loader').modal('hide');
                    }, error: function (err) {
                        $('#modal-loader').modal('hide');
                        console.log(err.responseJSON.message.substr(0,150));
                        alertError(err.statusText, err.responseJSON.message);
                    }
                });
            }
        }

        function saveHariLibur() {
            actionHariLibur( '/BackOffice/public/mstharilibur/insert')
        }

        function deleteHariLibur() {
            swal({
                icon: 'warning',
                title: 'Hari Libur Akan di Hapus?',
                buttons: true,
                dangerMode: true
            }).then((response) =>{
                if (response){
                    actionHariLibur( '/BackOffice/public/mstharilibur/delete')
                }
                });
        }

        function inputToField(tgl, ket) {
            // let tgl =  temp['attributes'][1]['nodeValue']
            // let ket =  temp['attributes'][2]['nodeValue']

            $('#i_tgl').val(tgl);
            $('#i_keterangan').val(ket);
        }
    </script>

@endsection
