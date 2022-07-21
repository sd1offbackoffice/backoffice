@extends('navbar')

@section('title','BO | CETAK REGISTER')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <fieldset class="card border-secondary">
                    <div class="card-body">
                        <fieldset class="card border-secondary">
                            <legend class="w-auto ml-3">@lang('CETAK REGISTER')</legend>
                            <div class="card-body">
                                <div class="row form-group">
                                    <label class="col-sm-3 text-right col-form-label">@lang('Jenis Register')</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="register">
                                            <option selected disabled>- @lang('silahkan pilih jenis register') -</option>
                                            <option value="B">PENERIMAAN BARANG</option>
                                            <option value="K">NOTA PENGELUARAN BARANG</option>
                                            <option value="O">SURAT JALAN</option>
                                            <option value="P">REPACKING</option>
                                            <option value="Z1">DAFTAR BARANG BAIK KE RETUR</option>
                                            <option value="Z2">DAFTAR BARANG BAIK KE RUSAK</option>
                                            <option value="Z3">BUKTI PERUBAHAN STATUS</option>
                                            <option value="X">MEMO PENYESUAIAN PERSEDIAAN</option>
                                            <option value="F">BA PEMUSNAHAN BARANG</option>
                                            <option value="H">BARANG HILANG</option>
                                            <option value="H1">PEMBATALAN BARANG HILANG</option>
                                            <option value="F2">PEMBATALAN BAPB</option>
                                            <option value="L">PENERIMAAN BARANG LAIN-LAIN</option>
                                            <option value="B2">BUKTI PEMBATALAN PENERIMAAN BARANG</option>
                                            <option value="K2">PEMBATALAN NPB</option>
                                            <option value="X1">PEMBATALAN MPP</option>
                                            <option value="I">TRANSFER ANTAR CABANG</option>
                                            <option value="I2">PEMBATALAN TRANSFER ANTAR CABANG</option>
                                            <option value="O2">PEMBATALAN SURAT JALAN</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm text-right col-form-label">@lang('Tanggal')</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control tanggal" id="tgl1">
                                    </div>
                                    <label class="col-sm-1 text-right col-form-label">@lang('s/d')</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control tanggal" id="tgl2">
                                    </div>
                                </div>
                                <div class="row form-group" id="field_cabang" style="display: none">
                                    <label class="col-sm-3 text-right col-form-label">@lang('Cabang')</label>
                                    <div class="col-sm-9">
                                        <select id="cabang" class="form-control">
                                            <option value="ALL" selected>{{ strtoupper(__('Semua Cabang')) }}</option>
                                            @foreach($cabang as $c)
                                                <option value="{{ $c->cab_kodecabang }}">{{ $c->cab_kodecabang }} - {{ $c->cab_namacabang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col"></div>
                                    <div class="col-sm-4">
                                        <button class="col btn btn-primary" onclick="print()">{{ strtoupper(__('Cetak')) }}</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-2"></div>
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
            $('.tanggal').datepicker({
                "dateFormat" : "dd/mm/yy",
            });
            $('.tanggal').datepicker('setDate', new Date());
        });

        $('#register').on('change',function(){
            if($(this).val() == 'O' || $(this).val() == 'I' || $(this).val() == 'I2' || $(this).val() == 'O2'){
                $('#field_cabang').show();
            }
            else $('#field_cabang').hide();
        });

        function print(){
            cab = $('#field_cabang').is(':visible') ? '&cabang=' + $('#cabang').val() : '';

            if(!$('#register').val() || !$('#tgl1').val() || !$('#tgl2').val()){
                swal({
                    title: `{{ __('Inputan belum lengkap') }}!`,
                    icon: 'warning'
                });
            }
            else{
                swal({
                    title: `{{ __('Ingin mencetak register tanggal') }} ` + $('#tgl1').val() + ' s/d ' + $('#tgl2').val() + '?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((ok) => {
                    if(ok){
                        if($.inArray($('#register').val(), ['K','X','X1']) > -1){
                            swal({
                                title: `{{ __('Pilih ukuran cetakan') }}`,
                                icon: 'warning',
                                buttons: {
                                    cancel: 'Cancel',
                                    besar: {
                                        text: `{{ __('Besar') }}`,
                                        value: 'besar'
                                    },
                                    kecil: {
                                        text: `{{ __('Kecil') }}`,
                                        value: 'kecil'
                                    }
                                },
                                dangerMode: true
                            }).then((ukuran) => {
                                if(ukuran){
                                    window.open(`{{ url()->current() }}/print?register=${$('#register').val()}&tgl1=${$('#tgl1').val()}&tgl2=${$('#tgl2').val()}${cab}&ukuran=${ukuran}${cab}`,'_blank');
                                }
                            });
                        }
                        else if($('#register').val() == 'B2'){
                            swal({
                                title: `{{ __('Pilih Jenis Penerimaan') }}`,
                                icon: 'warning',
                                buttons: {
                                    cancel: 'Cancel',
                                    pembelian: {
                                        text: `{{ __('Pembelian') }}`,
                                        value: 'B'
                                    },
                                    lain: {
                                        text: `{{ __('Lain-lain') }}`,
                                        value: 'L'
                                    }
                                },
                                dangerMode: true
                            }).then((jenis) => {
                                if(jenis){
                                    window.open(`{{ url()->current() }}/print?register=${$('#register').val()}&tgl1=${$('#tgl1').val()}&tgl2=${$('#tgl2').val()}${cab}&jenis=${jenis}${cab}`,'_blank');
                                }
                            });
                        }
                        else{
                            window.open(`{{ url()->current() }}/print?register=${$('#register').val()}&tgl1=${$('#tgl1').val()}&tgl2=${$('#tgl2').val()}${cab}`,'_blank');
                        }
                    }
                });
            }
        }
    </script>

@endsection
