@extends('navbar')
@section('title','PROSES | KARTU GUDANG')
@section('content')


    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Proses Kartu Gudang</legend>
                    <div class="card-body">
                        <div class="row form-group">
                            <label for="tanggal" class="col-sm-2 text-right col-form-label">Periode :</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control text-center" id="periode" placeholder="DD/MM/YYYY - DD/MM/YYYY" readonly>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="periode" class="col-sm-2 text-right col-form-label">Divisi :</label>
                            <div class="col-sm-3 buttonInside">
                                <input maxlength="10" type="text" class="form-control divisi" id="divisi1">
                                <button type="button" class="btn btn-primary btn-lov p-0 divisi1" data-toggle="modal" data-target="#m_lov_divisi">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <label class="pt-1 col-sm-1 text-center">s/d</label>
                            <div class="col-sm-3 buttonInside">
                                <input maxlength="10" type="text" class="form-control divisi" id="divisi2">
                                <button type="button" class="btn btn-primary btn-lov p-0 divisi1" data-toggle="modal" data-target="#m_lov_divisi">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="periode" class="col-sm-2 text-right col-form-label">Departement :</label>
                            <div class="col-sm-3 buttonInside">
                                <input maxlength="10" type="text" class="form-control departement" id="departement1">
                                <button type="button" class="btn btn-primary btn-lov p-0 departement1" data-toggle="modal" data-target="#m_lov_departement">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <label class="pt-1 col-sm-1 text-center">s/d</label>
                            <div class="col-sm-3 buttonInside">
                                <input maxlength="10" type="text" class="form-control departement" id="departement2">
                                <button type="button" class="btn btn-primary btn-lov p-0 departement2" data-toggle="modal" data-target="#m_lov_departement">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="periode" class="col-sm-2 text-right col-form-label">Kategori :</label>
                            <div class="col-sm-3 buttonInside">
                                <input maxlength="10" type="text" class="form-control kategori" id="kategori1">
                                <button type="button" class="btn btn-primary btn-lov p-0 kategori1" data-toggle="modal" data-target="#m_lov_kategori">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <label class="pt-1 col-sm-1 text-center">s/d</label>
                            <div class="col-sm-3 buttonInside">
                                <input maxlength="10" type="text" class="form-control kategori" id="kategori2">
                                <button type="button" class="btn btn-primary btn-lov p-0 kategori2" data-toggle="modal" data-target="#m_lov_kategori">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="periode" class="col-sm-2 text-right col-form-label">PLU :</label>
                            <div class="col-sm-3 buttonInside">
                                <input maxlength="10" type="text" class="form-control plu" id="plu1">
                                <button type="button" class="btn btn-primary btn-lov p-0 plu" data-toggle="modal" data-target="#m_lov_plu">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <label class="pt-1 col-sm-1 text-center">s/d</label>
                            <div class="col-sm-3 buttonInside">
                                <input maxlength="10" type="text" class="form-control plu" id="plu2">
                                <button type="button" class="btn btn-primary btn-lov p-0 plu" data-toggle="modal" data-target="#m_lov_plu">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 text-right col-form-label">Jenis Laporan :</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="laporan">
                                    <option value="DETAIL" selected>DETAIL</option>
                                    <option value="REKAP">REKAP</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group waktu">
                            <label for="tanggal" class="col-sm-2 text-right col-form-label">Waktu :</label>
                            <div class="col-sm-3">
                                <input maxlength="10" type="text" class="form-control" id="waktu1" disabled>
                            </div>
                            <label class="pt-1 col-sm-1 text-center">s/d</label>
                            <div class="col-sm-3">
                                <input maxlength="10" type="text" class="form-control" id="waktu2" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <div class="col-sm-3">
                                <button class="col btn btn-primary" onclick="process()">PROSES DAN CETAK</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    @if($isValid)
        <div class="modal fade" id="m_lov_divisi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="form-row col-sm">
                            <input id="i_lov_divisi" class="form-control search_lov" type="text" placeholder="Cari Divisi" aria-label="Search">
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col lov">
                                    <table class="table table-sm" id="table_lov_divisi">
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
                                            <tr id="row_lov_divisi_{{ $i }}" onclick="lov_selectDivision({{ $i }})" class="row_lov">
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
                            <input id="i_lov_departement" class="form-control search_lov" type="text" placeholder="Cari Departement" aria-label="Search">
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col lov">
                                    <table class="table table-sm" id="table_lov_departement">
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
                                            <tr id="row_lov_departement_{{ $i }}" onclick="lov_selectDepartment({{ $i }})" class="row_lov">
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

        <div class="modal fade" id="m_lov_kategori" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="form-row col-sm">
                            <input id="i_lov_kategori" class="form-control search_lov" type="text" placeholder="Cari Kategori" aria-label="Search">
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col lov">
                                    <table class="table table-sm" id="table_lov_kategori">
                                        <thead>
                                        <tr>
                                            <td>KODE DEPARTEMENT</td>
                                            <td>KODE KATEGORI</td>
                                            <td>NAMA KATEGORI</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $i = 0 @endphp
                                        @foreach($kategori as $k)
                                            @php $i++ @endphp
                                            <tr id="row_lov_kategori_{{ $i }}" onclick="lov_selectCategory({{ $i }})" class="row_lov">
                                                <td class="kat_kodedepartement">{{ $k->kat_kodedepartement }}</td>
                                                <td class="kat_kodekategori">{{ $k->kat_kodekategori }}</td>
                                                <td class="kat_namakategori">{{ $k->kat_namakategori }}</td>
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
    @endif

    <div class="modal fade" id="m_lov_plu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV PLU</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-striped table-bordered" id="table_lov_plu">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>PLU</th>
                                        <th>Deskripsi</th>
                                        <th>Satuan</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
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

    @if(!$isValid)
        <script>
            $(document).ready(function(){
                $('button').prop('disabled',true);
                $('input').prop('disabled',true);
                $('select').prop('disabled',true);

                swal({
                    title: '{{ $message }}',
                    icon: 'error'
                });
            });
        </script>
    @else
        <script>


            $(document).ready(function(){
                getModalData('');

                $('button').prop('disabled',false);
                $('input').prop('disabled',false);
                $('select').prop('disabled',false);
                $('.waktu input').prop('disabled',true);

                tglPer = '{{ $tglPer }}';

                currVar = '';

                date = new Date();

                $('#periode').daterangepicker({
                    locale: {
                        format: 'DD/MM/YYYY'
                    },
                    // minDate: new Date(date.getFullYear(), date.getMonth(), 1),
                    // maxDate: new Date(),
                    // startDate: new Date(date.getFullYear(), date.getMonth(), 1),
                    // endDate: new Date()
                });
            });


            $('.btn-lov').on('click',function(){
                currVar = $(this).parent().find('input').attr('id');
            });

            $('.modal').on('shown.bs.modal',function(){
                $(this).find('input').select();
            });

            $('#divisi1').on('keypress',function(e){
                if(e.which == 13){
                    // check-divisi($(this).val(),$(this).attr('id'),'true');
                    selectDivision('divisi1');
                }
            });

            $('#divisi2').on('keypress',function(e){
                if(e.which == 13){
                    if($(this).val() == ''){
                        $('#departement1').select();
                    }
                    else if($(this).val() < $('#divisi1').val()){
                        swal({
                            title: 'Kode divisi kedua tidak boleh lebih kecil dari kode divisi pertama!',
                            icon: 'error'
                        }).then(function(){
                            $(this).select();
                        })
                    }
                    // else check-divisi($(this).val(),$(this).attr('id'),'true');
                    else selectDivision('divisi2');
                }
            });

            $('#departement1').on('keypress',function(e){
                if(e.which == 13){
                    // check-departement($(this).val(),$(this).attr('id'),'true');
                    selectDepartment($(this).attr('id'));
                }
            });

            $('#departement2').on('keypress',function(e){
                if(e.which == 13){
                    if($(this).val() == ''){
                        $('#kategori1').select();
                    }
                    else if($(this).val() < $('#departement1').val()){
                        swal({
                            title: 'Kode departement kedua tidak boleh lebih kecil dari kode departement pertama!',
                            icon: 'error'
                        }).then(function(){
                            $(this).select();
                        })
                    }
                    else selectDepartment($(this).attr('id'));
                }
            });

            $('#kategori1').on('keypress',function(e){
                if(e.which == 13){
                    selectCategory($(this).attr('id'));
                }
            });

            $('#kategori2').on('keypress',function(e){
                if(e.which == 13){
                    if($(this).val() == ''){
                        $('#plu1').select();
                    }
                    else if($(this).val() < $('#kategori1').val()){
                        swal({
                            title: 'Kode kategori kedua tidak boleh lebih kecil dari kode kategori pertama!',
                            icon: 'error'
                        }).then(function(){
                            $(this).select();
                        })
                    }
                    else selectCategory($(this).attr('id'));
                }
            });

            function selectDivision(id){
                if($('#divisi1').val() > $('#divisi2').val() && $('#divisi2').val() != ''){
                    swal({
                        title: 'Kode divisi kedua tidak boleh lebih kecil dari kode divisi pertama!',
                        icon: 'error'
                    }).then(function () {
                        $('#'+id).val('');
                        $('#' + id).select();
                    });
                }
                else{
                    $.ajax({
                        url: '{{ url()->current().'/check-divisi' }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {div: $('#'+id).val(), div1: $('#divisi1').val(), div2: $('#divisi2').val()},
                        beforeSend: function () {
                            $('#table_lov_departement tbody tr').remove();
                            $('#modal-loader').modal('toggle');
                        },
                        success: function (response) {
                            if($('#m_lov_divisi').is(':visible'))
                                $('#m_lov_divisi').modal('toggle');

                            if($('#modal-loader').is(':visible'))
                                $('#modal-loader').modal('toggle');

                            if(response == 'false'){
                                swal({
                                    title: 'Kode divisi tidak ditemukan!',
                                    icon: 'error'
                                }).then(function(){
                                    $('#'+id).select();
                                })
                            }
                            else{
                                $('#table_lov_departement tbody tr').remove();

                                for(i=0;i<response.length;i++){
                                    html =  '<tr id="row_lov_departement_'+i+'" onclick="lov_selectDepartment('+i+')" class="row_lov">' +
                                        '<td class="dep_kodedepartement">'+ response[i].dep_kodedepartement +'</td>' +
                                        '<td class="dep_namadepartement">'+ response[i].dep_namadepartement +'</td>' +
                                        '<td class="dep_kodedivisi">'+ response[i].dep_kodedivisi +'</td>' +
                                        '</tr>';

                                    $('#table_lov_departement').append(html);
                                }

                                if(id == 'divisi1'){
                                    $('#divisi2').select();
                                }
                                else $('#departement1').select();
                            }
                        }
                    });
                }
            }

            function selectDepartment(id){
                if($('#departement1').val() > $('#departement2').val() && $('#departement2').val() != '') {
                    swal({
                        title: 'Kode departement kedua tidak boleh lebih kecil dari kode departement pertama!',
                        icon: 'error'
                    }).then(function () {
                        $('#'+id).val('');
                        $('#' + id).select();
                    });
                }
                else{
                    $.ajax({
                        url: '{{ url()->current().'/check-departement' }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {div1: $('#divisi1').val(), div2: $('#divisi2').val(), dep: $('#'+id).val(), dep1: $('#departement1').val(), dep2: $('#departement2').val()},
                        beforeSend: function () {
                            $('#table_lov_kategori tbody tr').remove();
                            $('#modal-loader').modal('toggle');
                        },
                        success: function (response) {
                            if($('#modal-loader').is(':visible'))
                                $('#modal-loader').modal('toggle');
                            if(response == 'false'){
                                swal({
                                    title: 'Kode departement tidak ditemukan!',
                                    icon: 'error'
                                }).then(function(){
                                    $('#'+id).select();
                                });
                            }
                            else{
                                $('#table_lov_kategori tbody tr').remove();

                                for(i=0;i<response.length;i++){
                                    html =  '<tr id="row_lov_kategori_'+i+'" onclick="lov_selectCategory('+i+')" class="row_lov">' +
                                        '<td class="kat_kodedepartement">'+ response[i].kat_kodedepartement +'</td>' +
                                        '<td class="kat_kodekategori">'+ response[i].kat_kodekategori +'</td>' +
                                        '<td class="kat_namakategori">'+ response[i].kat_namakategori +'</td>' +
                                        '</tr>';

                                    $('#table_lov_kategori').append(html);
                                }

                                if($('#modal-loader').is(':visible'))
                                    $('#modal-loader').modal('toggle');

                                if(id == 'departement1')
                                    $('#departement2').select();
                                else $('#kategori1').select();
                            }
                        }
                    });
                }
            }

            function selectCategory(id, condition){
                if($('#kategori1').val() > $('#kategori2').val() && $('#kategori2').val() != '' && condition) {
                    swal({
                        title: 'Kode kategori kedua tidak boleh lebih kecil dari kode kategori pertama!',
                        icon: 'error'
                    }).then(function(){
                        $('#'+id).val('');
                        $('#' + id).select();
                    });
                }
                else{
                    div1 = $('#divisi1').val();
                    div2 = $('#divisi2').val();
                    dep1 = $('#departement1').val();
                    dep2 = $('#departement2').val();
                    kat1 = $('#kategori1').val();
                    kat2 = $('#kategori2').val();

                    $.ajax({
                        url: '{{ url()->current().'/check-kategori' }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            kat: $('#'+id).val(),
                            div1: nvl($('#divisi1').val(), '0'),
                            div2: nvl($('#divisi2').val(), '9'),
                            dep1: nvl($('#departement1').val(), '00'),
                            dep2: nvl($('#departement2').val(), '99'),
                            kat1: nvl($('#kategori1').val(), '00'),
                            kat2: nvl($('#kategori2').val(), '99'),
                        },
                        beforeSend: function () {
                            $('#table_lov_plu tbody tr').remove();
                            $('#modal-loader').modal('toggle');
                        },
                        success: function (response) {
                            if($('#modal-loader').is(':visible'))
                                $('#modal-loader').modal('toggle');

                            $('#table_lov_plu tbody tr').remove();

                            for(i=0;i<response.length;i++){
                                html =  '<tr id="row_lov_plu_'+i+'" onclick="lov_selectPLU('+i+')" class="row_lov">' +
                                    '<td class="prd_prdcd">'+ response[i].prd_prdcd +'</td>' +
                                    '<td class="prd_deskripsipanjang">'+ response[i].prd_deskripsipanjang +'</td>' +
                                    '<td class="prd_satuan">'+ response[i].prd_unit +'/'+ response[i].prd_frac +'</td>' +
                                    '</tr>';

                                $('#table_lov_plu').append(html);
                            }

                            if(id == 'kategori1')
                                $('#kategori2').select();
                            else $('#plu1').select();
                        }
                    });
                }
            }

            $('.plu').on('keypress',function(e){
                if(e.which == 13){
                    checkPLU($(this).attr('id'));
                }
            });

            function checkPLU(id){
                if($('#plu1').val() > $('#plu2').val() && ($('#plu1').val() && $('#plu2').val())){
                    swal({
                        title: currVar === 'plu1' ?
                            'PLU pertama tidak boleh lebih besar dari PLU kedua!' :
                            'PLU kedua tidak boleh lebih kecil dari PLU pertama!',
                        icon: 'error'
                    }).then(function(){
                        $('#'+currVar).select();
                    });
                }
                else{
                    $.ajax({
                        url: '{{ url()->current().'/check-plu' }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            div1: nvl($('#divisi1').val(), '0'),
                            div2: nvl($('#divisi2').val(), '9'),
                            dep1: nvl($('#departement1').val(), '00'),
                            dep2: nvl($('#departement2').val(), '99'),
                            kat1: nvl($('#kategori1').val(), '00'),
                            kat2: nvl($('#kategori2').val(), '99'),
                            plu: convertPlu($('#'+id).val())
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            $('#'+id).val(response.plu);

                            id === 'plu1' ? $('#plu2').select() : $('#laporan').select();
                        },
                        error: function (error) {
                            swal({
                                title: error.responseJSON.message,
                                icon: 'error',
                            }).then(() => {
                                $('#modal-loader').modal('hide');
                                $('#'+id).select();
                            });
                        }
                    });
                }
            }

            function lov_selectPLU(i){
                plu = $('#row_lov_plu_'+i).find('.prd_prdcd').html();

                $('#'+currVar).val(plu);

                if(currVar == 'plu1'){
                    $('#plu2').select();
                }
                else if(currVar == 'plu2'){
                    $('#laporan').select();
                }

                $('#m_lov_plu').modal('hide');

                checkPLU(currVar);
            }

            function lov_selectDivision(i){
                kodedivisi = $('#row_lov_divisi_'+i).find('.div_kodedivisi').html();

                if(currVar == 'divisi1'){
                    $('#divisi1').val(kodedivisi);
                    $('#divisi2').select();
                }
                else if(currVar == 'divisi2'){
                    $('#divisi2').val(kodedivisi);
                    $('#departement1').select();
                }

                $('.departement').val('');
                $('.kategori').val('');
                $('.plu').val('');

                selectDivision(currVar);
            }

            function lov_selectDepartment(i){
                kodedepartement = $('#row_lov_departement_'+i).find('.dep_kodedepartement').html();

                $('#m_lov_departement').modal('toggle');

                if(currVar == 'departement1'){
                    $('#departement1').val(kodedepartement);
                    $('#departement2').select();
                }
                else if(currVar == 'departement2'){
                    $('#departement2').val(kodedepartement);
                    $('#kategori1').select();
                }

                $('.kategori').val('');
                $('.plu').val('');

                selectDepartment(currVar);
            }

            function lov_selectCategory(i){
                kodekategori = $('#row_lov_kategori_'+i).find('.kat_kodekategori').html();
                dep = $('#row_lov_kategori_'+i).find('.kat_kodedepartement').html();

                $('#m_lov_kategori').modal('toggle');

                console.log(dep);

                condition = true;

                if(currVar == 'kategori1'){
                    $('#kategori1').val(kodekategori);
                    $('#kategori2').select();
                }
                else if(currVar == 'kategori2'){
                    $('#kategori2').val(kodekategori);
                    $('#plu1').select();

                    if(dep > $('#departement1').val())
                        condition = false;
                }

                $('.plu').val('');

                selectCategory(currVar,condition);
            }

            $('#m_lov_plu').on('shown.bs.modal',function(){
                $('#table_lov_plu_filter input').val('');
                $('#table_lov_plu_filter input').select();
            });

            function getModalData(value){
                if ($.fn.DataTable.isDataTable('#table_lov_plu')) {
                    $('#table_lov_plu').DataTable().destroy();
                    $("#table_lov_plu tbody [role='row']").remove();
                }

                if(!$.isNumeric(value)){
                    search = value.toUpperCase();
                }
                else search = value;

                $('#table_lov_plu').DataTable({
                    "ajax": {
                        'url' : '{{ url()->current() }}/get-lov-plu',
                        "data" : {
                            'plu' : search
                        },
                    },
                    "columns": [
                        {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
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
                        $(row).addClass('row-plu');
                    },
                    "initComplete" : function(){
                        $('#table_lov_plu_filter input').val(value).select();

                        $(".row-plu").prop("onclick", null).off("click");

                        $(document).on('click', '.row-plu', function (e) {
                            $('#'+currVar).val($(this).find('td:eq(1)').html());

                            $('#m_lov_plu').modal('hide');

                            checkPLU(currVar);
                        });
                    }
                });

                $('#table_lov_plu_filter input').val(value);

                $('#table_lov_plu_filter input').off().on('keypress', function (e){
                    if (e.which === 13) {
                        let val = $(this).val().toUpperCase();

                        getModalData(val);
                    }
                });
            }

            function process() {
                swal({
                    title: 'Yakin akan melakukan proses dan cetak untuk periode '+$('#periode').val()+'?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then(function(ok){
                    if(ok){
                        periode = $('#periode').val().split(' - ');

                        periode1 = periode[0];
                        periode2 = periode[1];

                        $.ajax({
                            url: '{{ url()->current().'/process' }}',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                periode1: periode1,
                                periode2: periode2,
                                div1: nvl($('#divisi1').val(), '0'),
                                div2: nvl($('#divisi2').val(), '9'),
                                dep1: nvl($('#departement1').val(), '00'),
                                dep2: nvl($('#departement2').val(), '99'),
                                kat1: nvl($('#kategori1').val(), '00'),
                                kat2: nvl($('#kategori2').val(), '99'),
                                plu1: nvl($('#plu1').val(), '0000000'),
                                plu2: nvl($('#plu2').val(), '9999999'),
                                laporan: nvl($('#laporan').val(), 'DETAIL'),
                                tglPer: tglPer
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
                                    print();
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
                    }
                });
            }

            function print(){
                periode = $('#periode').val().split(' - ');

                periode1 = periode[0];
                periode2 = periode[1];

                div1 = nvl($('#divisi1').val(), '0');
                div2 = nvl($('#divisi2').val(), '9');
                dep1 = nvl($('#departement1').val(), '00');
                dep2 = nvl($('#departement2').val(), '99');
                kat1 = nvl($('#kategori1').val(), '00');
                kat2 = nvl($('#kategori2').val(), '99');
                plu1 = nvl($('#plu1').val(), '0000000');
                plu2 = nvl($('#plu2').val(), '9999999');
                laporan = nvl($('#laporan').val(), 'DETAIL');

                if(laporan == 'REKAP')
                    url = '{{ url()->current() }}/print-rekap?periode1=' + periode1 + '&periode2=' + periode2 + '&div1=' + div1 + '&div2=' + div2 + '&dep1=' + dep1 + '&dep2=' + dep2 + '&kat1=' + kat1 + '&kat2=' + kat2 + '&plu1=' + plu1 + '&plu2=' + plu2 + '&laporan=' + laporan;
                else url = '{{ url()->current() }}/print-detail?periode1=' + periode1 + '&periode2=' + periode2 + '&div1=' + div1 + '&div2=' + div2 + '&dep1=' + dep1 + '&dep2=' + dep2 + '&kat1=' + kat1 + '&kat2=' + kat2 + '&plu1=' + plu1 + '&plu2=' + plu2 + '&laporan=' + laporan;

                window.open(url);
            }
        </script>
    @endif

@endsection
