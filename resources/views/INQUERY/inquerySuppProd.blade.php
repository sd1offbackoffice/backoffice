@extends('navbar')
@section('title', __('INQUIRY | INQUIRY SUPPLIER PER PRODUK'))
@section('content')

    <div class="container mt-3">
        <div class="row justify-content-center mb-3">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">@lang('INQUIRY SUPPLIER PER PRODUK')</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <div class="col-sm-12">
                                {{--<fieldset class="card border-secondary">--}}
                                    <form>
                                        <div class="row text-right">
                                            <div class="col-sm-12 ">
                                                <div class="form-group row mb-0">
                                                    <label for="i_kodeplu" class="col-sm-2 col-form-label">@lang('PLU')</label>
                                                    <div class="col-sm-2 buttonInside">
                                                        <input type="text" class="form-control" id="i_kodeplu">
                                                        <button type="button" class="btn btn-lov p-0" data-toggle="modal" data-target="#modal_plu" onclick="showLOV()">
                                                            <img src="{{asset('image/icon/help.png')}}" width="30px">
                                                        </button>
                                                    </div>
                                                    <label>-</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="i_deskripsi" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <tbody>
                                    {{--@php--}}
                                        {{--$i = 0;--}}
                                    {{--@endphp--}}
                                    {{--@foreach($divisi as $div)--}}
                                    {{--<tr id="row_divisi_{{ $i }}"class="row_divisi d-flex" onclick="divisi_select('{{ $div->div_kodedivisi }}','{{ $i++ }}')">--}}
                                    {{--<td class="col-4">{{ $div->div_kodedivisi }}</td>--}}
                                    {{--<td class="col-8">{{ $div->div_namadivisi }}</td>--}}
                                    {{--</tr>--}}
                                    {{--@endforeach--}}
                                    </tbody>
{{--                                    </table>--}}
                                {{--</fieldset>--}}
                            </div>

                            <div class="col-sm-12">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-4">@lang('Detail')</legend>
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                        <table id="table_detail" class="table table-sm">
                                            <thead class="headerTable">
                                            <tr class="d-flex">
                                                <th class="col-sm-1">@lang('Supplier')</th>
                                                <th class="col-sm-4">@lang('Nama Supplier')</th>
                                                <th class="col-sm-1 text-right">@lang('Kuantum')</th>
                                                <th class="col-sm-2 pl-5 pr-0 text-left">@lang('BPB')</th>
                                                <th class="col-sm-2 text-right">@lang('Tanggal')</th>
                                                <th class="col-sm-1 text-right">@lang('Term')</th>
                                                <th class="col-sm-1 text-right">@lang('H.P.P')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="row_detail d-flex">
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-loader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="vertical-align: middle;">
        <div class="modal-dialog modal-dialog-centered" role="document" >
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="loader" id="loader"></div>
                            <div class="col-sm-12 text-center">
                                <label for="">LOADING...</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_plu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="form-row col-sm">
                            <input id="helpSearch" class="form-control helpSearch" type="text" placeholder="..." aria-label="Search">
                                <div class="invalid-feedback">@lang('Inputkan minimal 3 karakter')</div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="tableFixedHeader">
                                        <table class="table table-sm" id="table_lov">
                                            <thead class="headerModalSupp">
                                            <tr>
                                                <td>@lang('Kode PLU')</td>
                                                <td class="text-left">@lang('Deskripsi')</td>
                                            </tr>
                                            </thead>
                                            <tbody>
{{--                                            @foreach($plu as $p)--}}
{{--                                                <tr onclick="helpSelect('{{ $p->prd_prdcd }}')" class="row_lov">--}}
{{--                                                    <td>{{ $p->prd_prdcd }}</td>--}}
{{--                                                    <td>{{ $p->prd_deskripsipanjang }}</td>--}}
{{--                                                </tr>--}}
{{--                                            @endforeach--}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer"></div>
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
        .headerTable{
            background: #0079C2;
            color: white;
            position: sticky; top: 0;
            z-index: 10;
        }

        tr:nth-child(even) {background-color: #f2f2f2;}

        .headerModalSupp{
            background: #0079C2;
            color: white;
            font-weight: bold;
            position: sticky; top: 0;
        }

        .row_detail:hover {
            cursor: pointer;
            background-color: cornflowerblue;
            color: white;
        }

        /*.row_lov:hover{*/
        /*    cursor: pointer;*/
        /*    background-color: #acacac;*/
        /*}*/

        .my-custom-scrollbar {
            position: relative;
            height: 380px;
            overflow: auto;
        }
        .table-wrapper-scroll-y {
            display: block;
        }

    </style>

    <script>
        // $(':input').prop('readonly',true);
        // $('.custom-select').prop('disabled',true);
        // $('#i_kodesupplier').prop('readonly',false);
        // $('#search_lov').prop('readonly',false);
        //
        // $('#row_divisi_0').addClass('table-success');
        //
        // $(document).ready(function () {
        //
        // })

        $(document).on('keypress', '#i_kodeplu', function (e) {
            if (e.which == 13) {
                e.preventDefault();
                let kodeplu = $('#i_kodeplu').val();
                helpSelect(convertPlu(kodeplu));
            }
        });

        function helpSelect(kodeplu) {
            $('#modal_plu').modal('hide');
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/suppProd',
                type: 'post',
                data: {kodeplu: kodeplu},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    console.log(result);
                    $('#table_detail .row_detail').remove();

                    if(result.data.length == 0){
                        swal({
                            title: `{{ __('Data tidak ada') }}`,
                            icon: 'error'
                        })
                    } else {
                        console.log(result.data[0]);
                        var html = "";
                        var i;
                        for (i = 0; i < result.data.length; i++) {
                            html = '<tr class="row_detail d-flex">' +
                                '<td class="col-1">' + result.data[i].kodesup + '</td>' +
                                '<td class="col-4">' + result.data[i].namasup + '</td>' +
                                '<td class="col-1 text-right">' + convertToRupiah2(result.data[i].qty) + '</td>' +
                                '<td class="col-2 pl-5 pr-0 text-left">' + result.data[i].nobpb + '</td>' +
                                '<td class="col-2 text-right">' + formatDate(result.data[i].tglbpb) + '</td>' +
                                '<td class="col-1 text-right">' + result.data[i].term + '</td>' +
                                '<td class="col-1 text-right">' + convertToRupiah(result.data[i].hpp) + '</td>' +
                                '</tr>'
                            $('#i_kodeplu').val(result.data[i].prd_prdcd);
                            $('#i_deskripsi').val(result.data[i].prd_deskripsipanjang);
                            $('#table_detail').append(html);
                        }
                    }
                }, error: function () {
                    alert('error');
                }
            })
        }

        function showLOV() {
            $('#helpSearch').val('')
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/showLOV',
                type: 'post',
                data: {},
                success: function (result) {
                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        var temp = `<tr class="modalRow" onclick="helpSelect( '`+ result[i].prd_prdcd +`' )">
                                <td>`+ result[i].prd_prdcd +`</td>
                                <td>`+ result[i].prd_deskripsipanjang +`</td>
                                <tr>`;
                        $('#table_lov').append(temp);
                    }
                    $('#modal_plu').modal('show');
                }, error: function () {
                    alert('error');
                }
            });
        }

        $('#helpSearch').keypress(function (e) {
            if (e.which === 13) {
                let search = $('#helpSearch').val();
                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current() }}/showLOV',
                    type: 'post',
                    data: {search:search},
                    success: function (result) {
                        $('.modalRow').remove();
                        for (var i = 0; i < result.length; i++){
                            var temp = `<tr class="modalRow" onclick="helpSelect( '`+ result[i].prd_prdcd +`' )">
                                <td>`+ result[i].prd_prdcd +`</td>
                                <td>`+ result[i].prd_deskripsipanjang +`</td>
                                <tr>`;
                            $('#table_lov').append(temp);
                        }
                    }, error: function () {
                        alert('error');
                    }
                });
            }
        })

        // function null_check(value){
        //     if(value == null)
        //         return '';
        //     else return value;
        // }
    </script>

@endsection
