@extends('navbar')

@section('title','KIRIM CABANG | CETAK SJ PACKLIST')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body">
                        <div class="row form-group">
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">Periode Tanggal</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control tgl" id="tgl1" placeholder="DD/MM/YYYY">
                            </div>
                            <label class="col-form-label">s/d</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control tgl" id="tgl2" placeholder="DD/MM/YYYY">
                            </div>
                            <div class="col-sm-2">
                                <button class="col btn btn-primary" onclick="cetak()">Cetak</button>
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
        $(document).ready(function(){
            $('.tgl').datepicker({
                "dateFormat" : "dd/mm/yy",
            });

        });

        function cetak(){
            if($('#tgl1').val() == '' || $('#tgl2').val() == ''){
                swal({
                    title: 'Tanggal belum lengkap!',
                    icon: 'warning'
                });
            }
            else{
                $.ajax({
                    url: '{{ url('/bo/transaksi/kirimcabang/cetak-sj-packlist/cetak') }}',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data:{
                        tgl1: $('#tgl1').val(),
                        tgl2: $('#tgl2').val(),
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        if(response.status == 'error'){
                            swal({
                                title: response.title,
                                icon: 'error'
                            });
                        }
                        else{
                            tgl1 = $('#tgl1').val();
                            tgl2 = $('#tgl2').val();

                            window.open('{{ url('/bo/transaksi/kirimcabang/cetak-sj-packlist/get-pdf') }}?tgl1='+tgl1+'&tgl2='+tgl2);
                        }
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                    }
                });
            }
        }

    </script>

@endsection
