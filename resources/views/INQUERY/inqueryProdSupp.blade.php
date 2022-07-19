@extends('navbar')
@section('title', __('INQUIRY | INQUIRY PRODUK PER SUPPPLIER'))
@section('content')


    <div class="container mt-3">
        <div class="row justify-content-center mb-3">
            <div class="col-sm-12">

                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">@lang('INQUIRY PRODUK PER SUPPLIER')</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <div class="col-sm-10">
                                {{--<fieldset class="card border-secondary">--}}
                                <form>
                                    <div class="row text-right">
                                        <div class="col-sm-12">
                                            <div class="form-group row mb-0">
                                                <label for="i_kodesupplier" class="col-sm-2 col-form-label">@lang('Supplier')</label>
                                                <div class="col-sm-2 buttonInside">
                                                    <input type="text" class="form-control" id="i_kodesupplier">
                                                    <button type="button" class="btn btn-lov p-0" data-toggle="modal" data-target="#modal_supp" onclick="showLOV()">
                                                        <img src="{{asset('image/icon/help.png')}}" width="30px">
                                                    </button>
                                                </div>
                                                <label>-</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="i_namasupplier" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <tbody>
                                </tbody>
                            </div>
                            <div class="col-sm-12">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-4">@lang('Detail')</legend>
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                        <table id="tabledetail" class="table table-sm">
                                            <thead class="headerTable">
                                            <tr class="d-flex fontTable">
                                                <th class="col-sm-1">@lang('PLU')</th>
                                                <th class="col-sm-3">@lang('Nama Barang')</th>
                                                <th class="col-sm-1 pl-0 pr-0 text-right">@lang('Stok')</th>
                                                <th class="col-sm-2 text-right">@lang('Sales')</th>
                                                <th class="col-sm-2 text-right">@lang('PKM Exist')</th>
                                                <th class="col-sm-2 text-right">@lang('H.P.P')</th>
                                                <th class="col-sm-1 text-right">@Lang('Tag')</th>
                                            </tr>
                                            </thead>
                                            <tbody id="body-table">
                                            <tr class="rowdetail d-flex"></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row text-right">
                            <div class="offset-sm-12 col-sm-5 mt-3">
                                <div class="form-group row mb-0">
                                    <label for="i_totalitem" class="col-sm-4 col-form-label">@lang('Total Item')</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="i_totalitem" value="" disabled>
                                    </div>
                                </div>
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

    <div class="modal fade" id="modal_supp" tabindex="-1" role="dialog" aria-labelledby="modal_supp" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">

            {{--<!-- Modal content-->--}}
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="helpSearch" class="form-control helpSearch" type="text" placeholder="..." aria-label="Search">
                            <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="tableFixedHeader">
                                    <table class="table table-sm" id="table_lov">
                                        <thead class="headerModalSupp">
                                        <tr class="fontModal">
                                            <td>@lang('Kode Supplier')</td>
                                            <td>@lang('Kode Supplier MCG')</td>
                                            <td>@lang('Nama Supplier')</td>
                                        </tr>
                                        </thead>
                                        <tbody id="tbodyModal">
{{--                                        @foreach($result as $s)--}}
{{--                                            <tr class="row_lov" onclick="helpSelect('{{ $s->sup_kodesupplier }}')">--}}
{{--                                                <td>{{ $s->sup_kodesupplier }}</td>--}}
{{--                                                <td>{{ $s->sup_kodesuppliermcg }}</td>--}}
{{--                                                <td>{{ $s->sup_namasupplier }}</td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}
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
            position: sticky; top: 0;
            z-index: 10;
        }
        .fontTable{
            color: white;
            font-weight: bold;
        }
        .headerModalSupp{
            background: #0079C2;
            position: sticky; top: 0;
        }
        .fontModal{
            color: white;
            font-weight: bold;
        }
        .rowdetail:hover{
            cursor: pointer;
            background-color: cornflowerblue;
            color: white;
        }
        .my-custom-scrollbar {
            position: relative;
            height: 380px;
            overflow: auto;
        }
        .table-wrapper-scroll-y {
            display: block;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>

    <script>

        $(document).on('keypress', '#i_kodesupplier', function (e) {
            if(e.which == 13) {
                e.preventDefault();
                let kodesupp = $('#i_kodesupplier').val();
                helpSelect(kodesupp);
            }
        });

        function helpSelect(kodesupp) {
            $('#modal_supp').modal('hide');
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/prodSupp',
                type: 'post',
                data: {kodesupp: kodesupp},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    $('#tabledetail .rowdetail').remove();

                    if(result.data.length == 0){
                        swal({
                            title: `{{ __('Data tidak ada') }}`,
                            icon: 'error'
                        })
                    } else {
                        //console.log(result.data[0]);
                        var html = "";
                        var i;
                        for (i = 0; i < result.data.length; i++) {
                            var pkm = parseInt(result.data[i].pkm_pkmt) + parseInt(result.data[i].ngdl);
                            var hpp = result.data[i].prd_lastcost / result.data[i].nfrac;
                            html = '<tr class="rowdetail d-flex">' +
                                '<td class="col-1">' + result.data[i].mstd_prdcd + '</td>' +
                                '<td class="col-3">' + result.data[i].prd_deskripsipendek + '</td>' +
                                '<td class="col-1 pl-0 pr-0 text-right">' + convertToRupiah2(result.data[i].st_saldoakhir) + '</td>' +
                                '<td class="col-2 text-right">' + convertToRupiah2(result.data[i].st_sales) + '</td>' +
                                '<td class="col-2 text-right">' + convertToRupiah2(pkm) + '</td>' +
                                '<td class="col-2 text-right">' + convertToRupiah(hpp) + '</td>' +
                                '<td class="col-1 text-right">' + result.data[i].prd_kodetag + '</td>' +
                                '</tr>'
                            $('#i_kodesupplier').val(result.data[i].mstd_kodesupplier);
                            $('#i_namasupplier').val(result.data[i].sup_namasupplier);
                            $('#i_totalitem').val(result.count);
                            $('#tabledetail').append(html);
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
                url: '{{ url()->current() }}/suppLOV',
                type: 'post',
                data: {},
                success: function (result) {
                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        var temp = `<tr class="modalRow" onclick="helpSelect( '`+ result[i].sup_kodesupplier +`' )">
                                <td>`+ result[i].sup_kodesupplier +`</td>
                                <td>`+ result[i].sup_kodesuppliermcg +`</td>
                                <td>`+ result[i].sup_namasupplier +`</td>
                                <tr>`;
                        $('#table_lov').append(temp);
                    }
                    $('#modal_supp').modal('show');
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
                    url: '{{ url()->current() }}/suppLOV',
                    type: 'post',
                    data: {search:search},
                    success: function (result) {
                        $('.modalRow').remove();
                        for (var i = 0; i < result.length; i++){
                            var temp = `<tr class="modalRow" onclick="helpSelect( '`+ result[i].sup_kodesupplier +`' )">
                                <td>`+ result[i].sup_kodesupplier +`</td>
                                <td>`+ result[i].sup_kodesuppliermcg +`</td>
                                <td>`+ result[i].sup_namasupplier +`</td>
                                <tr>`;
                            $('#table_lov').append(temp);
                        }
                    }, error: function () {
                        alert('error');
                    }
                });
            }
        })

    </script>

@endsection
