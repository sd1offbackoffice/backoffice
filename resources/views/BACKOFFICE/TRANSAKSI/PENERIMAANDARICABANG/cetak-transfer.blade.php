@extends('navbar')

@section('title','PENERIMAAN CABANG | CETAK TRANSFER')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body">
                        <div class="row form-group">
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">No BPB</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="bpb1" disabled>
                                <button id="btn_lov_plu_utuh" type="button" class="btn btn-primary btn-lov p-0 btn_lov" data-toggle="modal" data-target="#m_lov_trn" onclick="f_bpb = 1;" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            <label class="col-form-label">s/d</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="bpb2" disabled>
                                <button id="btn_lov_plu_utuh" type="button" class="btn btn-primary btn-lov p-0 btn_lov" data-toggle="modal" data-target="#m_lov_trn" onclick="f_bpb = 2;" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            <div class="col-sm-2">
                                <button class="col btn btn-primary" onclick="cetak()">Cetak</button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">Ukuran Kertas</label>
                            <div class="col-sm-2">
                                <select class="form-control" id="ukuran">
                                    <option>BESAR</option>
                                    <option>KECIL</option>
                                </select>
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
        var f_bpb;

        $(document).ready(function(){
            $('.tgl').datepicker({
                "dateFormat" : "dd/mm/yy",
            });

            getLov();
        });

        function getLov(){
            lovtrn = $('#table_lov_trn').DataTable({
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
                    $(row).addClass('row-lov-trn').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $('.btn_lov').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-trn', function (e) {
                        nosj = $(this).find('td:eq(0)').html();

                        $('#m_lov_trn').modal('hide');

                        if(f_bpb == 1){
                            $('#bpb1').val(nosj);
                        }
                        else{
                            $('#bpb2').val(nosj);
                        }

                        cekBPB();
                    });
                }
            });
        }

        function cekBPB(){
            if($('#bpb1').val() > $('#bpb2').val() && $('#bpb1').val() != '' && $('#bpb2').val() != ''){
                swal({
                    title: 'No BPB pertama lebih besar dari no BPB kedua!',
                    icon: 'error'
                }).then(() => {
                    if(f_bpb == 1){
                        $('#bpb1').val('');
                    }
                    else{
                        $('#bpb2').val('');
                    }
                });
            }
        }

        function cetak(){
            if($('#bpb1').val() == '' || $('#bpb2').val() == ''){
                swal({
                    title: 'No BPB belum lengkap!',
                    icon: 'warning'
                });
            }
            else{
                swal({
                    title: 'Proses mungkin membutuhkan waktu jika data terlalu banyak!',
                    icon: 'warning'
                }).then(() => {
                    window.open('{{ url()->current() }}/cetak?bpb1='+$('#bpb1').val()+'&bpb2='+$('#bpb2').val()+'&size='+$('#ukuran').val());
                });
            }
        }

    </script>

@endsection
