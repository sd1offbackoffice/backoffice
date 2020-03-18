@extends('navbar')
@section('content')


    <div class="container">
        <div class="row justify-content-sm-center">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Master Kubikasi Plano</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row cek">
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
                                                <button class="btn btn-success" id="btn-clear" onclick="clear_data()">CLEAR</button>
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
                                    <label for="i_plu" class="col-sm-4 col-form-label text-right" >PLU :</label>
                                    <input type="text" class="col-sm-6 form-control" id="i_plu" onclick="validate()" placeholder="..." value="" disabled>
                                    <div class="col-sm-1 m-0">
                                        <button type="button" id="btn-plu" class="btn p-0" data-toggle="modal" data-target="#m_pluHelp" disabled><img src="{{asset('image/icon/help.png')}}" width="30px" ></button>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="i_deskripsi" class="col-sm-4 col-form-label text-right">DESKRIPSI :</label>
                                    {{--<input type="text" class="col-sm-6 form-control" id="i_deskripsi"  value="" disabled>--}}
                                    <textarea name="" id="i_deskripsi" class="col-sm-6 form-control" disabled></textarea>
                                </div>
                                <div class="row">
                                    <label for="i_satuan" class="col-sm-4 col-form-label text-right">SATUAN :</label>
                                    <input type="text" class="col-sm-6 form-control" id="i_satuan"  value="" disabled>
                                </div>
                                <div class="row">
                                    <label for="i_volume" class="col-sm-4 col-form-label text-right">Volume (cm<sup>3</sup>) :</label>
                                    <input type="text" class="col-sm-6 form-control text-right" id="i_volume" value="" disabled>
                                </div>
                                <div class="row">
                                    <label for="i_qty" class="col-sm-4 col-form-label text-right" >QTY (CTN) :</label>
                                    <input type="text" class="col-sm-6 form-control text-right num" id="i_qty" onclick="validate()" placeholder="..." value="" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 p-0">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-3 h5 ">KUBIKASI</legend>
                                    <div class="card-body p-1 my-custom-scrollbar table-wrapper-scroll-y">
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
                                            <tbody >
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>
                            <br>
                            <label for="ket_save"></label>
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
    <!-- Modal PLU-->
    <div class="modal fade" id="m_pluHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="search_lov" class="form-control search_lov" type="text" placeholder="Inputkan Deskripsi / PLU Produk" aria-label="Search">
                        <div class="invalid-feedback">
                            Inputkan minimal 3 karakter
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table" id="table_lov">
                                    <thead>
                                    <tr>
                                        <td>Deskripsi</td>
                                        <td>PLU</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($produk as $p)
                                        <tr onclick="lov_select('{{ $p->prd_prdcd }}')" class="row_lov">
                                            <td>{{ $p->prd_deskripsipanjang }}</td>
                                            <td>{{ $p->prd_prdcd }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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
        .red{
            background-color: #ff000094 !important;
        }
    </style>

    <script>
        var kubikasi;
        var data;
        var count_data=0;
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

            // $('#i_koderak').val('GTAC');
            // $('#i_subrak').val('01');
            // $('#i_shelving').val('01');
            //
            //
            // var e = $.Event("keypress");
            // e.keyCode = 13;
            // $('#i_shelving').trigger(e);

            // $('#i_plu').val('410');
            // $('#i_plu').trigger(e);
            // $('#i_qty').val('5');
            // $('#i_qty').trigger(e);


        });

        function koderak_lov_select(koderak) {
            $('#m_koderak').modal('hide');
            $('#i_koderak').val(koderak);
            $.ajax({
                url: '/BackOffice/public/api/mstkubikasiplano/lov_subrak',
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
                url: '/BackOffice/public/api/mstkubikasiplano/lov_shelving',
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
            $('#btn-plu').prop("disabled","disabled");
            $('#i_koderak').prop("disabled",false);
            $('#i_subrak').prop("disabled",false);
            $('#i_shelving').prop("disabled",false);
            $('#i_plu').val("");
            $('#i_qty').val("");
            $('#i_deskripsi').val("");
            $('#i_satuan').val("");
            $('#i_volume').val("");
            $('.baris').remove();
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
                    $.ajax({
                        url: '/BackOffice/public/api/mstkubikasiplano/dataRakKecilParam',
                        type: 'POST',
                        data: {"_token": "{{ csrf_token() }}",koderak:$('#i_koderak').val() ,kodesubrak: $('#i_subrak').val(),shelvingrak: $('#i_shelving').val()},
                        beforeSend: function(){
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (response) {
                            if(response.length!=0){
                                count_data=response.length;
                                kubikasi = response;
                                data = response;
                                for (var i = 0; i < response.length ; i++ ){
                                    $('#table_kubikasi').append(
                                        '<tr class="baris">' +
                                        '      <td class="kr-'+i+'">'+response[i].kbp_koderak+'</td>\n' +
                                        '      <td class="ksr-'+i+'">'+response[i].kbp_kodesubrak+'</td>\n' +
                                        '      <td class="sr-'+i+'">'+response[i].kbp_shelvingrak+'</td>\n' +
                                        '      <td><input type="text" class="col-sm-12 num text-right vol-'+i+' form-control" onchange="cekVol('+i+')" value="'+addDotInNumber(response[i].kbp_volumeshell)+'" ></td>\n' +
                                        '      <td><input type="text" class="col-sm-12 num text-right allow-'+i+' form-control" onchange="cekAllow('+i+')" value="'+addDotInNumber(response[i].kbp_allowance)+'" ></td>\n' +
                                        '      <td class="real-'+i+'">'+addDotInNumber(response[i].vreal)+'</td>\n' +
                                        '      <td class="exists-'+i+'">'+addDotInNumber(response[i].vexists)+'</td>\n' +
                                        '      <td class="book-'+i+'">'+addDotInNumber(response[i].vbook)+'</td>\n' +
                                        '      <td class="btb-'+i+'">'+addDotInNumber(response[i].vbtb)+'</td>\n' +
                                        '      <td class="sisa-'+i+'">'+addDotInNumber(response[i].vsisa)+'</td>\n' +
                                        '</tr>'
                                    );
                                }
                                null_check();
                                $('#i_koderak').prop("disabled","disabled");
                                $('#i_subrak').prop("disabled","disabled");
                                $('#i_shelving').prop("disabled","disabled");
                                $('#i_plu').prop("disabled",false);
                                $('#i_qty').prop("disabled",false);
                                $('#btn-plu').prop("disabled",false);
                                $('#i_plu').select();
                            }
                            else{
                                swal({
                                    title: "Data tidak ditemukan!",
                                    icon: "warning"
                                }).then((createData) => {
                                });
                            }
                        },
                        complete: function(){
                            $('#modal-loader').modal('hide');
                        }
                    });
                }
                else if($('#i_koderak').val() != "" && $('#i_subrak').val() == "" && $('#i_shelving').val() == ""){
                    swal({
                        title: 'Subrak belum diisi!',
                        icon: 'warning'
                    }).then((createData) => {
                        if (createData) {
                            $('#i_subrak').focus();
                        }
                    });
                    return;
                }
                else if($('#i_koderak').val() != "" && $('#i_subrak').val() != "" && $('#i_shelving').val() == ""){
                    swal({
                        title: 'Shelving belum diisi!',
                        icon: 'warning'
                    }).then((createData) => {
                        if (createData) {
                            $('#i_shelving').focus();
                        }
                    });
                    return;
                }
                else {
                    getdatarakkecil();
                    $('#i_koderak').prop("disabled","disabled");
                    $('#i_subrak').prop("disabled","disabled");
                    $('#i_shelving').prop("disabled","disabled");
                    $('#i_plu').prop("disabled",false);
                    $('#i_qty').prop("disabled",false);
                    $('#btn-plu').prop("disabled",false);
                    $('#i_plu').select();
                }
            }
        });

        function getdatarakkecil(){
            $.ajax({
                url: '/BackOffice/public/api/mstkubikasiplano/dataRakKecil',
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}"},
                beforeSend: function(){
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    kubikasi = response;
                    data = response;
                    count_data=response.length;
                    for (var i = 0; i < response.length ; i++ ){
                        $('#table_kubikasi').append(
                            '<tr class="baris b-'+i+'">' +
                            '      <td class="kr-'+i+'">'+response[i].kbp_koderak+'</td>\n' +
                            '      <td class="ksr-'+i+'">'+response[i].kbp_kodesubrak+'</td>\n' +
                            '      <td class="sr-'+i+'">'+response[i].kbp_shelvingrak+'</td>\n' +
                            '      <td><input type="text" class="num text-right vol-'+i+' form-control" onchange="cekVol('+i+')" value="'+addDotInNumber(response[i].kbp_volumeshell)+'" ></td>\n' +
                            '      <td><input type="text" class="num text-right allow-'+i+' form-control" onchange="cekAllow('+i+')" value="'+addDotInNumber(response[i].kbp_allowance)+'" ></td>\n' +
                            '      <td class="real-'+i+'">'+addDotInNumber(response[i].vreal)+'</td>\n' +
                            '      <td class="exists-'+i+'">'+addDotInNumber(response[i].vexists)+'</td>\n' +
                            '      <td class="book-'+i+'">'+addDotInNumber(response[i].vbook)+'</td>\n' +
                            '      <td class="btb-'+i+'">'+addDotInNumber(response[i].vbtb)+'</td>\n' +
                            '      <td class="sisa-'+i+'">'+addDotInNumber(response[i].vsisa)+'</td>\n' +
                            '</tr>'
                        );
                    }
                    null_check();
                },
                error: function(response){
                    console.log(response);
                },
                complete: function(){
                    $('#modal-loader').modal('hide');
                    $('#i_plu').focus();

                }
            });
        }
        function cekVol(val) {
           var  b = $('.b-'+val).text();
            var volume = replaceDotInNumber($('.vol-'+val).val());
            var allow = replaceDotInNumber($('.allow-'+val).val());

            if(volume < 0){
                swal({
                    title: 'Volume harus > 0',
                    icon: 'warning'
                }).then((createData) => {
                    $('.vol-'+val).focus();
                });
                return;
            }
            if(allow == 0){
                $('.allow-'+val).val('100');
                kubikasi[val].kbp_allowance = 100;
                allow =100;
            }
            if (volume == 0 && allow > 0) {
                swal({
                    title: 'Volume tidak boleh 0!',
                    icon: 'warning'
                }).then((createData) => {
                    $('.vol-'+val).focus();
                });
                return;
            }
            vreal = volume * allow / 100;
            vsisa = vreal - (nvl(kubikasi[val].vexists,0) + nvl(kubikasi[val].vbook,0) + nvl(kubikasi[val].vbtb,0));
            $('.real-'+val).text(addDotInNumber(vreal));
            $('.sisa-'+val).text(addDotInNumber(vsisa));
        }
        function cekAllow(val) {
            var  b = $('.b-'+val).text();
            var volume = replaceDotInNumber($('.vol-'+val).val());
            var allow = replaceDotInNumber($('.allow-'+val).val());

            if (allow < 0 || allow > 100) {
                swal({
                    title: 'Persentase Allowance 0..100',
                    icon: 'warning'
                }).then((createData) => {
                    $('.allow-'+val).focus();
                });
                return;
            }
            if (volume + allow > 0) {
                if (volume == 0 && allow > 0) {
                    swal({
                        title: 'Volume tidak boleh 0!',
                        icon: 'warning'
                    }).then((createData) => {
                        $('.vol-'+val).focus();
                    });
                    return;
                }
                if (volume > 0 && allow == 0) {
                    swal({
                        title: 'Allowance tidak boleh 0!',
                        icon: 'warning'
                    }).then((createData) => {
                        $('.allow-'+val).focus();
                    });
                    return;
                }
            }
            vreal = volume * allow / 100;
            vsisa = vreal - (nvl(kubikasi[val].vexists,0) + nvl(kubikasi[val].vbook,0) + nvl(kubikasi[val].vbtb,0));
            $('.real-'+val).text(addDotInNumber(vreal));
            $('.sisa-'+val).text(addDotInNumber(vsisa));
        }
        $(document).on('keydown','.num', function(e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl/cmd+A
                (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: Ctrl/cmd+C
                (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: Ctrl/cmd+X
                (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        $(document).on('keyup','.num', function(e) {
            $(this).val( addDotInNumber(replaceDotInNumber($(this).val())));
        });
        function replaceDotInNumber(number) {
            if (!number)
                return 0;
            else
                return number.toString().replace(/\,/g, '');
        }

        function addDotInNumber(number) {
            if (!number)
                return 0;
            else
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function null_check() {
            $("#table_kubikasi td").each(function(){
                var $this = $(this);
                if($this.text()=="null" || $this.text()=="NaN" ){
                    $this.text("0");
                }
            });
        }
        var trlov = $('#table_lov tbody').html();
        $('#search_lov').keypress(function (e) {
            if (e.which == 13) {
                if(this.value.length == 0) {
                    $('#table_lov .row_lov').remove();
                    $('#table_lov').append(trlov);
                    $('.invalid-feedback').hide();
                }
                else if(this.value.length >= 3) {
                    $('.invalid-feedback').hide();
                    $.ajax({
                        url: '/BackOffice/public/api/mstkubikasiplano/lov_search',
                        type: 'POST',
                        data: {"_token": "{{ csrf_token() }}", value: this.value.toUpperCase()},
                        success: function (response) {
                            $('#table_lov .row_lov').remove();
                            html = "";
                            for (i = 0; i < response.length; i++) {
                                html = '<tr class="row_lov" onclick=lov_select("' + response[i].prd_prdcd + '")><td>' + response[i].prd_deskripsipanjang + '</td><td>' + response[i].prd_prdcd + '</td></tr>';
                                trlov += html;
                                $('#table_lov').append(html);
                            }
                        }
                    });
                }
                else{
                    $('.invalid-feedback').show();
                }
            }
        });
        function lov_select(value){
            $.ajax({
                url: '/BackOffice/public/api/mstkubikasiplano/lov_search',
                type:'POST',
                data:{"_token":"{{ csrf_token() }}",value: value},
                beforeSend: function(){
                    $('#m_pluHelp').modal('hide');
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function(response){
                    $('#i_plu').val(response[0].prd_prdcd);
                    $('#i_deskripsi').val(response[0].prd_deskripsipanjang);
                    $('#i_satuan').val(response[0].s_sat);
                    $('#i_volume').val(addDotInNumber(response[0].s_vol));
                },
                complete: function(){
                    if($('#m_pluHelp').is(':visible')){
                        $('#search_lov').val('');
                        $('#table_lov .row_lov').remove();
                        $('#table_lov').append(trlov);
                    }
                    $('#modal-loader').modal('hide');
                    $('#i_qty').focus();

                }
            });
        }
        $('#i_plu').keypress(function (e) {
            if (e.keyCode == 13) {
                if ($(this).val() ==''){
                    swal({
                        title: 'Masukan PLU terlebih dahulu!',
                        icon: 'warning'
                    }).then((createData) => {
                        if (createData) {
                            $('#i_plu').focus();
                        }
                    });
                }
                else{
                    var plu = $(this).val();
                    for (var i = plu.length; i < 7; i++) {
                        plu = '0' + plu;
                    }
                    $(this).val(plu);
                    lov_select(plu);
                }
            }
        });

        var editor;
        $('#i_qty').keypress(function (e) {
            if (e.keyCode == 13) {
                if($('#i_plu').val()==''){
                    swal({
                        title: 'Masukan PLU terlebih dahulu!',
                        icon: 'warning'
                    }).then((createData) => {
                        if (createData) {
                            $('#i_plu').focus();
                        }
                    });
                }
                else{
                    $('.baris').remove();
                    for (var i = 0; i < kubikasi.length ; i++ ){
                        var vbtb = replaceDotInNumber($('#i_volume').val()) * replaceDotInNumber($('#i_qty').val());
                        var vsisa = replaceDotInNumber(kubikasi[i].vreal) -(replaceDotInNumber(kubikasi[i].vexists)  + replaceDotInNumber(kubikasi[i].vbook) + vbtb);
                        if ( vsisa <= 0){
                            tr = '<tr class="baris red">';
                        }
                        else{
                            tr = '<tr class="baris">';
                        }
                        $('#table_kubikasi').append(
                            tr +
                            '      <td class="kr-'+i+'">'+kubikasi[i].kbp_koderak+'</td>\n' +
                            '      <td class="ksr-'+i+'">'+kubikasi[i].kbp_kodesubrak+'</td>\n' +
                            '      <td class="sr-'+i+'">'+kubikasi[i].kbp_shelvingrak+'</td>\n' +
                            '      <td><input type="text" class="col-sm-12 text-right num vol-'+i+' form-control" onchange="cekVol('+i+')" value="'+addDotInNumber(kubikasi[i].kbp_volumeshell)+'" ></td>\n' +
                            '      <td><input type="text" class="col-sm-12 text-right num allow-'+i+' form-control" onchange="cekAllow('+i+')" value="'+addDotInNumber(kubikasi[i].kbp_allowance)+'" ></td>\n' +
                            '      <td class="real-'+i+'">'+addDotInNumber(kubikasi[i].vreal)+'</td>\n' +
                            '      <td class="exists-'+i+'">'+addDotInNumber(kubikasi[i].vexists)+'</td>\n' +
                            '      <td class="book-'+i+'">'+addDotInNumber(kubikasi[i].vbook)+'</td>\n' +
                            '      <td class="btb-'+i+'">'+addDotInNumber(vbtb)+'</td>\n' +
                            '      <td class="sisa-'+i+'">'+addDotInNumber(vsisa)+'</td>\n' +
                            '</tr>'
                        );
                        kubikasi[i].vbtb =vbtb;
                        kubikasi[i].vsisa =vsisa;
                    }
                    null_check();
                }
            }
        });
        function cek_data() {
            for(i = 0; i<count_data; i++) {
                volume = replaceDotInNumber($('.vol-' + i).val());
                allow = $('.allow-' + i).val();
                koderak = $('.kr-' + i).text();
                kodesubrak = $('.ksr-' + i).text();
                shelvingrak = $('.sr-' + i).text();
                if(data[i].kbp_volumeshell != volume || data[i].kbp_allowance != allow){
                    arr.koderak.push(koderak);
                    arr.kodesubrak.push(kodesubrak);
                    arr.shelvingrak.push(shelvingrak);
                    arr.volume.push(replaceDotInNumber(volume));
                    arr.allowance.push(allow);
                    if (volume == 0 && allow > 0) {
                        swal({
                            title: 'Volume tidak boleh 0!',
                            icon: 'warning'
                        }).then((createData) => {
                            $('.vol-' + i).focus();
                        });
                        return;
                    }
                    else if (allow < 0 || allow > 100) {
                        swal({
                            title: 'Persentase Allowance 0..100',
                            icon: 'warning'
                        }).then((createData) => {
                            $('.allow-' + i).focus();
                        });
                        return;
                    }
                    else if (volume > 0 && allow == 100) {
                        swal({
                            title: 'Allowance tidak boleh 0!',
                            icon: 'warning'
                        }).then((createData) => {
                            $('.allow-' + i).focus();
                        });
                        return;
                    }
                }
            }
        }
        $( "#btn-save" ).click(function() {
            arr = {};
            arr.koderak = [];
            arr.kodesubrak = [];
            arr.shelvingrak = [];
            arr.volume = [];
            arr.allowance = [];

            cek_data();
            $.ajax({
                url: '/BackOffice/public/api/mstkubikasiplano/save_kubikasi',
                type:'POST',
                data:{"_token":"{{ csrf_token() }}",value: arr},
                beforeSend: function(){
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function(response){
                    swal({
                        title: response.message,
                        icon: response.status
                    }).then((createData) => {
                    });
                },
                complete: function(){
                    $('#modal-loader').modal('hide');
                    $('.baris').remove();
                    var e = $.Event("keypress");
                    e.keyCode = 13;
                    $('#i_shelving').trigger(e);
                }
            });
        });

        function validate() {
            for(i = 0; i<count_data; i++) {
                volume = replaceDotInNumber($('.vol-' + i).val());
                allow = $('.allow-' + i).val();
                koderak = $('.kr-' + i).text();
                kodesubrak = $('.ksr-' + i).text();
                shelvingrak = $('.sr-' + i).text();
                if(data[i].kbp_volumeshell != volume || data[i].kbp_allowance != allow){
                    swal({
                        title: 'Terjadi perubahan data! ',
                        text: "Klik OK untuk simpan!",
                        icon: "info",
                        buttons: true,
                        dangerMode: true,
                    }).then((createData) => {
                        if(createData)
                            $( "#btn-save" ).click();
                        else {
                            $('.baris').remove();
                            var e = $.Event("keypress");
                            e.keyCode = 13;
                            $('#i_shelving').trigger(e);
                        }
                    });
                    return;
                }
            }
        }


    </script>

@endsection

