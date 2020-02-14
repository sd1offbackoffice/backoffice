@extends('navbar')
@section('content')


    <div class="container-fluid">
        <div class="row justify-content-sm-center">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Master Kubikasi Plano</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <div class="col-sm-7 p-0">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-3 h5 ">LOKASI</legend>
                                    <div class="card-body">
                                        <div class="row ">
                                            <label for="i_koderak" class="col-sm-4 col-form-label text-right">KODE RAK :</label>
                                            <input type="text" class="col-sm-4 form-control" id="i_koderak" placeholder="..." value="" >
                                            <div class="col-sm-1 m-0">
                                                <button type="button" class="btn p-0" data-toggle="modal" data-target="#m_koderak"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                                            </div>
                                            <div class="col-sm-1">
                                                <button class="btn btn-success" id="btn-save" onclick="clear_data()">CLEAR</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="i_subrak" class="col-sm-4 col-form-label text-right">SUB RAK :</label>
                                            <input type="text" class="col-sm-4 form-control" id="i_subrak" placeholder="..." value="" >
                                            <div class="col-sm-1 m-0">
                                                <button type="button" class="btn p-0" data-toggle="modal" data-target="#m_subrak"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="i_shelving" class="col-sm-4 col-form-label text-right">SHELVING :</label>
                                            <input type="text" class="col-sm-4 form-control" id="i_shelving" placeholder="..." value="" >
                                            <div class="col-sm-1 m-0">
                                                <button type="button" class="btn p-0" data-toggle="modal" data-target="#m_shelving"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                                            </div>
                                            <label for="i_kosongsemua" class="col-sm-3 col-form-label text-right" ><small>* kosong = semua</small></label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-5 p-0">
                                <legend  class="w-auto ml-3 h5 "><u>Simulasi BPB</u></legend>
                                <div class="row ">
                                    <label for="i_plu" class="col-sm-5 col-form-label text-right" >PLU :</label>
                                    <input type="text" class="col-sm-6 form-control" id="i_plu" placeholder="..." value="" disabled>
                                </div>
                                <div class="row">
                                    <label for="i_deskripsi" class="col-sm-5 col-form-label text-right">DESKRIPSI :</label>
                                    <input type="text" class="col-sm-6 form-control" id="i_deskripsi"  value="" disabled>
                                </div>
                                <div class="row">
                                    <label for="i_satuan" class="col-sm-5 col-form-label text-right">SATUAN :</label>
                                    <input type="text" class="col-sm-6 form-control" id="i_satuan"  value="" disabled>
                                </div>
                                <div class="row">
                                    <label for="i_volume" class="col-sm-5 col-form-label text-right">Volume (cm<sup>3</sup>) :</label>
                                    <input type="text" class="col-sm-6 form-control" id="i_volume" value="" disabled>
                                </div>
                                <div class="row">
                                    <label for="i_qty" class="col-sm-5 col-form-label text-right">QTY (CTN) :</label>
                                    <input type="text" class="col-sm-6 form-control" id="i_qty" placeholder="..." value="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 p-0">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-3 h5 ">KUBIKASI</legend>
                                    <div class="card-body p-1">
                                        <table class="table table-sm table-striped table-bordered display compact" id="table_kubikasi">
                                            <thead class="thead-dark">
                                            <tr class="thNormal text-center">
                                                <th class="text-center small">Koderak</th>
                                                <th class="text-center small">Sub Rak</th>
                                                <th class="text-center small">Shelving</th>
                                                <th class="text-center small">Volume (cm<sup>3</sup>)</th>
                                                <th class="text-center small">Allowance (%)</th>
                                                <th class="text-center small">Vol.Real (cm<sup>3</sup>)</th>
                                                <th class="text-center small">Vol.Exists (cm<sup>3</sup>)</th>
                                                <th class="text-center small">Vol.Book (cm<sup>3</sup>)</th>
                                                <th class="text-center small">Vol.BTB (cm<sup>3</sup>)</th>
                                                <th class="text-center small">Sisa (cm<sup>3</sup>)</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tbody_table_penerimaan">
                                            {{--<tr>--}}
                                                {{--<td>--}}
                                                    {{--<input type="text" class="form-control" value="" disabled>--}}
                                                {{--</td>--}}
                                                {{--<td>--}}
                                                    {{--<input type="text" class="form-control" value="" disabled>--}}
                                                {{--</td>--}}
                                                {{--<td>--}}
                                                    {{--<input type="text" class="form-control" value="" disabled>--}}
                                                {{--</td>--}}
                                                {{--<td>--}}
                                                    {{--<input type="text" class="form-control c-volume" value="" disabled>--}}
                                                {{--</td>--}}
                                                {{--<td>--}}
                                                    {{--<input type="text" class="form-control c-allowance" value="" disabled>--}}
                                                {{--</td>--}}
                                                {{--<td>--}}
                                                    {{--<input type="text" class="form-control" value="" disabled>--}}
                                                {{--</td>--}}
                                                {{--<td>--}}
                                                    {{--<input type="text" class="form-control" value="" disabled>--}}
                                                {{--</td>--}}
                                                {{--<td>--}}
                                                    {{--<input type="text" class="form-control" value="" disabled>--}}
                                                {{--</td>--}}
                                                {{--<td>--}}
                                                    {{--<input type="text" class="form-control" value="" disabled>--}}
                                                {{--</td>--}}
                                                {{--<td>--}}
                                                    {{--<input type="text" class="form-control" value="" disabled>--}}
                                                {{--</td>--}}
                                            {{--</tr>--}}
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>
                            <br>
                            <div class="col-sm-12 ">
                                    <button class="btn btn-primary float-right mt-1" id="btn-save">SAVE</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <!-- Modal LOV kode rak -->
    <div class="modal fade" id="m_koderak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                </div>
                <div class="modal-body" style="height: 650px">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-sm" id="table_lovkoderak">
                                    <thead class="thead-dark" width="1000px">
                                        <tr>
                                            <th>Kode Rak</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($koderak as $p)
                                    <tr onclick="koderak_lov_select('{{ $p->lks_koderak }}')" class="row_lov">
                                    <td>{{ $p->lks_koderak }}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal LOV sub rak -->
    <div class="modal fade" id="m_subrak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                </div>
                <div class="modal-body" style="height: 650px">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-sm" id="table_lovsubrak">
                                    <thead class="thead-dark" width="1000px">
                                    <tr>
                                        <th width="75%">Kode Rak</th>
                                        <th width="25%">Sub Rak</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal LOV shelving -->
    <div class="modal fade" id="m_shelving" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                </div>
                <div class="modal-body" style="height: 650px">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-sm" id="table_lovshelving">
                                    <thead class="thead-dark" width="1000px">
                                    <tr>
                                        <th>Kode Rak</th>
                                        <th>Sub Rak</th>
                                        <th>Shelving</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--LOADER--}}
    <div class="modal fade" id="modal-loader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="vertical-align: middle;">
        <div class="modal-dialog modal-dialog-centered" role="document" >
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="loader" id="loader"></div>
                            <div class="col-sm-12">
                                <label for="">LOADING...</label>
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
        label {
            color: #232443;
            /*color: #8A8A8A;*/
            font-weight: bold;
        }
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }
        .cardForm {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .my-custom-scrollbar {
            position: relative;
            height: 517px;
            overflow-x: hidden;
            overflow-y: scroll;
        }
        .table-wrapper-scroll-y {
            display: block;
        }
        .row_lov:hover{
            cursor: pointer;
            background-color: grey;
            color: white;
        }
        .row_lov_subrak:hover{
            cursor: pointer;
            background-color: grey;
            color: white;
        }
        .row_lov_shelving:hover{
            cursor: pointer;
            background-color: grey;
            color: white;
        }
    </style>

    <script>
        $(document).ready(function () {
            $('#table_lovkoderak').DataTable({
                "lengthChange": false,
            });
            $('#table_lovsubrak').DataTable({
                "lengthChange": false,
            });
            $('#table_lovshelving').DataTable({
                "lengthChange": false,
            });
            $('#table_kubikasi').DataTable({
                "lengthChange": false,
            });
        });

        function koderak_lov_select(koderak) {
            $('#m_koderak').modal('hide');
            $('#i_koderak').val(koderak);
            $.ajax({
                url: '/BackOffice/public/mstkubikasiplano/lov_subrak',
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}", koderak:koderak},
                beforeSend: function(){
                    $('#table_lovsubrak').DataTable().destroy();
                    $('.row_lov_subrak').remove();
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    for (var i = 0; i < response.length ; i++ ){
                        $('#table_lovsubrak').append(
                            '<tr onclick="subrak_lov_select(\''+response[i].lks_koderak+'\',\''+response[i].lks_kodesubrak+'\')" class="row_lov_subrak">' +
                            '      <td>'+response[i].lks_koderak+'</td>\n' +
                            '      <td>'+response[i].lks_kodesubrak+'</td>\n' +
                            '</tr>'
                            );
                    }
                },
                complete: function(){
                    $('#modal-loader').modal('hide');
                    $('#table_lovsubrak').DataTable();
                }
            });
        }

        function subrak_lov_select(koderak,subrak) {
            $('#m_subrak').modal('hide');
            $('#i_koderak').val(koderak);
            $('#i_subrak').val(subrak);
            $.ajax({
                url: '/BackOffice/public/mstkubikasiplano/lov_shelving',
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}", koderak:koderak ,subrak:subrak},
                beforeSend: function(){
                    $('#table_lovshelving').DataTable().destroy();
                    $('.row_lov_shelving').remove();
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    for (var i = 0; i < response.length ; i++ ){
                        $('#table_lovshelving').append(
                            '<tr onclick="shelving_lov_select(\''+response[i].lks_koderak+'\',\''+response[i].lks_kodesubrak+'\',\''+response[i].lks_shelvingrak+'\')" class="row_lov_shelving">' +
                            '      <td>'+response[i].lks_koderak+'</td>\n' +
                            '      <td>'+response[i].lks_kodesubrak+'</td>\n' +
                            '      <td>'+response[i].lks_shelvingrak+'</td>\n' +
                            '</tr>'
                        );
                    }
                },
                complete: function(){
                    $('#modal-loader').modal('hide');
                    $('#table_lovshelving').DataTable();
                }
            });
        }
        function shelving_lov_select(koderak,subrak,shelving) {
            $('#m_shelving').modal('hide');
            $('#i_koderak').val(koderak);
            $('#i_subrak').val(subrak);
            $('#i_shelving').val(shelving);
            $('#i_shelving').focus();
        }

        function clear_data() {
            $('#i_koderak').val("");
            $('#i_subrak').val("");
            $('#i_shelving').val("");
            $('.row_lov_subrak').remove();
            $('.row_lov_shelving').remove();
            $('#i_plu').prop("disabled","disabled");
            $('#i_qty').prop("disabled","disabled");
            $('#i_koderak').prop("disabled",false);
            $('#i_subrak').prop("disabled",false);
            $('#i_shelving').prop("disabled",false);
        }
        $('#i_koderak').keypress(function (e) {
            if (e.keyCode == 13) {
                $('#i_subrak').select();
            }
        });
        $('#i_subrak').keypress(function (e) {
            if (e.keyCode == 13) {
                $('#i_shelving').select();
            }
        });
        $('#i_subrak').on('keyup',function (e) {
            if ($('#i_subrak').val()!='' && $('#i_koderak').val()=='' ) {
                $('#i_subrak').val('');
                $('#i_koderak').select();
            }
        });

        $('#i_shelving').on('keyup',function (e) {
            if ($('#i_shelving').val()!='' && $('#i_koderak').val()=='' ) {
                $('#i_shelving').val('');
                $('#i_koderak').select();
            }
            else if($('#i_shelving').val()!='' && $('#i_subrak').val()==""){
                $('#i_shelving').val('');
                $('#i_subrak').select();
            }
        });

        $('#i_shelving').keypress(function (e) {
            if (e.keyCode == 13) {
                if ($('#i_koderak').val() != "" && $('#i_subrak').val() != "" && $('#i_shelving').val() != ""){
                    $('#i_koderak').prop("disabled","disabled");
                    $('#i_subrak').prop("disabled","disabled");
                    $('#i_shelving').prop("disabled","disabled");
                    $('#i_plu').prop("disabled",false);
                    $('#i_qty').prop("disabled",false);
                    $('#i_plu').select();
                }
                else {
                    $.ajax({
                        url: '/BackOffice/public/mstkubikasiplano/dataRakKecil',
                        type: 'POST',
                        data: {"_token": "{{ csrf_token() }}"},
                        beforeSend: function(){
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            $('#i_koderak').prop("disabled","disabled");
                            $('#i_subrak').prop("disabled","disabled");
                            $('#i_shelving').prop("disabled","disabled");
                        },
                        success: function (response) {
                            $('#table_kubikasi').DataTable().destroy();
                            console.log(response);
                            for (var i = 0; i < response.length ; i++ ){
                                $('#table_kubikasi').append(
                                    '<tr>' +
                                    '      <td>'+response[i].kbp_koderak+'</td>\n' +
                                    '      <td>'+response[i].kbp_kodesubrak+'</td>\n' +
                                    '      <td>'+response[i].kbp_shelvingrak+'</td>\n' +
                                    '      <td>'+response[i].kbp_volumeshell+'</td>\n' +
                                    '      <td>'+response[i].kbp_allowance+'</td>\n' +
                                    '      <td>'+response[i].volreal+'</td>\n' +
                                    '      <td>'+response[i].lks_shelvingrak+'</td>\n' +
                                    '      <td>'+response[i].lks_shelvingrak+'</td>\n' +
                                    '      <td>'+response[i].lks_shelvingrak+'</td>\n' +
                                    '      <td>'+response[i].lks_shelvingrak+'</td>\n' +
                                    '</tr>'
                                );
                            }
                        },
                        complete: function(){
                            $('#modal-loader').modal('hide');
                            $('#table_kubikasi').DataTable();
                            $('#i_plu').prop("disabled",false);
                            $('#i_qty').prop("disabled",false);
                            $('#i_plu').select();
                        }
                    });
                }
            }
        });
    </script>

@endsection

