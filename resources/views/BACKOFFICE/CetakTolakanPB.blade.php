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
                                            <input maxlength="10" type="text" class="form-control tanggal" id="div_tanggal1" readonly>
                                        </div>
                                        <label class="pt-1">s/d</label>
                                        <div class="col-sm-3">
                                            <input maxlength="10" type="text" class="form-control tanggal" id="div_tanggal2" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="periode" class="col-sm-2 text-right col-form-label">Divisi :</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control divisi" id="div_divisi1" readonly>
                                            <button style="display: none" type="button" class="btn btn-lov p-0 divisi1" data-toggle="modal" data-target="#m_lov_divisi">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <label class="pt-1">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control divisi" id="div_divisi2" readonly>
                                            <button style="display: none" type="button" class="btn btn-lov p-0 divisi2" data-toggle="modal" data-target="#m_lov_divisi">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="periode" class="col-sm-2 text-right col-form-label">Departement :</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control departement" id="div_departement1" readonly>
                                            <button style="display: none" type="button" class="btn btn-lov p-0 departement1" data-toggle="modal" data-target="#m_lov_departement">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <label class="pt-1">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control departement" id="div_departement2" readonly>
                                            <button style="display: none" type="button" class="btn btn-lov p-0 departement2" data-toggle="modal" data-target="#m_lov_departement">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="periode" class="col-sm-2 text-right col-form-label">Kategori :</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control kategori" id="div_kategori1" readonly>
                                            <button style="display: none" type="button" class="btn btn-lov p-0 kategori1" data-toggle="modal" data-target="#m_lov_kategori">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <label class="pt-1">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control kategori" id="div_kategori2" readonly>
                                            <button style="display: none" type="button" class="btn btn-lov p-0 kategori2" data-toggle="modal" data-target="#m_lov_kategori">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="periode" class="col-sm-2 text-right col-form-label">PLU :</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control plu" id="div_plu1">
                                            <button style="display: none" type="button" class="btn btn-lov p-0 plu1" data-toggle="modal" data-target="#m_lov_plu">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <label class="pt-1">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control plu" id="div_plu2">
                                            <button style="display: none" type="button" class="btn btn-lov p-0 plu2" data-toggle="modal" data-target="#m_lov_plu">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="periode" class="col-sm-2 text-right col-form-label">Pilihan :</label>
                                        <div class="col-sm-3">
                                            <input maxlength="1" type="text" class="form-control" id="div_pilihan">
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
                                            <button id="div_print" class="col-sm btn btn-success" onclick="div_print()">PRINT</button>
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
                                        <tr id="row_lov_divisi_{{ $i }}" onclick="lov_divisi_select({{ $i }})" class="row_lov">
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
                                        <tr id="row_lov_departement_{{ $i }}" onclick="lov_departement_select({{ $i }})" class="row_lov">
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
                                        <tr id="row_lov_kategori_{{ $i }}" onclick="lov_kategori_select({{ $i }})" class="row_lov">
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

    <div class="modal fade" id="m_lov_plu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="i_lov_plu" class="form-control search_lov" type="text" placeholder="Cari PLU" aria-label="Search">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm" id="table_lov_plu">
                                    <thead>
                                    <tr>
                                        <td>PLU</td>
                                        <td>DESKRIPSI</td>
                                        <td>SATUAN</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i = 0 @endphp
                                    @foreach($plu as $p)
                                        @php $i++ @endphp
                                        <tr id="row_lov_plu_{{ $i }}" onclick="lov_plu_select({{ $i }})" class="row_lov">
                                            <td class="prd_prdcd">{{ $p->prd_prdcd }}</td>
                                            <td class="prd_deskripsipanjang">{{ $p->prd_deskripsipanjang }}</td>
                                            <td class="prd_satuan">{{ $p->prd_unit }}/{{ $p->prd_frac }}</td>
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
        currVar = '';

        $('.tanggal').datepicker({
            "dateFormat" : "dd/mm/yy"
        });

        $('#div_tanggal1').focus();

        $('#div_tanggal1').on('change',function(){
            // $('#div_tanggal2').focus();
        });

        $('#div_tanggal2').on('change',function(){
            $('#div_divisi1').select();
        });

        $('input').on('focus',function(){
            $('.btn-lov').hide();
            $(this).parent().find('.btn-lov').show();
        });

        $('.btn-lov').on('click',function(){
            currVar = $(this).attr('class').split(' ').pop();
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
                }
            }
        });

        $('.tanggal').on('change',function(){
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


                if(tgl2 != '' && tgl1 > tgl2){
                    swal({
                        title: 'Tanggal pertama tidak boleh lebih besar dari tanggal kedua!',
                        icon: 'error'
                    }).then(function(){
                        if(id == 'div_tanggal1' || id == 'sup_tanggal1')
                            $('#'+id)
                    })
                }
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

        function lov_divisi_select(i){
            kodedivisi = $('#row_lov_divisi_'+i).find('.div_kodedivisi').html();

            $('#m_lov_divisi').modal('toggle');

            if(currVar == 'divisi1'){
                $('#div_divisi1').val(kodedivisi);
                $('#div_divisi2').select();
            }
            else if(currVar == 'divisi2'){
                $('#div_divisi2').val(kodedivisi);
                $('#div_departement1').select();
            }

            $('.departement').val('');
            $('.kategori').val('');
            $('.plu').val('');

            div1 = $('#div_divisi1').val();
            div2 = $('#div_divisi2').val();

            $.ajax({
                url: '{{ url('bocetaktolakanpb/get_departement') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {div1: div1, div2: div2},
                beforeSend: function () {
                    $('#table_lov_departement tbody tr').remove();
                },
                success: function (response) {
                    $('#table_lov_departement tbody tr').remove();

                    for(i=0;i<response.length;i++){
                        html =  '<tr id="row_lov_departement_'+i+'" onclick="lov_departement_select('+i+')" class="row_lov">' +
                                '<td class="dep_kodedepartement">'+ response[i].dep_kodedepartement +'</td>' +
                                '<td class="dep_namadepartement">'+ response[i].dep_namadepartement +'</td>' +
                                '<td class="dep_kodedivisi">'+ response[i].dep_kodedivisi +'</td>' +
                                '</tr>';

                        $('#table_lov_departement').append(html);
                    }
                }
            });
        }

        function lov_departement_select(i){
            kodedepartement = $('#row_lov_departement_'+i).find('.dep_kodedepartement').html();

            $('#m_lov_departement').modal('toggle');

            if(currVar == 'departement1'){
                $('#div_departement1').val(kodedepartement);
                $('#div_departement2').select();
            }
            else if(currVar == 'departement2'){
                $('#div_departement2').val(kodedepartement);
                $('#div_kategori1').select();
            }

            $('.kategori').val('');
            $('.plu').val('');

            dep1 = $('#div_departement1').val();
            dep2 = $('#div_departement2').val();

            $.ajax({
                url: '{{ url('bocetaktolakanpb/get_kategori') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {dep1: dep1, dep2: dep2},
                beforeSend: function () {
                    $('#table_lov_kategori tbody tr').remove();
                },
                success: function (response) {
                    $('#table_lov_kategori tbody tr').remove();

                    for(i=0;i<response.length;i++){
                        html =  '<tr id="row_lov_kategori_'+i+'" onclick="lov_kategori_select('+i+')" class="row_lov">' +
                                '<td class="kat_kodedepartement">'+ response[i].kat_kodedepartement +'</td>' +
                                '<td class="kat_kodekategori">'+ response[i].kat_kodekategori +'</td>' +
                                '<td class="kat_namakategori">'+ response[i].kat_namakategori +'</td>' +
                                '</tr>';

                        $('#table_lov_kategori').append(html);
                    }
                }
            });
        }

        function lov_kategori_select(i){
            kodekategori = $('#row_lov_kategori_'+i).find('.kat_kodekategori').html();

            $('#m_lov_kategori').modal('toggle');

            if(currVar == 'kategori1'){
                $('#div_kategori1').val(kodekategori);
                $('#div_kategori2').select();
            }
            else if(currVar == 'kategori2'){
                $('#div_kategori2').val(kodekategori);
                $('#div_plu1').select();
            }

            $('.plu').val('');

            div1 = $('#div_divisi1').val();
            div2 = $('#div_divisi2').val();
            dep1 = $('#div_departement1').val();
            dep2 = $('#div_departement2').val();
            kat1 = $('#div_kategori1').val();
            kat2 = $('#div_kategori2').val();

            $.ajax({
                url: '{{ url('bocetaktolakanpb/get_plu') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {div1: div1, div2: div2, dep1: dep1, dep2: dep2, kat1: kat1, kat2: kat2},
                beforeSend: function () {
                    $('#table_lov_plu tbody tr').remove();
                },
                success: function (response) {
                    $('#table_lov_plu tbody tr').remove();

                    for(i=0;i<response.length;i++){
                        html =  '<tr id="row_lov_plu_'+i+'" onclick="lov_plu_select('+i+')" class="row_lov">' +
                                '<td class="prd_prdcd">'+ response[i].prd_prdcd +'</td>' +
                                '<td class="prd_deskripsipanjang">'+ response[i].prd_deskripsipanjang +'</td>' +
                                '<td class="prd_satuan">'+ response[i].prd_unit +'/'+ response[i].prd_frac +'</td>' +
                                '</tr>';

                        $('#table_lov_plu').append(html);
                    }
                }
            });
        }

        function lov_plu_select(i){
            kodeplu = $('#row_lov_plu_'+i).find('.prd_prdcd').html();

            $('#m_lov_plu').modal('toggle');

            if(currVar == 'plu1'){
                $('#div_plu1').val(kodeplu);
                $('#div_plu2').select();
            }
            else if(currVar == 'plu2'){
                $('#div_plu2').val(kodeplu);
                $('#div_pilihan').select();
            }
        }

        $('.plu').on('change',function(){
            plu1 = $('#div_plu1').val();
            plu2 = $('#div_plu2').val();

            if(parseInt(plu1) > parseInt(plu2)){
                swal({
                    title: 'PLU pertama tidak boleh lebih besar dari PLU kedua!',
                    icon: 'error'
                }).then(function(){
                    $(this).select();
                })
            }
            else{
                $(this).val(convertPlu($(this).val()));
                cek_plu(convertPlu($(this).val()));
            }

        });

        function cek_plu(plu){

            div1 = $('#div_divisi1').val();
            div2 = $('#div_divisi2').val();
            dep1 = $('#div_departement1').val();
            dep2 = $('#div_departement2').val();
            kat1 = $('#div_kategori1').val();
            kat2 = $('#div_kategori2').val();

            $.ajax({
                url: '{{ url('bocetaktolakanpb/cek_plu') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {div1: div1, div2: div2, dep1: dep1, dep2: dep2, kat1: kat1, kat2: kat2, plu: plu},
                beforeSend: function () {
                },
                success: function (response) {
                    if(response != 'true'){
                        swal({
                            title: 'PLU tidak ditemukan!',
                            icon: 'error'
                        })
                    }
                }
            });
        }

        function div_print(){
            tgl1 = nvl($('#div_tanggal1').val().replace(/\//g,''),'ALL');
            tgl2 = nvl($('#div_tanggal2').val().replace(/\//g,''),'ALL');
            div1 = nvl($('#div_divisi1').val(),'ALL');
            div2 = nvl($('#div_divisi2').val(),'ALL');
            dep1 = nvl($('#div_departement1').val(),'ALL');
            dep2 = nvl($('#div_departement2').val(),'ALL');
            kat1 = nvl($('#div_kategori1').val(),'ALL');
            kat2 = nvl($('#div_kategori2').val(),'ALL');
            plu1 = nvl($('#div_plu1').val(),'ALL');
            plu2 = nvl($('#div_plu2').val(),'ALL');


            url = '{{ url('/bocetaktolakanpb') }}'+'/div_print?tgl1='+tgl1+'&tgl2='+tgl2+'&div1='+div1+'&div2='+div2+'&dep1='+dep1+'&dep2='+dep2+'&kat1='+kat1+'&kat2='+kat2+'&plu1='+plu1+'&plu2='+plu2;

            window.open(url);
        }


    </script>

@endsection
