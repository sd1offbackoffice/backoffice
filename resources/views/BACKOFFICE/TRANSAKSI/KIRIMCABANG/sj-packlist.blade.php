@extends('navbar')

@section('title','KIRIM CABANG | TRANSAKSI SJ PACKLIST')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body">
                        <div class="row">
                            <button class="col btn btn-lg btn-primary" onclick="proses()">Proses Transaksi Surat Jalan Packlist</button>
                        </div>
                    </div>
                    <fieldset class="card border-secondary ml-2 mr-2 mt-0 mb-2">
                        <div class="card-body">
                            <table id="table_daftar" class="table table-sm table-bordered mb-3 text-center">
                                <thead class="thColor">
                                    <tr>
                                        <th>Cabang</th>
                                        <th>No Packing List</th>
                                        <th>Nomor SJ</th>
                                        <th>Supplier</th>
                                        <th>Nama Supplier</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
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
        var tabel;
        var tableData;

        $(document).ready(function(){
            tabel = $('#table_daftar').DataTable({
                "scrollY": "40vh",
                "paging" : false,
                "sort": false,
                "bInfo": false,
                "searching": false
            });
        });

        function proses(){
            $.ajax({
                url: '{{ url('/bo/transaksi/kirimcabang/sj-packlist/proses') }}',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
                        tabel.destroy();

                        for(i=0;i<response.length;i++){
                            html = `<tr>
                                        <td>${nvl(response[i].trbo_loc,'-')}</td>
                                        <td>${nvl(response[i].trbo_nonota,'-')}</td>
                                        <td>${nvl(response[i].trbo_nodoc,'-')}</td>
                                        <td>${nvl(response[i].trbo_kodesupplier,'-')}</td>
                                        <td>${nvl(response[i].sup_namasupplier,'-')}</td>
                                    </tr>`;
                            $('#table_daftar tbody').append(html);
                        }
                        tabel = $('#table_daftar').DataTable({
                            "scrollY": "40vh",
                            "paging" : false,
                            "sort": false,
                            "bInfo": false,
                            "searching": false
                        });

                        swal({
                            title: 'Data berhasil diproses!',
                            icon: 'success'
                        }).then(() => {
                            window.open('{{ url('/bo/transaksi/kirimcabang/sj-packlist/cetak') }}','_blank');
                        });
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                }
            });
        }

    </script>

@endsection
