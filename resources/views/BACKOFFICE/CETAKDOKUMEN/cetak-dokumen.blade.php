@extends('navbar')

@section('title','BO | CETAK DOKUMEN')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="offset-1 col-sm-10">
                <fieldset class="card border-secondary">
                    <div class="card-body">
                        <fieldset class="card border-secondary">
                            <legend class="w-auto ml-3">CETAK DOKUMEN</legend>
                            <div class="card-body">
                                <div class="row form-group">
                                    <label class="col-sm text-right col-form-label">Tanggal</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control tanggal" id="tgl1">
                                    </div>
                                    <label class="col-sm-1 text-right col-form-label">s/d</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control tanggal" id="tgl2">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-3 text-right col-form-label">Jenis Dokumen</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="dokumen">
                                            <option value="pengeluaran">PENGELUARAN</option>
                                            <option value="barang hilang">BARANG HILANG</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-3 text-right col-form-label">Jenis Laporan</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="laporan">
                                            <option value="list">LIST</option>
                                            <option value="nota">NOTA</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="reprint" >
                                        <label for="reprint"> RE-PRINT</label><br>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-3 text-right col-form-label">Jenis Kertas</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="kertas">
                                            <option value="biasa">BIASA</option>
                                            <option value="kecil">KECIL</option>
                                        </select>
                                    </div>
                                </div>
                                <fieldset class="card border-secondary">
                                    <legend class="w-auto ml-3">[ DAFTAR DOKUMEN ]</legend>
                                    <table class="table table-responsive col-md-12">
                                        <thead style="border-top: double; border-bottom: double;">
                                            <tr>
                                                <th align="center" >NOMOR DOKUMEN</th>
                                                <th align="center" >TANGGAL</th>
                                                <th align="center" ></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @for($i=1;$i<=10;$i++)
                                            <tr>
                                                <th align="center" >abc</th>
                                                <th align="center" >abc</th>
                                                <th align="center" >
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="check{{$i}}">
                                                    </div>
                                                </th>
                                            </tr>
                                        @endfor
                                        </tbody>
                                        <tfoot>
                                        <div class="col-sm-6 form-check ml-3">
                                            <input type="checkbox" class="form-check-input" id="check10" >
                                            <label for="check10"> Check 10 Dokumen Pertama</label><br>
                                        </div>
                                        </tfoot>
                                    </table>
                                </fieldset>

                                <div class="row form-group mt-3 mb-0">
                                    <div class="col-sm-4">
                                        <button class="col btn btn-success" onclick="print()">CSV eFaktur</button>
                                    </div>
                                    <div class="col-sm-4">
                                        <button class="col btn btn-success" onclick="print()">CETAK</button>
                                    </div>
                                    <div class="col-sm-4">
                                        <button class="col btn btn-primary" onclick="print()">BATAL</button>
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
                    title: 'Inputan belum lengkap!',
                    icon: 'warning'
                });
            }
            else{
                swal({
                    title: 'Ingin mencetak register tanggal ' + $('#tgl1').val() + ' s/d ' + $('#tgl2').val() + '?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((ok) => {
                    if(ok){
                        if($.inArray($('#register').val(), ['K','X','X1']) > -1){
                            swal({
                                title: 'Pilih ukuran cetakan',
                                icon: 'warning',
                                buttons: {
                                    cancel: 'Cancel',
                                    besar: {
                                        text: 'Besar',
                                        value: 'besar'
                                    },
                                    kecil: {
                                        text: 'Kecil',
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
                                title: 'Pilih Jenis Penerimaan',
                                icon: 'warning',
                                buttons: {
                                    cancel: 'Cancel',
                                    pembelian: {
                                        text: 'Pembelian',
                                        value: 'B'
                                    },
                                    lain: {
                                        text: 'Lain-lain',
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
