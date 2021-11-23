@extends('navbar')

@section('title','OMI | Proses Tolakan CLO PB OMI')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body pt-0">
                        <fieldset class="card border-secondary mt-0" id="data-field">
                            <legend  class="w-auto ml-3">Detail Tolakan Kredit Limit PB OMI</legend>
                            <div class="card-body pt-0">
                                <table class="table table bordered table-sm mt-3" id="table_data">
                                    <thead class="theadDataTables">
                                    <tr class="text-center align-middle">
                                        <th class="align-middle" width="5%">Kode OMI</th>
                                        <th class="align-middle" width="15%">Nomor PB</th>
                                        <th class="align-middle" width="15%">Tanggal PB</th>
                                        <th class="align-middle" width="15%">Maksimum Kredit</th>
                                        <th class="align-middle" width="15%">Saldo Tagihan</th>
                                        <th class="align-middle" width="15%">Nilai Order PB</th>
                                        <th class="align-middle" width="15%">Jumlah Kredit</th>
                                        <th class="align-middle" width="5%">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body py-0" id="top_field">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-1 col-form-label text-right pl-0 pr-0">Nama OMI</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control text-left" id="namaOMI" disabled>
                                    </div>
                                    <label for="prdcd" class="col-sm-1 col-form-label text-right pl-0 pr-0">Keterangan</label>
                                    <div class="col-sm">
                                        <input type="text" class="form-control text-left" id="keterangan" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <p>Status PB OMI : 1 = Tolakan Kredit Limit, Kosong = OK</p>
                                    <div class="col-sm"></div>
                                    <div class="col-sm-2">
                                        <button class="col btn btn-success" onclick="save()">SIMPAN</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #edece9;
            /*background-color: #ECF2F4  !important;*/
            /*overflow-y: hidden;*/
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
            max-height: 230px;
            overflow-y: scroll;
            overflow-x: hidden;
        }

        .nowrap{
            white-space: nowrap;
        }
    </style>

    <script>
        var dataTolakan = [];

        $(document).ready(function(){
            getData();
        });

        function getData(){
            dataTolakan = [];

            if ($.fn.DataTable.isDataTable('#table_data')) {
                $('#table_data').DataTable().destroy();
                $("#table_data tbody [role='row']").remove();
            }

            $('#table_data').DataTable({
                "ajax": {
                    'url' : '{{ url()->current() }}/get-data',
                },
                "columns": [
                    {data: 'tlkc_kodeomi'},
                    {data: 'tlkc_nopb'},
                    {data: 'tlkc_tglpb'},
                    {data: 'tlkc_max_kredit'},
                    {data: 'tlkc_tagihan'},
                    {data: 'tlkc_nilai_pb'},
                    {data: 'tlkc_jml_kredit'},
                    {data: null, render: function(data, meta){
                            return `<input class="form-control text-right status" value="${ nvl(data.tlkc_status, '') }" maxlength="1">`;
                        }
                    },
                ],
                "scrollY" : '30vh',
                "paging": false,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-data');
                    $(row).find('td:eq(0)').attr('width','5%');
                    $(row).find('td:eq(1)').addClass('text-center kode').attr('width','15%');
                    $(row).find('td:eq(2)').addClass('text-center nomorPB').attr('width','15%');
                    $(row).find('td:eq(3)').addClass('text-right tanggalPB').attr('width','15%');
                    $(row).find('td:eq(4)').addClass('text-right').attr('width','15%');
                    $(row).find('td:eq(5)').addClass('text-right').attr('width','15%');
                    $(row).find('td:eq(6)').addClass('text-right').attr('width','15%');
                    $(row).find('td:eq(7)').attr('width','5%');
                    dataTolakan.push(data);
                },
                "initComplete" : function(){
                    $('.row-data').on('mouseover',function(){
                        $('#namaOMI').val(dataTolakan[$(this).index()].tlkc_namaomi);
                        $('#keterangan').val(dataTolakan[$(this).index()].tlkc_keterangan);
                    });
                }
            });
        }

        function save(){
            changedData  = [];

            $('.row-data').each(function(){
                index = $(this).index();

                if($(this).find('.status').val() != nvl(dataTolakan[index].tlkc_status, '')){
                    temp = {
                        'tlkc_kodeomi' : dataTolakan[index].tlkc_kodeomi,
                        'tlkc_nopb' : dataTolakan[index].tlkc_nopb,
                        'tlkc_tglpb' : dataTolakan[index].tlkc_tglpb,
                        'tlkc_status' : $(this).find('.status').val()
                    }

                    // temp = [];
                    // temp['tlkc_kodeomi'] = dataTolakan[index].tlkc_kodeomi;
                    // temp['tlkc_nopb'] = dataTolakan[index].tlkc_nopb;
                    // temp['tlkc_tglpb'] = dataTolakan[index].tlkc_tglpb;
                    // temp['tlkc_status'] = $(this).find('.status').val();

                    changedData.push(temp);
                }
            });

            console.log(changedData);

            if(changedData.length == 0){
                swal({
                    title: 'Tidak ada perubahan!',
                    icon: 'warning'
                });
            }
            else{
                swal({
                    title: 'Yakin ingin menyimpan perubahan?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then(function(ok){
                    $.ajax({
                        url: '{{ url()->current() }}/save-data',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            changedData  : changedData
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            swal({
                                title: response.message,
                                icon: 'success'
                            }).then(function(){
                                $('#modal-loader').modal('hide');
                                getData();
                            });
                        },
                        error: function (error) {
                            swal({
                                title: error.responseJSON.message,
                                icon: 'error',
                            }).then(() => {
                                $('#modal-loader').modal('hide');
                            });
                        }
                    });
                });
            }
        }
    </script>
@endsection
