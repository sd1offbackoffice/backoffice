@extends('navbar')

@section('title','BO | SCAN BARCODE IGR')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body">
                        <fieldset class="card border-secondary">
                            <legend  class="w-auto text-center">SCAN BARCODE BARANG / INPUT PLU</legend>
                            <div class="card-body">
                                <div class="row form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="custom-control custom-checkbox col-sm-2 ml-3">
                                        <input type="checkbox" class="custom-control-input" id="cb_barcode" onchange="switchField('barcode')">
                                        <label for="cb_barcode" class="custom-control-label">SCAN BARCODE</label>
                                    </div>
                                    <div class="custom-control custom-checkbox col-sm-2 ml-3">
                                        <input type="checkbox" class="custom-control-input" id="cb_plu"  onchange="switchField('plu')">
                                        <label for="cb_plu" class="custom-control-label">INPUT PLU</label>
                                    </div>
                                </div>
                                <div class="row form-group" id="barcode-field">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control text-center" id="barcode" onkeypress="getDetail(event)">
                                    </div>
                                    <div class="col-sm-2"></div>
                                </div>
                                <div class="row form-group" id="plu-field" style="display: none">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control text-center" id="plu" onkeypress="getDetail(event)">
                                    </div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="card border-secondary mt-3" id="data-field">
                            <div class="card-body">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-1 text-right col-form-label">PLU</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-center" id="det_plu" disabled>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="det_desk" disabled>
                                    </div>
                                </div>
                                <div class="row form-group mb-0">
                                    <div class="col-sm-2"></div>
                                    <label for="prdcd" class="col-sm-4 text-center col-form-label pr-1">HARGA JUAL</label>
                                    <label for="prdcd" class="col-sm-1 text-center pl-0 pr-0 col-form-label">SATUAN</label>
                                    <label for="prdcd" class="col-sm-1 text-center pl-0 pr-0 col-form-label">TAG</label>
                                    <label for="prdcd" class="col-sm-4 text-center col-form-label pr-1">HARGA PROMOSI</label>
                                </div>
                                @for($i=0;$i<4;$i++)
                                    <div class="row form-group">
                                        <div class="col-sm-2 pr-1">
                                            <input type="text" class="form-control text-center" id="satuanjual{{ $i }}" disabled>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="row pr-1">
                                                <input type="text" class="form-control col-sm text-right" id="hargajual{{ $i }}a" disabled>
                                                <label for="prdcd" class="text-center pr-1 pl-1 col-form-label">/</label>
                                                <input type="text" class="form-control col-sm text-right" id="hargajual{{ $i }}b" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 pr-1 pl-1">
                                            <input type="text" class="form-control text-center pr-0 pl-0" id="satuan{{ $i }}" disabled>
                                        </div>
                                        <div class="col-sm-1 pl-1 pr-1">
                                            <input type="text" class="form-control text-center" id="tag{{ $i }}" disabled>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="row pr-3">
                                                <input type="text" class="form-control col-sm text-right" id="hargapromo{{ $i }}a" disabled>
                                                <label for="prdcd" class="text-center pr-1 pl-1 col-form-label">/</label>
                                                <input type="text" class="form-control col-sm text-right" id="hargapromo{{ $i }}b" disabled>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                                <div class="row form-group mb-0">
                                    <div class="col-sm-5"></div>
                                    <label for="prdcd" class="col-sm-2 text-center col-form-label pr-1">RAK</label>
                                    <label for="prdcd" class="col-sm-1 text-center pl-0 pr-0 col-form-label">SUB RAK</label>
                                    <label for="prdcd" class="col-sm-1 text-center pl-0 pr-0 col-form-label">TIPE</label>
                                    <label for="prdcd" class="col-sm-2 text-center col-form-label pr-1">SHELVING</label>
                                    <label for="prdcd" class="col-sm-1 text-center col-form-label pl-0 pr-0">NO. URUT</label>
                                </div>
                                @for($i=0;$i<4;$i++)
                                    <div class="row form-group @if($i==3) mb-0 @endif">
                                        @if($i == 0)
                                            <label for="prdcd" class="col-sm-2 text-right col-form-label pr-1">STOCK AKHIR</label>
                                            <div class="col-sm-2 pr-1 pl-1">
                                                <input type="text" class="form-control text-right" id="stockakhir" disabled>
                                            </div>
                                            <label for="prdcd" class="col-sm-1 text-right col-form-label pr-1">LOKASI</label>
                                        @else
                                            <div class="col-sm-5"></div>
                                        @endif
                                        <div class="col-sm-2 pr-1 pl-1">
                                            <input type="text" class="form-control text-center" id="rak{{ $i }}" disabled>
                                        </div>
                                        <div class="col-sm-1 pr-1 pl-1">
                                            <input type="text" class="form-control text-center" id="subrak{{ $i }}" disabled>
                                        </div>
                                        <div class="col-sm-1 pr-1 pl-1">
                                            <input type="text" class="form-control text-center" id="tipe{{ $i }}" disabled>
                                        </div>
                                        <div class="col-sm-2 pr-1 pl-1">
                                            <input type="text" class="form-control text-center" id="shelving{{ $i }}" disabled>
                                        </div>
                                        <div class="col-sm-1 pr-1 pl-1">
                                            <input type="text" class="form-control text-center" id="nourut{{ $i }}" disabled>
                                        </div>
                                    </div>
                                @endfor
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

    </style>

    <script>
        $(document).ready(function(){
            $('#cb_barcode').prop('checked',true);
            $('#barcode').focus();
        });

        function switchField(field){
            if(field == 'barcode'){
                $('#cb_barcode').prop('checked',true);
                $('#cb_plu').prop('checked',false);

                $('#barcode-field').show();
                $('#plu-field').hide();

                $('#plu').val('');
                $('#barcode').focus();
            }
            else{
                $('#cb_plu').prop('checked',true);
                $('#cb_barcode').prop('checked',false);

                $('#plu-field').show();
                $('#barcode-field').hide();

                $('#barcode').val('');
                $('#plu').focus();
            }
        }

        function getDetail(e){
            if(e.which == 13){
                $('#data-field input').val('');

                if($('#cb_plu').is(':checked'))
                    $('#plu').val(('0000000' + $('#plu').val()).substr(-7));

                $.ajax({
                    url: '{{ url()->current() }}/detail',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        plu: $('#plu').val(),
                        barcode: $('#barcode').val()
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
                            }).then(() => {
                                $('#cb_barcode').is(':checked') ? $('#barcode').select() : $('#plu').select();
                            })
                        }
                        else{
                            data = response.data;
                            lokasi = response.lokasi;

                            $('#det_plu').val(response.prdcd);
                            $('#det_desk').val(data[0].prd_deskripsipanjang);

                            $('#stockakhir').val(convertToRupiah2(data[0].st_saldoakhir));

                            for(i=0;i<data.length;i++){
                                fillData(data[i],i);
                            }

                            for(i=0;i<lokasi.length;i++){
                                fillLokasi(lokasi[i],i);
                            }
                        }
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        swal({
                            title: 'Terjadi kesalahan!',
                            text: error.responseJSON.message,
                            icon: 'error',
                        });
                    }
                });
            }
        }

        function fillData(data, row){
            $('#satuanjual'+row).val(data.satuanjual);
            $('#hargajual'+row+'a').val(convertToRupiah2(data.prd_hrgjual));
            $('#hargajual'+row+'b').val(convertToRupiah2(data.hrgjual1));
            $('#satuan'+row).val(data.satuan);
            $('#tag'+row).val(data.prd_kodetag);
            $('#hargapromo'+row+'a').val(convertToRupiah2(data.prmd_hrgjual));
            $('#hargapromo'+row+'b').val(convertToRupiah2(data.hrgpromo1));
        }

        function fillLokasi(data, row){
            $('#rak'+row).val(data.lks_koderak);
            $('#subrak'+row).val(data.lks_kodesubrak);
            $('#tipe'+row).val(data.lks_tiperak);
            $('#shelving'+row).val(data.lks_shelvingrak);
            $('#nourut'+row).val(data.lks_nourut);
        }
    </script>
@endsection
