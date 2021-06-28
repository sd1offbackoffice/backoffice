@extends('navbar')
@section('title','PB | CETAK TOLAKAN PB')
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
                                            <button style="display: none" type="button" class="btn btn-lov p-0 divisi1" data-toggle="modal" data-target="#m_lov_divisi">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <label class="pt-1">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control divisi" id="div_divisi2">
                                            <button style="display: none" type="button" class="btn btn-lov p-0 divisi2" data-toggle="modal" data-target="#m_lov_divisi">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="periode" class="col-sm-2 text-right col-form-label">Departement :</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control departement" id="div_departement1">
                                            <button style="display: none" type="button" class="btn btn-lov p-0 departement1" data-toggle="modal" data-target="#m_lov_departement">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <label class="pt-1">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control departement" id="div_departement2">
                                            <button style="display: none" type="button" class="btn btn-lov p-0 departement2" data-toggle="modal" data-target="#m_lov_departement">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="periode" class="col-sm-2 text-right col-form-label">Kategori :</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control kategori" id="div_kategori1">
                                            <button style="display: none" type="button" class="btn btn-lov p-0 kategori1" data-toggle="modal" data-target="#m_lov_kategori">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <label class="pt-1">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control kategori" id="div_kategori2">
                                            <button style="display: none" type="button" class="btn btn-lov p-0 kategori2" data-toggle="modal" data-target="#m_lov_kategori">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="periode" class="col-sm-2 text-right col-form-label">PLU :</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control plu" id="div_plu1">
                                            <button style="display: none" type="button" class="btn btn-lov p-0 div_plu" data-toggle="modal" data-target="#m_lov_plu">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <label class="pt-1">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control plu" id="div_plu2">
                                            <button style="display: none" type="button" class="btn btn-lov p-0 div_plu" data-toggle="modal" data-target="#m_lov_plu">
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
                                            <button id="div_print" class="col-sm btn btn-success" onclick="print_by_div()">PRINT</button>
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
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control" id="sup_supplier1">
                                            <button style="display: none" type="button" class="btn btn-lov p-0" data-toggle="modal" data-target="#m_lov_supplier">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <label class="pt-1">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control" id="sup_supplier2">
                                            <button style="display: none" type="button" class="btn btn-lov p-0" data-toggle="modal" data-target="#m_lov_supplier">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="periode" class="col-sm-2 text-right col-form-label">PLU :</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control" id="sup_plu1">
                                            <button style="display: none" type="button" class="btn btn-lov p-0 sup_plu" data-toggle="modal" data-target="#m_lov_plu_sup">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <label class="pt-1">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control" id="sup_plu2">
                                            <button style="display: none" type="button" class="btn btn-lov p-0 sup_plu" data-toggle="modal" data-target="#m_lov_plu_sup">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
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
                                            <button id="sup_btn_print" class="col-sm btn btn-success" onclick="print_by_sup()">PRINT</button>
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
                                        <tr id="row_lov_plu_{{ $i }}" onclick="div_lov_plu_select({{ $i }})" class="row_lov">
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


    <div class="modal fade" id="m_lov_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="i_lov_supplier" class="form-control search_lov" type="text" placeholder="Cari Supplier" aria-label="Search">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm" id="table_lov_supplier">
                                    <thead>
                                    <tr>
                                        <td>KODE SUPPLIER</td>
                                        <td>NAMA SUPPLIER</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i = 0 @endphp
                                    @foreach($supplier as $s)
                                        @php $i++ @endphp
                                        <tr id="row_lov_supplier_{{ $i }}" onclick="lov_supplier_select({{ $i }})" class="row_lov">
                                            <td class="sup_kodesupplier">{{ $s->sup_kodesupplier }}</td>
                                            <td class="sup_namasupplier">{{ $s->sup_namasupplier }}</td>
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

    <div class="modal fade" id="m_lov_plu_sup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="sup_i_lov_plu" class="form-control search_lov" type="text" placeholder="Cari PLU" aria-label="Search">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm" id="table_lov_plu_sup">
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
                                        <tr id="row_lov_plu_sup_{{ $i }}" onclick="lov_plu_sup_select({{ $i }})" class="row_lov">
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
            currVar = $(this).parent().find('input').attr('id');
        });

        $('.modal').on('shown.bs.modal',function(){
            $(this).find('input').select();
        });

        $('.tanggal').on('keypress',function(e){
            if(e.which == 13){
                id = $(this).attr('id');

                if((id == 'div_tanggal2' || id == 'sup_tanggal2') && $(this).val() == ''){
                    $(this).val($('#div_tanggal1').val());
                    $('#div_divisi1').select();
                }
                else if(!checkDate($(this).val())){
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
                        if(tgl2 == ''){
                            tgl2 = tgl1;
                            $('#'+id).val(tgl2);
                        }

                        tgl1 = $('#'+id).parent().prev().prev().find('input').val();
                        tgl2 = $('#'+id).val();
                    }

                    if(tgl2 != '' && tgl1 > tgl2){
                        swal({
                            title: 'Tanggal pertama tidak boleh lebih besar dari tanggal kedua!',
                            icon: 'error'
                        }).then(function(){
                            $('#'+id).select();
                        })
                    }
                    else{
                        if(id == 'div_tanggal1')
                            $('#div_tanggal2').select();
                        else if(id == 'div_tanggal2')
                            $('#div_divisi1').select();
                        else if(id == 'sup_tanggal1')
                            $('#sup_tanggal2').select();
                        else if(id == 'sup_tanggal2')
                            $('#sup_supplier1').select();
                    }
                }
            }
        });

        $('.tanggal').on('change',function(){
            id = $(this).attr('id');
            if($(this).val() != '' && !checkDate($(this).val())){
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
                    if(tgl2 == ''){
                        tgl2 = tgl1;
                        $('#'+id).val(tgl2);
                    }

                    tgl1 = $('#'+id).parent().prev().prev().find('input').val();
                    tgl2 = $('#'+id).val();
                }


                if(tgl2 != '' && tgl1 > tgl2){
                    swal({
                        title: 'Tanggal pertama tidak boleh lebih besar dari tanggal kedua!',
                        icon: 'error'
                    }).then(function(){
                        $('#'+id).select();
                    })
                }
            }
        });

        $('#div_divisi1').on('keypress',function(e){
            if(e.which == 13){
                // cek_divisi($(this).val(),$(this).attr('id'),'true');
                divisi_select('div_divisi1');
            }
        });

        $('#div_divisi2').on('keypress',function(e){
            if(e.which == 13){
                if($(this).val() == ''){
                    $('#div_departement1').select();
                }
                else if($(this).val() < $('#div_divisi1').val()){
                    swal({
                        title: 'Kode divisi kedua tidak boleh lebih kecil dari kode divisi pertama!',
                        icon: 'error'
                    }).then(function(){
                        $(this).select();
                    })
                }
                // else cek_divisi($(this).val(),$(this).attr('id'),'true');
                else divisi_select('div_divisi2');
            }
        });

        $('#div_departement1').on('keypress',function(e){
            if(e.which == 13){
                // cek_departement($(this).val(),$(this).attr('id'),'true');
                departement_select($(this).attr('id'));
            }
        });

        $('#div_departement2').on('keypress',function(e){
            if(e.which == 13){
                if($(this).val() == ''){
                    $('#div_kategori1').select();
                }
                else if($(this).val() < $('#div_departement1').val()){
                    swal({
                        title: 'Kode departement kedua tidak boleh lebih kecil dari kode departement pertama!',
                        icon: 'error'
                    }).then(function(){
                        $(this).select();
                    })
                }
                else departement_select($(this).attr('id'));
            }
        });

        $('#div_kategori1').on('keypress',function(e){
            if(e.which == 13){
                kategori_select($(this).attr('id'));
            }
        });

        $('#div_kategori2').on('keypress',function(e){
            if(e.which == 13){
                if($(this).val() == ''){
                    $('#div_plu1').select();
                }
                else if($(this).val() < $('#div_kategori1').val()){
                    swal({
                        title: 'Kode kategori kedua tidak boleh lebih kecil dari kode kategori pertama!',
                        icon: 'error'
                    }).then(function(){
                        $(this).select();
                    })
                }
                else kategori_select($(this).attr('id'));
            }
        });

        function divisi_select(id){
            if($('#div_divisi1').val() > $('#div_divisi2').val() && $('#div_divisi2').val() != ''){
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
                    url: '{{ url()->current().'/cek_divisi' }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {div: $('#'+id).val(), div1: $('#div_divisi1').val(), div2: $('#div_divisi2').val()},
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
                                html =  '<tr id="row_lov_departement_'+i+'" onclick="lov_departement_select('+i+')" class="row_lov">' +
                                    '<td class="dep_kodedepartement">'+ response[i].dep_kodedepartement +'</td>' +
                                    '<td class="dep_namadepartement">'+ response[i].dep_namadepartement +'</td>' +
                                    '<td class="dep_kodedivisi">'+ response[i].dep_kodedivisi +'</td>' +
                                    '</tr>';

                                $('#table_lov_departement').append(html);
                            }

                            if(id == 'div_divisi1'){
                                $('#div_divisi2').select();
                            }
                            else $('#div_departement1').select();
                        }
                    }
                });
            }
        }

        function departement_select(id){
            if($('#div_departement1').val() > $('#div_departement2').val() && $('#div_departement2').val() != '') {
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
                    url: '{{ url()->current().'/cek_departement' }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {div1: $('#div_divisi1').val(), div2: $('#div_divisi2').val(), dep: $('#'+id).val(), dep1: $('#div_departement1').val(), dep2: $('#div_departement2').val()},
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
                                html =  '<tr id="row_lov_kategori_'+i+'" onclick="lov_kategori_select('+i+')" class="row_lov">' +
                                    '<td class="kat_kodedepartement">'+ response[i].kat_kodedepartement +'</td>' +
                                    '<td class="kat_kodekategori">'+ response[i].kat_kodekategori +'</td>' +
                                    '<td class="kat_namakategori">'+ response[i].kat_namakategori +'</td>' +
                                    '</tr>';

                                $('#table_lov_kategori').append(html);
                            }

                            if($('#modal-loader').is(':visible'))
                                $('#modal-loader').modal('toggle');

                            if(id == 'div_departement1')
                                $('#div_departement2').select();
                            else $('#div_kategori1').select();
                        }
                    }
                });
            }
        }

        function kategori_select(id, condition){
            if($('#div_kategori1').val() > $('#div_kategori2').val() && $('#div_kategori2').val() != '' && condition) {
                swal({
                    title: 'Kode kategori kedua tidak boleh lebih kecil dari kode kategori pertama!',
                    icon: 'error'
                }).then(function(){
                    $('#'+id).val('');
                    $('#' + id).select();
                });
            }
            else{
                div1 = $('#div_divisi1').val();
                div2 = $('#div_divisi2').val();
                dep1 = $('#div_departement1').val();
                dep2 = $('#div_departement2').val();
                kat1 = $('#div_kategori1').val();
                kat2 = $('#div_kategori2').val();

                $.ajax({
                    url: '{{ url()->current().'/cek_kategori' }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {kat: $('#'+id).val(), div1: div1, div2: div2, dep1: dep1, dep2: dep2, kat1: kat1, kat2: kat2},
                    beforeSend: function () {
                        $('#table_lov_plu tbody tr').remove();
                        $('#modal-loader').modal('toggle');
                    },
                    success: function (response) {
                        if($('#modal-loader').is(':visible'))
                            $('#modal-loader').modal('toggle');

                        $('#table_lov_plu tbody tr').remove();

                        for(i=0;i<response.length;i++){
                            html =  '<tr id="row_lov_plu_'+i+'" onclick="lov_plu_select('+i+')" class="row_lov">' +
                                '<td class="prd_prdcd">'+ response[i].prd_prdcd +'</td>' +
                                '<td class="prd_deskripsipanjang">'+ response[i].prd_deskripsipanjang +'</td>' +
                                '<td class="prd_satuan">'+ response[i].prd_unit +'/'+ response[i].prd_frac +'</td>' +
                                '</tr>';

                            $('#table_lov_plu').append(html);
                        }

                        if(id == 'div_kategori1')
                            $('#div_kategori2').select();
                        else $('#div_plu1').select();
                    }
                });
            }
        }

        function lov_divisi_select(i){
            kodedivisi = $('#row_lov_divisi_'+i).find('.div_kodedivisi').html();

            if(currVar == 'div_divisi1'){
                $('#div_divisi1').val(kodedivisi);
                $('#div_divisi2').select();
            }
            else if(currVar == 'div_divisi2'){
                $('#div_divisi2').val(kodedivisi);
                $('#div_departement1').select();
            }

            $('.departement').val('');
            $('.kategori').val('');
            $('.plu').val('');

            divisi_select(currVar);
        }

        function lov_departement_select(i){
            kodedepartement = $('#row_lov_departement_'+i).find('.dep_kodedepartement').html();

            $('#m_lov_departement').modal('toggle');

            if(currVar == 'div_departement1'){
                $('#div_departement1').val(kodedepartement);
                $('#div_departement2').select();
            }
            else if(currVar == 'div_departement2'){
                $('#div_departement2').val(kodedepartement);
                $('#div_kategori1').select();
            }

            $('.kategori').val('');
            $('.plu').val('');

            departement_select(currVar);
        }

        function lov_kategori_select(i){
            kodekategori = $('#row_lov_kategori_'+i).find('.kat_kodekategori').html();
            dep = $('#row_lov_kategori_'+i).find('.kat_kodedepartement').html();

            $('#m_lov_kategori').modal('toggle');

            console.log(dep);

            condition = true;

            if(currVar == 'div_kategori1'){
                $('#div_kategori1').val(kodekategori);
                $('#div_kategori2').select();
            }
            else if(currVar == 'div_kategori2'){
                $('#div_kategori2').val(kodekategori);
                $('#div_plu1').select();

                if(dep > $('#div_departement1').val())
                    condition = false;
            }

            $('.plu').val('');

            kategori_select(currVar,condition);
        }

        function lov_plu_select(i){
            kodeplu = $('#row_lov_plu_'+i).find('.prd_prdcd').html();

            if(currVar == 'div_plu1'){
                $('#div_plu1').val(kodeplu);
                $('#div_plu2').select();
            }
            else if(currVar == 'div_plu2'){
                $('#div_plu2').val(kodeplu);
                $('#div_pilihan').select();
            }

            div_cek_plu(currVar);
        }

        $('.div_plu').on('keypress',function(){
            if($(this).attr('id') == 'div_plu1')
                $('#div_plu2').select();
            else $('#div_pilihan').select();
        })

        $('.div_plu').on('change',function(){
            plu1 = $('#div_plu1').val();
            plu2 = $('#div_plu2').val();

            if(parseInt(plu1) > parseInt(plu2)){
                if($('#m_lov_plu').is(':visible'))
                    $('#m_lov_plu').modal('toggle');
                if($('#modal-loader').is(':visible'))
                    $('#modal-loader').modal('toggle');
                swal({
                    title: 'PLU pertama tidak boleh lebih besar dari PLU kedua!',
                    icon: 'error'
                }).then(function(){
                    $(this).select();
                })
            }
            else{
                $(this).val(convertPlu($(this).val()));
                div_cek_plu($(this).attr('id'));
            }

        });

        $('#div_pilihan').on('keypress',function(e){
            if(e.which == 13){
                pil = $(this).val();
                if(pil < 1 || pil > 6 || pil == 5){
                    swal({
                        title: 'Pilihan tidak sesuai!',
                        icon: 'error'
                    }).then(function(){
                        $('#div_pilihan').select();
                    })
                }
                else{
                    $('#div_print').focus();
                }
            }
        });

        function div_cek_plu(id){
            $('#'+id).val(convertPlu($('#'+id).val()));

            if($('#div_plu1').val() > $('#div_plu2').val() && $('#div_plu2').val() != ''){
                if($('#m_lov_plu').is(':visible'))
                    $('#m_lov_plu').modal('toggle');
                if($('#modal-loader').is(':visible'))
                    $('#modal-loader').modal('toggle');

                swal({
                    title: 'PLU pertama tidak boleh lebih besar dari PLU kedua!',
                    icon: 'error'
                }).then(function(){
                    $('#'+id).select();
                });
            }
            else{
                plu = convertPlu($('#'+id).val());
                div1 = $('#div_divisi1').val();
                div2 = $('#div_divisi2').val();
                dep1 = $('#div_departement1').val();
                dep2 = $('#div_departement2').val();
                kat1 = $('#div_kategori1').val();
                kat2 = $('#div_kategori2').val();

                $.ajax({
                    url: '{{ url()->current().'/div_cek_plu' }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {div1: div1, div2: div2, dep1: dep1, dep2: dep2, kat1: kat1, kat2: kat2, plu: plu},
                    beforeSend: function () {
                        $('#modal-loader').modal('toggle');
                    },
                    success: function (response) {
                        if($('#m_lov_plu').is(':visible'))
                            $('#m_lov_plu').modal('toggle');
                        if($('#modal-loader').is(':visible'))
                            $('#modal-loader').modal('toggle');
                        if(response != 'true'){
                            swal({
                                title: 'PLU tidak ditemukan!',
                                icon: 'error'
                            }).then(function(){
                                $('#'+id).select();
                            })
                        }
                        else{
                            if(id == 'div_plu1')
                                $('#div_plu2').select();
                            else $('#div_pilihan').select();
                        }
                    }
                });
            }
        }

        function print_by_div(){
            if($('#div_tanggal1').val() > $('#div_tanggal2').val()){
                swal({
                    title: 'Tanggal pertama tidak boleh lebih besar dari tanggal kedua!',
                    icon: 'error'
                }).then(function(){
                    $('#div_tanggal1').select();
                })
            }
            else{
                tgl1 = nvl($('#div_tanggal1').val().replace(/\//g,'-'),'ALL');
                tgl2 = nvl($('#div_tanggal2').val().replace(/\//g,'-'),'ALL');

                console.log(tgl1);
                console.log(tgl2);

                div1 = nvl($('#div_divisi1').val(),'ALL');
                div2 = nvl($('#div_divisi2').val(),'ALL');
                dep1 = nvl($('#div_departement1').val(),'ALL');
                dep2 = nvl($('#div_departement2').val(),'ALL');
                kat1 = nvl($('#div_kategori1').val(),'ALL');
                kat2 = nvl($('#div_kategori2').val(),'ALL');
                plu1 = nvl($('#div_plu1').val(),'ALL');
                plu2 = nvl($('#div_plu2').val(),'ALL');
                pil = nvl($('#div_pilihan').val(),'3');


                url = '{{ url()->current() }}/print_by_div?tgl1='+tgl1+'&tgl2='+tgl2+'&div1='+div1+'&div2='+div2+'&dep1='+dep1+'&dep2='+dep2+'&kat1='+kat1+'&kat2='+kat2+'&plu1='+plu1+'&plu2='+plu2+'&pil='+pil;

                window.open(url);
            }
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////BY SUPPLIER///////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $('#i_lov_supplier').on('keypress',function(e){
            if(e.which == 13){
                $.ajax({
                    url: '{{ url()->current().'/search_supplier' }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {sup: $(this).val().toUpperCase()},
                    beforeSend: function () {
                        $('#modal-loader').modal('toggle');
                    },
                    success: function (response) {
                        if($('#modal-loader').is(':visible'))
                            $('#modal-loader').modal('toggle');

                        $('#table_lov_supplier tbody tr').remove();

                        if(response == 'false'){
                            html = '<tr><td colspan="2" class="text-center">Data tidak ditemukan</td></tr>';
                            $('#table_lov_supplier').append(html);
                        }
                        else{
                            for(i=0;i<response.length;i++){
                                html =  '<tr id="row_lov_supplier_'+i+'" onclick="lov_supplier_select('+i+')" class="row_lov">' +
                                    '<td class="sup_kodesupplier">'+ response[i].sup_kodesupplier +'</td>' +
                                    '<td class="sup_namasupplier">'+ response[i].sup_namasupplier +'</td>' +
                                    '</tr>';

                                $('#table_lov_supplier').append(html);
                            }
                        }
                    }
                });
            }
        });

        $('#sup_i_lov_plu').on('keypress',function(e){
            if(e.which == 13){
                $.ajax({
                    url: '{{ url()->current().'/sup_search_plu' }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {plu: $(this).val().toUpperCase(), sup1: $('#sup_supplier1').val(), sup2: $('#sup_supplier2').val()},
                    beforeSend: function () {
                        $('#modal-loader').modal('toggle');
                    },
                    success: function (response) {
                        if($('#modal-loader').is(':visible'))
                            $('#modal-loader').modal('toggle');

                        $('#table_lov_plu_sup tbody tr').remove();

                        if(response == 'false'){
                            html = '<tr><td colspan="3" class="text-center">Data tidak ditemukan</td></tr>';
                            $('#table_lov_plu_sup').append(html);
                        }
                        else{
                            for(i=0;i<response.length;i++){
                                html =  '<tr id="row_lov_plu_'+i+'" onclick="lov_plu_select('+i+')" class="row_lov">' +
                                    '<td class="prd_prdcd">'+ response[i].prd_prdcd +'</td>' +
                                    '<td class="prd_deskripsipanjang">'+ response[i].prd_deskripsipanjang +'</td>' +
                                    '<td class="prd_satuan">'+ response[i].prd_unit +'/'+ response[i].prd_frac +'</td>' +
                                    '</tr>';

                                $('#table_lov_plu').append(html);
                            }
                        }
                    }
                });
            }
        })

        $('#sup_supplier1').on('keypress',function(e){
            if(e.which == 13){
                supplier_select($(this).attr('id'));
            }
        });

        $('#sup_supplier2').on('keypress',function(e){
            if(e.which == 13){
                if($(this).val() == '')
                    $('#sup_plu1').select();
                else supplier_select($(this).attr('id'));
            }
        });

        $('#sup_plu1').on('keypress',function(e){
            if(e.which == 13){
                sup_cek_plu($(this).attr('id'));
            }
        });

        $('#sup_plu2').on('keypress',function(e){
            if(e.which == 13){
                sup_cek_plu($(this).attr('id'));
            }
        });

        $('.sup_plu').on('change',function(){
            sup_cek_plu($(this).attr('id'));
        });

        function lov_supplier_select(i){
            kodesupplier = $('#row_lov_supplier_'+i).find('.sup_kodesupplier').html();

            $('#'+currVar).val(kodesupplier);
            if(currVar == 'sup_supplier1')
                $('#sup_supplier2').select();
            else $('#sup_pilihan').select();

            supplier_select(currVar);
        }

        function supplier_select(id){
            if($('#sup_supplier1').val() > $('#sup_supplier2').val() && $('#sup_supplier2').val() != ''){
                swal({
                    title: 'Kode supplier kedua tidak boleh lebih kecil dari kode supplier pertama!',
                    icon: 'error'
                }).then(function () {
                    $('#'+id).val('');
                    $('#' + id).select();
                });
            }
            else{
                sup = $('#'+id).val();
                sup1 = $('#sup_supplier1').val();
                sup2 = $('#sup_supplier2').val();

                $.ajax({
                    url: '{{ url()->current().'/cek_supplier' }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {sup: sup, sup1: sup1, sup2: sup2},
                    beforeSend: function () {
                        $('#modal-loader').modal('toggle');
                    },
                    success: function (response) {
                        if($('#m_lov_supplier').is(':visible'))
                            $('#m_lov_supplier').modal('toggle');

                        if($('#modal-loader').is(':visible'))
                            $('#modal-loader').modal('toggle');

                        if(response == 'false'){
                            swal({
                                title: 'Kode supplier tidak ditemukan!',
                                icon: 'error'
                            }).then(function(){
                                $('#'+id).select();
                            })
                        }
                        else{
                            $('#table_lov_plu_sup tbody tr').remove();

                            for(i=0;i<response.length;i++){
                                html =  '<tr id="row_lov_plu_sup_'+i+'" onclick="lov_plu_sup_select('+i+')" class="row_lov">' +
                                    '<td class="prd_prdcd">'+ response[i].prd_prdcd +'</td>' +
                                    '<td class="prd_deskripsipanjang">'+ response[i].prd_deskripsipanjang +'</td>' +
                                    '<td class="prd_satuan">'+ response[i].prd_unit +'/'+ response[i].prd_frac +'</td>' +
                                    '</tr>';

                                $('#table_lov_plu_sup').append(html);
                            }

                            if(id == 'sup_supplier1'){
                                $('#sup_supplier2').select();
                            }
                            else $('#sup_plu1').select();
                        }
                    }
                });
            }
        }

        function lov_plu_sup_select(i){
            kodeplu = $('#row_lov_plu_sup_'+i).find('.prd_prdcd').html();

            console.log($('#row_lov_plu_sup_'+i).find('.prd_prdcd').html());

            $('#m_lov_plu_sup').modal('toggle');

            $('#'+currVar).val(kodeplu);
            if(currVar == 'sup_plu1'){
                $('#div_plu2').select();
            }
            else if(currVar == 'sup_plu2'){
                $('#div_pilihan').select();
            }

            sup_cek_plu(currVar);
        }

        function sup_cek_plu(id){
            $('#'+id).val(convertPlu($('#'+id).val()));

            if($('#sup_plu1').val() > $('#sup_plu2').val() && $('#sup_plu2').val() != ''){
                if($('#m_lov_plu_sup').is(':visible'))
                    $('#m_lov_plu_sup').modal('toggle');
                if($('#modal-loader').is(':visible'))
                    $('#modal-loader').modal('toggle');

                swal({
                    title: 'PLU pertama tidak boleh lebih besar dari PLU kedua!',
                    icon: 'error'
                }).then(function(){
                    $('#'+id).select();
                });
            }
            else{
                plu = convertPlu($('#'+id).val());
                sup1 = $('#sup_supplier1').val();
                sup2 = $('#sup_supplier2').val();

                $.ajax({
                    url: '{{ url()->current().'/sup_cek_plu' }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {sup1: sup1, sup2: sup2, plu: plu},
                    beforeSend: function () {
                        $('#modal-loader').modal('toggle');
                    },
                    success: function (response) {
                        if($('#m_lov_plu_sup').is(':visible'))
                            $('#m_lov_plu_sup').modal('toggle');
                        if($('#modal-loader').is(':visible'))
                            $('#modal-loader').modal('toggle');
                        if(response != 'true'){
                            swal({
                                title: 'PLU tidak ditemukan!',
                                icon: 'error'
                            }).then(function(){
                                $('#'+id).select();
                            })
                        }
                        else{
                            if(id == 'sup_plu1')
                                $('#sup_plu2').select();
                            else $('#sup_pilihan').select();
                        }
                    }
                });
            }
        }

        function print_by_sup(){
            if($('#sup_tanggal1').val() > $('#sup_tanggal2').val()){
                swal({
                    title: 'Tanggal pertama tidak boleh lebih besar dari tanggal kedua!',
                    icon: 'error'
                }).then(function(){
                    $('#sup_tanggal1').select();
                })
            }
            else{
                tgl1 = nvl(formatDateCustom(formatDate($('#sup_tanggal1').val()),'dd-mm-yy'),'ALL');
                tgl2 = nvl(formatDateCustom(formatDate($('#sup_tanggal2').val()),'dd-mm-yy'),'ALL');

                console.log(tgl1);
                console.log(tgl2);

                sup1 = nvl($('#sup_supplier1').val(),'ALL');
                sup2 = nvl($('#sup_supplier2').val(),'ALL');
                plu1 = nvl($('#sup_plu1').val(),'ALL');
                plu2 = nvl($('#sup_plu2').val(),'ALL');
                pil = nvl($('#sup_pilihan').val(),'3');


                url = '{{ url()->current() }}'+'/print_by_sup?tgl1='+tgl1+'&tgl2='+tgl2+'&sup1='+sup1+'&sup2='+sup2+'&plu1='+plu1+'&plu2='+plu2+'&pil='+pil;

                window.open(url);
            }
        }

    </script>

@endsection
