@extends('navbar')
@section('content')


    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-12 pl-5 pr-5">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Master Lokasi</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <label for="periode" class="col-sm-1 col-form-label">KODE RAK</label>
                            <div class="col-sm-1">
                                <input maxlength="10" type="text" class="form-control" id="lks_koderak">
                            </div>
                            <div class="col-sm-1 p-0">
                                <button type="button" id="btn-lov" class="btn p-0 float-left" data-toggle="modal" data-target="#m_lov_rak"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                            </div>
                        </div>
                        <div class="row">
                            <label for="periode" class="col-sm-1 col-form-label">SUB RAK</label>
                            <div class="col-sm-1">
                                <input maxlength="10" type="text" class="form-control" id="lks_kodesubrak">
                            </div>
                        </div>
                        <div class="row">
                            <label for="periode" class="col-sm-1 col-form-label">TIPE RAK</label>
                            <div class="col-sm-1">
                                <input maxlength="10" type="text" class="form-control" id="lks_tiperak">
                            </div>
                        </div>
                        <div class="row">
                            <label for="periode" class="col-sm-1 col-form-label">SHELVING</label>
                            <div class="col-sm-1">
                                <input maxlength="10" type="text" class="form-control" id="lks_shelvingrak">
                            </div>
                            <div class="col-sm-4"></div>
                            <label for="periode" class="col-sm-1 col-form-label">JUMLAH ITEM</label>
                            <div class="col-sm-1">
                                <input maxlength="10" type="text" class="form-control" id="jumlahitem">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 pr-0">
                                <br>
                                <fieldset class="card border-secondary">
                                    {{--<legend class="w-auto ml-4">Detail</legend>--}}
                                    <div class="kiri col-sm table-wrapper-scroll-y my-custom-scrollbar scroll-y">
                                        <table id="table-all" class="table table-sm table-bordered m-1 mb-4">
                                            <thead>
                                                <tr class="d-flex text-center no-border">
                                                    <th width="56%"></th>
                                                    <th width="12%">DIMENSI</th>
                                                    <th width="9%">T I R</th>
                                                    <th width="6%">DISPLAY</th>
                                                    <th width="5%"></th>
                                                    <th width="4%">QTY</th>
                                                    <th width="4%">MIN PCT</th>
                                                    <th width="4%">MIN PCT</th>
                                                    <th width="5%">MAX PLANO</th>
                                                </tr>
                                                <tr class="d-flex text-center">
                                                    <th width="3%"></th>
                                                    <th width="3%">NO</th>
                                                    <th width="3%">D - B</th>
                                                    <th width="3%">A - B</th>
                                                    <th width="6%">PLU</th>
                                                    <th width="3%">JENIS</th>
                                                    <th width="25%">DESKRIPSI</th>
                                                    <th width="5%">SATUAN</th>
                                                    <th width="5%">NO ID</th>
                                                    <th width="4%">P</th>
                                                    <th width="4%">L</th>
                                                    <th width="4%">T</th>
                                                    <th width="3%">K - K</th>
                                                    <th width="3%">D - B</th>
                                                    <th width="3%">A - B</th>
                                                    <th width="3%">MIN</th>
                                                    <th width="3%">MAX</th>
                                                    <th width="5%">PKM</th>
                                                    <th width="4%">(PCS)</th>
                                                    <th width="4%">(%)</th>
                                                    <th width="4%">(QTY)</th>
                                                    <th width="5%">(PCS)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php for($i=0;$i<8;$i++){ @endphp
                                            <tr class="d-flex text-center" id="row_{{ $i }}">
                                                <td width="3%">
                                                    <button onclick="deleteRow({{ $i }})" class="col-sm btn btn-danger btn-delete">X</button>
                                                </td>
                                                <td width="3%"><input type="text" class="form-control lks_nourut"></td>
                                                <td width="3%"><input type="text" class="form-control"></td>
                                                <td width="3%"><input type="text" class="form-control"></td>
                                                <td width="6%">
                                                    <div class="buttonInside">
                                                        <input type="text" class="form-control lks_prdcd" maxlength="7">
                                                        <button style="display: none" type="button" class="btn btn-lov-plu p-0" data-toggle="modal" data-target="#m_lov_plu"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                                                    </div>
                                                </td>
                                                <td width="3%"><input type="text" class="form-control"></td>
                                                <td width="25%"><input type="text" class="form-control"></td>
                                                <td width="5%"><input type="text" class="form-control"></td>
                                                <td width="5%"><input type="text" class="form-control"></td>
                                                <td width="4%"><input type="text" class="form-control"></td>
                                                <td width="4%"><input type="text" class="form-control"></td>
                                                <td width="4%"><input type="text" class="form-control"></td>
                                                <td width="3%"><input type="text" class="form-control"></td>
                                                <td width="3%"><input type="text" class="form-control"></td>
                                                <td width="3%"><input type="text" class="form-control"></td>
                                                <td width="3%"><input type="text" class="form-control"></td>
                                                <td width="3%"><input type="text" class="form-control"></td>
                                                <td width="5%"><input type="text" class="form-control"></td>
                                                <td width="4%"><input type="text" class="form-control"></td>
                                                <td width="4%"><input type="text" class="form-control"></td>
                                                <td width="4%"><input type="text" class="form-control"></td>
                                                <td width="5%"><input type="text" class="form-control"></td>
                                            </tr>
                                            @php } @endphp
                                            </tbody>
                                        </table>

                                        <table id="table-s" class="table table-sm table-bordered m-1 mb-4 d-none">
                                            <thead>
                                            <tr class="d-flex text-center">
                                                <th width="3%"></th>
                                                <th width="3%">NO</th>
                                                <th width="3%">D - B</th>
                                                <th width="3%">A - B</th>
                                                <th width="5%">PLU</th>
                                                <th width="3%">JENIS</th>
                                                <th width="30%">DESKRIPSI</th>
                                                <th width="5%">SATUAN</th>
                                                <th width="5%">QTY (pcs)</th>
                                                <th width="8%">EXPIRED DATE</th>
                                                <th width="8%">MAX PALET (CTN)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php for($i=0;$i<7;$i++){ @endphp
                                            <tr class="d-flex text-center">
                                                <td width="3%">
                                                    <button onclick="deleteRow({{ $i }})" class="col-sm btn btn-danger btn-delete">X</button>
                                                </td>
                                                <td width="3%"><input type="text" class="form-control"></td>
                                                <td width="3%"><input type="text" class="form-control"></td>
                                                <td width="3%"><input type="text" class="form-control"></td>
                                                <td width="5%"><input type="text" class="form-control" maxlength="7"></td>
                                                <td width="3%"><input type="text" class="form-control"></td>
                                                <td width="30%"><input type="text" class="form-control"></td>
                                                <td width="5%"><input type="text" class="form-control"></td>
                                                <td width="5%"><input type="text" class="form-control"></td>
                                                <td width="8%"><input type="text" class="form-control"></td>
                                                <td width="8%"><input type="text" class="form-control"></td>
                                            </tr>
                                            @php } @endphp
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <br>

                        <ul class="nav nav-tabs custom-color" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="btn-p_identitas" data-toggle="tab" href="#p_tambah">TAMBAH</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="btn-p_identitas2" data-toggle="tab" href="#p_input_noid">INPUT NO ID</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="p_tambah" class="container-fluid tab-pane active pl-0 pr-0 fix-height">
                                <div class="card-body ">
                                    <div class="row text-right">
                                        <div class="col-sm-12">
                                            <table id="table-tambah" class="table table-sm table-bordered m-1 mb-4">
                                                <thead>
                                                    <tr class="d-flex text-center">
                                                        <th width="3%">NO</th>
                                                        <th width="3%">D - B</th>
                                                        <th width="3%">A - B</th>
                                                        <th width="5%">PLU</th>
                                                        <th width="3%">JENIS</th>
                                                        <th width="27%">DESKRIPSI</th>
                                                        <th width="6%">SATUAN</th>
                                                        <th width="5%">NO ID</th>
                                                        <th width="4%">P</th>
                                                        <th width="4%">L</th>
                                                        <th width="4%">T</th>
                                                        <th width="4%">K - K</th>
                                                        <th width="4%">D - B</th>
                                                        <th width="4%">A - B</th>
                                                        <th width="4%">MINDIS</th>
                                                        <th width="4%">MAXDIS</th>
                                                        <th width="4%">PKM</th>
                                                        <th width="4%">MIN PCT</th>
                                                        <th width="6%">MAX PLANO</th>
                                                    </tr>
                                                </thead>
                                                <tr class="d-flex text-center">
                                                    <td width="3%"><input type="text" class="form-control"></td>
                                                    <td width="3%"><input type="text" class="form-control"></td>
                                                    <td width="3%"><input type="text" class="form-control"></td>
                                                    <td width="5%"><input type="text" class="form-control" maxlength="7"></td>
                                                    <td width="3%"><input type="text" class="form-control"></td>
                                                    <td width="27%"><input type="text" class="form-control"></td>
                                                    <td width="6%"><input type="text" class="form-control"></td>
                                                    <td width="5%"><input type="text" class="form-control"></td>
                                                    <td width="4%"><input type="text" class="form-control"></td>
                                                    <td width="4%"><input type="text" class="form-control"></td>
                                                    <td width="4%"><input type="text" class="form-control"></td>
                                                    <td width="4%"><input type="text" class="form-control"></td>
                                                    <td width="4%"><input type="text" class="form-control"></td>
                                                    <td width="4%"><input type="text" class="form-control"></td>
                                                    <td width="4%"><input type="text" class="form-control"></td>
                                                    <td width="4%"><input type="text" class="form-control"></td>
                                                    <td width="4%"><input type="text" class="form-control"></td>
                                                    <td width="4%"><input type="text" class="form-control"></td>
                                                    <td width="6%"><input type="text" class="form-control"></td>
                                                </tr>
                                            </table>
                                            <button class="btn btn-success">TAMBAH</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="p_input_noid" class="container-fluid tab-pane pl-0 pr-0 fix-height">
                                <div class="card-body ">
                                    <div class="row text-right">
                                        <div class="col-sm-4"></div>
                                        <div class="col-sm-4">
                                            <button class="col-sm btn btn-success" data-toggle="modal" data-target="#m_input_noid">ENTRY MASTER NO ID DPD</button>
                                        </div>
                                        <div class="col-sm-4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id=m_input_noid tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <fieldset class="card border-secondary">
                            <legend  class="w-auto ml-5">ENTRY MASTER NO ID DPD</legend>
                            <div class="card-body shadow-lg cardForm">
                                <div class="row">
                                    <label for="periode" class="col-sm-3 col-form-label">NOMOR ID DPD</label>
                                    <div class="col-sm-3">
                                        <input maxlength="10" type="text" class="form-control" id="periode">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="periode" class="col-sm-3 col-form-label">KODE RAK</label>
                                    <div class="col-sm-3">
                                        <input maxlength="10" type="text" class="form-control" id="periode">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="periode" class="col-sm-3 col-form-label">KODE SUB RAK</label>
                                    <div class="col-sm-3">
                                        <input maxlength="10" type="text" class="form-control" id="periode">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="periode" class="col-sm-3 col-form-label">TIPE RAK</label>
                                    <div class="col-sm-3">
                                        <input maxlength="10" type="text" class="form-control" id="periode">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="periode" class="col-sm-3 col-form-label">SHELVING</label>
                                    <div class="col-sm-3">
                                        <input maxlength="10" type="text" class="form-control" id="periode">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="periode" class="col-sm-3 col-form-label">NOMOR URUT</label>
                                    <div class="col-sm-3">
                                        <input maxlength="10" type="text" class="form-control" id="periode">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-9"></div>
                                    <button class="col-sm-3 btn btn-success">SIMPAN</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_rak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="i_lov_rak" class="form-control search_lov" type="text" placeholder="Inputkan Rak" aria-label="Search">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_rak">
                                    <thead>
                                    <tr>
                                        <td>RAK</td>
                                        <td>SUB RAK</td>
                                        <td>TIPE</td>
                                        <td>SHELV</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($lokasi as $l)
                                        <tr id="row_lov_rak_{{ $l->rn }}" onclick="lov_rak_select({{ $l->rn }})" class="row_lov">
                                            <td class="lks_koderak">{{ $l->lks_koderak }}</td>
                                            <td class="lks_kodesubrak">{{ $l->lks_kodesubrak }}</td>
                                            <td class="lks_tiperak">{{ $l->lks_tiperak }}</td>
                                            <td class="lks_shelvingrak">{{ $l->lks_shelvingrak }}</td>
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
                        <input id="i_lov_plu" class="form-control search_lov" type="text" placeholder="Inputkan Deskripsi / PLU Produk" aria-label="Search">
                        <div class="invalid-feedback">
                            Inputkan minimal 3 karakter
                        </div>
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
                                        <td>Deskripsi</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($produk as $p)
                                        <tr onclick="lov_plu_select('{{ $p->prd_prdcd }}')" class="row_lov">
                                            <td>{{ $p->prd_prdcd }}</td>
                                            <td>{{ $p->prd_deskripsipanjang }}</td>
                                        </tr>
                                    @endforeach
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

        .number input{
            text-align: right;
        }

        .no-border th{
            border: none;
        }

        .fix-height{
            height: 200px;
        }

        input{
            text-transform: uppercase;
        }

        .row_lov:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }


        .buttonInside{
            position:relative;
        }
        input{
            height:25px;
            width:100%;
            padding-left:10px;
            border-radius: 4px;
            border:none;outline:none;
        }
        .btn-lov-plu{
            position:absolute;
            right: 4px;
            top: 4px;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;

        }
        button:hover{
            cursor:pointer;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 525px;
            overflow-x: auto;
        }

    </style>

    <script>
        $('#table-s').hide();
        $('#table-s').removeClass('d-none');

        trlovrak = $('#table_lov_rak tbody').html();
        trlovplu = $('#table_lov_plu tbody').html();
        idrow = '';
        tempprdcd = '';

        $('input').parent().find('button').each(function(){
            $(this).hide();
        });

        $('input').on('keypress',function(){
            $(this).val($(this).val().toUpperCase());
        });

        $('#table-all input').on('keypress',function(e){
            if(e.which == 13){
                lov_plu_select($(this).val());
            }
        });

        $('input').on('focus',function(){
            $(this).select();

            if(!$(this).hasClass('lks_prdcd'))
                $('.btn-lov-plu').hide();
            else{
                $(this).parent().find('.btn-lov-plu').show();
                idrow = $(this).parent().parent().parent().attr('id');
            }
        });

        // $('#table-all input').prop('disabled',true);

        $('.btn-lov').on('click',function(){
            idrow = $(this).parent().parent().parent().attr('id');
        });

        $('#m_lov_rak').on('shown.bs.modal',function(){
            $('#i_lov_rak').select();
        });

        $('#m_lov_plu').on('shown.bs.modal',function(){
            $('#i_lov_plu').select();
        });

        $('#m_lov_plu').on('hide.bs.modal',function(){
            $('.btn-lov-plu').hide();
        });



        $('#i_lov_rak').on('keypress',function(e){
            if(e.which == 13){
                if(this.value == ''){
                    $('#table_lov_rak tbody tr').remove();
                    $('#table_lov_rak').append(trlovrak);
                }
                else{
                    $.ajax({
                        url: '{{ url('/mstlokasi/lov_rak_search') }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {koderak: this.value.toUpperCase()},
                        beforeSend: function () {
                            $('#modal-loader').modal('toggle');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('toggle');

                            $('#table_lov_rak tbody tr').remove();

                            for(i=0;i<response.length;i++){
                                html = '<tr class="row_lov" id="row_lov_rak_'+i+'" onclick=lov_rak_select("'+i+'")><td class="lks_koderak">' + response[i].lks_koderak + '</td>' +
                                    '<td class="lks_kodesubrak">' + response[i].lks_kodesubrak + '</td>' +
                                    '<td class="lks_tiperak">' + response[i].lks_tiperak + '</td>' +
                                    '<td class="lks_shelvingrak">' + response[i].lks_shelvingrak + '</td></tr>';

                                $('#table_lov_rak').append(html);
                            }
                            $('#i_lov_rak').select();
                        }
                    });
                }
            }
        });

        $('#i_lov_plu').on('keypress',function(e){
            if(e.which == 13){
                if(this.value == ''){
                    $('#table_lov_plu tbody tr').remove();
                    $('#table_lov_plu').append(trlovplu);
                }
                else{
                    if($.isNumeric($(this).val())){
                        value = convertPlu($(this).val());
                    }
                    else value = $(this).val().toUpperCase();
                    $.ajax({
                        url: '{{ url('/mstlokasi/lov_plu_search') }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {data: value},
                        beforeSend: function () {
                            $('#modal-loader').modal('toggle');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('toggle');

                            console.log(response);
                            $('#table_lov_plu tbody tr').remove();

                            for(i=0;i<response.length;i++){
                                html = '<tr onclick=lov_plu_select("'+response[i].prd_prdcd+'") class="row_lov">' +
                                        '<td>'+response[i].prd_prdcd+'</td>' +
                                        '<td>'+response[i].prd_deskripsipanjang+'</td>' +
                                        '</tr>';

                                $('#table_lov_plu').append(html);

                                console.log(html);
                            }
                            $('#i_lov_plu').select();
                        }
                    });
                }
            }
        });




        $('#lks_koderak').on('keypress',function(e){
            if(e.which == 13){
                $('#lks_kodesubrak').select();
            }
        });

        $('#lks_kodesubrak').on('keypress',function(e){
            if(e.which == 13){
                $('#lks_tiperak').select();
            }
        });

        $('#lks_tiperak').on('keypress',function(e){
            if(e.which == 13){
                $('#lks_shelvingrak').select();
            }
        });

        $('#lks_shelvingrak').on('keypress',function(e){
            if(e.which == 13){
                lov_rak_select('input');
            }
        });

        function lov_rak_select(row){
            if(row == 'input' && ($('#lks_koderak').val() == '' || $('#lks_kodesubrak').val() == '' || $('#lks_tiperak').val() == '' || $('#lks_shelvingrak').val() == '')){
                swal({
                    title: 'Inputan tidak lengkap!',
                    icon: 'error'
                }).then(function(){
                    if($('#lks_koderak').val() == '')
                        $('#lks_koderak').select();
                    else if($('#lks_kodesubrak').val() == '')
                        $('#lks_kodesubrak').select();
                    else if($('#lks_tiperak').val() == '')
                        $('#lks_tiperak').select();
                    else if($('#lks_shelvingrak').val() == '')
                        $('#lks_shelvingrak').select();
                });
            }
            else{
                data = {};

                if(row != 'input'){
                    data['lks_koderak'] = $('#row_lov_rak_'+row).find('.lks_koderak').html();
                    data['lks_kodesubrak'] =  $('#row_lov_rak_'+row).find('.lks_kodesubrak').html();
                    data['lks_tiperak'] = $('#row_lov_rak_'+row).find('.lks_tiperak').html();
                    data['lks_shelvingrak'] = $('#row_lov_rak_'+row).find('.lks_shelvingrak').html();
                }
                else{
                    data['lks_koderak'] = $('#lks_koderak').val();
                    data['lks_kodesubrak'] =  $('#lks_kodesubrak').val();
                    data['lks_tiperak'] = $('#lks_tiperak').val();
                    data['lks_shelvingrak'] = $('#lks_shelvingrak').val();
                }

                console.log(data);

                $.ajax({
                    url: '{{ url('/mstlokasi/lov_rak_select') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {data},
                    beforeSend: function () {
                        $('#modal-loader').modal('toggle');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('toggle');

                        $('#table-all tbody tr').remove();

                        $('#jumlahitem').val(response.length);


                        if(row == 'input'){
                            $('#lks_koderak').val(data['lks_koderak']);
                            $('#lks_kodesubrak').val(data['lks_kodesubrak']);
                            $('#lks_tiperak').val(data['lks_tiperak']);
                            $('#lks_shelvingrak').val(data['lks_shelvingrak']);
                        }

                        if()

                        for(i=0;i<response.length;i++){
                            mindisplay = response[i].lks_tirkirikanan * response[i].lks_tirdepanbelakang * response[i].lks_tiratasbawah;
                            minpctqty = response[i].lks_minpct * response[i].lks_maxplano / 100;

                            html =
                                '<tr class="d-flex text-center" id="row_'+ i +'">' +
                                '<td width="3%">' +
                                '<button onclick="deleteRow('+ i +')" class="col-sm btn btn-danger btn-delete">X</button>' +
                                '</td>' +
                                '<td width="3%"><input type="text" class="form-control lks_nourut" value="'+ nvl(response[i].lks_nourut,'') +'"></td>' +
                                '<td width="3%"><input type="text" class="form-control lks_depanbelakang" value="'+ nvl(response[i].lks_depanbelakang,'') +'"></td>' +
                                '<td width="3%"><input type="text" class="form-control lks_atasbawah" value="'+ nvl(response[i].lks_atasbawah,'') +'"></td>' +
                                '<td width="6%">' +
                                '<div class="buttonInside">' +
                                '<input type="text" class="form-control lks_prdcd" maxlength="7" value="'+ nvl(response[i].lks_prdcd,'') +'">' +
                                '<button style="display: none" type="button" class="btn btn-lov-plu p-0" data-toggle="modal" data-target="#m_lov_plu"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>' +
                                '</div>' +
                                '</td>' +
                                '<td width="3%"><input type="text" class="form-control lks_jenisrak" value="'+ nvl(response[i].lks_jenisrak,'') +'"></td>' +
                                '<td width="25%"><input type="text" class="form-control desk" value="'+ nvl(response[i].desk,'') +'"></td>' +
                                '<td width="5%"><input type="text" class="form-control satuan" value="'+ nvl(response[i].satuan,'') +'"></td>' +
                                '<td width="5%"><input type="text" class="form-control lks_noid" value="'+ nvl(response[i].lks_noid,'') +'"></td>' +
                                '<td width="4%"><input type="text" class="form-control lks_dimensipanjangproduk" value="'+ convertToRupiah(nvl(response[i].lks_dimensipanjangproduk,'')) +'"></td>' +
                                '<td width="4%"><input type="text" class="form-control lks_dimensilebarproduk" value="'+ convertToRupiah(nvl(response[i].lks_dimensilebarproduk,'')) +'"></td>' +
                                '<td width="4%"><input type="text" class="form-control lks_dimensitinggiproduk" value="'+ convertToRupiah(nvl(response[i].lks_dimensitinggiproduk,'')) +'"></td>' +
                                '<td width="3%"><input type="text" class="form-control lks_tirkirikanan" value="'+ nvl(response[i].lks_tirkirikanan,'') +'"></td>' +
                                '<td width="3%"><input type="text" class="form-control lks_tirdepanbelakang" value="'+ nvl(response[i].lks_tirdepanbelakang,'') +'"></td>' +
                                '<td width="3%"><input type="text" class="form-control lks_tiratasbawah" value="'+ nvl(response[i].lks_tiratasbawah,'') +'"></td>' +
                                '<td width="3%"><input type="text" class="form-control lks_mindisplay" value="'+ nvl(mindisplay,'')  +'"></td>' +
                                '<td width="3%"><input type="text" class="form-control lks_maxdisplay" value="'+ nvl(response[i].lks_maxdisplay,'') +'"></td>' +
                                '<td width="5%"><input type="text" class="form-control pkm" value="'+ convertToRupiah(nvl(response[i].pkm,'')) +'"></td>' +
                                '<td width="4%"><input type="text" class="form-control lks_qty" value="'+ nvl(response[i].lks_qty,'') +'"></td>' +
                                '<td width="4%"><input type="text" class="form-control lks_minpct" value="'+ nvl(response[i].lks_minpct,'') +'"></td>' +
                                '<td width="4%"><input type="text" class="form-control minpctqty" value="'+ nvl(minpctqty,'')  +'"></td>' +
                                '<td width="5%"><input type="text" class="form-control lks_maxplano" value="'+ nvl(response[i].lks_maxplano,'') +'"></td>' +
                                '</tr>';

                            $('#table-all').append(html);
                        }

                        for(i=response.length;i<8;i++){
                            html = '<tr class="d-flex text-center" id="row_'+ i +'">' +
                                '<td width="3%">' +
                                '<button onclick="deleteRow('+ i +')" class="col-sm btn btn-danger btn-delete">X</button>' +
                                '</td>' +
                                '<td width="3%"><input type="text" class="form-control lks_nourut"></td>' +
                                '<td width="3%"><input type="text" class="form-control lks_depanbelakang"></td>' +
                                '<td width="3%"><input type="text" class="form-control lks_atasbawah"></td>' +
                                '<td width="6%">' +
                                '<div class="buttonInside">' +
                                '<input type="text" class="form-control lks_prdcd" maxlength="7">' +
                                '<button type="button" class="btn btn-lov-plu p-0" data-toggle="modal" data-target="#m_lov_plu"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>' +
                                '</div>' +
                                '</td>' +
                                '<td width="3%"><input type="text" class="form-control lks_jenisrak"></td>' +
                                '<td width="25%"><input type="text" class="form-control desk"></td>' +
                                '<td width="5%"><input type="text" class="form-control satuan"></td>' +
                                '<td width="5%"><input type="text" class="form-control lks_noid"></td>' +
                                '<td width="4%"><input type="text" class="form-control lks_dimensipanjangproduk"></td>' +
                                '<td width="4%"><input type="text" class="form-control lks_dimensilebarproduk"></td>' +
                                '<td width="4%"><input type="text" class="form-control lks_dimensitinggiproduk"></td>' +
                                '<td width="3%"><input type="text" class="form-control lks_tirkirikanan"></td>' +
                                '<td width="3%"><input type="text" class="form-control lks_tirdepanbelakang"></td>' +
                                '<td width="3%"><input type="text" class="form-control lks_tiratasbawah"></td>' +
                                '<td width="3%"><input type="text" class="form-control lks_mindisplay"></td>' +
                                '<td width="3%"><input type="text" class="form-control lks_maxdisplay"></td>' +
                                '<td width="5%"><input type="text" class="form-control pkm"></td>' +
                                '<td width="4%"><input type="text" class="form-control lks_qty"></td>' +
                                '<td width="4%"><input type="text" class="form-control lks_minpct"></td>' +
                                '<td width="4%"><input type="text" class="form-control minpctqty"></td>' +
                                '<td width="5%"><input type="text" class="form-control lks_maxplano"></td>' +
                                '</tr>';

                            $('#table-all').append(html);
                        }

                        $('#table-all  input').on('keypress',function(e){
                            if(e.which == 13){
                                lov_plu_select(convertPlu($(this).val()));
                            }
                        });

                        $('#table-all  input').on('focus',function(){
                            if($(this).hasClass('lks_prdcd')){
                                tempprdcd = $(this).val();
                            }
                        });

                        $('input').on('focus',function(){
                            $(this).select();

                            if(!$(this).hasClass('lks_prdcd'))
                                $('.btn-lov-plu').hide();
                            else{
                                $(this).parent().find('.btn-lov-plu').show();
                                idrow = $(this).parent().parent().parent().attr('id');
                            }
                        });

                        $('.btn-lov-plu').hide();
                        // $('#table-all input').prop('disabled',true);
                        if($('#m_lov_rak').is(':visible'))
                            $('#m_lov_rak').modal('toggle');
                    }
                });
            }
        }

        function lov_plu_select(value) {
            data = {};
            data['lks_koderak'] = $('#lks_koderak').val();
            data['lks_kodesubrak'] = $('#lks_kodesubrak').val();
            data['lks_tiperak'] = $('#lks_tiperak').val();
            data['lks_shelvingrak'] = $('#lks_shelvingrak').val();
            data['lks_qty'] = $('#'+idrow).find('.lks_qty').val();
            data['lks_noid'] = $('#'+idrow).find('.lks_noid').val();
            data['lks_nourut'] = $('#'+idrow).find('.lks_nourut').val();
            data['lks_prdcd'] = value;

            console.log(data);

            $.ajax({
                url: '{{ url('/mstlokasi/lov_plu_select') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {data},
                beforeSend: function () {
                    $('#modal-loader').modal('toggle');
                },
                success: function (response) {
                    if($('#modal-loader').is(':visible'))
                        $('#modal-loader').modal('toggle');
                    if($('#m_lov_plu').is(':visible'))
                        $('#m_lov_plu').modal('toggle');
                    console.log(response);

                    if(response.status == 'error'){
                        swal({
                            title: response.message,
                            icon: response.status,
                        }).then(function(){
                            $('#'+idrow).find('.lks_prdcd').val(tempprdcd);
                            $('#'+idrow).find('.lks_prdcd').select();
                        });

                    }
                    else{
                        $('#'+idrow).find('.lks_prdcd').val(value);
                        $('#'+idrow).find('.desk').val(response.prd_deskripsipanjang);
                        $('#'+idrow).find('.satuan').val(response.satuan);
                        $('#'+idrow).find('.lks_dimensipanjangproduk').val(response.panjang);
                        $('#'+idrow).find('.lks_dimensilebarproduk').val(response.lebar);
                        $('#'+idrow).find('.lks_dimensitinggiproduk').val(response.tinggi);
                        $('#'+idrow).find('.pkm').val(response.pkm);

                        $('#'+idrow).find('.lks_noid').select();
                    }
                }
            });
        }





    </script>

@endsection
