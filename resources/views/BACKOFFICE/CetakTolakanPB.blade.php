@extends('navbar')
@section('content')


    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Cetak Tolakan PB</legend>
                    <ul class="nav nav-tabs custom-color" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="btn-div" data-toggle="tab" href="#p_div">BY DIV</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="btn-sup" data-toggle="tab" href="#p_sup">BY SUP</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="p_div" class="container-fluid tab-pane active pl-0 pr-0">
                            <fieldset class="card border-secondary m-4  fix-height">
                                <legend  class="w-auto ml-5">** INQUIRY DAFTAR TOLAKAN PB / DIVISI / DEPT/ KATEGORI **</legend>
                                <div class="card-body">
                                    <div class="row">
                                        <label for="tanggal" class="col-sm-2 text-right col-form-label">Tanggal :</label>
                                        <div class="col-sm-3">
                                            <input maxlength="10" type="text" class="form-control tanggal" id="div_tanggal1">
                                        </div>
                                        <label class="pt-1">s/d</label>
                                        <div class="col-sm-3">
                                            <input maxlength="10" type="text" class="form-control tanggal" id="div_tanggal2">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="periode" class="col-sm-2 text-right col-form-label">Divisi :</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control divisi" id="div_divisi1">
                                            <button style="display: none" type="button" class="btn btn-lov p-0" data-toggle="modal" data-target="#m_lov_divisi">
                                                <img src="<?php echo (asset('image/icon/help.png')); ?>" width="30px">
                                            </button>
                                        </div>
                                        <label class="pt-1">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control divisi" id="div_divisi2">
                                            <button style="display: none" type="button" class="btn btn-lov p-0" data-toggle="modal" data-target="#m_lov_divisi">
                                                <img src="<?php echo (asset('image/icon/help.png')); ?>" width="30px">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="periode" class="col-sm-2 text-right col-form-label">Departement :</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control divisi" id="div_departement1">
                                            <button style="display: none" type="button" class="btn btn-lov p-0" data-toggle="modal" data-target="#m_lov_departement">
                                                <img src="<?php echo (asset('image/icon/help.png')); ?>" width="30px">
                                            </button>
                                        </div>
                                        <label class="pt-1">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control divisi" id="div_departement2">
                                            <button style="display: none" type="button" class="btn btn-lov p-0" data-toggle="modal" data-target="#m_lov_departement">
                                                <img src="<?php echo (asset('image/icon/help.png')); ?>" width="30px">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="periode" class="col-sm-2 text-right col-form-label">Kategori :</label>
                                        <div class="col-sm-3">
                                            <input maxlength="10" type="text" class="form-control" id="div_kategori1">
                                        </div>
                                        <label class="pt-1">s/d</label>
                                        <div class="col-sm-3">
                                            <input maxlength="10" type="text" class="form-control" id="div_kategori1">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="periode" class="col-sm-2 text-right col-form-label">PLU :</label>
                                        <div class="col-sm-3">
                                            <input maxlength="10" type="text" class="form-control" id="div_plu1">
                                        </div>
                                        <label class="pt-1">s/d</label>
                                        <div class="col-sm-3">
                                            <input maxlength="10" type="text" class="form-control" id="div_plu2">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="periode" class="col-sm-2 text-right col-form-label">Pilihan :</label>
                                        <div class="col-sm-3">
                                            <input maxlength="10" type="text" class="form-control" id="div_pilihan">
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="periode" class="text-right col-form-label">1 - Lain-lain</label>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="periode" class="text-right col-form-label">2 - Discontinue</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5"></div>
                                        <div class="col-sm-2">
                                            <label class="text-right col-form-label">3 - Semua</label>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="text-right col-form-label">4 - Discontinue + tag T</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5"></div>
                                        <div class="col-sm-2">
                                            <label class="text-right col-form-label">6 - < Minor</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-1"></div>
                                        <div class="col-sm-2">
                                            <label class="text-right col-form-label">KOSONG : SEMUA</label>
                                        </div>
                                        <div class="col-sm-7"></div>
                                        <div class="col-sm-2">
                                            <button id="div_print" class="col-sm btn btn-success">PRINT</button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div id="p_sup" class="container-fluid tab-pane pl-0 pr-0">
                            <fieldset class="card border-secondary m-4 fix-height">
                                <legend  class="w-auto ml-5">** INQUIRY DAFTAR TOLAKAN PB / SUPPLIER **</legend>
                                <div class="card-body">
                                    <div class="row">
                                        <label for="tanggal" class="col-sm-2 text-right col-form-label">Tanggal :</label>
                                        <div class="col-sm-3">
                                            <input maxlength="10" type="text" class="form-control tanggal" id="sup_tanggal1">
                                        </div>
                                        <label class="pt-1">s/d</label>
                                        <div class="col-sm-3">
                                            <input maxlength="10" type="text" class="form-control tanggal" id="sup_tanggal2">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="periode" class="col-sm-2 text-right col-form-label">Supplier :</label>
                                        <div class="col-sm-3">
                                            <input maxlength="10" type="text" class="form-control" id="sup_supplier1">
                                        </div>
                                        <label class="pt-1">s/d</label>
                                        <div class="col-sm-3">
                                            <input maxlength="10" type="text" class="form-control" id="sup_supplier2">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="periode" class="col-sm-2 text-right col-form-label">PLU :</label>
                                        <div class="col-sm-3">
                                            <input maxlength="10" type="text" class="form-control" id="sup_plu1">
                                        </div>
                                        <label class="pt-1">s/d</label>
                                        <div class="col-sm-3">
                                            <input maxlength="10" type="text" class="form-control" id="sup_plu2">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="periode" class="col-sm-2 text-right col-form-label">Pilihan :</label>
                                        <div class="col-sm-3">
                                            <input maxlength="10" type="text" class="form-control" id="sup_pilihan">
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="text-right col-form-label">1 - Lain-lain</label>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="text-right col-form-label">2 - Discontinue</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5"></div>
                                        <div class="col-sm-2">
                                            <label class="text-right col-form-label">3 - Semua</label>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="text-right col-form-label">4 - Discontinue + tag T</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5"></div>
                                        <div class="col-sm-2">
                                            <label class="text-right col-form-label">6 - < Minor</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-1"></div>
                                        <div class="col-sm-2">
                                            <label class="text-right col-form-label">KOSONG : SEMUA</label>
                                        </div>
                                        <div class="col-sm-7"></div>
                                        <div class="col-sm-2">
                                            <button id="sup_btn_print" class="col-sm btn btn-success">PRINT</button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_divisi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="i_lov_plu" class="form-control search_lov" type="text" placeholder="Cari Divisi" aria-label="Search">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm" id="table_lov_plu">
                                    <thead>
                                    <tr>
                                        <td>KODE DIVISI</td>
                                        <td>NAMA DIVISI</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i = 0 @endphp
                                    @foreach($divisi as $d)
                                        @php $i++ @endphp
                                        <tr id="row_lov_rak_{{ $i }}" onclick="lov_rak_select({{ $i }})" class="row_lov">
                                            <td class="div_kodedivisi">{{ $d->div_kodedivisi }}</td>
                                            <td class="div_namadivisi">{{ $d->div_namadivisi }}</td>
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

    <div class="modal fade" id="m_lov_departement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="i_lov_plu" class="form-control search_lov" type="text" placeholder="Cari Departement" aria-label="Search">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm" id="table_lov_plu">
                                    <thead>
                                    <tr>
                                        <td>KODE DEPARTEMENT</td>
                                        <td>NAMA DEPARTEMENT</td>
                                        <td>KODE DIVISI</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i = 0 @endphp
                                    @foreach($departement as $d)
                                        @php $i++ @endphp
                                        <tr id="row_lov_rak_{{ $i }}" onclick="lov_rak_select({{ $i }})" class="row_lov">
                                            <td class="dep_kodedepartement">{{ $d->dep_kodedepartement }}</td>
                                            <td class="dep_namadepartement">{{ $d->dep_namadepartement }}</td>
                                            <td class="dep_kodedivisi">{{ $d->dep_kodedivisi }}</td>
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

        .fix-height{
            height: 460px;
        }

        .buttonInside {
            position: relative;
        }

        .btn-lov{
            position:absolute;
            right: 20px;
            top: 4px;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .row_lov:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }


    </style>

    <script>
        $('.tanggal').datepicker({
            "dateFormat" : "dd/mm/yy"
        });

        $('input').on('focus',function(){
            $('.btn-lov').hide();
            $(this).parent().find('.btn-lov').show();
        });

        $('.modal').on('shown.bs.modal',function(){
            $(this).find('input').select();
        });

        $('.tanggal').on('keypress',function(e){
            if(e.which == 13){
                id = $(this).attr('id');
                if(!checkDate($(this).val())){
                    swal({
                        title: 'Format Tanggal Salah!',
                        icon: 'error'
                    }).then(function(){
                        $('#'+id).select();
                    });
                }
                else{
                    if(id == 'div_tanggal1' || id == 'sup_tanggal1'){
                        tgl1 = $('#'+id).val();
                        tgl2 = $('#'+id).parent().next().next().find('input').val();
                    }
                    else{
                        tgl1 = $('#'+id).parent().prev().prev().find('input').val();
                        tgl2 = $('#'+id).val();
                    }


                    if(tgl1 > tgl2){
                        swal({
                            title: 'Tanggal pertama tidak boleh lebih besar dari tanggal kedua!',
                            icon: 'error'
                        }).then(function(){
                            if(id == 'div_tanggal1' || id == 'sup_tanggal1')
                                $('#'+id)
                        })
                    }

                    console.log('tgl1 : ' + tgl1);
                    console.log('tgl2 : ' + tgl2);
                }
            }
        });

        $('.divisi').on('keypress',function(e){
            if(e.which == 13){
                cek_divisi($(this).val(), $(this).attr('id'),'true');
            }
        });

        function cek_divisi(value, id, loading){
            $.ajax({
                url: '{{ url('bocetaktolakanpb/cek_divisi') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {kodedivisi: value},
                beforeSend: function () {
                    if(loading == 'true')
                        $('#modal-loader').modal('toggle');
                },
                success: function (response) {
                    if($('#modal-loader').is(':visible'))
                        $('#modal-loader').modal('toggle');
                    if(response != 'true'){
                        swal({
                            title: 'Kode divisi tidak terdaftar!',
                            icon: 'error'
                        }).then(function(){
                            $('#'+id).select();
                        });
                    }
                    else{
                        if(id == 'div_divisi1')
                            $('#'+id).parent().parent().find('#div_divisi2').select();
                        else $('#'+id).parent().parent().next().find('#div_departement1').select();
                    }
                }
            });
        }


    </script>

@endsection
