@extends('navbar')

@section('title','ADMINISTRATION | USER ACCESS')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary" id="div-table" >
                    <div class="card-body shadow-lg cardForm">
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">USER ID</label>
                            <div class="col-sm-3 buttonInside">
                                <input type="text" class="form-control text-left" id="userid" style="text-transform: uppercase">
                                <button type="button" class="btn btn-primary btn-lov p-0" onclick="showLovUser()">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <button class="col-sm-2 btn btn-success" onclick="save()">SAVE</button>
                        </div>
                        <hr>
                        @for($i=0;$i<count($group);$i++)
                            <div class="row form-group">
                                <div class="col-sm">
                                    <div class="custom-control custom-checkbox mt-2 ml-1 text-left">
                                        <input type="checkbox" class="custom-control-input cb-all" id="ALL_{{ str_replace(' ','_',$group[$i]->acc_group) }}" onchange="checkAll('{{ str_replace(' ','_',$group[$i]->acc_group) }}', event)">
                                        <label class="custom-control-label" for="ALL_{{ str_replace(' ','_',$group[$i]->acc_group) }}">All {{ $group[$i]->acc_group }} ({{ $group[$i]->total }})</label>
                                    </div>
                                </div>
                                @if($i+1 < count($group))
                                    <div class="col-sm">
                                        <div class="custom-control custom-checkbox mt-2 ml-1 text-left">
                                            <input type="checkbox" class="custom-control-input cb-all" id="ALL_{{ str_replace(' ','_',$group[++$i]->acc_group) }}" onchange="checkAll('{{ str_replace(' ','_',$group[$i]->acc_group) }}',event)">
                                            <label class="custom-control-label" for="ALL_{{ str_replace(' ','_',$group[$i]->acc_group) }}">All {{ $group[$i]->acc_group }} ({{ $group[$i]->total }})</label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endfor
                    </div>
                </fieldset>
                @php
                    $temp = '';
                    $tempsubgroup1 = '';
                    $tempsubgroup2 = '';
                    $div = false;
                @endphp
                @for($i=0;$i<count($menu);$i++)
                    @if($temp != $menu[$i]->acc_group)
                        @if($temp != '')
                        @php $div = false; @endphp
                        </div>
                        </fieldset>
                        @endif
                        @php
                            $temp = $menu[$i]->acc_group;
                            $tempsubgroup1 = '';
                            $tempsubgroup2 = '';
                        @endphp
                        <fieldset class="card border-secondary {{ $menu[$i]->acc_group }}" id="field_{{ str_replace(' ','_',$menu[$i]->acc_group) }}" >
                            <legend class="ml-3">{{ $menu[$i]->acc_group }}</legend>
                            <div class="card-body shadow-lg cardForm">
                    @endif

                    @if(($tempsubgroup1 != $menu[$i]->acc_subgroup1 || $tempsubgroup2 != $menu[$i]->acc_subgroup2) && $menu[$i]->acc_subgroup1 != '')
                        @if($tempsubgroup1 != '' || $tempsubgroup2 != '')
                            @php $div = false; @endphp
                            </div><hr>
                        @endif
                        @if($menu[$i]->acc_subgroup2 != '')
                            @php
                                $tempsubgroup1 = $menu[$i]->acc_subgroup1;
                                $tempsubgroup2 = $menu[$i]->acc_subgroup2;
                            @endphp
                            <div class="row">
                                <div class="custom-control custom-checkbox mt-2 ml-1 text-left">
                                    <input type="checkbox" class="custom-control-input" id="ALL_{{ str_replace(' ','_',$menu[$i]->acc_subgroup1) }}_{{ str_replace(' ','_',$menu[$i]->acc_subgroup2) }}" onchange="checkAll('{{ str_replace(' ','_',$menu[$i]->acc_subgroup1) }}_{{ str_replace(' ','_',$menu[$i]->acc_subgroup2) }}',event)">
                                    <label class="custom-control-label" for="ALL_{{ str_replace(' ','_',$menu[$i]->acc_subgroup1) }}_{{ str_replace(' ','_',$menu[$i]->acc_subgroup2) }}"></label>
                                </div>
                                <label for="" class="col-form-label text-left">{{ $menu[$i]->acc_subgroup1 }} - {{ $menu[$i]->acc_subgroup2 }}</label>
                            </div>
                            <div id="field_{{ str_replace(' ','_',$menu[$i]->acc_subgroup1) }}_{{ str_replace(' ','_',$menu[$i]->acc_subgroup2) }}">
                            @php $div = true; @endphp
                        @elseif($menu[$i]->acc_subgroup1 != '')
                            @php
                                $tempsubgroup1 = $menu[$i]->acc_subgroup1;
                                $tempsubgroup2 = $menu[$i]->acc_subgroup2;
                            @endphp
                            <div class="row">
                                <div class="custom-control custom-checkbox mt-2 ml-1 text-left">
                                    <input type="checkbox" class="custom-control-input" id="ALL_{{ str_replace(' ','_',$menu[$i]->acc_subgroup1) }}" onchange="checkAll('{{ str_replace(' ','_',$menu[$i]->acc_subgroup1) }}',event)">
                                    <label class="custom-control-label" for="ALL_{{ str_replace(' ','_',$menu[$i]->acc_subgroup1) }}"></label>
                                </div>
                                <label for="" class="col-form-label text-left">{{ $menu[$i]->acc_subgroup1 }}</label>
                            </div>
                            <div id="field_{{ str_replace(' ','_',$menu[$i]->acc_subgroup1) }}">
                            @php $div = true; @endphp
                        @endif
                    @else
                        @if($tempsubgroup1 != 'x' && $menu[$i]->acc_subgroup1 == '')
                            @php $tempsubgroup1 = 'x'; @endphp
                            @if($div)
                                @php $div = false; @endphp
                                </div><hr>
                            @endif
                        @endif
                    @endif

                    <div class="row">
                        <div class="col-sm-1">
                            <div class="custom-control custom-checkbox mt-2 ml-1 text-left">
                                <input type="checkbox" class="custom-control-input cb-menu" id="{{ $menu[$i]->acc_id }}">
                                <label class="custom-control-label" for="{{ $menu[$i]->acc_id }}"></label>
                            </div>
                        </div>
                        <label for="" class="col-sm-5 col-form-label text-left">{{ $menu[$i]->acc_name }}</label>
                        @if($i+1 < count($menu))
                            @if($menu[$i]->acc_group == $menu[$i+1]->acc_group && $menu[$i]->acc_subgroup1 == $menu[$i+1]->acc_subgroup1 && $menu[$i]->acc_subgroup2 == $menu[$i+1]->acc_subgroup2)
                                <div class="col-sm-1">
                                    <div class="custom-control custom-checkbox mt-2 ml-1 text-left">
                                        <input type="checkbox" class="custom-control-input cb-menu" id="{{ $menu[++$i]->acc_id }}">
                                        <label class="custom-control-label" for="{{ $menu[$i]->acc_id }}"></label>
                                    </div>
                                </div>
                                <label for="" class="col-sm-5 col-form-label text-left">{{ $menu[$i]->acc_name }}</label>
                            @endif
                        @endif
                    </div>
                    @endfor
                </div>
        </div>
    </div>

    <div class="modal fade" id="m_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_user">
                                    <thead class="thColor">
                                    <tr>
                                        <th>USER</th>
                                        <th>USER LEVEL</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                    </tbody>
                                    <tfoot></tfoot>
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
            /*overflow-y: hidden;*/
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

        /*.my-custom-scrollbar {*/
        /*    position: relative;*/
        /*    height: 400px;*/
        /*    overflow-y: auto;*/
        /*}*/

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

        });

        function checkAll(field,event){
            $('#field_'+field+' input').prop('checked',$(event.target).is(':checked'));
        }

        function showLovUser(){
            $('#m_user').modal('show');

            if(!$.fn.DataTable.isDataTable('#table_user')){
                getLovUser();
            }
        }

        function getLovUser() {
            $('#table_user').DataTable({
                "ajax": '{{ url()->current().'/get-lov-user' }}',
                "columns": [
                    {data: 'userid'},
                    {data: 'userlevel'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('text-center');
                    $(row).addClass('row-plu').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    $(document).on('click', '.row-plu', function (e) {
                        $('#userid').val($(this).find('td:eq(0)').html());

                        $('#m_user').modal('hide');

                        getData();
                    });
                }
            });
        }

        $('#userid').on('keypress',function(e){
            if(e.which == 13){
                getData();
            }
        })

        function getData(){
            $.ajax({
                url: '{{ url()->current() }}/get-data',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    userid: $('#userid').val().toUpperCase()
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    $('.cb-menu').prop('checked',false);

                    for(i=0;i<response.length;i++){
                        $('#'+response[i].uac_acc_id).prop('checked',true);
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {

                    });
                }
            });
        }

        function save(){
            if(!$('#userid').val()){
                swal({
                    title: 'User ID belum diisi!',
                    icon: 'error'
                });
            }
            else{
                swal({
                    title: 'Yakin ingin menyimpan data?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then(function(ok){
                    if(ok){
                        menu = [];

                        $('.cb-menu').each(function(){
                            if($(this).is(':checked'))
                                menu.push($(this).attr('id'));
                        });

                        $.ajax({
                            url: '{{ url()->current() }}/save',
                            type: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: {
                                userid: $('#userid').val().toUpperCase(),
                                menu: menu
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('hide');

                                swal({
                                    title: response.title,
                                    icon: 'success'
                                }).then();
                            },
                            error: function (error) {
                                $('#modal-loader').modal('hide');
                                swal({
                                    title: error.responseJSON.title,
                                    text: error.responseJSON.message,
                                    icon: 'error',
                                }).then(() => {

                                });
                            }
                        });
                    }
                });
            }
        }

    </script>
@endsection
