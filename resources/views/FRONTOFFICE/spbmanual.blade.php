@extends('navbar')
@section('title','SPB MANUAL')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <fieldset class="card border-dark">
{{--                    <legend class="w-auto ml-5">SPB MANUAL</legend>--}}
                    <div class="card-body shadow-lg cardForm">

                            <br>
                            <div class="card-body shadow-lg cardForm">
                                <fieldset class="card border-dark">
                                    <br>
                                    <div class="row">
                                        <label class="col-sm-2 text-right col-form-label">PLU :</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input class="form-control" type="text" id="plu">
                                            <button type="button" class="btn btn-lov p-0" onclick="togglePlu()">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <div class="col-sm-2">&nbsp;&nbsp;&nbsp;&nbsp;</div>{{--FILLER AJA--}}
                                        <label class="col-sm-2 text-right col-form-label">Max Pallet :</label>
                                        <input disabled class="col-sm-2 text-left form-control" type="text" id="maxpallet" value="0">
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 text-right col-form-label">Deskripsi :</label>
                                        <input disabled class="col-sm-9 text-left form-control" type="text" id="deskripsi">
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 text-right col-form-label">Satuan :</label>
                                        <input disabled class="col-sm-1 text-center form-control" type="text" id="satuan">
                                        <label class="col-sm-3 text-right col-form-label">Qty Storage Toko :</label>
                                        <input disabled class="col-sm-2 text-right form-control" type="text" id="STctn" value="0">
                                        <label class="col-sm-1 text-left col-form-label">CTN</label>
                                        <input disabled class="col-sm-2 text-right form-control" type="text" id="STpcs" value="0">
                                        <label class="col-sm-1 text-left col-form-label">PCS</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">&nbsp;&nbsp;&nbsp;&nbsp;</div>{{--FILLER AJA--}}
                                        <label class="col-sm-3 text-right col-form-label">Qty Storage Gudang :</label>
                                        <input disabled class="col-sm-2 text-right form-control" type="text" id="SGctn" value="0">
                                        <label class="col-sm-1 text-left col-form-label">CTN</label>
                                        <input disabled class="col-sm-2 text-right form-control" type="text" id="SGpcs" value="0">
                                        <label class="col-sm-1 text-left col-form-label">PCS</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">&nbsp;&nbsp;&nbsp;&nbsp;</div>{{--FILLER AJA--}}
                                        <label class="col-sm-3 text-right col-form-label">Qty Non Storage Gudang :</label>
                                        <div class="col-sm-3">&nbsp;&nbsp;&nbsp;&nbsp;</div>{{--FILLER AJA--}}
                                        <input disabled class="col-sm-2 text-right form-control" type="text" id="NSGpcs" value="0">
                                        <label class="col-sm-1 text-left col-form-label">PCS</label>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 text-right col-form-label">Rak Tujuan :</label>
                                        <div class="col-sm-2 form-check form-control" style="border: none">
                                            <input class="form-check-input" type="radio" name="radioTipeRak" id="tipeRak1" value="display" checked>
                                            <label class="form-check-label" for="tipeRak1">
                                                Display
                                            </label>
                                        </div>
                                        <div class="col-sm-2 form-check form-control" style="border: none">
                                            <input class="form-check-input" type="radio" name="radioTipeRak" id="tipeRak2" value="storage">
                                            <label class="form-check-label" for="tipeRak2">
                                                Storage
                                            </label>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-sm-2 text-right col-form-label">QTY :</label>
                                        <input class="col-sm-2 text-right form-control" type="text" id="ctn" value="0" onkeypress="return isNumberKey(event)">
                                        <label class="col-sm-1 text-left col-form-label">CTN</label>
                                        <input class="col-sm-2 text-right form-control" type="text" id="pcs" value="0" onkeypress="return isNumberKey(event)">
                                        <label class="col-sm-1 text-left col-form-label">PCS</label>
                                        <button class="btn btn-primary col-sm-1" type="button" onclick="pilih()">Pilih</button>
                                    </div>
                                    <br>

                                    <!-- Nav tabs -->
                                    <div class="row">
                                        <div class="col-sm-1">
                                            {{--filler saja--}}
                                        </div>
                                        <div class="col-sm-8">
                                            <ul class="nav nav-tabs custom-color mt-3" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="btn-lok_tujuan" data-toggle="tab" href="#lokTujuan">Lokasi Tujuan</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="btn-antrian" data-toggle="tab" href="#antrian">Antrian</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- TAB CONTENT -->
                                    <div class="tab-content overflow-auto" style="border-bottom: 1px solid black; height: 500px;">

                                        <!-- Content Lokasi Tujuan -->
                                        <div id="lokTujuan" class="container tab-pane active pl-0 pr-0">
                                            <br>
                                            <fieldset class="card border-dark">
                                            <legend class="w-auto ml-3">Lokasi Tujuan Penempatan</legend>
                                            <div class="card-body">
                                                <div class="row text-right">
                                                    <div class="col-sm-8">
                                                        <div class="p-0 tableFixedHeader" style="height: 250px;">
                                                            <table class="table table-sm table-striped table-bordered">
                                                                <thead>
                                                                <tr class="table-sm text-center">
                                                                    <th width="5%" class="text-center small"></th>
                                                                    <th width="19%" class="text-center small">RAK</th>
                                                                    <th width="19%" class="text-center small">SUBRAK</th>
                                                                    <th width="19%" class="text-center small">TIPE</th>
                                                                    <th width="19%" class="text-center small">SHELV</th>
                                                                    <th width="19%" class="text-center small">No.URUT</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="tableTujuan" style="height: 250px;">
                                                                @for($i = 0 ; $i< 10 ; $i++)
                                                                    <tr class="barisTujuan">
                                                                        <td>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input checkTujuan" type="checkbox" value="">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <input disabled class="form-control rak"
                                                                                   type="text">
                                                                        </td>
                                                                        <td>
                                                                            <input disabled class="form-control subrak"
                                                                                   type="text">
                                                                        </td>
                                                                        <td>
                                                                            <input disabled class="form-control tipe"
                                                                                   type="text">
                                                                        </td>
                                                                        <td>
                                                                            <input disabled class="form-control shelv"
                                                                                   type="text">
                                                                        </td>
                                                                        <td>
                                                                            <input disabled class="form-control nourut"
                                                                                   rowheader=1
                                                                                   type="text">
                                                                        </td>
                                                                    </tr>
                                                                @endfor
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="d-flex align-content-around flex-wrap" style="height: 250px;">
                                                            <button class="btn btn-primary btn-block" onclick="clearall()">CLEAR</button>
                                                            <button class="btn btn-primary btn-block" onclick="simpan()">SIMPAN</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </fieldset>
                                        </div>

                                        <!-- Content Antrian -->
                                        <div id="antrian" class="container tab-pane pl-0 pr-0">
                                            <br>
                                            <fieldset class="card border-dark">
                                                <legend class="w-auto ml-3">Antrian SPB MANUAL</legend>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <label class="col-sm-2 text-right col-form-label">PLU :</label>
                                                        <input class="col-sm-2 text-right form-control" type="text" id="pluReadOnly" readonly>
                                                    </div>
                                                    <div class="row text-right">
                                                        <div class="col-sm-12">
                                                            <div class="p-0 tableFixedHeader" style="height: 250px;">
                                                                <table class="table table-sm table-striped table-bordered"
                                                                       id="table_antrian">
                                                                    <thead>
                                                                    <tr class="table-sm text-center">
                                                                        <th width="20%" class="text-center small">Lokasi Asal</th>
                                                                        <th width="20%" class="text-center small">Lokasi Tujuan</th>
                                                                        <th width="20%" class="text-center small">QTY (CTN)</th>
                                                                        <th width="20%" class="text-center small">Create By</th>
                                                                        <th width="20%" class="text-center small">Create Date</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="tableAntrian" style="height: 250px;">
                                                                    @for($i = 0 ; $i< 10 ; $i++)
                                                                        <tr class="barisAntrian">
                                                                            <td>
                                                                                <input disabled class="form-control lks_asal"
                                                                                       type="text">
                                                                            </td>
                                                                            <td>
                                                                                <input disabled class="form-control lks_tujuan"
                                                                                       type="text">
                                                                            </td>
                                                                            <td>
                                                                                <input disabled class="form-control qty_antrian"
                                                                                       type="text">
                                                                            </td>
                                                                            <td>
                                                                                <input disabled class="form-control create_by"
                                                                                       type="text">
                                                                            </td>
                                                                            <td>
                                                                                <input disabled class="form-control create_date"
                                                                                       type="text">
                                                                            </td>
                                                                        </tr>
                                                                    @endfor
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>

                                    </div>
                                    <br>
                                </fieldset>
                            </div>
                            <br>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>


    {{--Modal--}}
    <div class="modal fade" id="pluModal" tabindex="-1" role="dialog" aria-labelledby="pluModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="pluTable">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>Satuan</th>
                                        <th>Plu</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
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

    <style>
        input[type="checkbox"] {
            transform:scale(2, 2);
        }
    </style>
    <script>
        // +++ GLOBAL +++
        let barcode = '';
        let jenis = '';

        function clearall(){
            barcode = '';
            jenis = '';

            $(' input').val('');
            $('#maxpallet').val('0');
            $('#STctn').val('0'); $('#STpcs').val('0');
            $('#SGctn').val('0'); $('#SGpcs').val('0');
            $('#NSGpcs').val('0');
            $('#ctn').val('0'); $('#pcs').val('0');
            $('#tipeRak1').prop('checked',true);
            $('#tipeRak2').prop('checked',false);
            $('#tipeRak1').val('display');
            $('#tipeRak2').val('storage');

            $('.barisTujuan').remove();
            for (i = 0; i<10; i++) {
                $('#tableTujuan').append(tempTableTujuan());
            }
            $('.barisAntrian').remove();
            for (i = 0; i<10; i++) {
                $('#tableAntrian').append(tempTableAntrian());
            }

            $('#btn-lok_tujuan').click();
        }

        function convertBlank(val) {
            if(val == ''){
                return '0'
            } else {
                return val
            }
        }

        function tempTableTujuan() {
            var temptbl =  `<tr class="barisTujuan">
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input checkTujuan" type="checkbox" value="">
                                    </div>
                                </td>
                                <td>
                                    <input disabled class="form-control rak"
                                           type="text">
                                </td>
                                <td>
                                    <input disabled class="form-control subrak"
                                           type="text">
                                </td>
                                <td>
                                    <input disabled class="form-control tipe"
                                           type="text">
                                </td>
                                <td>
                                    <input disabled class="form-control shelv"
                                           type="text">
                                </td>
                                <td>
                                    <input disabled class="form-control nourut"
                                           rowheader=1
                                           type="text">
                                </td>
                            </tr>`

            return temptbl;
        }

        function tempTableAntrian(){
            let temptbl = `<tr class="barisAntrian">
                                <td>
                                    <input disabled class="form-control lks_asal"
                                           type="text">
                                </td>
                                <td>
                                    <input disabled class="form-control lks_tujuan"
                                           type="text">
                                </td>
                                <td>
                                    <input disabled class="form-control qty_antrian"
                                           type="text">
                                </td>
                                <td>
                                    <input disabled class="form-control create_by"
                                           type="text">
                                </td>
                                <td>
                                    <input disabled class="form-control create_date"
                                           type="text">
                                </td>
                            </tr>`

            return temptbl;
        }
        // --- GLOBAL END ---

        //FUNGSIONALITAS KOLOM PLU
        let modalPlu;
        //fungsi date
        $('#daterangepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
        $(document).ready(function () {
            pluModal('');
        });

        //Fungsi mengisi modal plu
        function pluModal(value) {
            modalPlu = $('#pluTable').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/getplu',
                    "data": {
                        'value': value
                    },
                },
                "columns": [
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                    {data: 'satuan', name: 'satuan'},
                    {data: 'prd_prdcd', name: 'prd_prdcd'},
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
                    $(row).addClass('pluRow');
                },
                "order": []
            });
            $('#pluTable_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    modalPlu.destroy();
                    pluModal(val);
                }
            })
        }
        $(document).on('click', '.pluRow', function () {
            var currentButton = $(this);
            let deskripsi = currentButton.children().first().text();
            let satuan = currentButton.children().first().next().text();
            let plu = currentButton.children().first().next().next().text();

            $('#plu').val(plu);
            $('#deskripsi').val(deskripsi);
            $('#satuan').val(satuan);
            $('#pluModal').modal('toggle');
            setTimeout(function () {
                $('#plu').select();
            }, 100); //AUTO SELECT KE KOLOM PLU SETELAH 0,1 detik
        });

        function togglePlu(){
            $('#pluModal').modal('toggle');
            if(!$('#pluModal').is(':visible')){
                $('#pluTable_filter input').val('');
                setTimeout(function () {
                    $('#pluTable_filter input').focus();
                    }, 100); //AUTO FOKUS KE KOLOM SEARCH SETELAH 0,1 detik
            }
        }

        function choosePlu(val){
            $.ajax({
                url: '{{ url()->current() }}/chooseplu',
                type: 'GET',
                data: {
                    plu: val
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if(response == 1){
                        swal({
                            title: 'ERROR',
                            text: 'Kode Barcode Salah',
                            icon: 'error',
                        }).then(() => {
                            clearall();
                        });
                        return false;
                    }else if(response == 2){
                        swal({
                            title: 'ERROR',
                            text: 'Kode Barcode Tidak Terdaftar',
                            icon: 'error',
                        }).then(() => {
                            clearall();
                        });
                        return false;
                    }else if(response == 3){
                        swal({
                            title: 'ERROR',
                            text: 'BARCODE DOUBLE',
                            icon: 'error',
                        }).then(() => {
                            clearall();
                        });
                        return false;
                    }else if(response == 4){
                        swal({
                            title: 'ERROR',
                            text: 'PLU Salah',
                            icon: 'error',
                        }).then(() => {
                            clearall();
                        });
                        return false;
                    }else if(response.result == 5){
                        swal({
                            title: 'ALERT',
                            text: 'Ada Antrian SPB Manual untuk PLU '+$('#plu').val(),
                            icon: 'info',
                        }).then(() => {
                            $('#btn-antrian').click();
                            antrian($('#plu').val());
                        });
                        //filling data
                        barcode = response.barcode;
                        jenis = response.jenis;

                        $('#plu').val(response.plu);
                        $('#deskripsi').val(response.deskripsi);
                        $('#satuan').val(response.satuan);
                        $('#maxpallet').val(response.maxplt);
                        $('#STctn').val(convertBlank(response.rsctn)); $('#STpcs').val(convertBlank(response.rspcs));
                        $('#SGctn').val(convertBlank(response.gsctn)); $('#SGpcs').val(convertBlank(response.gspcs));
                        $('#NSGpcs').val(convertBlank(response.nsgpcs));
                        $('#ctn').val('0'); $('#pcs').val('0');
                    }else if(response){
                        //bila benar maka akan masuk kesini, dan tidak ada antrian
                        barcode = response.barcode;
                        jenis = response.jenis;

                        $('#plu').val(response.plu);
                        $('#deskripsi').val(response.deskripsi);
                        $('#satuan').val(response.satuan);
                        $('#STctn').val(convertBlank(response.rsctn)); $('#STpcs').val(convertBlank(response.rspcs));
                        $('#SGctn').val(convertBlank(response.gsctn)); $('#SGpcs').val(convertBlank(response.gspcs));
                        $('#NSGpcs').val(convertBlank(response.nsgpcs));
                        $('#ctn').val('0'); $('#pcs').val('0');


                    }else{//jaga-jaga kalau ada sesuatu yang tidak terduga
                        swal({
                            title: 'ERROR',
                            text: 'Unexpected error',
                            icon: 'error',
                        }).then(() => {
                            clearall();
                        });
                    }
                },
                error: function (error) {
                    clearall();
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {
                        $('#plu').focus();
                    });
                }
            });
        }

        $('#plu').on('change',function(){
            if($('#plu').val() != ''){
                choosePlu($('#plu').val());
            }
        });

        $('#plu').on('keypress',function(charCode){
            if(charCode.which == 13){
                $('#plu').change();
            }
        });

        function antrian(val){
            $.ajax({
                url: '{{ url()->current() }}/getrakantrian',
                type: 'GET',
                data: {
                    plu: val
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (rec) {
                    $('#modal-loader').modal('hide');
                    $('.barisAntrian').remove();
                    //fill rak
                    if(rec.length != 0){
                        $('#pluReadOnly').val(rec[0].spb_prdcd);
                        for (i = 0; i< rec.length; i++) {
                            $('#tableAntrian').append(tempTableAntrian());
                            $('.lks_asal')[i].value = rec[i].spb_lokasiasal;
                            $('.lks_tujuan')[i].value = rec[i].spb_lokasitujuan;
                            $('.qty_antrian')[i].value = rec[i].spb_minus;
                            $('.create_by')[i].value = rec[i].spb_create_by;
                            $('.create_date')[i].value = rec[i].spb_create_dt;
                        }
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    });
                    return false;
                }
            });
        }
        //AKHIR FUNGSIONALITAS KOLOM PLU



        //FUNGSIONALITAS QTY

        function isNumberKey(evt){
            let charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        function pilih(){
            alert(jenis);
            if($('#plu').val() == ''){
                swal({
                    title: "ALERT",
                    text: "Belum ada data yang dipilih",
                    icon: 'error',
                }).then(() => {
                    $('#plu').focus();
                });
                return false;
            }
            $('#btn-lok_tujuan').click();
            let frac = ($('#satuan').val()).split('/');
            frac = parseInt(frac[1]);

            if(jenis == 'S' && $('input[name=radioTipeRak]:checked').val() == 'display'){
                if((((parseInt($('#STctn').val()) * frac)+parseInt($('#STpcs').val())) + ((parseInt($('#SGctn').val()) * frac)+parseInt($('#SGpcs').val()))) == 0){
                    swal({
                        title: "ALERT",
                        text: "Stock Barang tidak ada",
                        icon: 'error',
                    }).then(() => {
                        $('#ctn').focus();
                    });
                    return false;
                }else if( ((parseInt(convertBlank($('#ctn').val())) * frac)+ parseInt(convertBlank($('#pcs').val()))) > (((parseInt($('#STctn').val()) * frac)+parseInt($('#STpcs').val())) + ((parseInt($('#SGctn').val()) * frac)+parseInt($('#SGpcs').val())))){
                    swal({
                        title: "ALERT",
                        text: "QTY Stock tidak mencukupi",
                        icon: 'error',
                    }).then(() => {
                        $('#ctn').select();
                    });
                    return false;
                }
                let err = 0;
                $.ajax({
                    url: '{{ url()->current() }}/checkrak',
                    type: 'GET',
                    data: {
                        plu: $('#plu').val()
                    },
                    async: false,
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');
                        if(response == 0){
                            err = 1;
                        }
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        swal({
                            title: error.responseJSON.title,
                            text: error.responseJSON.message,
                            icon: 'error',
                        });
                        return false;
                    }
                });
                if(err == 1){
                    swal({
                        title: "ALERT",
                        text: "Lokasi Rak Display Toko tidak ada",
                        icon: 'error',
                    })
                    return false;
                }
               //bila tidak ada kendala(isi row lokasi tujuan)
                $.ajax({
                    url: '{{ url()->current() }}/getrak',
                    type: 'GET',
                    data: {
                        plu: $('#plu').val()
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (rec) {
                        $('#modal-loader').modal('hide');
                        $('.barisTujuan').remove();
                        //fill rak
                        if(rec.length != 0){
                            for (i = 0; i< rec.length; i++) {
                                $('#tableTujuan').append(tempTableTujuan());
                                if(i == 0){
                                    $('.checkTujuan')[i].setAttribute('checked',true);
                                }
                                $('.rak')[i].value = rec[i].lks_koderak;
                                $('.subrak')[i].value = rec[i].lks_kodesubrak;
                                $('.tipe')[i].value = rec[i].lks_tiperak;
                                $('.shelv')[i].value = rec[i].lks_shelvingrak;
                                $('.nourut')[i].value = rec[i].lks_nourut;
                            }
                        }
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        swal({
                            title: error.responseJSON.title,
                            text: error.responseJSON.message,
                            icon: 'error',
                        });
                        return false;
                    }
                });
            }else if(jenis == 'S' && $('input[name=radioTipeRak]:checked').val() == 'storage'){
                if(((parseInt($('#SGctn').val()) * frac)+parseInt($('#SGpcs').val())) == 0){
                    swal({
                        title: "ALERT",
                        text: "Stock Barang di Gudang tidak ada",
                        icon: 'error',
                    }).then(() => {
                        $('#ctn').focus();
                    });
                    return false;
                }else if( ((parseInt(convertBlank($('#ctn').val())) * frac)+ parseInt(convertBlank($('#pcs').val()))) > ((parseInt($('#SGctn').val()) * frac)+parseInt($('#SGpcs').val()))){
                    swal({
                        title: "ALERT",
                        text: "QTY Stock Gudang tidak mecukupi.",
                        icon: 'error',
                    }).then(() => {
                        $('#ctn').select();
                    });
                    return false;
                }
                //bila tidak ada kendala(isi row lokasi tujuan)
                $.ajax({
                    url: '{{ url()->current() }}/getrak2',
                    type: 'GET',
                    data: {
                        plu: $('#plu').val()
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (rec) {
                        $('#modal-loader').modal('hide');
                        $('.barisTujuan').remove();
                        //fill rak
                        if(rec.length != 0){
                            for (i = 0; i< rec.length; i++) {
                                $('#tableTujuan').append(tempTableTujuan());
                                if(i == 0){
                                    $('.checkTujuan')[i].setAttribute('checked',true);
                                }
                                $('.rak')[i].value = rec[i].lks_koderak;
                                $('.subrak')[i].value = rec[i].lks_kodesubrak;
                                $('.tipe')[i].value = rec[i].lks_tiperak;
                                $('.shelv')[i].value = rec[i].lks_shelvingrak;
                                $('.nourut')[i].value = rec[i].lks_nourut;
                            }
                        }
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        swal({
                            title: error.responseJSON.title,
                            text: error.responseJSON.message,
                            icon: 'error',
                        });
                        return false;
                    }
                });
            }else if(jenis == 'N'){
                if(parseInt(convertBlank($('#NSGpcs').val())) == 0){
                    swal({
                        title: "ALERT",
                        text: "Stock Barang Non Storage tidak ada",
                        icon: 'error',
                    }).then(() => {
                        $('#ctn').select();
                    });
                    return false;
                }else if(((parseInt(convertBlank($('#ctn').val())) * frac)+ parseInt(convertBlank($('#pcs').val()))) > parseInt(convertBlank($('#NSGpcs').val()))){
                    swal({
                        title: "ALERT",
                        text: "QTY Stock tidak mecukupi.",
                        icon: 'error',
                    }).then(() => {
                        $('#ctn').select();
                    });
                    return false;
                }
                if($('input[name=radioTipeRak]:checked').val() == 'display'){
                    let err = 0;
                    $.ajax({
                        url: '{{ url()->current() }}/checkrak',
                        type: 'GET',
                        data: {
                            plu: $('#plu').val()
                        },
                        async: false,
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');
                            if(response == 0){
                                err = 1;
                            }
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            swal({
                                title: error.responseJSON.title,
                                text: error.responseJSON.message,
                                icon: 'error',
                            });
                            return false;
                        }
                    });
                    if(err == 1){
                        swal({
                            title: "ALERT",
                            text: "Lokasi Rak Display Toko tidak ada",
                            icon: 'error',
                        })
                        return false;
                    }
                    //bila tidak ada kendala(isi row lokasi tujuan)
                    $.ajax({
                        url: '{{ url()->current() }}/getrak3',
                        type: 'GET',
                        data: {
                            plu: $('#plu').val()
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (rec) {
                            $('#modal-loader').modal('hide');
                            $('.barisTujuan').remove();
                            //fill rak
                            if(rec.length != 0){
                                for (i = 0; i< rec.length; i++) {
                                    $('#tableTujuan').append(tempTableTujuan());
                                    if(i == 0){
                                        $('.checkTujuan')[i].setAttribute('checked',true);
                                    }
                                    $('.rak')[i].value = rec[i].lks_koderak;
                                    $('.subrak')[i].value = rec[i].lks_kodesubrak;
                                    $('.tipe')[i].value = rec[i].lks_tiperak;
                                    $('.shelv')[i].value = rec[i].lks_shelvingrak;
                                    $('.nourut')[i].value = rec[i].lks_nourut;
                                }
                            }
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            swal({
                                title: error.responseJSON.title,
                                text: error.responseJSON.message,
                                icon: 'error',
                            });
                            return false;
                        }
                    });
                }else{
                    $.ajax({
                        url: '{{ url()->current() }}/getrak2',
                        type: 'GET',
                        data: {
                            plu: $('#plu').val()
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (rec) {
                            $('#modal-loader').modal('hide');
                            $('.barisTujuan').remove();
                            //fill rak
                            if(rec.length != 0){
                                for (i = 0; i< rec.length; i++) {
                                    $('#tableTujuan').append(tempTableTujuan());
                                    if(i == 0){
                                        $('.checkTujuan')[i].setAttribute('checked',true);
                                    }
                                    $('.rak')[i].value = rec[i].lks_koderak;
                                    $('.subrak')[i].value = rec[i].lks_kodesubrak;
                                    $('.tipe')[i].value = rec[i].lks_tiperak;
                                    $('.shelv')[i].value = rec[i].lks_shelvingrak;
                                    $('.nourut')[i].value = rec[i].lks_nourut;
                                }
                            }
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            swal({
                                title: error.responseJSON.title,
                                text: error.responseJSON.message,
                                icon: 'error',
                            });
                            return false;
                        }
                    });
                }
            }

        }

        //AKHIR FUNGSIONALITAS QTY

        //FUNGSIONALITAS TABEL LOKASI TUJUAN PENEMPATAN

        //NOTE!!! fungsi clear ambil dari fungsi clear yang ada di global

        function simpan(){
            if($('#plu').val() == ''){
                swal({
                    title: "ALERT",
                    text: "Belum ada data yang dipilih",
                    icon: 'error',
                }).then(() => {
                    $('#plu').focus();
                });
                return false;
            }
            let frac = ($('#satuan').val()).split('/'); //pecahan nya di array ke-1
            frac = parseInt(frac[1]);
            if(parseInt(convertBlank($('#ctn').val()))*frac + parseInt(convertBlank($('#pcs').val())) <= 0){
                swal({
                    title: "ALERT",
                    text: "QTY belum diinput.",
                    icon: 'error',
                }).then(() => {
                    $('#ctn').focus();
                });
                return false;
            }
            let qty = parseInt(convertBlank($('#ctn').val()))*frac + parseInt(convertBlank($('#pcs').val()));

            // Periksa apakah ada centang checkbox dan apakah checkbox yang tercentang hanya 1
            let cursor = 'pity';
            $('#tableTujuan [type="checkbox"]').each(function(i, chk) {
                if (chk.checked) {
                    if(cursor == 'pity'){
                        if($('.rak')[i].value != ''){ //untuk memastikan mengabaikan row yang value rak nya kosong
                            cursor = i;
                        }
                    }else{
                        cursor = 'pity gone'
                    }
                    console.log("Checked!", i, chk);
                }
            });

            if(cursor == 'pity'){
                swal({
                    title: "ALERT",
                    text: "Lokasi Tempat tujuan belum dipilih!",
                    icon: 'error',
                });
                return false;
            }else if(cursor == 'pity gone'){
                swal({
                    title: "ALERT",
                    text: "Pilih hanya 1 Lokasi tujuan",
                    icon: 'error',
                });
                return false;
            }
            //bila tidak ada trouble, maka mencatat lokasi tujuan rak
            let lks_to = $('.rak')[cursor].value + '.' + $('.subrak')[cursor].value + '.' + $('.tipe')[cursor].value + '.' + $('.shelv')[cursor].value + '.' + $('.nourut')[cursor].value;
            $.ajax({
                url: '{{ url()->current() }}/save',
                type: 'GET',
                data: {
                    plu: $('#plu').val(),
                    jenis: jenis,
                    tiperak: $('input[name=radioTipeRak]:checked').val(),
                    lks_to: lks_to,
                    qty: qty,
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function () {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: "Info",
                        text: "PLU "+$('#plu').val()+" berhasil ditambahkan dalam antrian SPB Manual",
                        icon: 'info',
                    }).then(() => {
                        clearall();
                        $('#plu').focus();
                    });
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    });
                    return false;
                }
            });
        }


        //AKHIR FUNGSIONALITAS TABEL LOKASI TUJUAN PENEMPATAN
    </script>
@endsection
